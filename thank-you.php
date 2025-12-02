<?php
$pageTitle = 'Thank You - DonateNow';
require_once __DIR__ . '/config/database.php';
require_once __DIR__ . '/includes/functions.php';
require_once __DIR__ . '/includes/header.php';

$donationId = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if ($donationId > 0) {
    $stmt = $pdo->prepare("SELECT d.*, c.title as campaign_title FROM donations d LEFT JOIN campaigns c ON d.campaign_id = c.id WHERE d.id = ?");
    $stmt->execute([$donationId]);
    $donation = $stmt->fetch();
} else {
    $donation = null;
}
?>

<section class="py-5" style="margin-top: 76px;">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8 text-center">
                <div class="mb-4">
                    <i class="bi bi-check-circle-fill text-success" style="font-size: 5rem;"></i>
                </div>
                <h1 class="display-4 fw-bold mb-3">Thank You!</h1>
                <p class="lead text-muted mb-5">Your donation has been received and is being processed.</p>

                <?php if ($donation): ?>
                <div class="card shadow-lg mb-4">
                    <div class="card-body p-5">
                        <h3 class="fw-bold mb-4">Donation Details</h3>
                        <div class="row text-start">
                            <div class="col-md-6 mb-3">
                                <strong>Donation ID:</strong><br>
                                <span class="text-muted">#<?php echo $donation['id']; ?></span>
                            </div>
                            <div class="col-md-6 mb-3">
                                <strong>Amount:</strong><br>
                                <span class="text-success fw-bold fs-5">$<?php echo formatCurrency($donation['amount']); ?></span>
                            </div>
                            <div class="col-md-6 mb-3">
                                <strong>Donor Name:</strong><br>
                                <span class="text-muted"><?php echo htmlspecialchars($donation['donor_name']); ?></span>
                            </div>
                            <div class="col-md-6 mb-3">
                                <strong>Email:</strong><br>
                                <span class="text-muted"><?php echo htmlspecialchars($donation['email']); ?></span>
                            </div>
                            <?php if ($donation['campaign_title']): ?>
                            <div class="col-md-6 mb-3">
                                <strong>Campaign:</strong><br>
                                <span class="text-muted"><?php echo htmlspecialchars($donation['campaign_title']); ?></span>
                            </div>
                            <?php endif; ?>
                            <div class="col-md-6 mb-3">
                                <strong>Date:</strong><br>
                                <span class="text-muted"><?php echo formatDateTime($donation['donated_at']); ?></span>
                            </div>
                            <div class="col-md-6 mb-3">
                                <strong>Status:</strong><br>
                                <span class="badge bg-warning"><?php echo ucfirst($donation['status']); ?></span>
                            </div>
                        </div>
                    </div>
                </div>
                <?php endif; ?>

                <div class="alert alert-info">
                    <i class="bi bi-info-circle me-2"></i>
                    <strong>What's Next?</strong><br>
                    Your donation is currently pending approval. Once approved, you will receive a confirmation email. Thank you for your generosity!
                </div>

                <div class="mt-4">
                    <a href="/index.php" class="btn btn-primary btn-lg me-2">
                        <i class="bi bi-house me-2"></i>Return Home
                    </a>
                    <a href="/campaigns.php" class="btn btn-outline-primary btn-lg">
                        <i class="bi bi-heart me-2"></i>View More Campaigns
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

<?php require_once __DIR__ . '/includes/footer.php'; ?>

