<?php
/**
 * Process Donation
 * Handles donation form submission with security checks
 */

require_once __DIR__ . '/config/database.php';
require_once __DIR__ . '/includes/functions.php';

// Check if POST request
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: /donate.php');
    exit;
}

// Verify CSRF token
if (!isset($_POST['csrf_token']) || !verifyCSRFToken($_POST['csrf_token'])) {
    $_SESSION['error'] = 'Invalid security token. Please try again.';
    header('Location: /donate.php');
    exit;
}

// Sanitize and validate inputs
$campaignId = isset($_POST['campaign_id']) ? (int)$_POST['campaign_id'] : 0;
$donorName = sanitizeInput($_POST['donor_name'] ?? '');
$email = sanitizeInput($_POST['email'] ?? '');
$phone = sanitizeInput($_POST['phone'] ?? '');
$amount = isset($_POST['amount']) ? (float)$_POST['amount'] : 0;
$message = sanitizeInput($_POST['message'] ?? '');

// Validation
$errors = [];

if (empty($donorName)) {
    $errors[] = 'Name is required.';
}

if (empty($email) || !validateEmail($email)) {
    $errors[] = 'Valid email is required.';
}

if ($amount <= 0) {
    $errors[] = 'Donation amount must be greater than 0.';
}

// Validate campaign if provided
if ($campaignId > 0) {
    $stmt = $pdo->prepare("SELECT id FROM campaigns WHERE id = ?");
    $stmt->execute([$campaignId]);
    if (!$stmt->fetch()) {
        $errors[] = 'Invalid campaign selected.';
    }
}

if (!empty($errors)) {
    $_SESSION['error'] = implode(' ', $errors);
    header('Location: /donate.php' . ($campaignId > 0 ? '?campaign=' . $campaignId : ''));
    exit;
}

// Handle file upload if provided
$proofFile = null;
if (isset($_FILES['proof_file']) && $_FILES['proof_file']['error'] === UPLOAD_ERR_OK) {
    $uploadResult = uploadFile($_FILES['proof_file']);
    if ($uploadResult['success']) {
        $proofFile = $uploadResult['filename'];
    } else {
        $_SESSION['error'] = $uploadResult['message'];
        header('Location: /donate.php' . ($campaignId > 0 ? '?campaign=' . $campaignId : ''));
        exit;
    }
}

// Insert donation into database
try {
    $pdo->beginTransaction();

    // Insert donation
    $stmt = $pdo->prepare("INSERT INTO donations (campaign_id, donor_name, email, phone, amount, message, proof_file, status) VALUES (?, ?, ?, ?, ?, ?, ?, 'pending')");
    $stmt->execute([
        $campaignId > 0 ? $campaignId : null,
        $donorName,
        $email,
        $phone ?: null,
        $amount,
        $message ?: null,
        $proofFile
    ]);

    $donationId = $pdo->lastInsertId();

    // Note: Campaign collected_amount is updated only when donation is approved by admin
    // This prevents double-counting and ensures only verified donations are counted

    $pdo->commit();

    // Redirect to thank you page
    header('Location: /thank-you.php?id=' . $donationId);
    exit;

} catch (PDOException $e) {
    $pdo->rollBack();
    
    // Delete uploaded file if donation failed
    if ($proofFile) {
        deleteFile($proofFile);
    }
    
    $_SESSION['error'] = 'An error occurred while processing your donation. Please try again.';
    header('Location: /donate.php' . ($campaignId > 0 ? '?campaign=' . $campaignId : ''));
    exit;
}
?>

