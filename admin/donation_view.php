<?php
$pageTitle = 'View Donation';
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/includes/header.php';

$donationId = isset($_GET['id']) ? (int)$_GET['id'] : 0;

$stmt = $pdo->prepare("SELECT d.*, c.title as campaign_title FROM donations d LEFT JOIN campaigns c ON d.campaign_id = c.id WHERE d.id = ?");
$stmt->execute([$donationId]);
$donation = $stmt->fetch();

if (!$donation) {
    $_SESSION['error'] = 'Donation not found.';
    header('Location: /donation/admin/donations.php');
    exit;
}
?>

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Donation Details #<?php echo $donation['id']; ?></h1>
    <a href="/donation/admin/donations.php" class="btn btn-secondary">Back to Donations</a>
</div>

<div class="row">
    <div class="col-md-8">
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="mb-0">Donor Information</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <strong>Name:</strong><br>
                        <?php echo htmlspecialchars($donation['donor_name']); ?>
                    </div>
                    <div class="col-md-6 mb-3">
                        <strong>Email:</strong><br>
                        <?php echo htmlspecialchars($donation['email']); ?>
                    </div>
                    <div class="col-md-6 mb-3">
                        <strong>Phone:</strong><br>
                        <?php echo htmlspecialchars($donation['phone'] ?? 'N/A'); ?>
                    </div>
                    <div class="col-md-6 mb-3">
                        <strong>Amount:</strong><br>
                        <span class="text-success fw-bold fs-4">$<?php echo formatCurrency($donation['amount']); ?></span>
                    </div>
                </div>
            </div>
        </div>

        <div class="card mb-4">
            <div class="card-header">
                <h5 class="mb-0">Donation Details</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <strong>Campaign:</strong><br>
                        <?php echo $donation['campaign_title'] ? htmlspecialchars($donation['campaign_title']) : '<em>General Donation</em>'; ?>
                    </div>
                    <div class="col-md-6 mb-3">
                        <strong>Status:</strong><br>
                        <span class="badge bg-<?php echo $donation['status'] === 'approved' ? 'success' : ($donation['status'] === 'rejected' ? 'danger' : 'warning'); ?> fs-6">
                            <?php echo ucfirst($donation['status']); ?>
                        </span>
                    </div>
                    <div class="col-md-6 mb-3">
                        <strong>Date:</strong><br>
                        <?php echo formatDateTime($donation['donated_at']); ?>
                    </div>
                </div>
                <?php if ($donation['message']): ?>
                <div class="mt-3">
                    <strong>Message:</strong><br>
                    <p class="mt-2"><?php echo nl2br(htmlspecialchars($donation['message'])); ?></p>
                </div>
                <?php endif; ?>
            </div>
        </div>

        <?php if ($donation['proof_file']): ?>
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Payment Proof</h5>
            </div>
            <div class="card-body">
                <a href="/donation/uploads/<?php echo htmlspecialchars($donation['proof_file']); ?>" target="_blank" class="btn btn-primary">
                    <i class="bi bi-download me-2"></i>View/Download Proof
                </a>
            </div>
        </div>
        <?php endif; ?>
    </div>

    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Actions</h5>
            </div>
            <div class="card-body">
                <?php if ($donation['status'] === 'pending'): ?>
                <div class="d-grid gap-2">
                    <a href="/donation/admin/donation_approve.php?id=<?php echo $donation['id']; ?>" class="btn btn-success" onclick="return confirm('Approve this donation?');">
                        <i class="bi bi-check-circle me-2"></i>Approve Donation
                    </a>
                    <a href="/donation/admin/donation_reject.php?id=<?php echo $donation['id']; ?>" class="btn btn-danger" onclick="return confirm('Reject this donation?');">
                        <i class="bi bi-x-circle me-2"></i>Reject Donation
                    </a>
                </div>
                <?php else: ?>
                <p class="text-muted">This donation has been <?php echo $donation['status']; ?>.</p>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/includes/footer.php'; ?>

