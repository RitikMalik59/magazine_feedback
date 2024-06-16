<?php

function redirect($url)
{
    header("Location: " . $url);
}

function is_loggedIn()
{
    // session_start();
    if (!isset($_SESSION['username'])) {
        redirect('../admin/login.php');
        exit();
    }
}