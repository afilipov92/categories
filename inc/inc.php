<?php
error_reporting(E_ALL);

function __autoload($className) {
    require_once __DIR__ . DIRECTORY_SEPARATOR . $className . '.php';
}

define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASSWORD', 'Blackpearl99');
define('DB_NAME', 'study2');