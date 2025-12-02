<?php
$pageTitle = 'Manage Campaigns';
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/includes/header.php';

// Get all campaigns
$stmt = $pdo->query("SELECT * FROM campaigns ORDER BY created_at DESC");
$campaigns = $stmt->fetchAll();
?>

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Manage Campaigns</h1>
    <a href="/donation/admin/campaign_add.php" class="btn btn-primary">
        <i class="bi bi-plus-circle me-2"></i>Add New Campaign
    </a>
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
    <div class="card-body">
        <?php if (empty($campaigns)): ?>
        <p class="text-muted text-center py-4">No campaigns found. <a href="/donation/admin/campaign_add.php">Create your first campaign</a>.</p>
        <?php else: ?>
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Image</th>
                        <th>Title</th>
                        <th>Goal</th>
                        <th>Collected</th>
                        <th>Progress</th>
                        <th>Deadline</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($campaigns as $campaign): 
                        $progress = calculateProgress($campaign['collected_amount'], $campaign['goal_amount']);
                    ?>
                    <tr>
                        <td><?php echo $campaign['id']; ?></td>
                        <td>
                            <?php if ($campaign['image']): ?>
                            <img src="/donation/uploads/<?php echo htmlspecialchars($campaign['image']); ?>" alt="Campaign" style="width: 60px; height: 60px; object-fit: cover;" class="rounded">
                            <?php else: ?>
                            <i class="bi bi-image text-muted" style="font-size: 2rem;"></i>
                            <?php endif; ?>
                        </td>
                        <td><?php echo htmlspecialchars($campaign['title']); ?></td>
                        <td>$<?php echo formatCurrency($campaign['goal_amount']); ?></td>
                        <td><strong class="text-success">$<?php echo formatCurrency($campaign['collected_amount']); ?></strong></td>
                        <td>
                            <div class="progress" style="height: 20px; width: 100px;">
                                <div class="progress-bar" role="progressbar" style="width: <?php echo $progress; ?>%"><?php echo $progress; ?>%</div>
                            </div>
                        </td>
                        <td><?php echo $campaign['deadline'] ? formatDate($campaign['deadline']) : 'No deadline'; ?></td>
                        <td>
                            <a href="/donation/admin/campaign_edit.php?id=<?php echo $campaign['id']; ?>" class="btn btn-sm btn-primary">
                                <i class="bi bi-pencil"></i>
                            </a>
                            <a href="/donation/admin/campaign_delete.php?id=<?php echo $campaign['id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this campaign?');">
                                <i class="bi bi-trash"></i>
                            </a>
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

