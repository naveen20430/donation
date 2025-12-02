<?php
/**
 * Save Settings (Change Password)
 */

require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../includes/functions.php';
requireAdminLogin();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: /donation/admin/settings.php');
    exit;
}

// Verify CSRF token
if (!isset($_POST['csrf_token']) || !verifyCSRFToken($_POST['csrf_token'])) {
    $_SESSION['error'] = 'Invalid security token.';
    header('Location: /donation/admin/settings.php');
    exit;
}

$currentPassword = $_POST['current_password'] ?? '';
$newPassword = $_POST['new_password'] ?? '';
$confirmPassword = $_POST['confirm_password'] ?? '';

// Validation
if (empty($currentPassword) || empty($newPassword) || empty($confirmPassword)) {
    $_SESSION['error'] = 'All fields are required.';
    header('Location: /donation/admin/settings.php');
    exit;
}

if (strlen($newPassword) < 6) {
    $_SESSION['error'] = 'New password must be at least 6 characters long.';
    header('Location: /donation/admin/settings.php');
    exit;
}

if ($newPassword !== $confirmPassword) {
    $_SESSION['error'] = 'New passwords do not match.';
    header('Location: /donation/admin/settings.php');
    exit;
}

// Verify current password
$adminId = $_SESSION['admin_id'];
$stmt = $pdo->prepare("SELECT password FROM admins WHERE id = ?");
$stmt->execute([$adminId]);
$admin = $stmt->fetch();

if (!$admin || !password_verify($currentPassword, $admin['password'])) {
    $_SESSION['error'] = 'Current password is incorrect.';
    header('Location: /donation/admin/settings.php');
    exit;
}

// Update password
try {
    $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
    $stmt = $pdo->prepare("UPDATE admins SET password = ? WHERE id = ?");
    $stmt->execute([$hashedPassword, $adminId]);
    
    $_SESSION['success'] = 'Password updated successfully!';
} catch (PDOException $e) {
    $_SESSION['error'] = 'An error occurred while updating the password.';
}

header('Location: /donation/admin/settings.php');
exit;
?>

