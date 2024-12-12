<?php
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $captchaString = '';
    $captchaLength = random_int(3,8);

    for ($i = 0; $i < $captchaLength; $i++) {
        $captchaString .= $characters[random_int(0, $charactersLength - 1)];
    }

    session_start();
    $_SESSION["captcha"] = $captchaString;

    header("Content-Type: image/png");
    $im = @imagecreate(100, 30);
    $background_color = imagecolorallocate($im, 0, 0, 0);
    $text_color = imagecolorallocate($im, random_int(0,255), random_int(0,225), random_int(0,225));
    imagestring($im, random_int(4,10), random_int(0,25), random_int(0,15), $captchaString, $text_color);
    imagepng($im);
    imagedestroy($im);
    die();
?>