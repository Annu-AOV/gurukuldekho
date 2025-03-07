<?php
include('../includes/header.php');
include('../includes/sidebar.php');
include('../includes/db_connect.php');

// Check if `id` is provided in the URL
if (!isset($_GET['id']) || empty($_GET['id']) || !is_numeric($_GET['id'])) {
    echo "<p class='alert alert-danger'>Invalid student ID.</p>";
    exit;
}

$id = $_GET['id']; // Fetch the student ID

// Fetch student details
$query = "SELECT * FROM user_log WHERE id = $id";
$result = mysqli_query($conn, $query);

// Check if the student exists
if (!$result || mysqli_num_rows($result) == 0) {
    echo "<p class='alert alert-danger'>Student not found.</p>";
    exit;
}

$user = mysqli_fetch_assoc($result);
?>

<div class="container mt-4">
    <h2 style="margin-top:80px;">Edit Student</h2>
    <form action="edit-student.php?id=<?= $id; ?>" method="POST">
        <div class="row mt-4">
            <div class="col-md-6 mb-3">
                <label for="name" class="form-label">Student Name</label>
                <input type="text" class="form-control" id="name" name="name" value="<?= $user['name']; ?>" required>
            </div>

            <div class="col-md-6 mb-3">
                <label for="phone" class="form-label">Phone Number</label>
                <input type="text" class="form-control" id="phone" name="phone" value="<?= $user['phone']; ?>" required>
            </div>
        </div>
        <div class="row">
            <div class="col-md-8 mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" id="email" name="email" value="<?= $user['email']; ?>"
                    required>
            </div>
            <div class="col-md-4 mb-3">
                <label for="date_of_birth" class="form-label">Date Of Birth </label>
                <input type="date" class="form-control" id="date_of_birth" name="date_of_birth"
                    value="<?php echo $user['date_of_birth']; ?>" required>
            </div>
        </div>
        <div class="row">
            <div class="col-md-3 mb-3">
                <label for="city" class="form-label">City</label>
                <input type="text" class="form-control" id="city" name="city" value="<?php echo $user['city']; ?>">
            </div>
            <div class="col-md-3 mb-3">
                <label for="state" class="form-label">State</label>
                <input type="state" class="form-control" id="state" name="state" value="<?php echo $user['state']; ?>"
                    required>
            </div>

            <div class="col-md-3 mb-3">
                <label for="pincode" class="form-label">Pincode</label>
                <input type="text" class="form-control" id="pincode" name="pincode" pattern="[0-9]{6}"
                    value="<?php echo $user['pincode']; ?>" required>
            </div>

            <div class="col-md-3 mb-3">
                <label for="status" class="form-label">Status</label>
                <select class="form-select" id="status" name="status">
                    <option value="Active" <?= ($user['status'] == 'Active') ? 'selected' : ''; ?>>Active</option>
                    <option value="Inactive" <?= ($user['status'] == 'Inactive') ? 'selected' : ''; ?>>Inactive</option>
                </select>
            </div>
        </div>
        <button type="submit" name="update" class="btn btn-primary">Update</button>
    </form>
    <?php
    if (isset($_POST['update'])) {
        $name = $_POST['name'];
        $phone = $_POST['phone'];
        $email = $_POST['email'];
        $date_of_birth = $_POST['date_of_birth'];
        $city = $_POST['city'];
        $state = $_POST['state'];
        $pincode = $_POST['pincode'];
        // $password = $_POST['password'];
        $status = $_POST['status'];
        $created_at = date('Y-m-d H:i:s');

        // Update query
        $update_query = "UPDATE user_log SET 
        name = '$name', 
        phone = '$phone', 
        email = '$email', 
        date_of_birth = '$date_of_birth',
        city = '$city',
        state = '$state',
        pincode ='$pincode',
        -- password = '$password',
        status = '$status' 
        WHERE id = $id";

        if (mysqli_query($conn, $update_query)) {
            echo "<p class='alert alert-success mt-4'>Student updated successfully!</p>";
        } else {
            echo "<p class='alert alert-danger'>Error: " . mysqli_error($conn) . "</p>";
        }
    }
    // Close the database connection
    mysqli_close($conn);
    ?>
</div>

<?php include('../includes/footer.php'); ?>