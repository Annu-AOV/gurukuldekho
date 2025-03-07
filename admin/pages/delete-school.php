<?php
include('../includes/db_connect.php'); // Include database connection

if (isset($_GET['id'])) {
    $id = intval($_GET['id']); // Sanitize the ID to prevent SQL injection

    // Delete related records from school_documents
    $deleteDocuments = "DELETE FROM school_documents WHERE school_id = $id";
    mysqli_query($conn, $deleteDocuments);

    // Delete related records from admissions
    $deleteAdmissions = "DELETE FROM admissions WHERE school_id = $id";
    mysqli_query($conn, $deleteAdmissions);

    // Now delete the school record
    $deleteSchool = "DELETE FROM schools WHERE id = $id";
    if (mysqli_query($conn, $deleteSchool)) {
        header("Location: manage-school.php?message=success");
    } else {
        header("Location: manage-school.php?message=error");
    }
} else {
    header("Location: manage-school.php");
}

mysqli_close($conn);
exit();

?>
