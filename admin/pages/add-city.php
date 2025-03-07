<?php
include('../includes/header.php');
include('../includes/sidebar.php');
include('../includes/db_connect.php'); // Include database connection
?>

<div class="container mt-4">
<div class="d-flex justify-content-between align-items-center">
<h2 class="mb-4" style="margin-top:80px;">Add City</h2>
        <button class="btn btn-view-all btn-outline-primary" onclick="window.location.href='manage-city.php';">
           Go To Manage City
        </button>
    </div>
   

    <!-- City Form -->
    <form action="add-city.php" method="POST">
        <div class="mb-3">
            <label for="city_name" class="form-label">City Name</label>
            <input type="text" class="form-control" id="city_name" name="city_name" required>
        </div>
        <div class="mb-3">
            <label for="pincode" class="form-label">Pin Code</label>
            <input type="text" class="form-control" id="pincode" name="pincode" required>
        </div>
        <div class="mb-3">
            <label for="state" class="form-label">State</label>
            <input type="text" class="form-control" id="state" name="state" required>
        </div>

        <button type="submit" name="submit" class="btn btn-primary">Add City</button>
    </form>

    <?php
    if (isset($_POST['submit'])) {
        // Get form values
        $city_name = $_POST['city_name'];
        $pincode = $_POST['pincode'];
        $state = $_POST['state'];

        // Insert city into the database
        $query = "INSERT INTO city (city_name, pincode, state) VALUES ('$city_name', '$pincode', '$state')";
        if (mysqli_query($conn, $query)) {
            echo "<p class='alert alert-success mt-4'>City added successfully!</p>";
        } else {
            echo "<p class='alert alert-danger mt-4'>Error: " . mysqli_error($conn) . "</p>";
        }
    }
    ?>
</div>

<?php include('../includes/footer.php'); ?>
