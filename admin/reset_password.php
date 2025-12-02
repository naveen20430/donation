<?php
/**
 * Admin Password Reset Script
 * Run this once to create/update admin password
 * DELETE THIS FILE after use for security!
 */

require_once __DIR__ . '/../config/database.php';

// Set new admin credentials
$adminEmail = 'admin@donation.com';
$adminPassword = 'admin123'; // Change this to your desired password
$adminName = 'Administrator';

// Generate password hash
$hashedPassword = password_hash($adminPassword, PASSWORD_DEFAULT);

try {
    // Check if admin exists
    $stmt = $pdo->prepare("SELECT id FROM admins WHERE email = ?");
    $stmt->execute([$adminEmail]);
    $existing = $stmt->fetch();

    if ($existing) {
        // Update existing admin
        $stmt = $pdo->prepare("UPDATE admins SET password = ?, name = ? WHERE email = ?");
        $stmt->execute([$hashedPassword, $adminName, $adminEmail]);
        echo "✅ Admin password updated successfully!<br>";
        echo "Email: $adminEmail<br>";
        echo "Password: $adminPassword<br><br>";
    } else {
        // Create new admin
        $stmt = $pdo->prepare("INSERT INTO admins (name, email, password) VALUES (?, ?, ?)");
        $stmt->execute([$adminName, $adminEmail, $hashedPassword]);
        echo "✅ Admin account created successfully!<br>";
        echo "Email: $adminEmail<br>";
        echo "Password: $adminPassword<br><br>";
    }
    
    echo "⚠️ <strong>IMPORTANT:</strong> Delete this file (reset_password.php) immediately for security!<br>";
    echo "You can now login at: <a href='login.php'>Admin Login</a>";
    
} catch (PDOException $e) {
    echo "❌ Error: " . htmlspecialchars($e->getMessage());
}
?>

