<?php
$pageTitle = 'Contact Us - DonateNow';
require_once __DIR__ . '/includes/functions.php';
require_once __DIR__ . '/includes/header.php';

$csrfToken = generateCSRFToken();
?>

<section class="py-5" style="margin-top: 76px;">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 mx-auto">
                <div class="text-center mb-5">
                    <h1 class="display-4 fw-bold">Contact Us</h1>
                    <p class="lead text-muted">We'd love to hear from you</p>
                </div>

                <div class="row mb-5">
                    <div class="col-md-4 mb-4">
                        <div class="card h-100 shadow-sm text-center">
                            <div class="card-body p-4">
                                <i class="bi bi-envelope-fill text-primary mb-3" style="font-size: 2.5rem;"></i>
                                <h5 class="fw-bold">Email</h5>
                                <p class="text-muted mb-0">info@donatenow.org</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 mb-4">
                        <div class="card h-100 shadow-sm text-center">
                            <div class="card-body p-4">
                                <i class="bi bi-telephone-fill text-success mb-3" style="font-size: 2.5rem;"></i>
                                <h5 class="fw-bold">Phone</h5>
                                <p class="text-muted mb-0">+1 (555) 123-4567</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 mb-4">
                        <div class="card h-100 shadow-sm text-center">
                            <div class="card-body p-4">
                                <i class="bi bi-geo-alt-fill text-danger mb-3" style="font-size: 2.5rem;"></i>
                                <h5 class="fw-bold">Address</h5>
                                <p class="text-muted mb-0">123 Charity Street<br>City, Country</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card shadow-lg">
                    <div class="card-body p-5">
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

                        <form action="/donation/process_contact.php" method="POST">
                            <input type="hidden" name="csrf_token" value="<?php echo $csrfToken; ?>">

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="name" class="form-label fw-bold">Name <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="name" name="name" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="email" class="form-label fw-bold">Email <span class="text-danger">*</span></label>
                                    <input type="email" class="form-control" id="email" name="email" required>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="subject" class="form-label fw-bold">Subject <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="subject" name="subject" required>
                            </div>

                            <div class="mb-3">
                                <label for="message" class="form-label fw-bold">Message <span class="text-danger">*</span></label>
                                <textarea class="form-control" id="message" name="message" rows="6" required></textarea>
                            </div>

                            <div class="d-grid">
                                <button type="submit" class="btn btn-primary btn-lg">
                                    <i class="bi bi-send me-2"></i>Send Message
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?php require_once __DIR__ . '/includes/footer.php'; ?>

