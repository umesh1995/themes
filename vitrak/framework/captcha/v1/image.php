<?php

include_once dirname(__FILE__).'/captcha.php';

$captcha = new Ecotech_Captcha();
$code    = $captcha->get_and_show_image();

session_start();

$_SESSION['captcha_code'] = $code;
