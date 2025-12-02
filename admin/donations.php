<?php
$pageTitle = 'Manage Donations';
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/includes/header.php';

// Get filter parameters
$filterCampaign = isset($_GET['campaign']) ? (int)$_GET['campaign'] : 0;
$filterDate = isset($_GET['date']) ? $_GET['date'] : '';
$filterStatus = isset($_GET['status']) ? $_GET['status'] : '';

// Build query
$where = [];
$params = [];

if ($filterCampaign > 0) {
    $where[] = "d.campaign_id = ?";
    $params[] = $filterCampaign;
}

if ($filterDate) {
    $where[] = "DATE(d.donated_at) = ?";
    $params[] = $filterDate;
}

if ($filterStatus) {
    $where[] = "d.status = ?";
    $params[] = $filterStatus;
}

$whereClause = !empty($where) ? "WHERE " . implode(" AND ", $where) : "";

// Get donations
$sql = "SELECT d.*, c.title as campaign_title FROM donations d LEFT JOIN campaigns c ON d.campaign_id = c.id $whereClause ORDER BY d.donated_at DESC";
$stmt = $pdo->prepare($sql);
$stmt->execute($params);
$donations = $stmt->fetchAll();

// Get campaigns for filter
$stmt = $pdo->query("SELECT id, title FROM campaigns ORDER BY title");
$campaigns = $stmt->fetchAll();
?>

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Manage Donations</h1>
    <a href="/admin/donations_export.php?<?php echo http_build_query($_GET); ?>" class="btn btn-success">
        <i class="bi bi-download me-2"></i>Export CSV
    </a>
</div>

<?php if (isset($_SESSION['success'])): ?>
<div class="alert alert-success alert-dismissible fade show">
    <?php echo htmlspecialchars($_SESSION['success']); unset($_SESSION['success']); ?>
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>
<?php endif; ?>

<!-- Filters -->
<div class="card mb-4">
    <div class="card-body">
        <form method="GET" class="row g-3">
            <div class="col-md-3">
                <label for="campaign" class="form-label">Filter by Campaign</label>
                <select class="form-select" id="campaign" name="campaign">
                    <option value="">All Campaigns</option>
                    <?php foreach ($campaigns as $camp): ?>
                    <option value="<?php echo $camp['id']; ?>" <?php echo ($filterCampaign == $camp['id']) ? 'selected' : ''; ?>>
                        <?php echo htmlspecialchars($camp['title']); ?>
                    </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col-md-3">
                <label for="date" class="form-label">Filter by Date</label>
                <input type="date" class="form-control" id="date" name="date" value="<?php echo htmlspecialchars($filterDate); ?>">
            </div>
            <div class="col-md-3">
                <label for="status" class="form-label">Filter by Status</label>
                <select class="form-select" id="status" name="status">
                    <option value="">All Statuses</option>
                    <option value="pending" <?php echo ($filterStatus === 'pending') ? 'selected' : ''; ?>>Pending</option>
                    <option value="approved" <?php echo ($filterStatus === 'approved') ? 'selected' : ''; ?>>Approved</option>
                    <option value="rejected" <?php echo ($filterStatus === 'rejected') ? 'selected' : ''; ?>>Rejected</option>
                </select>
            </div>
            <div class="col-md-3">
                <label class="form-label">&nbsp;</label>
                <div class="d-grid">
                    <button type="submit" class="btn btn-primary">Apply Filters</button>
                </div>
            </div>
        </form>
    </div>
</div>

<div class="card">
    <div class="card-body">
        <?php if (empty($donations)): ?>
        <p class="text-muted text-center py-4">No donations found.</p>
        <?php else: ?>
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Donor Name</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Amount</th>
                        <th>Campaign</th>
                        <th>Status</th>
                        <th>Date</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($donations as $donation): ?>
                    <tr>
                        <td>#<?php echo $donation['id']; ?></td>
                        <td><?php echo htmlspecialchars($donation['donor_name']); ?></td>
                        <td><?php echo htmlspecialchars($donation['email']); ?></td>
                        <td><?php echo htmlspecialchars($donation['phone'] ?? 'N/A'); ?></td>
                        <td><strong class="text-success">$<?php echo formatCurrency($donation['amount']); ?></strong></td>
                        <td><?php echo $donation['campaign_title'] ? htmlspecialchars($donation['campaign_title']) : '<em>General</em>'; ?></td>
                        <td>
                            <span class="badge bg-<?php echo $donation['status'] === 'approved' ? 'success' : ($donation['status'] === 'rejected' ? 'danger' : 'warning'); ?>">
                                <?php echo ucfirst($donation['status']); ?>
                            </span>
                        </td>
                        <td><?php echo formatDateTime($donation['donated_at']); ?></td>
                        <td>
                            <a href="/admin/donation_view.php?id=<?php echo $donation['id']; ?>" class="btn btn-sm btn-info">
                                <i class="bi bi-eye"></i>
                            </a>
                            <?php if ($donation['status'] === 'pending'): ?>
                            <a href="/admin/donation_approve.php?id=<?php echo $donation['id']; ?>" class="btn btn-sm btn-success" onclick="return confirm('Approve this donation?');">
                                <i class="bi bi-check"></i>
                            </a>
                            <a href="/admin/donation_reject.php?id=<?php echo $donation['id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Reject this donation?');">
                                <i class="bi bi-x"></i>
                            </a>
                            <?php endif; ?>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <?php endif; ?>
    </div>
</div>

<?php require_once __DIR__ . '/includes/footer.php'; ?>

