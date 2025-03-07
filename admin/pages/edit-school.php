<?php
include('../includes/header.php');
include('../includes/sidebar.php');
include('../includes/db_connect.php'); // Database connection

// Get the school ID from the URL
if (!isset($_GET['id'])) {
    echo "<p class='alert alert-danger'>No school selected. Please go back and try again.</p>";
    exit();
}

$id = $_GET['id'];

// Fetch the school data from the database
$query = "SELECT * FROM schools WHERE id = $id";
$result = mysqli_query($conn, $query);

if (mysqli_num_rows($result) == 0) {
    echo "<p class='alert alert-danger'>School not found. Please go back and try again.</p>";
    exit();
}

$school = mysqli_fetch_assoc($result);
?>

<div class="container mt-4">
    <h2 class="mb-4" style="margin-top:80px">Edit School</h2>

    <!-- Form to edit school -->
    <form action="edit-school.php?id=<?php echo $id; ?>" method="POST" enctype="multipart/form-data">
        <div class="row">
            <div class="col-md-6 mb-3">
                <label for="name" class="form-label">School Name</label>
                <input type="text" class="form-control" id="name" name="name" value="<?php echo $school['name']; ?>" required>
            </div>
            <div class="col-md-3 mb-3">
                <label for="admission_status" class="form-label">Admission Status</label>
                <select class="form-select" id="admission_status" name="admission_status" required>
                    <option value="Open" <?php echo ($school['admission_status'] == 'Open') ? 'selected' : ''; ?>>Open</option>
                    <option value="Close" <?php echo ($school['admission_status'] == 'Close') ? 'selected' : ''; ?>>Close</option>
                </select>
            </div> 
            <div class="col-md-3 mb-3">
                <label for="school_type" class="form-label">School Type</label>
                <select class="form-select" id="school_type" name="school_type" required>
                    <option value="Boarding" <?php echo ($school['school_type'] == 'Boarding') ? 'selected' : ''; ?>>Boarding School</option>
                    <option value="Day" <?php echo ($school['school_type'] == 'Day') ? 'selected' : ''; ?>>Day School</option>
                    <option value="Online" <?php echo ($school['school_type'] == 'Online') ? 'selected' : ''; ?>>Online School</option>
                </select>
            </div> 
        </div>

        <div class="row">
            <div class="col-md-6 mb-3">
                <label for="address" class="form-label">Address</label>
                <input type="text" class="form-control" id="address" name="address" value="<?php echo $school['address']; ?>" required>
            </div>
            <div class="col-md-3 mb-3">
                <label for="affiliate" class="form-label">Affiliate</label>
                <input type="text" class="form-control" id="affiliate" name="affiliate" value="<?php echo $school['affiliate']; ?>">
            </div>
            <div class="col-md-3 mb-3">
                <label for="locality" class="form-label">Locality</label>
                <input type="text" class="form-control" id="locality" name="locality" value="<?php echo $school['address_locality']; ?>">
            </div>
        </div>

        <div class="row">
            <div class="col-md-3 mb-3">
                <label for="class_minimum" class="form-label">Minimum Class</label>
                <input type="text" class="form-control" id="class_minimum" name="class_minimum" value="<?php echo $school['class_minimum']; ?>" required>
            </div>
            <div class="col-md-3 mb-3">
                <label for="class_maximum" class="form-label">Maximum Class</label>
                <input type="text" class="form-control" id="class_maximum" name="class_maximum" value="<?php echo $school['class_maximum']; ?>" required>
            </div>
            <div class="col-md-2 mb-3">
                <label for="estd" class="form-label">Estd</label>
                <input type="number" class="form-control" id="estd" name="estd" value="<?php echo $school['estd']; ?>">
            </div>
            <div class="col-md-4 mb-3">
                <label for="school_mail" class="form-label">School Email</label>
                <input type="email" class="form-control" id="school_mail" name="school_mail" value="<?php echo $school['school_mail']; ?>" required>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6 mb-3">
                <label for="primary_mob" class="form-label">Primary Mobile Number</label>
                <input type="text" class="form-control" id="primary_mob" name="primary_mob" value="<?php echo $school['primary_mob']; ?>" required>
            </div>
            <div class="col-md-6 mb-3">
                <label for="secondary_mob" class="form-label">Secondary Mobile Number</label>
                <input type="text" class="form-control" id="secondary_mob" name="secondary_mob" value="<?php echo $school['secondary_mob']; ?>">
            </div>
        </div>

        <div class="row">
            <div class="col-md-6 mb-3">
                <label for="description" class="form-label">School Description</label>
                <textarea class="form-control" id="description" name="description" rows="4"><?php echo $school['description']; ?></textarea>
            </div>
            <div class="col-md-6 mb-3">
                <label for="map_embed_code" class="form-label">Google Map Embed Code</label>
                <textarea class="form-control" id="map_embed_code" name="map_embed_code" rows="4"><?php echo htmlspecialchars($school['map_embed_code']); ?></textarea>
            </div>
        </div>

        <button type="submit" name="update" class="btn btn-success">Update School</button>
    </form>

    <?php
    if (isset($_POST['update'])) {
        // Get updated form values
        $name = mysqli_real_escape_string($conn, $_POST['name']);
        $admission_status = mysqli_real_escape_string($conn, $_POST['admission_status']);
        $address = mysqli_real_escape_string($conn, $_POST['address']);
        $class_maximum = mysqli_real_escape_string($conn, $_POST['class_maximum']);
        $class_minimum = mysqli_real_escape_string($conn, $_POST['class_minimum']);
        $affiliate = mysqli_real_escape_string($conn, $_POST['affiliate']);
        $address_locality =  mysqli_real_escape_string($conn, $_POST['locality']);
        $estd = mysqli_real_escape_string($conn, $_POST['estd']);
        $school_type = mysqli_real_escape_string($conn, $_POST['school_type']);
        $school_mail = mysqli_real_escape_string($conn, $_POST['school_mail']);
        $primary_mob = mysqli_real_escape_string($conn, $_POST['primary_mob']);
        $secondary_mob = mysqli_real_escape_string($conn, $_POST['secondary_mob']);
        $description = mysqli_real_escape_string($conn, $_POST['description']);
        $map_embed_code = mysqli_real_escape_string($conn, $_POST['map_embed_code']);

        // Update data in the database
        $updateQuery = "UPDATE schools 
        SET name='$name', 
            admission_status='$admission_status', 
            address='$address', 
            school_type='$school_type',
            affiliate='$affiliate', 
            class_maximum='$class_maximum', 
            address_locality = '$address_locality',
            class_minimum='$class_minimum',
            estd='$estd', 
            school_mail='$school_mail', 
            primary_mob='$primary_mob', 
            secondary_mob='$secondary_mob', 
            description='$description', 
            map_embed_code='$map_embed_code'
        WHERE id=$id";

        if (mysqli_query($conn, $updateQuery)) {
            echo "<p class='alert alert-success mt-4'>School details updated successfully!</p>";
        } else {
            echo "<p class='alert alert-danger mt-4'>Error: " . mysqli_error($conn) . "</p>";
        }
    }

    // Close the database connection
    mysqli_close($conn);
    ?>
</div>

<?php include('../includes/footer.php'); ?>
