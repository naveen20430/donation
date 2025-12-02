<?php
/**
 * Admin Logout
 */

require_once __DIR__ . '/../includes/functions.php';

session_start();
session_destroy();
header('Location: /donation/admin/login.php');
exit;
?>

