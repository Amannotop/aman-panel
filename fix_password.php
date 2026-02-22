<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

$host = 'dpg-d6dfkdhr0fns73cqksj0-a.oregon-postgres.render.com';
$db   = 'aman_panel';
$user = 'aman_panel_user';
$pass = 'zlthHrxOudcWpNiucw6vYBTZRTAYhhaw';
$port = 5432;

try {
    $dsn = "pgsql:host=$host;port=$port;dbname=$db";
    $pdo = new PDO($dsn, $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    echo "Connected to database successfully!<br><br>";
    
    $passwordHash = '$2y$08$GEG/7Ab.3X97o6qzvE8A0OxTuqujhrX7RZ1xg2A0VSB.gtps9jVFW';
    
    $stmt = $pdo->prepare("UPDATE users SET password = :password WHERE username = 'cheatbot'");
    $stmt->execute([':password' => $passwordHash]);
    
    echo "Password updated successfully!<br><br>";
    
    $result = $pdo->query("SELECT username, password FROM users WHERE username = 'cheatbot'");
    $user = $result->fetch(PDO::FETCH_ASSOC);
    
    echo "User: " . $user['username'] . "<br>";
    echo "Password: " . $user['password'] . "<br>";
    
    echo "<br>Done! You can now login with username: cheatbot and the original password.";
    
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
