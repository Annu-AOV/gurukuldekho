<?php
// Include database connection
include('../includes/header.php');
include('../includes/sidebar.php');
include('../includes/db_connect.php');

// Check if ID is provided
if (!isset($_GET['id']) || empty($_GET['id'])) {
    echo "Invalid request!";
    exit;
}

$id = $_GET['id'];

// Fetch the existing quick fact details
$query = "SELECT * FROM school_quickfact WHERE id = $id";
$result = mysqli_query($conn, $query);

if (!$result || mysqli_num_rows($result) == 0) {
    echo "Record not found!";
    exit;
}

$row = mysqli_fetch_assoc($result);

// Update record when form is submitted
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

    $update_query = "UPDATE school_quickfact SET 
                     school_id = '$school_id', board = '$board', gender = '$gender',
                     class_min = '$class_min', class_max = '$class_max',
                     academic_session = '$academic_session', medium = '$medium',
                     student_teacher_ratio = '$student_teacher_ratio',
                     day_boarding = '$day_boarding', campus_size = '$campus_size'
                     WHERE id = $id";

    if (mysqli_query($conn, $update_query)) {
        echo "<script>alert('School Quick Fact updated successfully!'); window.location.href='manage-school-quickfact.php';</script>";
    } else {
        echo "Error updating record: " . mysqli_error($conn);
    }
}

// Fetch all schools for dropdown
$schools_query = "SELECT id, name FROM schools";
$schools_result = mysqli_query($conn, $schools_query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit School Quick Fact</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css">
</head>
<body>
<div class="container my-5">
    <h2 class="text-center mb-4">Edit School Quick Fact</h2>

    <form method="POST">
        <table class="table table-bordered">
            <tr>
                <th>School</th>
                <td>
                    <select name="school_id" class="form-select" required>
                        <?php while ($school = mysqli_fetch_assoc($schools_result)): ?>
                            <option value="<?= $school['id'] ?>" <?= $row['school_id'] == $school['id'] ? 'selected' : '' ?>><?= $school['name'] ?></option>
                        <?php endwhile; ?>
                    </select>
                </td>
            </tr>
            <tr><th>Board</th><td><input type="text" name="board" value="<?= $row['board'] ?>" class="form-control" required></td></tr>
            <tr><th>Gender</th><td><input type="text" name="gender" value="<?= $row['gender'] ?>" class="form-control" required></td></tr>
            <tr>
                <th>Classes (Min - Max)</th>
                <td>
                    <input type="number" name="class_min" value="<?= $row['class_min'] ?>" class="form-control" required>
                    <input type="number" name="class_max" value="<?= $row['class_max'] ?>" class="form-control" required>
                </td>
            </tr>
            <tr><th>Session</th><td><input type="text" name="academic_session" value="<?= $row['academic_session'] ?>" class="form-control" required></td></tr>
            <tr><th>Medium</th><td><input type="text" name="medium" value="<?= $row['medium'] ?>" class="form-control" required></td></tr>
            <tr><th>Student-Teacher Ratio</th><td><input type="text" name="student_teacher_ratio" value="<?= $row['student_teacher_ratio'] ?>" class="form-control" required></td></tr>
            <tr><th>Type</th><td><input type="text" name="day_boarding" value="<?= $row['day_boarding'] ?>" class="form-control" required></td></tr>
            <tr><th>Campus Size</th><td><input type="text" name="campus_size" value="<?= $row['campus_size'] ?>" class="form-control" required></td></tr>
        </table>

        <div class="text-center">
            <button type="submit" class="btn btn-primary">Update</button>
            <a href="manage-schoolQuickfact.php" class="btn btn-secondary">Cancel</a>
        </div>
    </form>
</div>
</body>
<?php include('../includes/footer.php'); ?>
</html>
