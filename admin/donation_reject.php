<?php
/**
 * Reject Donation
 */

require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../includes/functions.php';
requireAdminLogin();

$donationId = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if ($donationId > 0) {
    try {
        // Update donation status
        $stmt = $pdo->prepare("UPDATE donations SET status = 'rejected' WHERE id = ? AND status = 'pending'");
        $stmt->execute([$donationId]);

        if ($stmt->rowCount() > 0) {
            $_SESSION['success'] = 'Donation rejected.';
        } else {
            $_SESSION['error'] = 'Donation not found or already processed.';
        }
    } catch (PDOException $e) {
        $_SESSION['error'] = 'An error occurred while rejecting the donation.';
    }
}

header('Location: /donation/admin/donations.php');
exit;
?>

