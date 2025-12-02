<?php
/**
 * Delete Campaign
 */

require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../includes/functions.php';
requireAdminLogin();

$campaignId = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if ($campaignId > 0) {
    try {
        // Get campaign image to delete
        $stmt = $pdo->prepare("SELECT image FROM campaigns WHERE id = ?");
        $stmt->execute([$campaignId]);
        $campaign = $stmt->fetch();

        // Delete campaign (donations will have campaign_id set to NULL due to foreign key)
        $stmt = $pdo->prepare("DELETE FROM campaigns WHERE id = ?");
        $stmt->execute([$campaignId]);

        // Delete image file if exists
        if ($campaign && $campaign['image']) {
            deleteFile($campaign['image']);
        }

        $_SESSION['success'] = 'Campaign deleted successfully!';
    } catch (PDOException $e) {
        $_SESSION['error'] = 'An error occurred while deleting the campaign.';
    }
}

header('Location: /donation/admin/campaigns.php');
exit;
?>

