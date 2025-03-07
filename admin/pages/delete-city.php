<?php
include('../includes/header.php');
include('../includes/sidebar.php');
include('../config/db_connect.php');

// Check if 'city' parameter is present in the URL
if (isset($_GET['city'])) {
    $city_name = mysqli_real_escape_string($conn, $_GET['city']); // Sanitize the city name

    // Delete the city from the database
    $deleteQuery = "DELETE FROM city WHERE city_name = '$city_name'";

    if (mysqli_query($conn, $deleteQuery)) {
        // Redirect to the cities list page with a success message
        header("Location: manage-city.php?message=success");
        exit();
    } else {
        // Redirect to the cities list page with an error message
        header("Location: manage-city.php?message=error");
        exit();
    }
} else {
    // Redirect to the cities list page if no city is specified
    header("Location: manage-city.php?message=error");
    exit();
}