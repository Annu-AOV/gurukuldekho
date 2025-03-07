<?php
// Include database connection
include('../includes/db_connect.php');

// Check if ID is set in the URL
if (isset($_GET['id'])) {
    $fee_id = $_GET['id'];

    // Delete query
    $delete_query = "DELETE FROM fee_structure WHERE id = '{$fee_id}'";

    if (mysqli_query($conn, $delete_query)) {
        echo "<script>alert('Fee Structure deleted successfully!'); window.location.href='manage-feeStructure.php';</script>";
    } else {
        echo "<script>alert('Error deleting Fee Structure: " . mysqli_error($conn) . "'); window.location.href='manage-feeStructure.php';</script>";
    }
} else {
    echo "<script>alert('Invalid request!'); window.location.href='manage-feeStructure.php';</script>";
}

// Close database connection
mysqli_close($conn);
?>
