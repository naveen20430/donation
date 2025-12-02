<?php
$pageTitle = 'Home - DonateNow';
require_once __DIR__ . '/config/database.php';
require_once __DIR__ . '/includes/functions.php';
require_once __DIR__ . '/includes/header.php';

// Get impact stats
$stmt = $pdo->query("SELECT 
    COUNT(DISTINCT id) as total_donations,
    COALESCE(SUM(amount), 0) as total_amount,
    COUNT(DISTINCT email) as total_donors
    FROM donations WHERE status = 'approved'");
$stats = $stmt->fetch();

// Get featured campaigns
$stmt = $pdo->query("SELECT * FROM campaigns ORDER BY created_at DESC LIMIT 3");
$featuredCampaigns = $stmt->fetchAll();
?>

<!-- Hero Section -->
<section class="hero-section text-white text-center py-5" style="margin-top: 76px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
    <div class="container">
        <div class="row align-items-center min-vh-50">
            <div class="col-lg-8 mx-auto">
                <h1 class="display-4 fw-bold mb-4">Make a Difference Today</h1>
                <p class="lead mb-4">Your generosity can change lives. Join thousands of donors making an impact in communities around the world.</p>
                <a href="/donate.php" class="btn btn-light btn-lg px-5">
                    <i class="bi bi-heart-fill me-2"></i>Donate Now
                </a>
            </div>
        </div>
    </div>
</section>

<!-- Impact Stats -->
<section class="py-5 bg-light">
    <div class="container">
        <div class="row text-center">
            <div class="col-md-4 mb-4">
                <div class="stat-card p-4 bg-white rounded shadow-sm">
                    <i class="bi bi-currency-dollar display-4 text-primary mb-3"></i>
                    <h3 class="fw-bold text-primary">$<?php echo formatCurrency($stats['total_amount']); ?></h3>
                    <p class="text-muted mb-0">Total Raised</p>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="stat-card p-4 bg-white rounded shadow-sm">
                    <i class="bi bi-people display-4 text-success mb-3"></i>
                    <h3 class="fw-bold text-success"><?php echo number_format($stats['total_donors']); ?></h3>
                    <p class="text-muted mb-0">Generous Donors</p>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="stat-card p-4 bg-white rounded shadow-sm">
                    <i class="bi bi-gift display-4 text-info mb-3"></i>
                    <h3 class="fw-bold text-info"><?php echo number_format($stats['total_donations']); ?></h3>
                    <p class="text-muted mb-0">Donations Made</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Featured Campaigns -->
<section class="py-5">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="display-5 fw-bold">Featured Campaigns</h2>
            <p class="text-muted">Help us reach our goals and make a lasting impact</p>
        </div>
        <div class="row">
            <?php foreach ($featuredCampaigns as $campaign): 
                $progress = calculateProgress($campaign['collected_amount'], $campaign['goal_amount']);
            ?>
            <div class="col-md-4 mb-4">
                <div class="card h-100 shadow-sm">
                    <?php if ($campaign['image']): ?>
                    <img src="/uploads/<?php echo htmlspecialchars($campaign['image']); ?>" class="card-img-top" alt="<?php echo htmlspecialchars($campaign['title']); ?>" style="height: 200px; object-fit: cover;">
                    <?php else: ?>
                    <div class="card-img-top bg-secondary d-flex align-items-center justify-content-center" style="height: 200px;">
                        <i class="bi bi-image text-white" style="font-size: 3rem;"></i>
                    </div>
                    <?php endif; ?>
                    <div class="card-body">
                        <h5 class="card-title fw-bold"><?php echo htmlspecialchars($campaign['title']); ?></h5>
                        <p class="card-text text-muted"><?php echo htmlspecialchars(substr($campaign['description'], 0, 100)) . '...'; ?></p>
                        <div class="mb-3">
                            <div class="d-flex justify-content-between mb-1">
                                <small class="text-muted">Progress</small>
                                <small class="text-muted"><?php echo $progress; ?>%</small>
                            </div>
                            <div class="progress" style="height: 8px;">
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
                        <a href="/campaign.php?id=<?php echo $campaign['id']; ?>" class="btn btn-primary w-100">View Details</a>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
        <div class="text-center mt-4">
            <a href="/campaigns.php" class="btn btn-outline-primary btn-lg">View All Campaigns</a>
        </div>
    </div>
</section>

<!-- Testimonials -->
<section class="py-5 bg-light">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="display-5 fw-bold">What Donors Say</h2>
            <p class="text-muted">Hear from people making a difference</p>
        </div>
        <div class="row">
            <div class="col-md-4 mb-4">
                <div class="card h-100 shadow-sm">
                    <div class="card-body">
                        <div class="mb-3">
                            <i class="bi bi-star-fill text-warning"></i>
                            <i class="bi bi-star-fill text-warning"></i>
                            <i class="bi bi-star-fill text-warning"></i>
                            <i class="bi bi-star-fill text-warning"></i>
                            <i class="bi bi-star-fill text-warning"></i>
                        </div>
                        <p class="card-text">"Knowing that my donation is making a real impact gives me so much joy. This platform makes it easy to support causes I care about."</p>
                        <div class="d-flex align-items-center">
                            <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 50px; height: 50px;">
                                <i class="bi bi-person-fill"></i>
                            </div>
                            <div>
                                <strong>Sarah Johnson</strong>
                                <small class="text-muted d-block">Regular Donor</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="card h-100 shadow-sm">
                    <div class="card-body">
                        <div class="mb-3">
                            <i class="bi bi-star-fill text-warning"></i>
                            <i class="bi bi-star-fill text-warning"></i>
                            <i class="bi bi-star-fill text-warning"></i>
                            <i class="bi bi-star-fill text-warning"></i>
                            <i class="bi bi-star-fill text-warning"></i>
                        </div>
                        <p class="card-text">"Transparency and trust are important to me. I can see exactly where my money goes and the impact it creates. Highly recommended!"</p>
                        <div class="d-flex align-items-center">
                            <div class="bg-success text-white rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 50px; height: 50px;">
                                <i class="bi bi-person-fill"></i>
                            </div>
                            <div>
                                <strong>Michael Chen</strong>
                                <small class="text-muted d-block">Corporate Sponsor</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="card h-100 shadow-sm">
                    <div class="card-body">
                        <div class="mb-3">
                            <i class="bi bi-star-fill text-warning"></i>
                            <i class="bi bi-star-fill text-warning"></i>
                            <i class="bi bi-star-fill text-warning"></i>
                            <i class="bi bi-star-fill text-warning"></i>
                            <i class="bi bi-star-fill text-warning"></i>
                        </div>
                        <p class="card-text">"The process is simple, secure, and I receive updates on how my donation is being used. It's a wonderful platform for giving back."</p>
                        <div class="d-flex align-items-center">
                            <div class="bg-info text-white rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 50px; height: 50px;">
                                <i class="bi bi-person-fill"></i>
                            </div>
                            <div>
                                <strong>Emily Rodriguez</strong>
                                <small class="text-muted d-block">Community Leader</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- CTA Section -->
<section class="py-5 text-white text-center" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
    <div class="container">
        <h2 class="display-5 fw-bold mb-3">Ready to Make an Impact?</h2>
        <p class="lead mb-4">Every donation counts. Join us in creating positive change.</p>
        <a href="/donate.php" class="btn btn-light btn-lg px-5">
            <i class="bi bi-heart-fill me-2"></i>Start Donating
        </a>
    </div>
</section>

<?php require_once __DIR__ . '/includes/footer.php'; ?>

