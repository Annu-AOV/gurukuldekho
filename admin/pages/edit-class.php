<?php
include('../includes/header.php');
include('../includes/sidebar.php');
include('../includes/db_connect.php'); // Database connection
?>

<div class="container mt-4">
    <h2 class="mb-4" style="margin-top:80px">Edit Class</h2>

    <?php
    // Get the class ID from the URL
    if (isset($_GET['id'])) {
        $class_id = $_GET['id'];

        // Fetch class details from the database
        $query = "SELECT * FROM classes WHERE id = $class_id";
        $result = mysqli_query($conn, $query);

        if (mysqli_num_rows($result) > 0) {
            $class = mysqli_fetch_assoc($result);
        } else {
            echo "<p class='alert alert-danger'>Class not found.</p>";
            exit;
        }
    } else {
        echo "<p class='alert alert-danger'>No class ID provided.</p>";
        exit;
    }
?>

    <!-- Edit Class Form -->
    <form action="edit-class.php?id=<?php echo $class_id; ?>" method="POST">
        <div class="mb-3">
            <label for="class_name" class="form-label">Class Name</label>
            <input type="text" class="form-control" id="class_name" name="class_name"
                value="<?php echo htmlspecialchars($class['class_name']); ?>" required>
        </div>

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

        <button type="submit" name="update" class="btn btn-primary">Update Class</button>
    </form>

    <?php
    // Handle form submission
    if (isset($_POST['update'])) {
        $class_name = trim($_POST['class_name']); // Get the updated class name
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

        // Check if the class name already exists
        $check_query = "SELECT * FROM classes WHERE class_name = '$class_name' AND id != $class_id";
        $check_result = mysqli_query($conn, $check_query);

        if (mysqli_num_rows($check_result) > 0) {
            echo "<p class='alert alert-danger mt-4'>Class name already exists. Please use a different name.</p>";
        } else {
            // Update the class in the database
            $update_query = "UPDATE classes SET class_name = '$class_name',
            registration_fee = '$registration_fee',
        admission_fee = '$admission_fee',
        annual_fee = '$annual_fee',
        tuition_fee = '$tuition_fee',
        exam_fee = '$exam_fee',
        library_fee ='$library_fee',
        lab_fee = '$lab_fee',
        activity_fee ='$activity_fee',
        study_material_fee = '$study_material_fee',
        technology_fee = '$technology_fee',
        transport_fee = '$transport_fee' WHERE id = $class_id";
            if (mysqli_query($conn, $update_query)) {
                echo "<p class='alert alert-success mt-4'>Class updated successfully!</p>";
            } else {
                echo "<p class='alert alert-danger mt-4'>Error updating class: " . mysqli_error($conn) . "</p>";
            }
        }
    }

    // Close the database connection
    mysqli_close($conn);
    ?>
</div>

<?php include('../includes/footer.php'); ?>