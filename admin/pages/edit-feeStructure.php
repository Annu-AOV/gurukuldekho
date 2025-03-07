<?php
// Include database connection
include('../includes/header.php');
include('../includes/sidebar.php');
include('../includes/db_connect.php');

// Check if the ID is set in the URL
if (isset($_GET['id'])) {
    $fee_id = $_GET['id'];

    // Fetch the fee structure details based on the ID
    $fee_query = "SELECT * FROM fee_structure WHERE id = '{$fee_id}'";
    $fee_result = mysqli_query($conn, $fee_query);

    // Check if the fee structure exists
    if (mysqli_num_rows($fee_result) > 0) {
        $fee_data = mysqli_fetch_assoc($fee_result);
    } else {
        echo "<script>alert('Fee Structure not found!'); window.location.href='manage-feeStructure.php';</script>";
    }
} else {
    echo "<script>alert('Invalid request!'); window.location.href='manage-feeStructure.php';</script>";
}

// Handle form submission to update fee structure
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $school_id = $_POST['school_id'];
    $class = $_POST['class'];
    $session = $_POST['session'];
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
    $frequency = $_POST['frequency'];
    $refundable = $_POST['refundable'];

    // Update query
    $update_query = "UPDATE fee_structure SET school_id='$school_id', class='$class', session='$session', batch='$batch', 
                    course='$course', security_fee='$security_fee', registration_fee='$registration_fee', admission_fee='$admission_fee', 
                    annual_fee='$annual_fee', tuition_fee='$tuition_fee', examination_fee='$examination_fee', library_fee='$library_fee', 
                    sports_fee='$sports_fee', hostel_fee='$hostel_fee', frequency='$frequency', refundable='$refundable' WHERE id='$fee_id'";

    if (mysqli_query($conn, $update_query)) {
        echo "<script>alert('Fee Structure updated successfully!'); window.location.href='manage-feeStructure.php';</script>";
    } else {
        echo "<script>alert('Error updating Fee Structure: " . mysqli_error($conn) . "'); window.location.href='manage-feeStructure.php';</script>";
    }
}

