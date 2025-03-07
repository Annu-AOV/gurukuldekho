<?php
include('../includes/header.php');
include('../includes/sidebar.php');
include('../includes/db_connect.php'); // Include database connection
?>

<div class="container mt-4">
    <h2 style="margin-top:80px;">Edit Course</h2>
    <?php
    // Check if course ID is provided
    if (isset($_GET['id'])) {
        $course_id = $_GET['id'];

        // Fetch course details
        $query = "SELECT * FROM courses WHERE id = $course_id";
        $result = mysqli_query($conn, $query);

        if (mysqli_num_rows($result) > 0) {
            $course = mysqli_fetch_assoc($result);
        } else {
            echo "<p class='alert alert-danger'>Course not found.</p>";
            exit;
        }
    } else {
        echo "<p class='alert alert-danger'>Invalid course ID.</p>";
        exit;
    }
    ?>


    <!-- <div class="container mt-4">
    <h2 style="margin-top:80px;">Edit Course</h2> -->

    <form action="" method="POST">
        <div class="mb-3 mt-4">
            <label for="course_name" class="form-label">Course Name</label>
            <input type="text" class="form-control" id="course_name" name="course_name"
                value="<?php echo $course['course_name']; ?>" required>
        </div>
        <div class="mb-3">
            <label for="description" class="form-label">Description</label>
            <textarea class="form-control" id="description" name="description" rows="4"
                required><?php echo $course['description']; ?></textarea>
        </div>
        <div class="mb-3">
            <label for="duration" class="form-label">Duration</label>
            <input type="text" class="form-control" id="duration" name="duration"
                value="<?php echo $course['duration']; ?>" required>
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

        <button type="submit" name="update" class="btn btn-success">Update Course</button>
        <a href="manage-course.php" class="btn btn-secondary">Cancel</a>
    </form>

    <?php
    // Handle form submission for course update
    if (isset($_POST['update'])) {
        $course_name = mysqli_real_escape_string($conn, $_POST['course_name']);
        $description = mysqli_real_escape_string($conn, $_POST['description']);
        $duration = mysqli_real_escape_string($conn, $_POST['duration']);
        $registration_fee = $_POST['registration_fee'];
        $admission_fee = $_POST['admission_fee'];
        $annual_fee = $_POST['annual_fee'];
        $tuition_fee = $_POST['tuition_fee'];
        $exam_fee = $_POST['exam_fee'];
        $library_fee = $_POST['library_fee'];
        $laboratory_fee = $_POST['laboratory_fee'];
        $hostel_fee = $_POST['hostel_fee'];


        // Update course details in the database
        $update_query = "UPDATE courses SET 
                        course_name = '$course_name', 
                        description = '$description', 
                        duration = '$duration',
                        registration_fee = '$registration_fee',
                        admission_fee = '$admission_fee',
                        annual_fee = '$annual_fee',
                        tuition_fee = '$tuition_fee',
                        exam_fee = '$exam_fee',
                        library_fee = '$library_fee',
                        laboratory_fee = '$laboratory_fee',
                        hostel_fee = '$hostel_fee' 
                     WHERE id = $course_id";

        if (mysqli_query($conn, $update_query)) {
            echo "<p class='alert alert-success mt-4'>Course updated successfully!</p>";
            //Optionally redirect to manage-course.php
            echo "<a href='manage-course.php' class='btn btn-primary'>Go to Manage Courses</a>";
            // exit;
        } else {
            echo "<p class='alert alert-danger'>Error updating course: " . mysqli_error($conn) . "</p>";
        }
    }

    // Close the database connection
    mysqli_close($conn);
    ?>
</div>

<?php include('../includes/footer.php'); ?>