<?php

/**
 * @file
 * User page callback file for the user_registrationpassword module.
 */

/**
 * Menu callback; process one time login link.
 */
function user_registrationpassword_confirm_account($form, &$form_state, $uid, $timestamp, $hashed_pass) {
  global $user;

  // When processing the one-time login link, we have to make sure that a user
  // isn't already logged in.
  if ($user->uid) {
    // The existing user is already logged in.
    if ($user->uid == $uid) {
      drupal_set_message(t('You are logged in as %user. <a href="@url">Change your password</a>',
        array('%user' => $user->name, '@url' => url("user/$user->uid/edit"))
      ));
    }
    // A different user is already logged in on the computer.
    else {
      $reset_link_account = user_load($uid);
      if (!empty($reset_link_account)) {
        drupal_set_message(t('Another user (%other_user) is already logged into the site on this computer, but you tried to use a one-time link for user %resetting_user. Please <a href="@url">logout</a> and try using the link again.',
          array(
            '%other_user' => $user->name,
            '%resetting_user' => $reset_link_account->name,
            '@url' => url("logout"),
          )
        ));
      }
      else {
        // Invalid one-time link specifies an unknown user.
        user_registrationpassword_set_message('linkerror');
      }
    }
  }
  else {
    // Time out, in seconds, until login URL expires. 24 hours = 86400 seconds.
    $timeout = 86400;
    $current = REQUEST_TIME;
    // Some redundant checks for extra security ?
    $users = user_load_multiple(array($uid), array('status' => '0', 'access' => '0'));
    if ($timestamp <= $current && $account = reset($users)) {
      // No time out for first time login.
      if ($account->login && $current - $timestamp > $timeout) {
        user_registrationpassword_set_message('linkerror');
      }
      elseif ($account->uid && $timestamp >= $account->login && $timestamp <= $current && $hashed_pass == user_pass_rehash($account->pass, $timestamp, $account->login)) {
        watchdog('user', 'User %name used one-time login link at time %timestamp.', array('%name' => $account->name, '%timestamp' => $timestamp));
        // Activate the user and update the access and login time to $current.
        $account = user_save($account, array(
          'status' => 1,
          'access' => $current,
          'login' => $current)
        );
        // Set the new user.
        $user = $account;
        // user_login_finalize() also updates the login timestamp of the
        // user, which invalidates further use of the one-time login link.
        user_login_finalize();
        drupal_set_message(t('You have just used your one-time login link. Your account is now active.'));

        // Test for Commerce checkout and redirect to checkout if exists.
        if (module_exists('commerce_checkout')) {
          $order_id = commerce_cart_order_id();
          // People need to be coming from the checkout form, and thus
          // have an order ready, so we will forward them to the checkout
          // form if they have an cart order set.
          if (!empty($order_id)) {
            drupal_goto('checkout/' . $order_id);
          }
        }
        // And just redirect to /user if this site does not have commerce,
        // or if the user does not have an order in the cart.
        drupal_goto('user');
      }
      else {
        user_registrationpassword_set_message('linkerror');
      }
    }
    else {
      // Deny access, no more clues.
      // Everything will be in the watchdog's
      // URL for the administrator to check.
      user_registrationpassword_set_message('linkerror');
    }
  }
}
