<?php
/**
 * Export Donations to CSV
 */

require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../includes/functions.php';
requireAdminLogin();

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

// Set headers for CSV download
header('Content-Type: text/csv');
header('Content-Disposition: attachment; filename="donations_' . date('Y-m-d') . '.csv"');

// Open output stream
$output = fopen('php://output', 'w');

// Add CSV headers
fputcsv($output, ['ID', 'Donor Name', 'Email', 'Phone', 'Amount', 'Campaign', 'Status', 'Message', 'Date']);

// Add data rows
foreach ($donations as $donation) {
    fputcsv($output, [
        $donation['id'],
        $donation['donor_name'],
        $donation['email'],
        $donation['phone'] ?? '',
        $donation['amount'],
        $donation['campaign_title'] ?? 'General',
        $donation['status'],
        $donation['message'] ?? '',
        $donation['donated_at']
    ]);
}

fclose($output);
exit;
?>

