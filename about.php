<?php
$pageTitle = 'About Us - DonateNow';
require_once __DIR__ . '/includes/functions.php';
require_once __DIR__ . '/includes/header.php';
?>

<section class="py-5" style="margin-top: 76px;">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 mx-auto">
                <div class="text-center mb-5">
                    <h1 class="display-4 fw-bold">About DonateNow</h1>
                    <p class="lead text-muted">Making a difference, one donation at a time</p>
                </div>

                <div class="card shadow-sm mb-4">
                    <div class="card-body p-5">
                        <h2 class="fw-bold mb-4">Our Mission</h2>
                        <p class="lead">At DonateNow, we believe that everyone deserves a chance to thrive. Our mission is to connect generous donors with meaningful causes, creating positive change in communities around the world.</p>
                        
                        <p>We are committed to transparency, accountability, and making the donation process as simple and secure as possible. Every contribution, no matter the size, helps us move closer to our shared goals of education, healthcare, clean water, and emergency relief.</p>
                    </div>
                </div>

                <div class="row mb-4">
                    <div class="col-md-6 mb-4">
                        <div class="card h-100 shadow-sm">
                            <div class="card-body p-4">
                                <div class="text-center mb-3">
                                    <i class="bi bi-eye-fill text-primary" style="font-size: 3rem;"></i>
                                </div>
                                <h4 class="fw-bold text-center mb-3">Transparency</h4>
                                <p class="text-center text-muted">We believe in complete transparency. Every donation is tracked, and you can see exactly how your contribution is being used.</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 mb-4">
                        <div class="card h-100 shadow-sm">
                            <div class="card-body p-4">
                                <div class="text-center mb-3">
                                    <i class="bi bi-shield-check-fill text-success" style="font-size: 3rem;"></i>
                                </div>
                                <h4 class="fw-bold text-center mb-3">Security</h4>
                                <p class="text-center text-muted">Your data and donations are protected with industry-standard security measures. We take your privacy seriously.</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row mb-4">
                    <div class="col-md-6 mb-4">
                        <div class="card h-100 shadow-sm">
                            <div class="card-body p-4">
                                <div class="text-center mb-3">
                                    <i class="bi bi-heart-fill text-danger" style="font-size: 3rem;"></i>
                                </div>
                                <h4 class="fw-bold text-center mb-3">Impact</h4>
                                <p class="text-center text-muted">We focus on creating measurable, lasting impact in the communities we serve. Your donation makes a real difference.</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 mb-4">
                        <div class="card h-100 shadow-sm">
                            <div class="card-body p-4">
                                <div class="text-center mb-3">
                                    <i class="bi bi-people-fill text-info" style="font-size: 3rem;"></i>
                                </div>
                                <h4 class="fw-bold text-center mb-3">Community</h4>
                                <p class="text-center text-muted">Together, we build stronger communities. Join thousands of donors making a positive impact worldwide.</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card shadow-sm">
                    <div class="card-body p-5">
                        <h2 class="fw-bold mb-4">Our Values</h2>
                        <ul class="list-unstyled">
                            <li class="mb-3">
                                <i class="bi bi-check-circle-fill text-success me-2"></i>
                                <strong>Integrity:</strong> We operate with honesty and ethical standards in everything we do.
                            </li>
                            <li class="mb-3">
                                <i class="bi bi-check-circle-fill text-success me-2"></i>
                                <strong>Accountability:</strong> We are accountable to our donors, beneficiaries, and partners.
                            </li>
                            <li class="mb-3">
                                <i class="bi bi-check-circle-fill text-success me-2"></i>
                                <strong>Compassion:</strong> We approach every situation with empathy and understanding.
                            </li>
                            <li class="mb-3">
                                <i class="bi bi-check-circle-fill text-success me-2"></i>
                                <strong>Innovation:</strong> We continuously improve our platform to better serve our community.
                            </li>
                        </ul>
                    </div>
                </div>

                <div class="text-center mt-5">
                    <a href="/donation/donate.php" class="btn btn-primary btn-lg px-5">
                        <i class="bi bi-heart-fill me-2"></i>Join Us Today
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

<?php require_once __DIR__ . '/includes/footer.php'; ?>

