<?php
include('../includes/header.php');
include('../includes/sidebar.php');
?>

<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center">
        <h2 class="mb-4" style="margin-top:80px;">Add Classes</h2>
        <button class="btn btn-view-all btn-outline-primary" onclick="window.location.href='manage-class.php';">
            Go To Manage Class
        </button>
    </div>

    <!-- Form to add multiple classes -->
    <form action="add-class.php" method="POST">
        <div class="mb-3">
            <label for="class_name" class="form-label">Class Names</label>
            <textarea class="form-control" id="class_name" name="class_name" rows="5"
                placeholder="Enter multiple class names, one per line" required></textarea>
            <small class="text-muted">Enter one class name per line.</small>
        </div>

        <!-- Fees Section -->
        <div class="mb-3">
            <h4>Class Fees</h4>
            <div class="row">
                <div class="col-md-4 mb-3">
                    <label for="registration_fee" class="form-label">Registration Fee</label>
                    <input type="number" class="form-control" id="registration_fee" name="registration_fee" required>
                </div>
                <div class="col-md-4 mb-3">
                    <label for="admission_fee" class="form-label">Admission Fee</label>
                    <input type="number" class="form-control" id="admission_fee" name="admission_fee" required>
                </div>
                <div class="col-md-4 mb-3">
                    <label for="annual_fee" class="form-label">Annual Fee</label>
                    <input type="number" class="form-control" id="annual_fee" name="annual_fee" required>
                </div>
                <div class="col-md-4 mb-3">
                    <label for="tuition_fee" class="form-label">Tuition Fee</label>
                    <input type="number" class="form-control" id="tuition_fee" name="tuition_fee" required>
                </div>
                <div class="col-md-4 mb-3">
                    <label for="exam_fee" class="form-label">Exam Fee</label>
                    <input type="number" class="form-control" id="exam_fee" name="exam_fee" required>
                </div>
                <div class="col-md-4 mb-3">
                    <label for="library_fee" class="form-label">Library Fee</label>
                    <input type="number" class="form-control" id="library_fee" name="library_fee" required>
                </div>
                <div class="col-md-4 mb-3">
                    <label for="lab_fee" class="form-label">Lab Fee</label>
                    <input type="number" class="form-control" id="lab_fee" name="lab_fee" required>
                </div>
                <div class="col-md-4 mb-3">
                    <label for="activity_fee" class="form-label">Activity Fee</label>
                    <input type="number" class="form-control" id="activity_fee" name="activity_fee" required>
                </div>
                <div class="col-md-4 mb-3">
                    <label for="study_material_fee" class="form-label">Study Material Fee</label>
                    <input type="number" class="form-control" id="study_material_fee" name="study_material_fee"
                        required>
                </div>
                <div class="col-md-4 mb-3">
                    <label for="technology_fee" class="form-label">Technology Fee</label>
                    <input type="number" class="form-control" id="technology_fee" name="technology_fee" required>
                </div>
                <div class="col-md-4 mb-3">
                    <label for="transport_fee" class="form-label">Transport Fee</label>
                    <input type="number" class="form-control" id="transport_fee" name="transport_fee" required>
                </div>
            </div>
        </div>

        <button type="submit" name="submit" class="btn btn-primary">Add Classes</button>
    </form>

    <?php
    if (isset($_POST['submit'])) {
        // Include database connection
        include('../includes/db_connect.php');

        // Get the class names from the form
        $class_names = explode("\n", trim($_POST['class_name'])); // Split the textarea input by newlines
    
        // Get the fees from the form
        $registration_fee = $_POST['registration_fee'];
        $admission_fee = $_POST['admission_fee'];
        $annual_fee = $_POST['annual_fee'];
        $tuition_fee = $_POST['tuition_fee'];
        $exam_fee = $_POST['exam_fee'];
        $library_fee = $_POST['library_fee'];
        $lab_fee = $_POST['lab_fee'];
        $activity_fee = $_POST['activity_fee'];
        $study_material_fee = $_POST['study_material_fee'];
        $technology_fee = $_POST['technology_fee'];
        $transport_fee = $_POST['transport_fee'];

        // Initialize arrays for success and errors
        $success = [];
        $errors = [];

        foreach ($class_names as $class_name) {
            $class_name = trim($class_name); // Trim whitespace
            if (!empty($class_name)) {
                // Check if the class name already exists
                $check_query = "SELECT * FROM classes WHERE class_name = '$class_name'";
                $check_result = mysqli_query($conn, $check_query);

                if (mysqli_num_rows($check_result) > 0) {
                    $errors[] = "Class <strong>$class_name</strong> already exists.";
                } else {
                    // Insert the class and fees into the database
                    $insert_query = "INSERT INTO classes 
                    (class_name, registration_fee, admission_fee, annual_fee, tuition_fee, exam_fee, library_fee, lab_fee, activity_fee, study_material_fee, technology_fee, transport_fee) 
                    VALUES ('$class_name', $registration_fee, $admission_fee, $annual_fee, $tuition_fee, $exam_fee, $library_fee, $lab_fee, $activity_fee, $study_material_fee, $technology_fee, $transport_fee)";

                    if (mysqli_query($conn, $insert_query)) {
                        $success[] = "Class <strong>$class_name</strong> added successfully.";
                    } else {
                        $errors[] = "Error adding class: <strong>$class_name</strong> - " . mysqli_error($conn);
                    }
                }
            }
        }

        // Display success and error messages
        if (!empty($success)) {
            echo "<div class='alert alert-success mt-4'>" . implode("<br>", $success) . "</div>";
        }
        if (!empty($errors)) {
            echo "<div class='alert alert-danger mt-4'>" . implode("<br>", $errors) . "</div>";
        }

        // Close the database connection
        mysqli_close($conn);
    }
    ?>
</div>

<?php include('../includes/footer.php'); ?>