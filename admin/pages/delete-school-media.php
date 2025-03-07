<?php
include('../includes/db_connect.php');

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql = "DELETE FROM school_medias WHERE id = $id";

    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('Media deleted successfully!'); window.location.href='manage-school-media.php';</script>";
    } else {
        echo "Error deleting record: " . $conn->error;
    }
}
?>