// Fetch schools data
$schools_query = "SELECT id, name FROM schools";
$schools_result = mysqli_query($conn, $schools_query);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Fee Structure</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css">
</head>
<body>
<div class="container my-5">
    <h2 class="text-center mb-4" style="margin-top:80px;">Edit Fee Structure</h2>
    <form method="POST" action="">
        <table class="table table-bordered">
            <thead class="table-primary">
                <tr>
                    <th>School</th><th>Class</th><th>Session</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>
                        <select name="school_id" class="form-select" required>
                            <option value="">Select School</option>
                            <?php while ($row = mysqli_fetch_assoc($schools_result)) {
                                $selected = ($fee_data['school_id'] == $row['id']) ? "selected" : "";
                                echo "<option value='{$row['id']}' {$selected}>{$row['name']}</option>";
                            } ?>
                        </select>
                    </td>
                    <td><input type="text" name="class" class="form-control" value="<?php echo $fee_data['class']; ?>" required></td>
                    <td><input type="text" name="session" class="form-control" value="<?php echo $fee_data['session']; ?>" required></td>
                </tr>
            </tbody>
        </table>
        
        <table class="table table-bordered">
            <thead class="table-secondary">
                <tr>
                    <th>Course</th>
                    <th>Registration Fee</th>
                    <th>Security Fee</th>
                    <th>Admission Fee</th>
                    <th>Annual Fee</th>
                    <th>Tuition Fee</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td><input type="text" name="course" class="form-control" value="<?php echo $fee_data['course']; ?>"></td>
                    <td><input type="number" step="0.01" name="registration_fee" class="form-control" value="<?php echo $fee_data['registration_fee']; ?>" required></td>
                    <td><input type="number" step="0.01" name="security_fee" class="form-control" value="<?php echo $fee_data['security_fee']; ?>" required></td>
                    <td><input type="number" step="0.01" name="admission_fee" class="form-control" value="<?php echo $fee_data['admission_fee']; ?>" required></td>
                    <td><input type="number" step="0.01" name="annual_fee" class="form-control" value="<?php echo $fee_data['annual_fee']; ?>" required></td>
                    <td><input type="number" step="0.01" name="tuition_fee" class="form-control" value="<?php echo $fee_data['tuition_fee']; ?>" required></td>
                </tr>
            </tbody>
        </table>

        <!-- <table class="table table-bordered">
            <thead class="table-secondary">
                <tr>
                    <th>Admission Fee</th>
                    <th>Annual Fee</th>
                    <th>Tuition Fee</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                <td><input type="number" step="0.01" name="admission_fee" class="form-control" value="<?php echo $fee_data['admission_fee']; ?>" required></td>
                    <td><input type="number" step="0.01" name="annual_fee" class="form-control" value="<?php echo $fee_data['annual_fee']; ?>" required></td>
                    <td><input type="number" step="0.01" name="tuition_fee" class="form-control" value="<?php echo $fee_data['tuition_fee']; ?>" required></td>
                </tr>
            </tbody>
        </table> -->

        <table class="table table-bordered">
            <thead class="table-secondary">
                <tr>
                    <th>Examination Fee</th>
                    <th>Library Fee</th>
                    <th>Sports Fee</th>
                    <th>Hostel Fee</th>
                    <th>Frequency</th>
                    <th>Refundable</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                <td><input type="number" step="0.01" name="examination_fee" class="form-control" value="<?php echo $fee_data['examination_fee']; ?>" required></td>
                    <td><input type="number" step="0.01" name="library_fee" class="form-control" value="<?php echo $fee_data['library_fee']; ?>" required></td>
                    <td><input type="number" step="0.01" name="sports_fee" class="form-control" value="<?php echo $fee_data['sports_fee']; ?>" required></td>
                    <td><input type="number" step="0.01" name="hostel_fee" class="form-control" value="<?php echo $fee_data['hostel_fee']; ?>" required></td>
                    <td>
                        <select name="frequency" class="form-select" required>
                            <option value="Monthly" <?= ($fee_data['frequency'] == 'Monthly') ? 'selected' : '' ?>>Monthly</option>
                            <option value="Onetime" <?= ($fee_data['frequency'] == 'Onetime') ? 'selected' : '' ?>>Onetime</option>
                            <option value="Quarterly" <?= ($fee_data['frequency'] == 'Quarterly') ? 'selected' : '' ?>>Quarterly</option>
                            <option value="Yearly" <?= ($fee_data['frequency'] == 'Yearly') ? 'selected' : '' ?>>Yearly</option>
                        </select>
                    </td>
                    <td>
                        <select name="refundable" class="form-select">
                            <option value="Yes" <?php echo ($fee_data['refundable'] == 'Yes') ? 'selected' : ''; ?>>Yes</option>
                            <option value="No" <?php echo ($fee_data['refundable'] == 'No') ? 'selected' : ''; ?>>No</option>
                        </select>
                    </td>

                </tr>
            </tbody>
        </table>
        
        <!-- <table class="table table-bordered">
            <thead class="table-secondary">
                <tr>
                
                    <th>Frequency</th>
                    <th>Refundable</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td><input type="text" name="frequency" class="form-control" value="<?php echo $fee_data['frequency']; ?>" required></td>
                    <td>
                        <select name="refundable" class="form-select">
                            <option value="Yes" <?php echo ($fee_data['refundable'] == 'Yes') ? 'selected' : ''; ?>>Yes</option>
                            <option value="No" <?php echo ($fee_data['refundable'] == 'No') ? 'selected' : ''; ?>>No</option>
                        </select>
                    </td>
                </tr>
            </tbody>
        </table> -->
        
        <div class="text-center">
            <button type="submit" class="btn btn-success">Save Changes</button>
        </div>
    </form>
</div>
</body>

<?php include('../includes/footer.php'); ?>
</html>
