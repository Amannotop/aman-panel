<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "=== Environment Variables ===<br>";
echo "CI_ENVIRONMENT: " . getenv('CI_ENVIRONMENT') . "<br>";
echo "app.baseURL: " . getenv('app.baseURL') . "<br>";
echo "database.default.hostname: " . getenv('database.default.hostname') . "<br>";
echo "database.default.DBDriver: " . getenv('database.default.DBDriver') . "<br>";

echo "<br>=== Testing CI Database ===<br>";

try {
    $hostname = getenv('database.default.hostname') ?: 'dpg-d6dfkdhr0fns73cqksj0-a.oregon-postgres.render.com';
    $database = getenv('database.default.database') ?: 'aman_panel';
    $username = getenv('database.default.username') ?: 'aman_panel_user';
    $password = getenv('database.default.password') ?: 'zlthHrxOudcWpNiucw6vYBTZRTAYhhaw';
    $port = getenv('database.default.port') ?: 5432;

    $dsn = "pgsql:host=$hostname;port=$port;dbname=$database";
    $pdo = new PDO($dsn, $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    echo "Database connected via PDO!<br>";
    
    $result = $pdo->query("SELECT COUNT(*) as cnt FROM users");
    $count = $result->fetch(PDO::FETCH_ASSOC);
    echo "Users count: " . $count['cnt'] . "<br>";
    
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "<br>";
}
