<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!defined('SITEURL')) {
    define('SITEURL', 'http://localhost/restaurant-practice/');
}

if (!defined('LOCALHOST')) {
    define('LOCALHOST', 'localhost');
}

if (!defined('DB_USERNAME')) {
    define('DB_USERNAME', 'root');
}

if (!defined('DB_PASSWORD')) {
    define('DB_PASSWORD', '');
}

if (!defined('DB_NAME')) {
    define('DB_NAME', 'food_db');
}

if (!defined('MAX_ORDER_QUANTITY')) {
    define('MAX_ORDER_QUANTITY', 10);
}

if (!isset($conn)) {
    $conn = mysqli_connect(LOCALHOST, DB_USERNAME, DB_PASSWORD) or die(mysqli_error());
    $db_select = mysqli_select_db($conn, DB_NAME) or die(mysqli_error());
}
