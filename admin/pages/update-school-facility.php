<?php
include('../includes/db_connect.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $facility_id = $_POST['facility_id'];

    $fields = ['extra_curricular', 'class_facilities', 'infrastructure', 'sports_fitness', 'lab_facilities', 'boarding', 'disabled_friendly', 'safety_security', 'advanced_facilities'];

    $update_data = [];
    foreach ($fields as $field) {
        $values = isset($_POST[$field]) ? implode(',', $_POST[$field]) : '';
        $update_data[] = "$field = '$values'";
    }

    $update_query = "UPDATE school_facility SET " . implode(", ", $update_data) . " WHERE id = $facility_id";

    if (mysqli_query($conn, $update_query)) {
        echo "<script>alert('Facilities updated successfully!'); window.location.href='manage-school-facility.php';</script>";
    } else {
        echo "Error updating record: " . mysqli_error($conn);
    }
}
?>
