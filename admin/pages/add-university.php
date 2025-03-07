<?php
include('../includes/header.php');
include('../includes/sidebar.php');
?>

<div class="container mt-4">
    <div class="row">
        <!-- Main Content Area -->
        <!-- <div class="col-md-9 ms-sm-auto col-lg-10 px-4"> -->
        <h2 class="mb-4" style="margin-top: 50px;">Add University</h2>

        <!-- Form to add university -->
        <form action="add-university.php" method="POST" enctype="multipart/form-data">
            <div class="row">
                <div class="col-md-6 col-12 mb-3">
                    <label for="university_name" class="form-label">University Name</label>
                    <input type="text" class="form-control" id="university_name" name="university_name" required>
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
                <div class="col-md-6 col-12 mb-3">
                    <label for="affiliate" class="form-label">Affiliate</label>
                    <input type="text" class="form-control" id="affiliate" name="affiliate">
                </div>
            </div>

            <!-- Fetch Courses from Database -->
            <div class="row">
                <div class="col-md-6 col-12 mb-3">
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

                <div class="col-md-6 col-12 mb-3">
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
            </div>

            <div class="row">
                <div class="col-md-3 col-12 mb-3">
                    <label for="class_minimum" class="form-label">Minimum Class</label>
                    <input type="number" class="form-control" id="class_minimum" name="class_minimum" required>
                </div>
                <div class="col-md-3 col-12 mb-3">
                    <label for="class_maximum" class="form-label">Maximum Class</label>
                    <input type="number" class="form-control" id="class_maximum" name="class_maximum" required>
                </div>
                <div class="col-md-6 col-12 mb-3">
                    <label for="estd" class="form-label">Estd</label>
                    <input type="number" class="form-control" id="estd" name="estd">
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 col-12 mb-3">
                    <label for="university_mail" class="form-label">University Email</label>
                    <input type="email" class="form-control" id="university_mail" name="university_mail" required>
                </div>
                <div class="col-md-6 col-12 mb-3">
                    <label for="photo" class="form-label">University Photo</label>
                    <input type="file" class="form-control" id="photo" name="photo" required>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 col-12 mb-3">
                    <label for="primary_mob" class="form-label">Primary Mobile Number</label>
                    <input type="text" class="form-control" id="primary_mob" name="primary_mob" required>
                </div>
                <div class="col-md-6 col-12 mb-3">
                    <label for="secondary_mob" class="form-label">Secondary Mobile Number</label>
                    <input type="text" class="form-control" id="secondary_mob" name="secondary_mob">
                </div>
            </div>

            <div class="col-md-12 col-12 mb-3">
                <label for="overview" class="form-label">University Overview</label>
                <textarea class="form-control" id="overview" name="overview" rows="4"></textarea>
            </div>

            <button type="submit" name="submit" class="btn btn-primary w-100">Add University</button>
        </form>
        <!-- </div> -->
    </div>

    <?php
    if (isset($_POST['submit'])) {
        include('../includes/db_connect.php'); // Include database connection
    
        // Get form values
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
        $overview = $_POST['overview'];
        $courses = $_POST['courses']; // Array of selected course IDs
        $city_id = intval($_POST['city_name']); // Fetches correct city ID
    
        // Handle file upload
        $photo = $_FILES['photo']['name'];
        $target_dir = "../admin/uploads/university_photos/";
        $target_file = $target_dir . basename($photo);

        if (!is_dir($target_dir)) {
            mkdir($target_dir, 0777, true);
        }

        if (move_uploaded_file($_FILES['photo']['tmp_name'], $target_file)) {
            // Store the relative path in the database
            $photo_path = $target_file;

            // Convert selected courses array to a comma-separated string
            $courses_string = implode(',', $courses);

            // Insert university data
            $sql = "INSERT INTO universities (university_name, admission_status, address, affiliate, class_minimum, class_maximum, estd, university_mail, primary_mob, secondary_mob, overview, photo, courses, city_id) 
                    VALUES ('$university_name', '$admission_status', '$address', '$affiliate', $class_minimum, $class_maximum, $estd, '$university_mail', '$primary_mob', '$secondary_mob', '$overview', '$photo_path', '$courses_string', '$city_id')";

            if (mysqli_query($conn, $sql)) {
                echo "<p class='alert alert-success mt-4'>University and courses added successfully!</p>";
            } else {
                echo "<p class='alert alert-danger mt-4'>Error: " . mysqli_error($conn) . "</p>";
            }
        } else {
            echo "<p class='alert alert-danger mt-4'>Error uploading photo.</p>";
        }

        // Close the database connection
        mysqli_close($conn);
    }
    ?>
</div>

<?php include('../includes/footer.php'); ?>