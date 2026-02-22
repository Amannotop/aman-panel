<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "=== Starting CI Test ===<br>";

chdir(__DIR__);
define('FCPATH', __DIR__ . DIRECTORY_SEPARATOR);
define('APPPATH', 'app/');
define('SYSTEMPATH', 'vendor/codeigniter4/framework/system/');

echo "Paths defined<br>";

require 'vendor/autoload.php';
echo "Autoload included<br>";

$paths = new Config\Paths();
echo "Paths created<br>";

$bootstrap = rtrim($paths->systemDirectory, '\\/ ') . DIRECTORY_SEPARATOR . 'bootstrap.php';
echo "Bootstrap path: $bootstrap<br>";

if (!file_exists($bootstrap)) {
    echo "ERROR: Bootstrap file not found!<br>";
    exit;
}

$app = require $bootstrap;
echo "App bootstrapped<br>";

echo "=== CI Loaded Successfully ===";
