<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "Test file working!<br>";
echo "PHP Version: " . phpversion() . "<br>";

try {
    $host = 'dpg-d6dfkdhr0fns73cqksj0-a.oregon-postgres.render.com';
    $db   = 'aman_panel';
    $user = 'aman_panel_user';
    $pass = 'zlthHrxOudcWpNiucw6vYBTZRTAYhhaw';
    $port = 5432;

    $dsn = "pgsql:host=$host;port=$port;dbname=$db";
    $pdo = new PDO($dsn, $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    echo "Database connected!<br>";
    
    $result = $pdo->query("SELECT * FROM users WHERE username = 'cheatbot'");
    $user = $result->fetch(PDO::FETCH_ASSOC);
    
    if ($user) {
        echo "User: " . $user['username'] . "<br>";
        echo "Password OK: " . (strpos($user['password'], 'GEG') !== false ? 'Yes' : 'No') . "<br>";
    }
    
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "<br>";
}
