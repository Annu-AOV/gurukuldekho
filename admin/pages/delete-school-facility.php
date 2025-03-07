<?php
// Include database connection
include('../includes/db_connect.php');

// Check if 'id' parameter is set in the URL
if (isset($_GET['id'])) {
    $id = intval($_GET['id']); // Sanitize input to prevent SQL injection

    // Delete the school facility record
    $query = "DELETE FROM school_facility WHERE id = $id";
    
    if (mysqli_query($conn, $query)) {
        // If deletion is successful, redirect with success message
        header("Location: manage-school-facility.php?message=success");
    } else {
        // If deletion fails, redirect with error message
        header("Location: manage-school-facility.php?message=error");
    }
} else {
    // If no ID is provided, redirect to manage page
    header("Location: manage-school-facility.php");
}

// Close the database connection
mysqli_close($conn);
exit();
?>