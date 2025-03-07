<?php
include('../includes/header.php');
include('../includes/sidebar.php');
include('../includes/db_connect.php'); // Include database connection
?>

<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center">
        <div>
        <h2 class="mb-4" style="margin-top: 80px;">Add School</h2></div>
        <button class="btn btn-view-all btn-outline-primary" onclick="window.location.href='manage-school.php';">
            Go To Manage School
        </button>
    </div>

    <!-- Form to add school -->
    <form action="add-school.php" method="POST" enctype="multipart/form-data">
        <div class="row">
            <div class="col-md-6 col-12 mb-3">
                <label for="name" class="form-label">School Name</label>
                <input type="text" class="form-control" id="name" name="name" required>
            </div>
            <div class="col-md-6 col-12 mb-3">
                <label for="admission_status" class="form-label">Admission Status</label>
                <select class="form-select" id="admission_status" name="admission_status" required>
                    <option value="Open">Open</option>
                    <option value="Close">Close</option>
                </select>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6 col-12 mb-3">
                <label for="address" class="form-label">Address</label>
                <input type="text" class="form-control" id="address" name="address" required>
            </div>
            <div class="col-md-3 col-12 mb-3">
                <label for="affiliate" class="form-label">Affiliate</label>
                <input type="text" class="form-control" id="affiliate" name="affiliate">
            </div>
        </div>

        <div class="row">
            <div class="col-md-6 col-12 mb-3">
                <label for="class_minimum" class="form-label">Minimum Class</label>
                <input type="text" class="form-control" id="class_minimum" name="class_minimum" required>
            </div>

            <div class="col-md-6 col-12 mb-3">
                <label for="class_maximum" class="form-label">Maximum Class</label>
                <input type="text" class="form-control" id="class_maximum" name="class_maximum" required>
            </div>
        </div>

        <div class="row">
            <div class="col-md-3 col-12 mb-3">
                <label for="estd" class="form-label">Estd</label>
                <input type="number" class="form-control" id="estd" name="estd">
            </div>

            <div class="col-md-3 col-12 mb-3">
                <label for="city_name" class="form-label">City</label>
                <select class="form-select" id="city_name" name="city_name" required>
                    <option value="">Select City</option>
                    <?php
                    $city_query = "SELECT id, city_name FROM city";
                    $city_result = mysqli_query($conn, $city_query);
                    while ($row = mysqli_fetch_assoc($city_result)) {
                        echo "<option value='{$row['id']}'>{$row['city_name']}</option>";
                    }
                    ?>
                </select>
            </div>

            <div class="col-md-6 col-12 mb-3">
                <label for="school_mail" class="form-label">School Email</label>
                <input type="email" class="form-control" id="school_mail" name="school_mail" required>
            </div>
        </div>

        <div class="row">
            <div class="col-md-3 col-12 mb-3">
                <label for="primary_mob" class="form-label">Primary Mobile Number</label>
                <input type="text" class="form-control" id="primary_mob" name="primary_mob" required>
            </div>
            <div class="col-md-3 col-12 mb-3">
                <label for="secondary_mob" class="form-label">Secondary Mobile Number</label>
                <input type="text" class="form-control" id="secondary_mob" name="secondary_mob">
            </div>
            <div class="col-md-6 col-12 mb-3">
                <label for="photo" class="form-label">School Photo</label>
                <input type="file" class="form-control" id="photo" name="photo" accept="image/*" required>
            </div>
        </div>

        <div class="row">
            <div class="col-6 mb-3">
                <label for="map_embed_code" class="form-label">Google Map Embed Code</label>
                <textarea class="form-control" id="map_embed_code" name="map_embed_code" rows="3"
                    placeholder="Paste Google Map Embed Code Here"></textarea>
            </div>
            <div class="col-6 mb-3">
                <label for="description" class="form-label">School Description</label>
                <textarea class="form-control" id="description" name="description" rows="2"></textarea>
            </div>
        </div>

        <button type="submit" name="submit" class="btn btn-primary">Add School</button>
    </form>

    <?php
    if (isset($_POST['submit'])) {
        include('../includes/db_connect.php');

        $name = mysqli_real_escape_string($conn, $_POST['name']);
        $admission_status = $_POST['admission_status'];
        $address = mysqli_real_escape_string($conn, $_POST['address']);
        $city_id = intval($_POST['city_name']); // Fetches correct city ID
        $affiliate = mysqli_real_escape_string($conn, $_POST['affiliate']);
        $class_minimum = $_POST['class_minimum'];
        $class_maximum = $_POST['class_maximum'];
        $estd = $_POST['estd'] ? intval($_POST['estd']) : NULL;
        $school_mail = $_POST['school_mail'];
        $primary_mob = $_POST['primary_mob'];
        $secondary_mob = $_POST['secondary_mob'] ? $_POST['secondary_mob'] : NULL;
        $description = mysqli_real_escape_string($conn, $_POST['description']);
        $map_embed_code = mysqli_real_escape_string($conn, $_POST['map_embed_code']);

        // Handle file upload
        $photo = $_FILES['photo']['name'];
        $target_dir = "../admin/uploads/school_photos/";
        $target_file = $target_dir . basename($photo);

        if (!is_dir($target_dir)) {
            mkdir($target_dir, 0777, true);
        }

        if (move_uploaded_file($_FILES['photo']['tmp_name'], $target_file)) {
            // Store the relative path in the database
            $photo_path = $target_file;

            // Insert data into the database
            $sql = "INSERT INTO schools (name, admission_status, address, city_id, affiliate, class_minimum, class_maximum, estd, school_mail, primary_mob, secondary_mob, description, photo, map_embed_code) 
                    VALUES ('$name', '$admission_status', '$address', '$city_id', '$affiliate', '$class_minimum', '$class_maximum', $estd, '$school_mail', '$primary_mob', '$secondary_mob', '$description', '$photo_path', '$map_embed_code')";

            if (mysqli_query($conn, $sql)) {
                echo "<p class='alert alert-success mt-4'>School added successfully!</p>";
            } else {
                echo "<p class='alert alert-danger mt-4'>Error: " . mysqli_error($conn) . "</p>";
            }
        } else {
            echo "<p class='alert alert-danger mt-4'>Error uploading photo.</p>";
        }

        mysqli_close($conn);
    }
    ?>
</div>

<?php include('../includes/footer.php'); ?>