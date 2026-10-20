<?php
session_start();

function acakCaptcha()
{
  $alphabet = "abcdefghijklmnopqrstuwxyzABCDEFGHIJKLMNOPQRSTUWXYZ0123456789";

  // Untuk menyatakan $pass sebagai array
  $pass = array();

  // Masukkan -2 dalam string length
  $panjangAlpha = strlen($alphabet) - 2;

  for ($i = 0; $i < 5; $i++) {
    $n = rand(0, $panjangAlpha);
    $pass[] = $alphabet[$n];
  }

  // Ubah array menjadi string
  return implode($pass);
}

// Untuk mengacak captcha
$code = acakCaptcha();
$_SESSION["code"] = $code;

// Lebar dan tinggi captcha
$wh = imagecreatetruecolor(173, 50);

// Background color biru
$bgc = imagecolorallocate($wh, 22, 86, 165);

// Text color abu-abu
$fc = imagecolorallocate($wh, 223, 230, 233);

imagefill($wh, 0, 0, $bgc);

// ( $image, $fontsize, $x, $y, $string, $fontcolor )
$font = 10;
$x = 50;
$y = 15;

// Tulis karakter satu per satu agar jaraknya bisa diatur
for ($i = 0; $i < strlen($code); $i++) {
  imagestring($wh, $font, $x, $y, $code[$i], $fc);
  $x += 17;
}

// Buat gambar
header('Content-Type: image/jpeg');
header('Cache-Control: no-store, no-cache, must-revalidate, max-age=0');
header('Pragma: no-cache');
header('Expires: 0');

imagejpeg($wh);
imagedestroy($wh);
