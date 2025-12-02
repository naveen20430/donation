<?php
/**
 * Common Functions
 * Security and utility functions
 */

// Start session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

/**
 * Generate CSRF token
 */
function generateCSRFToken() {
    if (empty($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf_token'];
}

/**
 * Verify CSRF token
 */
function verifyCSRFToken($token) {
    return isset($_SESSION['csrf_token']) && hash_equals($_SESSION['csrf_token'], $token);
}

/**
 * Sanitize input to prevent XSS
 */
function sanitizeInput($data) {
    if (is_array($data)) {
        return array_map('sanitizeInput', $data);
    }
    return htmlspecialchars(strip_tags(trim($data)), ENT_QUOTES, 'UTF-8');
}

/**
 * Validate email
 */
function validateEmail($email) {
    return filter_var($email, FILTER_VALIDATE_EMAIL);
}

/**
 * Format currency
 */
function formatCurrency($amount) {
    return number_format($amount, 2);
}

/**
 * Format date
 */
function formatDate($date) {
    return date('F j, Y', strtotime($date));
}

/**
 * Format datetime
 */
function formatDateTime($datetime) {
    return date('F j, Y g:i A', strtotime($datetime));
}

/**
 * Check if user is logged in as admin
 */
function isAdminLoggedIn() {
    return isset($_SESSION['admin_id']) && isset($_SESSION['admin_email']);
}

/**
 * Require admin login
 */
function requireAdminLogin() {
    if (!isAdminLoggedIn()) {
        header('Location: /admin/login.php');
        exit;
    }
}

/**
 * Secure file upload
 */
function uploadFile($file, $uploadDir = 'uploads/', $allowedTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp', 'application/pdf']) {
    if (!isset($file['error']) || is_array($file['error'])) {
        return ['success' => false, 'message' => 'Invalid file upload.'];
    }

    if ($file['error'] !== UPLOAD_ERR_OK) {
        return ['success' => false, 'message' => 'File upload error.'];
    }

    // Check file size (max 5MB)
    if ($file['size'] > 5000000) {
        return ['success' => false, 'message' => 'File size exceeds 5MB limit.'];
    }

    // Check MIME type
    $finfo = new finfo(FILEINFO_MIME_TYPE);
    $mimeType = $finfo->file($file['tmp_name']);
    
    if (!in_array($mimeType, $allowedTypes)) {
        return ['success' => false, 'message' => 'Invalid file type.'];
    }

    // Generate unique filename
    $extension = pathinfo($file['name'], PATHINFO_EXTENSION);
    $filename = uniqid('file_', true) . '.' . $extension;
    $filepath = $uploadDir . $filename;

    // Create upload directory if it doesn't exist
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0755, true);
    }

    // Move uploaded file
    if (!move_uploaded_file($file['tmp_name'], $filepath)) {
        return ['success' => false, 'message' => 'Failed to save file.'];
    }

    return ['success' => true, 'filename' => $filename, 'filepath' => $filepath];
}

/**
 * Delete file
 */
function deleteFile($filename, $uploadDir = 'uploads/') {
    $filepath = $uploadDir . $filename;
    if (file_exists($filepath)) {
        return unlink($filepath);
    }
    return false;
}

/**
 * Calculate campaign progress percentage
 */
function calculateProgress($collected, $goal) {
    if ($goal == 0) return 0;
    $progress = ($collected / $goal) * 100;
    return min(100, round($progress, 2));
}
?>

