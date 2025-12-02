<?php
/**
 * Admin Header
 */

require_once __DIR__ . '/../../includes/functions.php';
requireAdminLogin();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo isset($pageTitle) ? htmlspecialchars($pageTitle) : 'Admin Panel'; ?> - DonateNow</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="/donation/assets/css/admin.css">
</head>
<body>
    <nav class="navbar navbar-dark bg-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="/donation/admin/dashboard.php">
                <i class="bi bi-shield-lock-fill me-2"></i>Admin Panel
            </a>
            <div class="d-flex">
                <span class="navbar-text text-light me-3">
                    <i class="bi bi-person-circle me-1"></i><?php echo htmlspecialchars($_SESSION['admin_name']); ?>
                </span>
                <a href="/donation/admin/logout.php" class="btn btn-outline-light btn-sm">
                    <i class="bi bi-box-arrow-right me-1"></i>Logout
                </a>
            </div>
        </div>
    </nav>

    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <nav class="col-md-3 col-lg-2 bg-light sidebar">
                <div class="position-sticky pt-3">
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link" href="/donation/admin/dashboard.php">
                                <i class="bi bi-speedometer2 me-2"></i>Dashboard
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="/donation/admin/campaigns.php">
                                <i class="bi bi-megaphone me-2"></i>Campaigns
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="/donation/admin/donations.php">
                                <i class="bi bi-cash-stack me-2"></i>Donations
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="/donation/admin/settings.php">
                                <i class="bi bi-gear me-2"></i>Settings
                            </a>
                        </li>
                    </ul>
                </div>
            </nav>

            <!-- Main content -->
            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">

