<?php
include('../includes/db_connect.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $school_id = mysqli_real_escape_string($conn, $_POST['school_id']);
    $class = mysqli_real_escape_string($conn, $_POST['class']);
    $session = mysqli_real_escape_string($conn, $_POST['session']);
    $batch = mysqli_real_escape_string($conn, $_POST['batch']);
    $course = mysqli_real_escape_string($conn, $_POST['course']);
    $security_fee = mysqli_real_escape_string($conn, $_POST['security_fee']);
    $registration_fee = mysqli_real_escape_string($conn, $_POST['registration_fee']);
    $admission_fee = mysqli_real_escape_string($conn, $_POST['admission_fee']);
    $annual_fee = mysqli_real_escape_string($conn, $_POST['annual_fee']);
    $tuition_fee = mysqli_real_escape_string($conn, $_POST['tuition_fee']);
    $examination_fee = mysqli_real_escape_string($conn, $_POST['examination_fee']);
    $library_fee = mysqli_real_escape_string($conn, $_POST['library_fee']);
    $sports_fee = mysqli_real_escape_string($conn, $_POST['sports_fee']);
    $hostel_fee = mysqli_real_escape_string($conn, $_POST['hostel_fee']);
    $frequency = mysqli_real_escape_string($conn, $_POST['frequency']);
    $refundable = mysqli_real_escape_string($conn, $_POST['refundable']);

    // Insert query
    $insert_query = "INSERT INTO fee_structure (school_id, class, session, batch, course, security_fee, registration_fee, admission_fee, annual_fee, tuition_fee, examination_fee, library_fee, sports_fee, hostel_fee, frequency, refundable) 
                     VALUES ('$school_id', '$class', '$session', '$batch', '$course', '$security_fee', '$registration_fee', '$admission_fee', '$annual_fee', '$tuition_fee', '$examination_fee', '$library_fee', '$sports_fee', '$hostel_fee', '$frequency', '$refundable')";

    if (mysqli_query($conn, $insert_query)) {
        echo "<script>alert('Fee Structure Added Successfully'); window.location.href='manage-feeStructure.php';</script>";
    } else {
        echo "<script>alert('Error: Could not add fee structure'); window.history.back();</script>";
    }
}
?>
