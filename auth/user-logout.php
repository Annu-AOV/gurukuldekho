

<?php
session_start();
include '../admin/includes/db_connect.php';

// Check if remember_token exists in cookies
if (isset($_COOKIE['remember_token'])) {
    // Clear the remember token cookie
    setcookie('remember_token', '', time() - 3600, "/");
}

// Destroy session and clear session variables
session_unset();
session_destroy();

// Redirect to the homepage or login page
header("Location: ../pages/home-page.php");
exit;
?>
