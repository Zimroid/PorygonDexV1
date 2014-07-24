<?php
header ("Content-type: image/png");
$image = imagecreatefrompng("BatFond.png");
$noir = imagecolorallocate($image, 0, 0, 0);
putenv('GDFONTPATH=' . realpath('.'));
$font = 'RainbowMan';


if(isset($_GET['rouge']))
{
	$ligne = " ";
	$l1 = true;
	$l2 = true;
	$l3 = true;

	$motsRouge = split(" ", $_GET['rouge']);

	for ($i = 0; $i < count($motsRouge); $i++)
	{ 
		$ligne = $ligne . $motsRouge[$i] . " ";
		if(imagettfbbox(25, 0, $font, $ligne)[2] < 280)
		{
			if($l1)
			{
				imagettftext($image, 25, 0, 30, 42, $noir, $font, $ligne);
			}
			else if($l2)
			{
				imagettftext($image, 25, 0, 30, 70, $noir, $font, $ligne);
			}
			else if($l3)
			{
				imagettftext($image, 25, 0, 30, 98, $noir, $font, $ligne);
			}
		}
		else
		{
			$ligne = " " . $motsRouge[$i];
			if($l1)
			{
				$l1 = false;
				imagettftext($image, 25, 0, 30, 70, $noir, $font, $ligne);
			}
			else if($l2)
			{
				$l2 = false;
				imagettftext($image, 25, 0, 30, 98, $noir, $font, $ligne);
			}
			else if($l3)
			{
				$l3 = false;
				imagettftext($image, 25, 0, 150, 126, $noir, $font, "...");
			}
		}
	}
}

if(isset($_GET['bat']))
{
	$ligne = " ";
	$l1 = true;
	$l2 = true;
	$l3 = true;

	$motsBat = split(" ", $_GET['bat']);

	for ($i = 0; $i < count($motsBat); $i++)
	{ 
		$ligne = $ligne . $motsBat[$i] . " ";
		if(imagettfbbox(25, 0, $font, $ligne)[2] < 280)
		{
			if($l1)
			{
				imagettftext($image, 25, 0, 330, 42, $noir, $font, $ligne);
			}
			else if($l2)
			{
				imagettftext($image, 25, 0, 330, 70, $noir, $font, $ligne);
			}
			else if($l3)
			{
				imagettftext($image, 25, 0, 330, 98, $noir, $font, $ligne);
			}
		}
		else
		{
			$ligne = " " . $motsBat[$i];
			if($l1)
			{
				$l1 = false;
				imagettftext($image, 25, 0, 330, 70, $noir, $font, $ligne);
			}
			else if($l2)
			{
				$l2 = false;
				imagettftext($image, 25, 0, 330, 98, $noir, $font, $ligne);
			}
			else if($l3)
			{
				$l3 = false;
				imagettftext($image, 25, 0, 450, 126, $noir, $font, "...");
			}
		}
	}
}

imagepng($image);

?>