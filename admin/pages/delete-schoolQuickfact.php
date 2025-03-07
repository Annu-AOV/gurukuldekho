<?php
// Include database connection
include('../includes/db_connect.php');

// Check if ID is provided
if (!isset($_GET['id']) || empty($_GET['id'])) {
    echo "<script>alert('Invalid request!'); window.location.href='manage-schoolQuickfact.php';</script>";
    exit;
}

$id = $_GET['id'];

// Delete query
$delete_query = "DELETE FROM school_quickfact WHERE id = $id";

if (mysqli_query($conn, $delete_query)) {
    echo "<script>alert('School Quick Fact deleted successfully!'); window.location.href='manage-school-quickfact.php';</script>";
} else {
    echo "<script>alert('Error deleting record!'); window.location.href='manage-schoolQuickfact.php';</script>";
}

// Close connection
mysqli_close($conn);
?>
