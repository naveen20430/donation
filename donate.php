<?php
$pageTitle = 'Donate - DonateNow';
require_once __DIR__ . '/config/database.php';
require_once __DIR__ . '/includes/functions.php';
require_once __DIR__ . '/includes/header.php';

$selectedCampaignId = isset($_GET['campaign']) ? (int)$_GET['campaign'] : 0;
$csrfToken = generateCSRFToken();

// Get all campaigns for dropdown
$stmt = $pdo->query("SELECT id, title FROM campaigns ORDER BY title");
$campaigns = $stmt->fetchAll();

// Get selected campaign if provided
$selectedCampaign = null;
if ($selectedCampaignId > 0) {
    $stmt = $pdo->prepare("SELECT * FROM campaigns WHERE id = ?");
    $stmt->execute([$selectedCampaignId]);
    $selectedCampaign = $stmt->fetch();
}
?>

<section class="py-5" style="margin-top: 76px;">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="text-center mb-5">
                    <h1 class="display-4 fw-bold">Make a Donation</h1>
                    <p class="lead text-muted">Your generosity makes a difference</p>
                </div>

                <div class="card shadow-lg">
                    <div class="card-body p-4">
                        <?php if (isset($_SESSION['error'])): ?>
                        <div class="alert alert-danger alert-dismissible fade show">
                            <?php echo htmlspecialchars($_SESSION['error']); unset($_SESSION['error']); ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                        <?php endif; ?>

                        <?php if (isset($_SESSION['success'])): ?>
                        <div class="alert alert-success alert-dismissible fade show">
                            <?php echo htmlspecialchars($_SESSION['success']); unset($_SESSION['success']); ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                        <?php endif; ?>

                        <form action="/process_donation.php" method="POST" enctype="multipart/form-data">
                            <input type="hidden" name="csrf_token" value="<?php echo $csrfToken; ?>">

                            <?php if ($selectedCampaign): ?>
                            <div class="alert alert-info">
                                <i class="bi bi-info-circle me-2"></i>
                                Donating to: <strong><?php echo htmlspecialchars($selectedCampaign['title']); ?></strong>
                                <input type="hidden" name="campaign_id" value="<?php echo $selectedCampaign['id']; ?>">
                            </div>
                            <?php else: ?>
                            <div class="mb-4">
                                <label for="campaign_id" class="form-label fw-bold">Select Campaign <span class="text-danger">*</span></label>
                                <select class="form-select" id="campaign_id" name="campaign_id" required>
                                    <option value="">-- Select a Campaign --</option>
                                    <option value="0">General Donation (No specific campaign)</option>
                                    <?php foreach ($campaigns as $camp): ?>
                                    <option value="<?php echo $camp['id']; ?>" <?php echo ($selectedCampaignId == $camp['id']) ? 'selected' : ''; ?>>
                                        <?php echo htmlspecialchars($camp['title']); ?>
                                    </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <?php endif; ?>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="donor_name" class="form-label fw-bold">Full Name <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="donor_name" name="donor_name" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="email" class="form-label fw-bold">Email Address <span class="text-danger">*</span></label>
                                    <input type="email" class="form-control" id="email" name="email" required>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="phone" class="form-label fw-bold">Phone Number</label>
                                    <input type="tel" class="form-control" id="phone" name="phone">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="amount" class="form-label fw-bold">Donation Amount ($) <span class="text-danger">*</span></label>
                                    <input type="number" class="form-control" id="amount" name="amount" min="1" step="0.01" required>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="message" class="form-label fw-bold">Message (Optional)</label>
                                <textarea class="form-control" id="message" name="message" rows="4" placeholder="Leave a message with your donation..."></textarea>
                            </div>

                            <div class="mb-4">
                                <label for="proof_file" class="form-label fw-bold">Payment Proof (Optional)</label>
                                <input type="file" class="form-control" id="proof_file" name="proof_file" accept="image/*,.pdf">
                                <small class="text-muted">Upload screenshot or receipt of payment (Max 5MB, Images or PDF)</small>
                            </div>

                            <div class="d-grid">
                                <button type="submit" class="btn btn-primary btn-lg">
                                    <i class="bi bi-heart-fill me-2"></i>Submit Donation
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="text-center mt-4">
                    <p class="text-muted">
                        <i class="bi bi-shield-check me-2"></i>
                        Your donation is secure and will be processed safely.
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>

<?php require_once __DIR__ . '/includes/footer.php'; ?>

