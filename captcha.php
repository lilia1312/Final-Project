<?php
session_start();

// Generate random number
$rand = rand(1000, 9999);
$_SESSION['captcha'] = $rand;

// Set the content type header to output SVG
header('Content-Type: image/svg+xml');

$rotation = rand(-15, 15); // Random text rotation
$font_size = rand(18, 22);
$color = sprintf('#%06X', mt_rand(0, 0xFFFFFF)); 

// Output the SVG
echo '<svg width="100" height="40" xmlns="http://www.w3.org/2000/svg">';
echo "<text x='20' y='35' font-size='$font_size' fill='$color' font-family='Arial, sans-serif' transform='rotate($rotation 60,35)'>$rand</text>";
echo "<rect width='100' height='40' fill='$color' fill-opacity= '0.5'/>"; 
echo '</svg>';
?>
