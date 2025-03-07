<?php
// Include database connection
include('../includes/header.php');
include('../includes/sidebar.php');
include('../includes/db_connect.php');

// Fetch school data from the schools table
$schools_query = "SELECT id, name FROM schools";
$schools_result = mysqli_query($conn, $schools_query);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Fee Structure</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css">
</head>

<body>
    <div class="container my-5">
        <div class="d-flex justify-content-between align-items-center">
            <h2 class="text-center mb-4" style="margin-top: 80px;">Add New Fee Structure</h2>
            <button class="btn btn-view-all btn-outline-primary" onclick="window.location.href='manage-feeStructure.php';">
                Go To Manage Fee Structure
            </button>
        </div>

        <form action="process-addFeeStructure.php" method="POST">
            <table class="table table-bordered">
                <thead class="table-primary">
                    <tr>
                        <th>School</th>
                        <th>Class</th>
                        <th>Session</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>
                            <select name="school_id" class="form-select" required>
                                <option value="">Select School</option>
                                <?php
                                if (mysqli_num_rows($schools_result) > 0) {
                                    while ($row = mysqli_fetch_assoc($schools_result)) {
                                        echo "<option value='{$row['id']}'>{$row['name']}</option>";
                                    }
                                } else {
                                    echo "<option value=''>No Schools Available</option>";
                                }
                                ?>
                            </select>
                        </td>
                        <td>
                            <input type="text" name="class" class="form-control" placeholder="Enter Class" required>
                        </td>
                        <td>
                            <input type="text" name="session" class="form-control"
                                placeholder="Enter Session (e.g., 2025-2026)" required>
                        </td>
                    </tr>
                </tbody>
            </table>

            <table class="table table-bordered">
                <thead class="table-secondary">
                    <tr>
                        <th>Refundable</th>
                        <th>Course</th>
                        <th>Security Fee</th>
                        <th>Registration Fee</th>
                        <th>Admission Fee</th>
                        <th>Annual Fee</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <!-- Refundable Dropdown -->
                        <td>
                            <select name="refundable" class="form-select" required>
                                <option value="No">No</option>
                                <option value="Yes">Yes</option>
                            </select>
                        </td>
                        <td><input type="text" name="course" class="form-control" placeholder="Enter Course"></td>
                        <td><input type="number" step="0.01" name="security_fee" class="form-control"
                                placeholder="Enter Security Fee" required></td>
                        <td><input type="number" step="0.01" name="registration_fee" class="form-control"
                                placeholder="Enter Registration Fee" required></td>
                        <td><input type="number" step="0.01" name="admission_fee" class="form-control"
                                placeholder="Enter Admission Fee" required></td>
                        <td><input type="number" step="0.01" name="annual_fee" class="form-control"
                                placeholder="Enter Annual Fee" required></td>
                    </tr>
                </tbody>
            </table>

            <table class="table table-bordered">
                <thead class="table-secondary">
                    <tr>

                        <th>Tuition Fee</th>
                        <th>Examination Fee</th>
                        <th>Library Fee</th>
                        <th>Sports Fee</th>
                        <th>Hostel Fee</th>
                        <th>Frequency</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>

                        <td><input type="number" step="0.01" name="tuition_fee" class="form-control"
                                placeholder="Enter Tuition Fee" required></td>
                        <td><input type="number" step="0.01" name="examination_fee" class="form-control"
                                placeholder="Enter Examination Fee" required></td>
                        <td><input type="number" step="0.01" name="library_fee" class="form-control"
                                placeholder="Enter Library Fee" required></td>
                        <td><input type="number" step="0.01" name="sports_fee" class="form-control"
                                placeholder="Enter Sports Fee" required></td>
                        <td><input type="number" step="0.01" name="hostel_fee" class="form-control"
                                placeholder="Enter Hostel Fee" required></td>
                        <!-- Frequency Dropdown -->
                        <td>
                            <select name="frequency" class="form-select" required>
                                <option value="Monthly">Monthly</option>
                                <option value="OneTime">OneTime</option>
                                <option value="Quarterly">Quarterly</option>
                                <option value="Annually">Annually</option>
                            </select>
                        </td>
                    </tr>
                </tbody>
            </table>

            <div class="text-center">
                <button type="submit" class="btn btn-success">Add Fee Structure</button>
            </div>
        </form>
    </div>
</body>
<?php include('../includes/footer.php'); ?>

</html>