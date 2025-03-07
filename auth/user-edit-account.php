<?php
session_start(); // Session Start
include '../admin/includes/db_connect.php';
// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: ../pages/home-page.php"); // Agar user login nahi hai toh login page par bhej do
    exit();
}

// Redirect user to the dashboard where they can edit their account
header("Location: ../pages/user-dashboard.php");
exit();
?>
