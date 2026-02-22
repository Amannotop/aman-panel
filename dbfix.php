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
    
    // Fix password
    $passwordHash = '$2y$08$GEG/7Ab.3X97o6qzvE8A0OxTuqujhrX7RZ1xg2A0VSB.gtps9jVFW';
    $pdo->prepare("UPDATE users SET password = ? WHERE username = 'cheatbot'")->execute([$passwordHash]);
    
    // Add timestamp columns to all tables
    $tables = ['users', 'keys_code', 'history', 'referral_code', 'asettings'];
    foreach ($tables as $table) {
        $pdo->exec("ALTER TABLE $table ADD COLUMN IF NOT EXISTS created_at TIMESTAMP DEFAULT NULL");
        $pdo->exec("ALTER TABLE $table ADD COLUMN IF NOT EXISTS updated_at TIMESTAMP DEFAULT NULL");
    }
    
    echo "SUCCESS: All database fixes applied!";
    
} catch (PDOException $e) {
    echo "ERROR: " . $e->getMessage();
}
