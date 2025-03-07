<?php
// Include database connection
include('../includes/db_connect.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $school_id = $_POST['school_id'];
    
    $extra_curricular = isset($_POST['extra_curricular']) ? implode(',', $_POST['extra_curricular']) : '';
    $class_facilities = isset($_POST['class_facilities']) ? implode(',', $_POST['class_facilities']) : '';
    $infrastructure = isset($_POST['infrastructure']) ? implode(',', $_POST['infrastructure']) : '';
    $sports_fitness = isset($_POST['sports_fitness']) ? implode(',', $_POST['sports_fitness']) : '';
    $lab_facilities = isset($_POST['lab_facilities']) ? implode(',', $_POST['lab_facilities']) : '';
    $boarding = isset($_POST['boarding']) ? implode(',', $_POST['boarding']) : '';
    $disabled_friendly = isset($_POST['disabled_friendly']) ? implode(',', $_POST['disabled_friendly']) : '';
    $safety_security = isset($_POST['safety_security']) ? implode(',', $_POST['safety_security']) : '';
    $advanced_facilities = isset($_POST['advanced_facilities']) ? implode(',', $_POST['advanced_facilities']) : '';

    // Check if school facility already exists
    $check_query = "SELECT * FROM school_facility WHERE school_id = '$school_id'";
    $check_result = mysqli_query($conn, $check_query);

    if (mysqli_num_rows($check_result) > 0) {
        // Update existing record
        $update_query = "UPDATE school_facility SET 
            extra_curricular = '$extra_curricular', 
            class_facilities = '$class_facilities', 
            infrastructure = '$infrastructure', 
            sports_fitness = '$sports_fitness', 
            lab_facilities = '$lab_facilities', 
            boarding = '$boarding', 
            disabled_friendly = '$disabled_friendly', 
            safety_security = '$safety_security', 
            advanced_facilities = '$advanced_facilities', 
            updated_at = NOW()
            WHERE school_id = '$school_id'";
        mysqli_query($conn, $update_query);
    } else {
        // Insert new record
        $insert_query = "INSERT INTO school_facility (school_id, extra_curricular, class_facilities, infrastructure, sports_fitness, lab_facilities, boarding, disabled_friendly, safety_security, advanced_facilities, created_at, updated_at) 
            VALUES ('$school_id', '$extra_curricular', '$class_facilities', '$infrastructure', '$sports_fitness', '$lab_facilities', '$boarding', '$disabled_friendly', '$safety_security', '$advanced_facilities', NOW(), NOW())";
        mysqli_query($conn, $insert_query);
    }

    // Redirect to manage-school-facility.php with success message
    header("Location: manage-school-facility.php?status=success");
    exit();
} else {
    // Redirect to manage-school-facility.php if accessed directly
    header("Location: manage-school-facility.php");
    exit();
}
?>
