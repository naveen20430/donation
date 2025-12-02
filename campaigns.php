<?php
$pageTitle = 'Campaigns - DonateNow';
require_once __DIR__ . '/config/database.php';
require_once __DIR__ . '/includes/functions.php';
require_once __DIR__ . '/includes/header.php';

// Get all campaigns
$stmt = $pdo->query("SELECT * FROM campaigns ORDER BY created_at DESC");
$campaigns = $stmt->fetchAll();
?>

<section class="py-5" style="margin-top: 76px;">
    <div class="container">
        <div class="text-center mb-5">
            <h1 class="display-4 fw-bold">Our Campaigns</h1>
            <p class="lead text-muted">Choose a cause that matters to you</p>
        </div>

        <?php if (empty($campaigns)): ?>
        <div class="alert alert-info text-center">
            <i class="bi bi-info-circle me-2"></i>No campaigns available at the moment. Please check back later.
        </div>
        <?php else: ?>
        <div class="row">
            <?php foreach ($campaigns as $campaign): 
                $progress = calculateProgress($campaign['collected_amount'], $campaign['goal_amount']);
                $daysLeft = $campaign['deadline'] ? ceil((strtotime($campaign['deadline']) - time()) / 86400) : null;
            ?>
            <div class="col-md-6 col-lg-4 mb-4">
                <div class="card h-100 shadow-sm">
                    <?php if ($campaign['image']): ?>
                    <img src="/uploads/<?php echo htmlspecialchars($campaign['image']); ?>" class="card-img-top" alt="<?php echo htmlspecialchars($campaign['title']); ?>" style="height: 250px; object-fit: cover;">
                    <?php else: ?>
                    <div class="card-img-top bg-secondary d-flex align-items-center justify-content-center" style="height: 250px;">
                        <i class="bi bi-image text-white" style="font-size: 4rem;"></i>
                    </div>
                    <?php endif; ?>
                    <div class="card-body">
                        <h5 class="card-title fw-bold"><?php echo htmlspecialchars($campaign['title']); ?></h5>
                        <p class="card-text text-muted"><?php echo htmlspecialchars(substr($campaign['description'], 0, 120)) . '...'; ?></p>
                        
                        <div class="mb-3">
                            <div class="d-flex justify-content-between mb-1">
                                <small class="text-muted">Progress</small>
                                <small class="text-muted"><?php echo $progress; ?>%</small>
                            </div>
                            <div class="progress" style="height: 10px;">
                                <div class="progress-bar bg-success" role="progressbar" style="width: <?php echo $progress; ?>%"></div>
                            </div>
                        </div>

                        <div class="d-flex justify-content-between mb-3">
                            <div>
                                <small class="text-muted d-block">Raised</small>
                                <strong class="text-success">$<?php echo formatCurrency($campaign['collected_amount']); ?></strong>
                            </div>
                            <div class="text-end">
                                <small class="text-muted d-block">Goal</small>
                                <strong>$<?php echo formatCurrency($campaign['goal_amount']); ?></strong>
                            </div>
                        </div>

                        <?php if ($campaign['deadline']): ?>
                        <div class="mb-3">
                            <small class="text-muted">
                                <i class="bi bi-calendar-event me-1"></i>
                                <?php if ($daysLeft > 0): ?>
                                    <?php echo $daysLeft; ?> days left
                                <?php else: ?>
                                    <span class="text-danger">Campaign ended</span>
                                <?php endif; ?>
                            </small>
                        </div>
                        <?php endif; ?>

                        <a href="/campaign.php?id=<?php echo $campaign['id']; ?>" class="btn btn-primary w-100">
                            <i class="bi bi-arrow-right me-2"></i>View Details & Donate
                        </a>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
        <?php endif; ?>
    </div>
</section>

<?php require_once __DIR__ . '/includes/footer.php'; ?>

