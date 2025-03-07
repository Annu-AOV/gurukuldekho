<?php
// Include database connection
include('../includes/db_connect.php');

// Check if ID is set
if (!isset($_GET['id']) || empty($_GET['id'])) {
    echo "<script>alert('Invalid Request!'); window.location.href='manage-school-document.php';</script>";
    exit;
}

$id = intval($_GET['id']);

// Delete document record
$delete_query = "DELETE FROM school_documents WHERE id = $id";

if (mysqli_query($conn, $delete_query)) {
    echo "<script>alert('Deleted Successfully!'); window.location.href='manage-school-document.php';</script>";
} else {
    echo "Error deleting record: " . mysqli_error($conn);
}
?>
