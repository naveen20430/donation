<?php
// Start session and include functions
require_once __DIR__ . '/functions.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo isset($pageTitle) ? htmlspecialchars($pageTitle) : 'Donation Platform'; ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="/donation/assets/css/style.css">
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary fixed-top">
        <div class="container">
            <a class="navbar-brand fw-bold" href="/donation/index.php">
                <i class="bi bi-heart-fill me-2"></i>DonateNow
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="/donation/index.php">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/donation/campaigns.php">Campaigns</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/donation/donate.php">Donate</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/donation/about.php">About</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/donation/contact.php">Contact</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

