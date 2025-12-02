<?php
/**
 * Approve Donation
 */

require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../includes/functions.php';
requireAdminLogin();

$donationId = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if ($donationId > 0) {
    try {
        $pdo->beginTransaction();

        // Get donation details
        $stmt = $pdo->prepare("SELECT campaign_id, amount, status FROM donations WHERE id = ?");
        $stmt->execute([$donationId]);
        $donation = $stmt->fetch();

        if ($donation && $donation['status'] === 'pending') {
            // Update donation status
            $stmt = $pdo->prepare("UPDATE donations SET status = 'approved' WHERE id = ?");
            $stmt->execute([$donationId]);

            // Update campaign collected amount if campaign exists
            if ($donation['campaign_id']) {
                $stmt = $pdo->prepare("UPDATE campaigns SET collected_amount = collected_amount + ? WHERE id = ?");
                $stmt->execute([$donation['amount'], $donation['campaign_id']]);
            }

            $pdo->commit();
            $_SESSION['success'] = 'Donation approved successfully!';
        } else {
            $pdo->rollBack();
            $_SESSION['error'] = 'Donation not found or already processed.';
        }
    } catch (PDOException $e) {
        $pdo->rollBack();
        $_SESSION['error'] = 'An error occurred while approving the donation.';
    }
}

header('Location: /donation/admin/donations.php');
exit;
?>

