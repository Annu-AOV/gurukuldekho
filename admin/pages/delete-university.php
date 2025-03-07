<?php
include('../includes/db_connect.php'); // Include database connection

// Check if the 'id' parameter is set in the URL
if (isset($_GET['id'])) {
    $id = intval($_GET['id']); // Sanitize the ID to prevent SQL injection

    // Delete the school record
    $query = "DELETE FROM universities WHERE id = $id";
    if (mysqli_query($conn, $query)) {
        // If the record is deleted, redirect to manage-school.php with a success message
        header("Location: manage-university.php?message=success");
    } else {
        // If deletion fails, redirect with an error message
        header("Location: manage-university.php?message=error");
    }
} else {
    // If no ID is provided, redirect back to manage-school.php
    header("Location: manage-university.php");
}

// Close the database connection
mysqli_close($conn);
exit();
