<?php
/**
 * Admin Logout
 */

require_once __DIR__ . '/../includes/functions.php';

session_start();
session_destroy();
header('Location: /admin/login.php');
exit;
?>

