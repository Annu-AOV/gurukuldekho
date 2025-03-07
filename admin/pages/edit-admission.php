<?php
// Include database connection
include('../includes/header.php');
include('../includes/sidebar.php');
include('../includes/db_connect.php');

if (!isset($_GET['id']) || empty($_GET['id'])) {
    echo "<script>alert('Invalid Request!'); window.location.href='manage-admissions.php';</script>";
    exit;
}

$id = intval($_GET['id']);
$query = "SELECT * FROM admissions WHERE id = $id";
$result = mysqli_query($conn, $query);

if (!$result || mysqli_num_rows($result) == 0) {
    echo "<script>alert('Record not found!'); window.location.href='manage-admission.php';</script>";
    exit;
}

$row = mysqli_fetch_assoc($result);

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $class = $_POST['class'];
    $session = $_POST['session'];
    $last_application_date = $_POST['last_application_date'];
    $application_fee = $_POST['application_fee'];
    $admission_process = $_POST['admission_process'];
    $start_date = $_POST['start_date'];
    $end_date = $_POST['end_date'];

    $update_query = "UPDATE admissions SET 
                        class = '$class', 
                        session = '$session', 
                        last_application_date = '$last_application_date', 
                        application_fee = '$application_fee', 
                        admission_process = '$admission_process',
                        start_date = '$start_date',
                        end_date = '$end_date'
                     WHERE id = $id";

    if (mysqli_query($conn, $update_query)) {
        echo "<script>alert('Updated Successfully!'); window.location.href='manage-admission.php';</script>";
    } else {
        echo "Error updating record: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Admission</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css">
</head>
<body>
<div class="container my-5">
    <h2 class="text-center mb-4" style="margin-top:80px;">Edit School Admission</h2>
    <form action="" method="POST">
        <div class="mb-3">
            <label class="form-label">Class</label>
            <input type="text" name="class" class="form-control" value="<?php echo $row['class']; ?>" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Session</label>
            <input type="text" name="session" class="form-control" value="<?php echo $row['session']; ?>" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Last Application Date</label>
            <input type="date" name="last_application_date" class="form-control" value="<?php echo $row['last_application_date']; ?>" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Application Fee</label>
            <input type="number" name="application_fee" class="form-control" value="<?php echo $row['application_fee']; ?>" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Admission Process</label>
            <input type="text" name="admission_process" class="form-control" value="<?php echo $row['application_fee']; ?>" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Start Date</label>
            <input type="date" name="start_date" class="form-control" value="<?php echo $row['start_date']; ?>" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Last Date</label>
            <input type="date" name="end_date" class="form-control" value="<?php echo $row['end_date']; ?>" required>
        </div>
        <div class="text-center">
            <button type="submit" class="btn btn-primary">Update</button>
            <a href="manage-admissions.php" class="btn btn-secondary">Cancel</a>
        </div>
    </form>
</div>
</body>
</html>
