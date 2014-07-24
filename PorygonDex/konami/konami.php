<?php

echo '<form method="POST">';
echo '	<table align="center">';
echo '		<tr align="center"><td><img src="rouge.png" /></td><td><img src="bat.png" /></td></tr>';
echo '		<tr align="center">';
echo '		<td><textarea name="rouge" rows="5" cols="30">' . (!isset($_POST['rouge']) ? 'Mais enfin le type fée n\'exist-' : '') . '</textarea></td>';
echo '		<td><textarea name="bat" rows="5" cols="30">' . (!isset($_POST['bat']) ? 'IL EXISTE !' : '') . '</textarea></td>';
echo '		</tr>';
echo '		<tr align="center"><td colspan="2"><input type="submit" value="SLAAAP!" /></td></tr>';
echo '	</table>';
echo '</form>';

$bat = "IL EXISTE !";
$rouge = "Mais enfin le type fée n'exist-";

if(isset($_POST['bat']))
{
	$bat = $_POST['bat'];
}

if(isset($_POST['rouge']))
{
	$rouge = $_POST['rouge'];
}


echo '<div align="center"><img src="img.php?bat=' . $bat . '&rouge=' . $rouge . '" /><br>';

echo 'Share : <input style="width:500" type="text" value="' . $_SERVER['SERVER_NAME'] . '/konami/img.php?bat=' . $bat . '&rouge=' . $rouge . '" /></div>';
?>