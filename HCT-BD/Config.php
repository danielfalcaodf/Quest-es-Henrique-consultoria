<?php
$whitelist = array('127.0.0.1', "::1", 'localhost');

if (in_array($_SERVER['REMOTE_ADDR'], $whitelist)) {
    //DB credentials
    define('DB_HOST', 'localhost');
    define('DB_USER', 'root');
    define('DB_PASSWORD', '');
    define('DB_NAME', 'teste');
    define('DB_PORT', '3306'); //Default 3306

}