<?php
include('../includes/db_connect.php'); // Include database connection

// Check if course ID is provided
if (isset($_GET['id'])) {
    $course_id = $_GET['id'];

    // Delete the course from the database
    $query = "DELETE FROM courses WHERE id = $course_id";

    if (mysqli_query($conn, $query)) {
        // Redirect to manage-course.php with a success message
        header("Location: manage-course.php?msg=Course deleted successfully!");
        exit;
    } else {
        // Redirect to manage-course.php with an error message
        header("Location: manage-course.php?msg=Error deleting course: " . mysqli_error($conn));
        exit;
    }
} else {
    // Redirect to manage-course.php with an invalid ID message
    header("Location: manage-course.php?msg=Invalid course ID!");
    exit;
}
?>
