<?php
$pageTitle = 'Edit Campaign';
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/includes/header.php';

$campaignId = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$csrfToken = generateCSRFToken();

// Get campaign details
$stmt = $pdo->prepare("SELECT * FROM campaigns WHERE id = ?");
$stmt->execute([$campaignId]);
$campaign = $stmt->fetch();

if (!$campaign) {
    $_SESSION['error'] = 'Campaign not found.';
    header('Location: /admin/campaigns.php');
    exit;
}
?>

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Edit Campaign</h1>
    <a href="/admin/campaigns.php" class="btn btn-secondary">Back to Campaigns</a>
</div>

<div class="card">
    <div class="card-body">
        <form action="/admin/campaign_save.php" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="csrf_token" value="<?php echo $csrfToken; ?>">
            <input type="hidden" name="action" value="edit">
            <input type="hidden" name="campaign_id" value="<?php echo $campaign['id']; ?>">

            <div class="mb-3">
                <label for="title" class="form-label">Campaign Title <span class="text-danger">*</span></label>
                <input type="text" class="form-control" id="title" name="title" value="<?php echo htmlspecialchars($campaign['title']); ?>" required>
            </div>

            <div class="mb-3">
                <label for="description" class="form-label">Description <span class="text-danger">*</span></label>
                <textarea class="form-control" id="description" name="description" rows="6" required><?php echo htmlspecialchars($campaign['description']); ?></textarea>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="goal_amount" class="form-label">Goal Amount ($) <span class="text-danger">*</span></label>
                    <input type="number" class="form-control" id="goal_amount" name="goal_amount" min="0" step="0.01" value="<?php echo $campaign['goal_amount']; ?>" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="deadline" class="form-label">Deadline</label>
                    <input type="date" class="form-control" id="deadline" name="deadline" value="<?php echo $campaign['deadline']; ?>">
                </div>
            </div>

            <?php if ($campaign['image']): ?>
            <div class="mb-3">
                <label class="form-label">Current Image</label>
                <div>
                    <img src="/uploads/<?php echo htmlspecialchars($campaign['image']); ?>" alt="Current" style="max-width: 300px; height: auto;" class="img-thumbnail">
                </div>
            </div>
            <?php endif; ?>

            <div class="mb-3">
                <label for="image" class="form-label"><?php echo $campaign['image'] ? 'Change' : 'Upload'; ?> Campaign Image</label>
                <input type="file" class="form-control" id="image" name="image" accept="image/*">
                <small class="text-muted">Recommended: 800x600px, Max 5MB (JPG, PNG, GIF, WebP)</small>
            </div>

            <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                <a href="/admin/campaigns.php" class="btn btn-secondary">Cancel</a>
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-save me-2"></i>Update Campaign
                </button>
            </div>
        </form>
    </div>
</div>

<?php require_once __DIR__ . '/includes/footer.php'; ?>

