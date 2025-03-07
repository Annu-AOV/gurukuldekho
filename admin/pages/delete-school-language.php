<?php
include('../includes/db_connect.php');

$id = $_GET['id'];
$delete_query = "DELETE FROM school_language WHERE id = $id";

if (mysqli_query($conn, $delete_query)) {
    echo "<script>alert('Deleted Successfully!'); window.location.href='manage-school-lang.php';</script>";
} else {
    echo "Error deleting record: " . mysqli_error($conn);
}

mysqli_close($conn);
?>
