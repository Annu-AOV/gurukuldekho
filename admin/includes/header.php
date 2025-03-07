<?php
session_start(); // Start the session

// Check if the admin is logged in
if (!isset($_SESSION['admin'])) {
    header("Location: ../login.php"); // Redirect to login page if not logged in
    exit();
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <script src="../assets/js/script.js"></script>

    <!-- Optional Custom CSS -->
    <link href="../assets/css/style.css" rel="stylesheet">
</head>

<body>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
        <div class="container-fluid">
            <!-- Left side: Logo -->
            <a class="navbar-brand d-flex align-items-center" href="#">
                <img src="../assets/uploads/glogo.png" alt="Logo" width="40" height="40"
                    class="d-inline-block align-text-top me-2">
                Admin Panel
            </a>

            <!-- Right side: Icons -->
            <div class="d-flex align-items-center">
                <!-- Bag Icon -->
                <!-- <a href="cart.php" class="btn btn-outline-light me-2">
                <i class="bi bi-bag"></i>
            </a> -->
                <!-- Profile Icon
                <a href="profile.php" class="btn btn-outline-light" style="margin:5px;border-radius: 50px;">
                    <i class="bi bi-person-circle"></i>
                </a> -->

                 <!-- Dark Mode Toggle -->
            <!-- <button class="btn ms-3" id="darkModeToggle">
                <i class="bi bi-moon-fill"></i>
            </button> -->

            <div style="background: #dc3545; padding: 10px; border-radius: 5px; text-align: center;">
    <i class="fas fa-sign-out-alt" style="color: white; margin-right: 5px;"></i>
    <a href="../logout.php" style="color: white; text-decoration: none; font-weight: bold;">Logout</a>
</div>

                <!-- Sidebar Toggle Button -->
                <button class="btn btn-outline-light d-lg-none" id="menu-toggle">
                    <i class="bi bi-list"></i>
                </button>
            </div>
        </div>
    </nav>