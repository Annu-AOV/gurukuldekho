<?php
// Include database connection
include('../includes/db_connect.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data
    $school_id = mysqli_real_escape_string($conn, $_POST['school_id']);
    $class = mysqli_real_escape_string($conn, $_POST['class']);
    $session = mysqli_real_escape_string($conn, $_POST['session']);
    $last_application_date = mysqli_real_escape_string($conn, $_POST['last_application_date']);
    $application_fee = mysqli_real_escape_string($conn, $_POST['application_fee']);
    $admission_process = mysqli_real_escape_string($conn, $_POST['admission_process']);
    $start_date = mysqli_real_escape_string($conn, $_POST['start_date']);
    $end_date = mysqli_real_escape_string($conn, $_POST['end_date']);

    // Insert data into the admissions table
    $query = "INSERT INTO admissions (school_id, class, session, last_application_date, application_fee, admission_process, start_date, end_date) 
              VALUES ('$school_id', '$class', '$session', '$last_application_date', '$application_fee', '$admission_process', '$start_date', '$end_date')";

    if (mysqli_query($conn, $query)) {
        echo "<script>
                alert('Admission added successfully!');
                window.location.href = 'manage-admission.php';
              </script>";
    } else {
        echo "<script>
                alert('Error: " . mysqli_error($conn) . "');
                window.history.back();
              </script>";
    }
}

// Close database connection
mysqli_close($conn);
?>
