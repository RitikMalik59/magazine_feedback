<?php

function redirect($url)
{
    header("Location: " . $url);
}

function is_loggedIn()
{
    
    if (!isset($_SESSION['username'])) {
        redirect('../admin/login.php');
    }
}