<?php

// Show errors on development environment
if(env('APP_ENV') != 'production') {
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
}

// Database connection
$conn = mysqli_connect(
    env('DB_HOST'),
    env('DB_USER'),
    env('DB_PASS'),
    env('DB_NAME')
) or die('Connection failed');