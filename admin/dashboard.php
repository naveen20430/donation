<?php
$pageTitle = 'Dashboard';
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/includes/header.php';

// Get statistics
$stmt = $pdo->query("SELECT 
    COUNT(DISTINCT id) as total_donations,
    COALESCE(SUM(amount), 0) as total_amount,
    COUNT(DISTINCT email) as total_donors
    FROM donations WHERE status = 'approved'");
$stats = $stmt->fetch();

// Get pending donations count
$stmt = $pdo->query("SELECT COUNT(*) as count FROM donations WHERE status = 'pending'");
$pendingCount = $stmt->fetch()['count'];

// Get total campaigns
$stmt = $pdo->query("SELECT COUNT(*) as count FROM campaigns");
$campaignsCount = $stmt->fetch()['count'];

// Get recent donations
$stmt = $pdo->query("SELECT d.*, c.title as campaign_title FROM donations d LEFT JOIN campaigns c ON d.campaign_id = c.id ORDER BY d.donated_at DESC LIMIT 10");
$recentDonations = $stmt->fetchAll();
?>

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Dashboard</h1>
</div>

<!-- Statistics Cards -->
<div class="row mb-4">
    <div class="col-md-3 mb-3">
        <div class="card text-white bg-primary">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h6 class="card-subtitle mb-2">Total Raised</h6>
                        <h3 class="card-title">$<?php echo formatCurrency($stats['total_amount']); ?></h3>
                    </div>
                    <div class="align-self-center">
                        <i class="bi bi-currency-dollar" style="font-size: 2.5rem; opacity: 0.5;"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3 mb-3">
        <div class="card text-white bg-success">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h6 class="card-subtitle mb-2">Total Donors</h6>
                        <h3 class="card-title"><?php echo number_format($stats['total_donors']); ?></h3>
                    </div>
                    <div class="align-self-center">
                        <i class="bi bi-people" style="font-size: 2.5rem; opacity: 0.5;"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3 mb-3">
        <div class="card text-white bg-info">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h6 class="card-subtitle mb-2">Total Donations</h6>
                        <h3 class="card-title"><?php echo number_format($stats['total_donations']); ?></h3>
                    </div>
                    <div class="align-self-center">
                        <i class="bi bi-gift" style="font-size: 2.5rem; opacity: 0.5;"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3 mb-3">
        <div class="card text-white bg-warning">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h6 class="card-subtitle mb-2">Pending</h6>
                        <h3 class="card-title"><?php echo number_format($pendingCount); ?></h3>
                    </div>
                    <div class="align-self-center">
                        <i class="bi bi-clock-history" style="font-size: 2.5rem; opacity: 0.5;"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Recent Donations -->
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">Recent Donations</h5>
        <a href="/admin/donations.php" class="btn btn-sm btn-primary">View All</a>
    </div>
    <div class="card-body">
        <?php if (empty($recentDonations)): ?>
        <p class="text-muted text-center py-4">No donations yet.</p>
        <?php else: ?>
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Donor</th>
                        <th>Email</th>
                        <th>Amount</th>
                        <th>Campaign</th>
                        <th>Status</th>
                        <th>Date</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($recentDonations as $donation): ?>
                    <tr>
                        <td>#<?php echo $donation['id']; ?></td>
                        <td><?php echo htmlspecialchars($donation['donor_name']); ?></td>
                        <td><?php echo htmlspecialchars($donation['email']); ?></td>
                        <td><strong class="text-success">$<?php echo formatCurrency($donation['amount']); ?></strong></td>
                        <td><?php echo $donation['campaign_title'] ? htmlspecialchars($donation['campaign_title']) : '<em>General</em>'; ?></td>
                        <td>
                            <span class="badge bg-<?php echo $donation['status'] === 'approved' ? 'success' : ($donation['status'] === 'rejected' ? 'danger' : 'warning'); ?>">
                                <?php echo ucfirst($donation['status']); ?>
                            </span>
                        </td>
                        <td><?php echo formatDateTime($donation['donated_at']); ?></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <?php endif; ?>
    </div>
</div>

<?php require_once __DIR__ . '/includes/footer.php'; ?>

