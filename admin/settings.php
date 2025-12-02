<?php
$pageTitle = 'Settings';
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/includes/header.php';

$csrfToken = generateCSRFToken();
?>

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Settings</h1>
</div>

<?php if (isset($_SESSION['success'])): ?>
<div class="alert alert-success alert-dismissible fade show">
    <?php echo htmlspecialchars($_SESSION['success']); unset($_SESSION['success']); ?>
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>
<?php endif; ?>

<?php if (isset($_SESSION['error'])): ?>
<div class="alert alert-danger alert-dismissible fade show">
    <?php echo htmlspecialchars($_SESSION['error']); unset($_SESSION['error']); ?>
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>
<?php endif; ?>

<div class="card">
    <div class="card-header">
        <h5 class="mb-0">Change Password</h5>
    </div>
    <div class="card-body">
        <form action="/donation/admin/settings_save.php" method="POST">
            <input type="hidden" name="csrf_token" value="<?php echo $csrfToken; ?>">

            <div class="mb-3">
                <label for="current_password" class="form-label">Current Password <span class="text-danger">*</span></label>
                <input type="password" class="form-control" id="current_password" name="current_password" required>
            </div>

            <div class="mb-3">
                <label for="new_password" class="form-label">New Password <span class="text-danger">*</span></label>
                <input type="password" class="form-control" id="new_password" name="new_password" required minlength="6">
                <small class="text-muted">Minimum 6 characters</small>
            </div>

            <div class="mb-3">
                <label for="confirm_password" class="form-label">Confirm New Password <span class="text-danger">*</span></label>
                <input type="password" class="form-control" id="confirm_password" name="confirm_password" required minlength="6">
            </div>

            <button type="submit" class="btn btn-primary">
                <i class="bi bi-save me-2"></i>Update Password
            </button>
        </form>
    </div>
</div>

<?php require_once __DIR__ . '/includes/footer.php'; ?>

