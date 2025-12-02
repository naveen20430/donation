<?php
$pageTitle = 'Add Campaign';
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/includes/header.php';

$csrfToken = generateCSRFToken();
?>

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Add New Campaign</h1>
    <a href="/admin/campaigns.php" class="btn btn-secondary">Back to Campaigns</a>
</div>

<div class="card">
    <div class="card-body">
        <form action="/admin/campaign_save.php" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="csrf_token" value="<?php echo $csrfToken; ?>">
            <input type="hidden" name="action" value="add">

            <div class="mb-3">
                <label for="title" class="form-label">Campaign Title <span class="text-danger">*</span></label>
                <input type="text" class="form-control" id="title" name="title" required>
            </div>

            <div class="mb-3">
                <label for="description" class="form-label">Description <span class="text-danger">*</span></label>
                <textarea class="form-control" id="description" name="description" rows="6" required></textarea>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="goal_amount" class="form-label">Goal Amount ($) <span class="text-danger">*</span></label>
                    <input type="number" class="form-control" id="goal_amount" name="goal_amount" min="0" step="0.01" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="deadline" class="form-label">Deadline</label>
                    <input type="date" class="form-control" id="deadline" name="deadline">
                </div>
            </div>

            <div class="mb-3">
                <label for="image" class="form-label">Campaign Image</label>
                <input type="file" class="form-control" id="image" name="image" accept="image/*">
                <small class="text-muted">Recommended: 800x600px, Max 5MB (JPG, PNG, GIF, WebP)</small>
            </div>

            <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                <a href="/admin/campaigns.php" class="btn btn-secondary">Cancel</a>
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-save me-2"></i>Save Campaign
                </button>
            </div>
        </form>
    </div>
</div>

<?php require_once __DIR__ . '/includes/footer.php'; ?>

