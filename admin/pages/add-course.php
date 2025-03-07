<?php
include('../includes/header.php');
include('../includes/sidebar.php');
include('../includes/db_connect.php'); // Include database connection
?>

<div class="container mt-4">
    <h2 class="mb-4" style="margin-top:80px;">Add Course</h2>

    <!-- Course Form -->
    <form action="add-course.php" method="POST">
        <div class="mb-3">
            <label for="course_name" class="form-label">Course Name</label>
            <input type="text" class="form-control" id="course_name" name="course_name" required>
        </div>
        <div class="mb-3">
            <label for="description" class="form-label">Description</label>
            <textarea class="form-control" id="description" name="description" rows="4" required></textarea>
        </div>
        <div class="mb-3">
            <label for="duration" class="form-label">Duration (in months)</label>
            <input type="number" class="form-control" id="duration" name="duration" required>
        </div>

        <!-- Course Fee Section -->
        <div class="mb-3">
            <h5>Course Fees</h5>
        </div>
        <div class="row">
            <div class="col-md-6 mb-3">
                <label for="registration_fee" class="form-label">Registration Fee</label>
                <input type="number" class="form-control" id="registration_fee" name="registration_fee" required>
            </div>
            <div class="col-md-6 mb-3">
                <label for="admission_fee" class="form-label">Admission Fee</label>
                <input type="number" class="form-control" id="admission_fee" name="admission_fee" required>
            </div>
            <div class="col-md-6 mb-3">
                <label for="annual_fee" class="form-label">Annual Fee</label>
                <input type="number" class="form-control" id="annual_fee" name="annual_fee" required>
            </div>
            <div class="col-md-6 mb-3">
                <label for="tuition_fee" class="form-label">Tuition Fee</label>
                <input type="number" class="form-control" id="tuition_fee" name="tuition_fee" required>
            </div>
            <div class="col-md-6 mb-3">
                <label for="exam_fee" class="form-label">Exam Fee</label>
                <input type="number" class="form-control" id="exam_fee" name="exam_fee" required>
            </div>
            <div class="col-md-6 mb-3">
                <label for="library_fee" class="form-label">Library Fee</label>
                <input type="number" class="form-control" id="library_fee" name="library_fee" required>
            </div>
            <div class="col-md-6 mb-3">
                <label for="laboratory_fee" class="form-label">Laboratory Fee</label>
                <input type="number" class="form-control" id="laboratory_fee" name="laboratory_fee" required>
            </div>
            <div class="col-md-6 mb-3">
                <label for="hostel_fee" class="form-label">Hostel Fee</label>
                <input type="number" class="form-control" id="hostel_fee" name="hostel_fee" required>
            </div>
        </div>

        <button type="submit" name="submit" class="btn btn-primary">Add Course</button>
    </form>

    <?php
    if (isset($_POST['submit'])) {
        // Get form values
        $course_name = $_POST['course_name'];
        $description = $_POST['description'];
        $duration = $_POST['duration'];

        // Fees
        $registration_fee = $_POST['registration_fee'];
        $admission_fee = $_POST['admission_fee'];
        $annual_fee = $_POST['annual_fee'];
        $tuition_fee = $_POST['tuition_fee'];
        $exam_fee = $_POST['exam_fee'];
        $library_fee = $_POST['library_fee'];
        $laboratory_fee = $_POST['laboratory_fee'];
        $hostel_fee = $_POST['hostel_fee'];

        // Insert course into the database
        $query = "INSERT INTO courses (course_name, description, duration, registration_fee, admission_fee, annual_fee, tuition_fee, exam_fee, library_fee, laboratory_fee, hostel_fee) 
                  VALUES ('$course_name', '$description', $duration, $registration_fee, $admission_fee, $annual_fee, $tuition_fee, $exam_fee, $library_fee, $laboratory_fee, $hostel_fee)";
        if (mysqli_query($conn, $query)) {
            echo "<p class='alert alert-success mt-4'>Course added successfully!</p>";
        } else {
            echo "<p class='alert alert-danger mt-4'>Error: " . mysqli_error($conn) . "</p>";
        }
    }
    ?>
</div>

<?php include('../includes/footer.php'); ?>
