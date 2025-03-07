<?php
include('../includes/header.php');
include('../includes/sidebar.php');
?>

<div class="container mt-4">
    <h2 class="mb-4">Manage Fee Structure</h2>

    <!-- Fee Structure Form -->
    <form action="fee-structure.php" method="POST">
        <div class="row">
            <div class="col-md-6 mb-3">
                <label for="class" class="form-label">Class</label>
                <input type="text" class="form-control" id="class" name="class" placeholder="Enter class (e.g., Class 1)" required>
            </div>
            <div class="col-md-6 mb-3">
                <label for="academic_year" class="form-label">Academic Year</label>
                <input type="text" class="form-control" id="academic_year" name="academic_year" placeholder="Enter academic year (e.g., 2023-2024)" required>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6 mb-3">
                <label for="batch" class="form-label">Batch</label>
                <input type="text" class="form-control" id="batch" name="batch" placeholder="Enter batch (e.g., A)">
            </div>
            <div class="col-md-6 mb-3">
                <label for="course" class="form-label">Course</label>
                <input type="text" class="form-control" id="course" name="course" placeholder="Enter course (e.g., Science)">
            </div>
        </div>

        <h4 class="mt-4">Fee Details</h4>
        <div class="row">
            <div class="col-md-6 mb-3">
                <label for="security_fee" class="form-label">Security Fee</label>
                <input type="number" class="form-control" id="security_fee" name="security_fee" required>
            </div>
            <div class="col-md-6 mb-3">
                <label for="registration_fee" class="form-label">Registration Fee</label>
                <input type="number" class="form-control" id="registration_fee" name="registration_fee" required>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6 mb-3">
                <label for="admission_fee" class="form-label">Admission Fee</label>
                <input type="number" class="form-control" id="admission_fee" name="admission_fee" required>
            </div>
            <div class="col-md-6 mb-3">
                <label for="annual_fee" class="form-label">Annual Fee</label>
                <input type="number" class="form-control" id="annual_fee" name="annual_fee" required>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6 mb-3">
                <label for="tuition_fee" class="form-label">Tuition Fee</label>
                <input type="number" class="form-control" id="tuition_fee" name="tuition_fee" required>
            </div>
            <div class="col-md-6 mb-3">
                <label for="examination_fee" class="form-label">Examination Fee</label>
                <input type="number" class="form-control" id="examination_fee" name="examination_fee" required>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6 mb-3">
                <label for="library_fee" class="form-label">Library Fee</label>
                <input type="number" class="form-control" id="library_fee" name="library_fee" required>
            </div>
            <div class="col-md-6 mb-3">
                <label for="sports_fee" class="form-label">Sports Fee</label>
                <input type="number" class="form-control" id="sports_fee" name="sports_fee" required>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6 mb-3">
                <label for="hostel_fee" class="form-label">Hostel Fee</label>
                <input type="number" class="form-control" id="hostel_fee" name="hostel_fee">
            </div>
        </div>

        <button type="submit" name="submit" class="btn btn-primary mt-4">Save Fee Structure</button>
    </form>

    <?php
    if (isset($_POST['submit'])) {
        include('../includes/db_connect.php');

        // Get form values
        $class = $_POST['class'];
        $academic_year = $_POST['academic_year'];
        $batch = $_POST['batch'];
        $course = $_POST['course'];
        $security_fee = $_POST['security_fee'];
        $registration_fee = $_POST['registration_fee'];
        $admission_fee = $_POST['admission_fee'];
        $annual_fee = $_POST['annual_fee'];
        $tuition_fee = $_POST['tuition_fee'];
        $examination_fee = $_POST['examination_fee'];
        $library_fee = $_POST['library_fee'];
        $sports_fee = $_POST['sports_fee'];
        $hostel_fee = $_POST['hostel_fee'];

        // SQL to insert fee structure
        $sql = "INSERT INTO fee_structure (class, academic_year, batch, course, security_fee, registration_fee, admission_fee, annual_fee, tuition_fee, examination_fee, library_fee, sports_fee, hostel_fee) 
                VALUES ('$class', '$academic_year', '$batch', '$course', $security_fee, $registration_fee, $admission_fee, $annual_fee, $tuition_fee, $examination_fee, $library_fee, $sports_fee, $hostel_fee)";

        if (mysqli_query($conn, $sql)) {
            echo "<p class='alert alert-success mt-4'>Fee structure saved successfully!</p>";
        } else {
            echo "<p class='alert alert-danger mt-4'>Error: " . mysqli_error($conn) . "</p>";
        }

        // Close connection
        mysqli_close($conn);
    }
    ?>
</div>

<?php include('../includes/footer.php'); ?>
