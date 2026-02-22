<?php
$host = 'dpg-d6dfkdhr0fns73cqksj0-a.oregon-postgres.render.com';
$db   = 'aman_panel';
$user = 'aman_panel_user';
$pass = 'zlthHrxOudcWpNiucw6vYBTZRTAYhhaw';
$port = 5432;

try {
    $dsn = "pgsql:host=$host;port=$port;dbname=$db";
    $pdo = new PDO($dsn, $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    $stmt = $pdo->query("SELECT * FROM users WHERE username = 'cheatbot'");
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if ($user) {
        echo "User found!<br>";
        echo "Username: " . $user['username'] . "<br>";
        echo "Password hash: " . $user['password'] . "<br>";
    } else {
        echo "User not found!";
    }
    
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
