<?php
include('../includes/header.php');
include('../includes/sidebar.php');
include('../includes/db_connect.php'); // Database connection

// Get the city from the URL and sanitize it
if (!isset($_GET['city'])) {
    echo "<p class='alert alert-danger'>No city selected. Please go back and try again.</p>";
    exit();
}

$city = mysqli_real_escape_string($conn, $_GET['city']); // Sanitize city value

// Fetch the city data from the database using the sanitized city name
$query = "SELECT * FROM city WHERE city_name = '$city'";
$result = mysqli_query($conn, $query);

if (mysqli_num_rows($result) == 0) {
    echo "<p class='alert alert-danger'>City not found. Please go back and try again.</p>";
    exit();
}

$cityData = mysqli_fetch_assoc($result);
?>

<div class="container mt-4">
    <h2 class="mb-4" style="margin-top:80px">Edit City: <?php echo htmlspecialchars($cityData['city_name']); ?></h2>

    <!-- Form to edit city -->
    <form action="edit-city.php?city=<?php echo urlencode($city); ?>" method="POST">
        <div class="row">
            <div class="col-md-6 mb-3">
                <label for="city_name" class="form-label">City Name</label>
                <input type="text" class="form-control" id="city_name" name="city_name" value="<?php echo htmlspecialchars($cityData['city_name']); ?>" required>
            </div>
            <div class="col-md-6 mb-3">
                <label for="pincode" class="form-label">Pincode</label>
                <input type="text" class="form-control" id="pincode" name="pincode" value="<?php echo htmlspecialchars($cityData['pincode']); ?>" required>
            </div>
        </div>

        <button type="submit" name="update" class="btn btn-success">Update City</button>
    </form>

    <?php
    if (isset($_POST['update'])) {
        // Get updated form values
        $city_name = mysqli_real_escape_string($conn, $_POST['city_name']);
        $pincode = mysqli_real_escape_string($conn, $_POST['pincode']);

        // Update data in the database
        $updateQuery = "UPDATE city 
                        SET city_name='$city_name', pincode='$pincode' 
                        WHERE city_name = '$city'";

        if (mysqli_query($conn, $updateQuery)) {
            echo "<p class='alert alert-success mt-4'>City details updated successfully!</p>";
        } else {
            echo "<p class='alert alert-danger mt-4'>Error: " . mysqli_error($conn) . "</p>";
        }
    }

    // Close the database connection
    mysqli_close($conn);
    ?>
</div>

<?php include('../includes/footer.php'); ?>
