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
    
    echo "=== Connected to database ===<br><br>";
    
    // Fix password
    $passwordHash = '$2y$08$GEG/7Ab.3X97o6qzvE8A0OxTuqujhrX7RZ1xg2A0VSB.gtps9jVFW';
    $stmt = $pdo->prepare("UPDATE users SET password = ? WHERE username = 'cheatbot'");
    $stmt->execute([$passwordHash]);
    echo "✓ Password fixed<br>";
    
    // Add timestamp columns to users table if not exist
    try {
        $pdo->exec("ALTER TABLE users ADD COLUMN IF NOT EXISTS created_at TIMESTAMP DEFAULT NULL");
        $pdo->exec("ALTER TABLE users ADD COLUMN IF NOT EXISTS updated_at TIMESTAMP DEFAULT NULL");
        echo "✓ Users table timestamps fixed<br>";
    } catch (Exception $e) {
        echo "Users table: " . $e->getMessage() . "<br>";
    }
    
    // Add timestamp columns to keys_code table
    try {
        $pdo->exec("ALTER TABLE keys_code ADD COLUMN IF NOT EXISTS created_at TIMESTAMP DEFAULT NULL");
        $pdo->exec("ALTER TABLE keys_code ADD COLUMN IF NOT EXISTS updated_at TIMESTAMP DEFAULT NULL");
        echo "✓ Keys table timestamps fixed<br>";
    } catch (Exception $e) {
        echo "Keys table: " . $e->getMessage() . "<br>";
    }
    
    // Add timestamp columns to history table
    try {
        $pdo->exec("ALTER TABLE history ADD COLUMN IF NOT EXISTS created_at TIMESTAMP DEFAULT NULL");
        $pdo->exec("ALTER TABLE history ADD COLUMN IF NOT EXISTS updated_at TIMESTAMP DEFAULT NULL");
        echo "✓ History table timestamps fixed<br>";
    } catch (Exception $e) {
        echo "History table: " . $e->getMessage() . "<br>";
    }
    
    // Add timestamp columns to referral_code table
    try {
        $pdo->exec("ALTER TABLE referral_code ADD COLUMN IF NOT EXISTS created_at TIMESTAMP DEFAULT NULL");
        $pdo->exec("ALTER TABLE referral_code ADD COLUMN IF NOT EXISTS updated_at TIMESTAMP DEFAULT NULL");
        echo "✓ Referral table timestamps fixed<br>";
    } catch (Exception $e) {
        echo "Referral table: " . $e->getMessage() . "<br>";
    }
    
    // Add timestamp columns to asettings table
    try {
        $pdo->exec("ALTER TABLE asettings ADD COLUMN IF NOT EXISTS created_at TIMESTAMP DEFAULT NULL");
        $pdo->exec("ALTER TABLE asettings ADD COLUMN IF NOT EXISTS updated_at TIMESTAMP DEFAULT NULL");
        echo "✓ Settings table timestamps fixed<br>";
    } catch (Exception $e) {
        echo "Settings table: " . $e->getMessage() . "<br>";
    }
    
    echo "<br>=== All fixes complete! ===<br>";
    echo "Now try: https://aman-panel-1.onrender.com/<br>";
    
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
