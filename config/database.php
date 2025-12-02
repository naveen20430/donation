<?php
/**
 * Database Configuration
 * Secure database connection using PDO with prepared statements
 */

// Database credentials
define('DB_HOST', 'srv1499.hstgr.io');
define('DB_NAME', 'u255007981_don');
define('DB_USER', 'u255007981_don');
define('DB_PASS', 'U255007981_don');
define('DB_CHARSET', 'utf8mb4');

// Create PDO connection
try {
    $dsn = "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=" . DB_CHARSET;
    $options = [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES   => false,
    ];
    
    $pdo = new PDO($dsn, DB_USER, DB_PASS, $options);
} catch (PDOException $e) {
    die("Database connection failed: " . htmlspecialchars($e->getMessage()));
}
?>

