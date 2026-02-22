<?php
$host = 'dpg-d6dfkdhr0fns73cqksj0-a.oregon-postgres.render.com';
$db   = 'aman_panel';
$user = 'aman_panel_user';
$pass = 'zlthHrxOudcWpNiucw6vYBTZRTAYhhaw';
$port = 5432;

try {
    $dsn = "pgsql:host=$host;port=$port;dbname=$db;user=$user;password=$pass";
    $pdo = new PDO($dsn);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    echo "Connected successfully!<br><br>";
    
    $pdo->exec("CREATE TABLE IF NOT EXISTS asettings (
        id SERIAL PRIMARY KEY,
        averion VARCHAR(255) NOT NULL,
        alink VARCHAR(255) NOT NULL,
        alicence VARCHAR(255) NOT NULL
    )");
    
    $check = $pdo->query("SELECT COUNT(*) FROM asettings")->fetchColumn();
    if ($check == 0) {
        $pdo->exec(\"INSERT INTO asettings (averion, alink, alicence) VALUES ('1.8.6', 'https://6', 'G743GFD738GD83G6')\");
    }
    
    $pdo->exec("CREATE TABLE IF NOT EXISTS history (
        id_history SERIAL PRIMARY KEY,
        keys_id VARCHAR(33) DEFAULT NULL,
        user_do VARCHAR(33) DEFAULT NULL,
        info TEXT NOT NULL,
        created_at TIMESTAMP DEFAULT NULL,
        updated_at TIMESTAMP DEFAULT NULL
    )");
    
    $pdo->exec("CREATE TABLE IF NOT EXISTS keys_code (
        id_keys SERIAL PRIMARY KEY,
        game VARCHAR(32) NOT NULL,
        user_key VARCHAR(32) DEFAULT NULL,
        duration INTEGER DEFAULT NULL,
        expired_date TIMESTAMP DEFAULT NULL,
        max_devices INTEGER DEFAULT NULL,
        devices TEXT DEFAULT NULL,
        status SMALLINT DEFAULT 1,
        registrator VARCHAR(32) DEFAULT NULL,
        created_at TIMESTAMP DEFAULT NULL,
        updated_at TIMESTAMP DEFAULT NULL,
        UNIQUE (user_key)
    )");
    
    $pdo->exec("CREATE TABLE IF NOT EXISTS referral_code (
        id_reff SERIAL PRIMARY KEY,
        code VARCHAR(128) DEFAULT NULL,
        set_saldo INTEGER DEFAULT NULL,
        used_by VARCHAR(66) DEFAULT NULL,
        created_by VARCHAR(66) DEFAULT NULL,
        created_at TIMESTAMP DEFAULT NULL,
        updated_at TIMESTAMP DEFAULT NULL
    )");
    
    $pdo->exec("CREATE TABLE IF NOT EXISTS users (
        id_users SERIAL PRIMARY KEY,
        fullname VARCHAR(155) DEFAULT NULL,
        username VARCHAR(66) NOT NULL,
        level INTEGER DEFAULT 2,
        saldo INTEGER DEFAULT NULL,
        status SMALLINT DEFAULT 1,
        uplink VARCHAR(66) DEFAULT NULL,
        password VARCHAR(155) NOT NULL,
        created_at TIMESTAMP DEFAULT NULL,
        updated_at TIMESTAMP DEFAULT NULL,
        UNIQUE (username)
    )");
    
    $checkUser = $pdo->query("SELECT COUNT(*) FROM users WHERE username = 'cheatbot'")->fetchColumn();
    if ($checkUser == 0) {
        $pdo->exec(\"INSERT INTO users (fullname, username, level, saldo, status, uplink, password, created_at, updated_at) VALUES ('CHEATBOT', 'cheatbot', 1, 2388500, 1, 'CHEATBOT_OWNER', '\$2y\$08\$GEG/7Ab.3X97o6qzvE8A0OxTuqujhrX7RZ1xg2A0VSB.gtps9jVFW', NULL, '2023-10-11 11:04:01')\");
    }
    
    echo "All tables created successfully!";
    
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
