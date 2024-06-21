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

define('SMTP_HOST', 'app.debugmail.io');
define('SMTP_AUTH', true);
define('SMTP_USERNAME', '0b84ad88-146f-4007-91b6-a8bdca71bd49');
define('SMTP_PASSWORD', 'd71c5270-455f-4fce-872d-ee6500117344');
define('SMTP_PORT', 25);
define('SMTP_SETFROM_MAIL', 'list@example.com');
define('SMTP_SETFROM_NAME', 'List manager');
define('SMTP_CC_MAIL', [
    'test@gmail.com',
]);

// App Root
define('APPROOT', dirname(dirname(__FILE__)));
// URL Root
define('URLROOT', __DIR__);
// SITE NAME
define('SITENAME', 'Magazine Feedback');
// SITE URL
define('SITEURL', 'https://cleanindiajournal.com/magazine_feedback-main');
// VERSION
define('APPVERSION', '1.0.0');

// echo APPROOT . '<br>';
// echo URLROOT . '<br>';
// echo SITENAME . '<br>';
// echo APPROOT . '<br>';
