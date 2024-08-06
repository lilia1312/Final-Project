<?php
  session_start();
header('content-type:image/jpeg');
$mj = $_SESSION['x'] = mt_rand(1111,9999);
$image = imagecreate(100, 50);

imagecolorallocate($image, 215, 215, 215);
$txtcolor = imagecolorallocate($image, 0, 0, 0);
imagettftext($image,20,0,20,40,$txtcolor,'font.ttf',$mj);

imagejpeg($image);
?>