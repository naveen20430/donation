<?php
/**
 * Process Contact Form
 * Sends email using PHPMailer
 */

require_once __DIR__ . '/includes/functions.php';

// Check if POST request
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: /contact.php');
    exit;
}

// Verify CSRF token
if (!isset($_POST['csrf_token']) || !verifyCSRFToken($_POST['csrf_token'])) {
    $_SESSION['error'] = 'Invalid security token. Please try again.';
    header('Location: /contact.php');
    exit;
}

// Sanitize inputs
$name = sanitizeInput($_POST['name'] ?? '');
$email = sanitizeInput($_POST['email'] ?? '');
$subject = sanitizeInput($_POST['subject'] ?? '');
$message = sanitizeInput($_POST['message'] ?? '');

// Validation
if (empty($name) || empty($email) || empty($subject) || empty($message)) {
    $_SESSION['error'] = 'All fields are required.';
    header('Location: /contact.php');
    exit;
}

if (!validateEmail($email)) {
    $_SESSION['error'] = 'Please provide a valid email address.';
    header('Location: /contact.php');
    exit;
}

// Try to send email using PHP mail() function
// Note: For production, you should use PHPMailer with SMTP
$to = 'info@donatenow.org'; // Change this to your email
$emailSubject = 'Contact Form: ' . $subject;
$emailMessage = "Name: $name\n";
$emailMessage .= "Email: $email\n\n";
$emailMessage .= "Message:\n$message";

$headers = "From: $email\r\n";
$headers .= "Reply-To: $email\r\n";
$headers .= "Content-Type: text/plain; charset=UTF-8\r\n";

if (mail($to, $emailSubject, $emailMessage, $headers)) {
    $_SESSION['success'] = 'Thank you for contacting us! We will get back to you soon.';
} else {
    $_SESSION['error'] = 'Sorry, there was an error sending your message. Please try again later.';
}

header('Location: /contact.php');
exit;
?>

