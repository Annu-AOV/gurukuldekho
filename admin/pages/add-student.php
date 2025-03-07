<?php
include('../includes/header.php');
include('../includes/sidebar.php');
include('../includes/db_connect.php'); // Include database connection

// Handle form submission for adding or updating student details
if (isset($_POST['save'])) {
    $student_name = $_POST['student_name'];
    $email = $_POST['email'];
    $mobile_number = $_POST['mobile_number'];
    $neighbour_location = $_POST['neighbour_location'];
    $city = $_POST['city'];
    $state = $_POST['state'];
    $preferences = implode(', ', $_POST['preferences']); // Save preferences as a comma-separated string
    $monthly_budget = $_POST['monthly_budget'];
    $admission_area = $_POST['admission_area'];

    if (isset($_POST['student_id'])) {
        // Update existing student record
        $student_id = $_POST['student_id'];
        $sql = "UPDATE students 
                SET student_name = '$student_name', email = '$email', mobile_number = '$mobile_number', neighbour_location = '$neighbour_location', city = '$city', state = '$state', preferences = '$preferences', monthly_budget = '$monthly_budget', admission_area = '$admission_area'
                WHERE id = $student_id";
        $message = "Student details updated successfully!";
    } else {
        // Insert new student record
        $sql = "INSERT INTO students (student_name, email, mobile_number, neighbour_location, city, state, preferences, monthly_budget, admission_area) 
                VALUES ('$student_name', '$email', '$mobile_number', '$neighbour_location', '$city', '$state', '$preferences', '$monthly_budget', '$admission_area')";
        $message = "Student added successfully!";
    }

    if (mysqli_query($conn, $sql)) {
        echo "<p class='alert alert-success mt-4'>$message</p>";
    } else {
        echo "<p class='alert alert-danger mt-4'>Error: " . mysqli_error($conn) . "</p>";
    }
}

// Fetch student details for editing
$student = null;
if (isset($_GET['edit_id'])) {
    $edit_id = $_GET['edit_id'];
    $result = mysqli_query($conn, "SELECT * FROM students WHERE id = $edit_id");
    $student = mysqli_fetch_assoc($result);
}
?>

<div class="container mt-4">
    <h2 class="mb-4"><?= $student ? "Edit Student" : "Add Student" ?></h2>

    <!-- Form to add/edit student -->
    <form action="manage-student.php" method="POST">
        <?php if ($student): ?>
            <input type="hidden" name="student_id" value="<?= $student['id'] ?>">
        <?php endif; ?>
        <div class="row">
            <div class="col-md-6 mb-3">
                <label for="student_name" class="form-label">Student Name</label>
                <input type="text" class="form-control" id="student_name" name="student_name" value="<?= $student['student_name'] ?? '' ?>" required>
            </div>
            <div class="col-md-6 mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" id="email" name="email" value="<?= $student['email'] ?? '' ?>" required>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6 mb-3">
                <label for="mobile_number" class="form-label">Mobile Number</label>
                <input type="text" class="form-control" id="mobile_number" name="mobile_number" value="<?= $student['mobile_number'] ?? '' ?>" required>
            </div>
            <div class="col-md-6 mb-3">
                <label for="neighbour_location" class="form-label">Neighbour Location</label>
                <input type="text" class="form-control" id="neighbour_location" name="neighbour_location" value="<?= $student['neighbour_location'] ?? '' ?>" required>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6 mb-3">
                <label for="city" class="form-label">City</label>
                <input type="text" class="form-control" id="city" name="city" value="<?= $student['city'] ?? '' ?>" required>
            </div>
            <div class="col-md-6 mb-3">
                <label for="state" class="form-label">State</label>
                <input type="text" class="form-control" id="state" name="state" value="<?= $student['state'] ?? '' ?>" required>
            </div>
        </div>
        <div class="mb-3">
            <label for="preferences" class="form-label">Tell Us About Your Preference</label><br>
            <?php
            $preference_options = ['Day School', 'Boarding School', 'Online School'];
            $selected_preferences = $student ? explode(', ', $student['preferences']) : [];
            foreach ($preference_options as $option): ?>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="checkbox" id="preferences_<?= $option ?>" name="preferences[]" value="<?= $option ?>" <?= in_array($option, $selected_preferences) ? 'checked' : '' ?>>
                    <label class="form-check-label" for="preferences_<?= $option ?>"><?= $option ?></label>
                </div>
            <?php endforeach; ?>
        </div>
        <div class="row">
            <div class="col-md-6 mb-3">
                <label for="monthly_budget" class="form-label">Monthly Budget for School Fees</label>
                <select class="form-select" id="monthly_budget" name="monthly_budget" required>
                    <?php
                    $budget_options = [
                        'Below 3000', '3000 to 6000', '6000 to 10000', 
                        '10000 to 15000', 'More than 15000'
                    ];
                    foreach ($budget_options as $option): ?>
                        <option value="<?= $option ?>" <?= isset($student['monthly_budget']) && $student['monthly_budget'] == $option ? 'selected' : '' ?>>
                            <?= $option ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col-md-6 mb-3">
                <label for="admission_area" class="form-label">Area You Are Aiming For Admission In</label>
                <select class="form-select" id="admission_area" name="admission_area" required>
                    <?php
                    $area_options = ['Delhi', 'Pune', 'Bangalore', 'Ghaziabad', 'Gurugram', 'Noida', 'Greater Noida', 'Greater Noida West', 'Faridabad', 'Mumbai', 'Kolkata'];
                    foreach ($area_options as $option): ?>
                        <option value="<?= $option ?>" <?= isset($student['admission_area']) && $student['admission_area'] == $option ? 'selected' : '' ?>>
                            <?= $option ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>
        <button type="submit" name="save" class="btn btn-primary"><?= $student ? "Update" : "Save" ?></button>
    </form>
</div>

<?php include('../includes/footer.php'); ?>
