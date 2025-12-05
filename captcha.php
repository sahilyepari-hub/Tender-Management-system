<?php
session_start();
$code = substr(str_shuffle('ABCDEFGHJKLMNPQRSTUVWXYZ23456789'), 0, 6);
$_SESSION['captcha'] = $code;

header('Content-Type: image/svg+xml');
echo '<svg xmlns="http://www.w3.org/2000/svg" width="140" height="40">
<rect width="100%" height="100%" fill="#f8f9fa"/>
<text x="50%" y="50%" dominant-baseline="middle" text-anchor="middle"
      font-family="monospace" font-size="24">'.$code.'</text>
</svg>';