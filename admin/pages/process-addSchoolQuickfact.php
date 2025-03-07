<?php
// Include database connection
include('../includes/db_connect.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $school_id = $_POST['school_id'];
    $board = $_POST['board'];
    $gender = $_POST['gender'];
    $class_min = $_POST['class_min'];
    $class_max = $_POST['class_max'];
    $academic_session = $_POST['academic_session'];
    $medium = $_POST['medium'];
    $student_teacher_ratio = $_POST['student_teacher_ratio'];
    $day_boarding = $_POST['day_boarding'];
    $campus_size = $_POST['campus_size'];

    // Validate inputs
    if (empty($school_id) || empty($board) || empty($gender) || empty($class_min) || empty($class_max) || empty($academic_session) || empty($medium) || empty($student_teacher_ratio) || empty($day_boarding) || empty($campus_size)) {
        echo "<script>alert('All fields are required!'); window.location.href='manage-school-quickfact.php';</script>";
        exit();
    }

    // Check if school_quickfact entry already exists for this school
    $check_query = "SELECT * FROM school_quickfact WHERE school_id = '$school_id'";
    $result = mysqli_query($conn, $check_query);

    if (mysqli_num_rows($result) > 0) {
        // Update existing record
        $update_query = "UPDATE school_quickfact SET 
            board = '$board', 
            gender = '$gender', 
            class_min = '$class_min', 
            class_max = '$class_max', 
            academic_session = '$academic_session', 
            medium = '$medium', 
            student_teacher_ratio = '$student_teacher_ratio', 
            day_boarding = '$day_boarding', 
            campus_size = '$campus_size' 
            WHERE school_id = '$school_id'";

        if (mysqli_query($conn, $update_query)) {
            echo "<script>alert('School Quick Fact Updated Successfully!'); window.location.href='manage-school-quickfact.php';</script>";
        } else {
            echo "<script>alert('Error updating record: " . mysqli_error($conn) . "'); window.location.href='manage-school-quickfact.php';</script>";
        }
    } else {
        // Insert new record
        $insert_query = "INSERT INTO school_quickfact (school_id, board, gender, class_min, class_max, academic_session, medium, student_teacher_ratio, day_boarding, campus_size) 
            VALUES ('$school_id', '$board', '$gender', '$class_min', '$class_max', '$academic_session', '$medium', '$student_teacher_ratio', '$day_boarding', '$campus_size')";

        if (mysqli_query($conn, $insert_query)) {
            echo "<script>alert('School Quick Fact Added Successfully!'); window.location.href='manage-school-quickfact.php';</script>";
        } else {
            echo "<script>alert('Error inserting record: " . mysqli_error($conn) . "'); window.location.href='manage-school-quickfact.php';</script>";
        }
    }
}
?>
