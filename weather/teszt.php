<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$connect = mysqli_connect("localhost","-----","------")or die(mysqli_error());
$db = "----";
$a = mysqli_query($connect, "SELECT * FROM $db.`RaspberryPiWeatherLog` WHERE `Datum` LIKE '".date("Y-m-d")."%'");
if (!$a) {
    printf("Error: %s\n", mysqli_error($connect));
    exit();
}
$db = 0;
$ho = 0;
$minho = -999;
$maxho = -999;
$para = 0;
$minpara = -999;
$maxpara = -999;
$harmat = 0;
$minharmat = -999;
$maxharmat = -999;
while($b = mysqli_fetch_array($a)) {
	$db++;
	$ho += $b['Homerseklet'];
	$para += $b['Paratartalom'];
	$harmat += $b['Harmatpont'];
	
	if($minho == -999 || $b['Homerseklet'] < $minho)
		$minho = $b['Homerseklet'];
	if($maxho == -999 || $b['Homerseklet'] > $maxho)
		$maxho = $b['Homerseklet'];
	
	if($minpara == -999 || $b['Paratartalom'] < $minpara)
		$minpara = $b['Paratartalom'];
	if($maxpara == -999 || $b['Paratartalom'] > $maxpara)
		$maxpara = $b['Paratartalom'];
	
	if($minharmat == -999 || $b['Harmatpont'] < $minharmat)
		$minharmat = $b['Harmatpont'];
	if($maxharmat == -999 || $b['Harmatpont'] > $maxharmat)
		$maxharmat = $b['Harmatpont'];
}
$atlagho = $ho/$db;
$atlagpara = $para/$db;
$atlagharmat =  $harmat/$db;

$im = imagecreatefrompng("assets/images/drag.png");

$white = imagecolorallocate($im, 255, 255, 255);
$font_path = 'assets/fonts/arial.ttf';
$text1 = date("Y-m-d");
$text10 = date("H:i");
$text2 = '';
$text3 = 'Átlag: '.number_format($atlagho,2).' °C';
$text4 = 'Legmagasabb: '.$maxho.' °C';
$text5 = 'Legkisebb: '.$minho.' °C';

$text6 = 'Átlag: '.number_format($atlagpara,2).'%';
$text7 = 'Legmagasabb: '.$maxpara.'%';
$text8 = 'Legkisebb: '.$minpara.'%';

$text9 = 'Átlag: '.number_format($atlagharmat,2).' °C';
$text11 = 'Legmagasabb: '.$maxharmat.' °C';
$text12 = 'Legkisebb: '.$minharmat.' °C';

imagettftext($im, 20, 0, 90, 80, $white, $font_path, $text1);
imagettftext($im, 20, 0, 120, 110, $white, $font_path, $text10);
imagettftext($im, 25, 0, 120, 50, $white, $font_path, $text2);

imagettftext($im, 15, 0, 160, 210, $white, $font_path, $text3);
imagettftext($im, 11, 0, 20, 235, $white, $font_path, $text4);
imagettftext($im, 11, 0, 20, 255, $white, $font_path, $text5);

imagettftext($im, 15, 0, 170, 345, $white, $font_path, $text6);
imagettftext($im, 11, 0, 20, 370, $white, $font_path, $text7);
imagettftext($im, 11, 0, 20, 390, $white, $font_path, $text8);

imagettftext($im, 15, 0, 170, 480, $white, $font_path, $text9);
imagettftext($im, 11, 0, 20, 505, $white, $font_path, $text11);
imagettftext($im, 11, 0, 20, 525, $white, $font_path, $text12);
imagepng($im, "assets/images/dragma.png");
imagedestroy($im);
?>