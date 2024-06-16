<?php
// session start
session_start();

// DB Params
define('DB_HOST', 'localhost');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', '');
define('DB_NAME', 'magazine');
define('DB_PREFIX', 'ma_');

// Email Credentials

define('SMTP_HOST', 'sandbox.smtp.mailtrap.io');
define('SMTP_AUTH', true);
define('SMTP_USERNAME', 'e2fecd3ce9e387');
define('SMTP_PASSWORD', '33b49ee5f22ede');
define('SMTP_PORT', 587);

// App Root
define('APPROOT', dirname(dirname(__FILE__)));
// URL Root
define('URLROOT', __DIR__);
// SITE NAME
define('SITENAME', 'Magazine Feedback');
// VERSION
define('APPVERSION', '1.0.0');

// echo APPROOT . '<br>';
// echo URLROOT . '<br>';
// echo SITENAME . '<br>';
// echo APPROOT . '<br>';
