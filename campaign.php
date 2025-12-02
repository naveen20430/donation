<?php
$pageTitle = 'Campaign Details - DonateNow';
require_once __DIR__ . '/config/database.php';
require_once __DIR__ . '/includes/functions.php';
require_once __DIR__ . '/includes/header.php';

// Get campaign ID
$campaignId = isset($_GET['id']) ? (int)$_GET['id'] : 0;

// Get campaign details
$stmt = $pdo->prepare("SELECT * FROM campaigns WHERE id = ?");
$stmt->execute([$campaignId]);
$campaign = $stmt->fetch();

if (!$campaign) {
    header('Location: /donation/campaigns.php');
    exit;
}

$progress = calculateProgress($campaign['collected_amount'], $campaign['goal_amount']);
$daysLeft = $campaign['deadline'] ? ceil((strtotime($campaign['deadline']) - time()) / 86400) : null;
?>

<section class="py-5" style="margin-top: 76px;">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 mb-4">
                <?php if ($campaign['image']): ?>
                <img src="/donation/uploads/<?php echo htmlspecialchars($campaign['image']); ?>" class="img-fluid rounded shadow mb-4" alt="<?php echo htmlspecialchars($campaign['title']); ?>">
                <?php endif; ?>
                
                <h1 class="display-5 fw-bold mb-3"><?php echo htmlspecialchars($campaign['title']); ?></h1>
                <p class="lead text-muted mb-4"><?php echo nl2br(htmlspecialchars($campaign['description'])); ?></p>
            </div>

            <div class="col-lg-4">
                <div class="card shadow-lg sticky-top" style="top: 100px;">
                    <div class="card-body">
                        <h5 class="card-title fw-bold mb-4">Campaign Progress</h5>
                        
                        <div class="mb-4">
                            <div class="d-flex justify-content-between mb-2">
                                <span class="text-muted">Raised</span>
                                <strong class="text-success">$<?php echo formatCurrency($campaign['collected_amount']); ?></strong>
                            </div>
                            <div class="d-flex justify-content-between mb-2">
                                <span class="text-muted">Goal</span>
                                <strong>$<?php echo formatCurrency($campaign['goal_amount']); ?></strong>
                            </div>
                            <div class="progress mb-3" style="height: 15px;">
                                <div class="progress-bar bg-success" role="progressbar" style="width: <?php echo $progress; ?>%"></div>
                            </div>
                            <div class="text-center">
                                <strong class="text-primary"><?php echo $progress; ?>% Complete</strong>
                            </div>
                        </div>

                        <?php if ($campaign['deadline']): ?>
                        <div class="mb-4 p-3 bg-light rounded">
                            <small class="text-muted d-block mb-1">Deadline</small>
                            <strong><?php echo formatDate($campaign['deadline']); ?></strong>
                            <?php if ($daysLeft !== null): ?>
                                <br>
                                <small class="<?php echo $daysLeft > 0 ? 'text-info' : 'text-danger'; ?>">
                                    <?php if ($daysLeft > 0): ?>
                                        <i class="bi bi-clock me-1"></i><?php echo $daysLeft; ?> days remaining
                                    <?php else: ?>
                                        <i class="bi bi-x-circle me-1"></i>Campaign ended
                                    <?php endif; ?>
                                </small>
                            <?php endif; ?>
                        </div>
                        <?php endif; ?>

                        <a href="/donation/donate.php?campaign=<?php echo $campaign['id']; ?>" class="btn btn-primary btn-lg w-100">
                            <i class="bi bi-heart-fill me-2"></i>Donate Now
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?php require_once __DIR__ . '/includes/footer.php'; ?>

