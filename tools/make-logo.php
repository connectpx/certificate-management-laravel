<?php

$w = 240;
$h = 240;
$im = imagecreatetruecolor($w, $h);
imagesavealpha($im, true);
$trans = imagecolorallocatealpha($im, 0, 0, 0, 127);
imagefill($im, 0, 0, $trans);
$navy = imagecolorallocate($im, 15, 42, 68);
$gold = imagecolorallocate($im, 184, 148, 58);
$white = imagecolorallocate($im, 255, 255, 255);
imagefilledellipse($im, 120, 120, 220, 220, $navy);
imageellipse($im, 120, 120, 200, 200, $gold);
imageellipse($im, 120, 120, 190, 190, $gold);
imagestring($im, 5, 88, 105, 'BASDU', $gold);
imagestring($im, 3, 78, 130, 'K9 UNIT', $white);
$path = __DIR__.'/../public/images/logo.png';
imagepng($im, $path);
imagedestroy($im);
echo "logo ok\n";
