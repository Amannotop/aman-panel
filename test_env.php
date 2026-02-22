<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require __DIR__ . '/vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

echo "baseURL: " . getenv('app.baseURL') . "<br>";
echo "CI_ENVIRONMENT: " . getenv('CI_ENVIRONMENT') . "<br>";
echo "DBDriver: " . getenv('database.default.DBDriver') . "<br>";
echo "Hostname: " . getenv('database.default.hostname') . "<br>";
