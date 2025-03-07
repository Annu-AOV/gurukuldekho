<?php
// Include database connection
include('../includes/db_connect.php');

if (!isset($_GET['id']) || empty($_GET['id'])) {
    echo "<script>alert('Invalid Request!'); window.location.href='manage-admission.php';</script>";
    exit;
}

$id = intval($_GET['id']);
$delete_query = "DELETE FROM admissions WHERE id = $id";

if (mysqli_query($conn, $delete_query)) {
    echo "<script>alert('Deleted Successfully!'); window.location.href='manage-admission.php';</script>";
} else {
    echo "Error deleting record: " . mysqli_error($conn);
}
?>
