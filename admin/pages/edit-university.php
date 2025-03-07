<?php
include('../includes/header.php');
include('../includes/sidebar.php');
include('../includes/db_connect.php'); // Database connection

// Get the school ID from the URL
if (!isset($_GET['id'])) {
    echo "<p class='alert alert-danger'>No university selected. Please go back and try again.</p>";
    exit();
}

$id = $_GET['id'];

// Fetch the school data from the database
$query = "SELECT * FROM universities WHERE id = $id";
$result = mysqli_query($conn, $query);

if (mysqli_num_rows($result) == 0) {
    echo "<p class='alert alert-danger'>university not found. Please go back and try again.</p>";
    exit();
}

$university = mysqli_fetch_assoc($result);
?>

<div class="container mt-4">
    <h2 class="mb-4">Edit university</h2>

    <!-- Form to edit university -->
    <form action="edit-university.php?id=<?php echo $id; ?>" method="POST" enctype="multipart/form-data">
        <div class="row">
            <div class="col-md-6 mb-3">
                <label for="university_name" class="form-label">University Name</label>
                <input type="text" class="form-control" id="university_name" name="university_name"
                    value="<?php echo $university['university_name']; ?>" required>
            </div>
            <div class="col-md-6 mb-3">
                <label for="admission_status" class="form-label">Admission Status</label>
                <select class="form-select" id="admission_status" name="admission_status" required>
                    <option value="Open" <?php echo ($university['admission_status'] == 'Open') ? 'selected' : ''; ?>>Open
                    </option>
                    <option value="Close" <?php echo ($university['admission_status'] == 'Close') ? 'selected' : ''; ?>>
                        Close</option>
                </select>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6 mb-3">
                <label for="address" class="form-label">Address</label>
                <input type="text" class="form-control" id="address" name="address"
                    value="<?php echo $university['address']; ?>" required>
            </div>
            <div class="col-md-6 mb-3">
                <label for="affiliate" class="form-label">Affiliate</label>
                <input type="text" class="form-control" id="affiliate" name="affiliate"
                    value="<?php echo $university['affiliate']; ?>">
            </div>
        </div>

        <div class="row">
            <div class="col-md-3 mb-3">
                <label for="class_minimum" class="form-label">Minimum Class</label>
                <input type="number" class="form-control" id="class_minimum" name="class_minimum"
                    value="<?php echo $university['class_minimum']; ?>" required>
            </div>
            <div class="col-md-3 mb-3">
                <label for="class_maximum" class="form-label">Maximum Class</label>
                <input type="number" class="form-control" id="class_maximum" name="class_maximum"
                    value="<?php echo $university['class_maximum']; ?>" required>
            </div>
            <div class="col-md-6 mb-3">
                <label for="estd" class="form-label">Estd</label>
                <input type="number" class="form-control" id="estd" name="estd"
                    value="<?php echo $university['estd']; ?>">
            </div>
        </div>

        <div class="row">
            <div class="col-md-6 mb-3">
                <label for="university_mail" class="form-label">University Email</label>
                <input type="email" class="form-control" id="university_mail" name="university_mail"
                    value="<?php echo $university['university_mail']; ?>" required>
            </div>
            <div class="col-md-6 mb-3">
                <label for="primary_mob" class="form-label">Primary Mobile Number</label>
                <input type="text" class="form-control" id="primary_mob" name="primary_mob"
                    value="<?php echo $university['primary_mob']; ?>" required>
            </div>

            <div class="col-md-6 mb-3">
                <label for="secondary_mob" class="form-label">Secondary Mobile Number</label>
                <input type="text" class="form-control" id="secondary_mob" name="secondary_mob"
                    value="<?php echo $university['secondary_mob']; ?>">
            </div>
        </div>
        <div class="row">
            <div class="col-md-3 mb-3">
                <label for="courses" class="form-label">Select Courses</label>
                <select class="form-select" id="courses" name="courses[]" multiple required>
                    <?php
                    include('../includes/db_connect.php'); // Include database connection
                    $query = "SELECT id, course_name FROM courses"; // Fetch course data
                    $result = mysqli_query($conn, $query);
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo "<option value='{$row['id']}'>{$row['course_name']}</option>";
                    }
                    ?>
                </select>
                <small class="text-muted">Hold down the Ctrl (Windows) or Command (Mac) key to select multiple
                    courses.</small>
            </div>
            <div class="col-md-9 mb-3">
                <label for="overview" class="form-label">University Overview</label>
                <textarea class="form-control" id="overview" name="overview"
                    rows="4"><?php echo $university['overview']; ?></textarea>
            </div>
        </div>

        <button type="submit" name="update" class="btn btn-success">Update University</button>
    </form>

    <?php
    if (isset($_POST['update'])) {
        // Get updated form values
        $university_name = $_POST['university_name'];
        $admission_status = $_POST['admission_status'];
        $address = $_POST['address'];
        $affiliate = $_POST['affiliate'];
        $class_minimum = $_POST['class_minimum'];
        $class_maximum = $_POST['class_maximum'];
        $estd = $_POST['estd'];
        $university_mail = $_POST['university_mail'];
        $primary_mob = $_POST['primary_mob'];
        $secondary_mob = $_POST['secondary_mob'];
        $courses = $_POST['courses'];
        $overview = $_POST['overview'];

         // Convert selected courses array to a comma-separated string
         $courses_string = implode(',', $courses);

        // Update data in the database
        $updateQuery = "UPDATE universities 
                        SET university_name='$university_name', admission_status='$admission_status', address='$address', affiliate='$affiliate', 
                            class_minimum=$class_minimum, class_maximum=$class_maximum, estd=$estd, 
                            university_mail='$university_mail', primary_mob='$primary_mob', secondary_mob='$secondary_mob', courses='$courses_string',
                            overview='$overview' 
                        WHERE id=$id";

        if (mysqli_query($conn, $updateQuery)) {
            echo "<p class='alert alert-success mt-4'>University details updated successfully!</p>";
        } else {
            echo "<p class='alert alert-danger mt-4'>Error: " . mysqli_error($conn) . "</p>";
        }
    }

    // Close the database connection
    mysqli_close($conn);
    ?>
</div>

<?php include('../includes/footer.php'); ?>