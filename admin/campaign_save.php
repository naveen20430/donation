<?php
/**
 * Save Campaign (Add/Edit)
 */

require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../includes/functions.php';
requireAdminLogin();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: /donation/admin/campaigns.php');
    exit;
}

// Verify CSRF token
if (!isset($_POST['csrf_token']) || !verifyCSRFToken($_POST['csrf_token'])) {
    $_SESSION['error'] = 'Invalid security token.';
    header('Location: /donation/admin/campaigns.php');
    exit;
}

$action = $_POST['action'] ?? '';
$campaignId = isset($_POST['campaign_id']) ? (int)$_POST['campaign_id'] : 0;

// Sanitize inputs
$title = sanitizeInput($_POST['title'] ?? '');
$description = sanitizeInput($_POST['description'] ?? '');
$goalAmount = isset($_POST['goal_amount']) ? (float)$_POST['goal_amount'] : 0;
$deadline = !empty($_POST['deadline']) ? $_POST['deadline'] : null;

// Validation
if (empty($title) || empty($description) || $goalAmount <= 0) {
    $_SESSION['error'] = 'Please fill all required fields correctly.';
    header('Location: /donation/admin/campaigns.php');
    exit;
}

try {
    // Handle image upload
    $imageFilename = null;
    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $uploadResult = uploadFile($_FILES['image']);
        if ($uploadResult['success']) {
            $imageFilename = $uploadResult['filename'];
        } else {
            $_SESSION['error'] = $uploadResult['message'];
            header('Location: /donation/admin/campaigns.php');
            exit;
        }
    }

    if ($action === 'add') {
        // Insert new campaign
        $stmt = $pdo->prepare("INSERT INTO campaigns (title, description, goal_amount, deadline, image) VALUES (?, ?, ?, ?, ?)");
        $stmt->execute([$title, $description, $goalAmount, $deadline, $imageFilename]);
        $_SESSION['success'] = 'Campaign added successfully!';
    } else {
        // Update existing campaign
        $oldImage = null;
        if ($campaignId > 0) {
            $stmt = $pdo->prepare("SELECT image FROM campaigns WHERE id = ?");
            $stmt->execute([$campaignId]);
            $oldCampaign = $stmt->fetch();
            $oldImage = $oldCampaign['image'] ?? null;
        }

        if ($imageFilename) {
            // Delete old image if new one is uploaded
            if ($oldImage) {
                deleteFile($oldImage);
            }
            $stmt = $pdo->prepare("UPDATE campaigns SET title = ?, description = ?, goal_amount = ?, deadline = ?, image = ? WHERE id = ?");
            $stmt->execute([$title, $description, $goalAmount, $deadline, $imageFilename, $campaignId]);
        } else {
            $stmt = $pdo->prepare("UPDATE campaigns SET title = ?, description = ?, goal_amount = ?, deadline = ? WHERE id = ?");
            $stmt->execute([$title, $description, $goalAmount, $deadline, $campaignId]);
        }
        $_SESSION['success'] = 'Campaign updated successfully!';
    }

    header('Location: /donation/admin/campaigns.php');
    exit;

} catch (PDOException $e) {
    $_SESSION['error'] = 'An error occurred while saving the campaign.';
    header('Location: /donation/admin/campaigns.php');
    exit;
}
?>

