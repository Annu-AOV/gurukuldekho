<?php
// Include database connection
include('../includes/header.php');
include('../includes/sidebar.php');
include('../includes/db_connect.php');

// Get the facility ID from URL
if (!isset($_GET['id']) || empty($_GET['id'])) {
    die("Invalid Request!");
}

$facility_id = $_GET['id'];

// Fetch existing facility data
$query = "SELECT * FROM school_facility WHERE id = $facility_id";
$result = mysqli_query($conn, $query);
$facility = mysqli_fetch_assoc($result);

if (!$facility) {
    die("Facility record not found!");
}

// Fetch school name
$school_query = "SELECT name FROM schools WHERE id = {$facility['school_id']}";
$school_result = mysqli_query($conn, $school_query);
$school_name = mysqli_fetch_assoc($school_result)['name'];

// Facility options
$facilities = [
    'extra_curricular' => ['Art and Craft', 'Dance', 'Debate', 'Drama', 'Gardening', 'Music', 'Picnics and excursion'],
    'class_facilities' => ['AC Classes', 'Smart Classes', 'Wifi'],
    'infrastructure' => ['Library/Reading Room', 'Playground', 'Auditorium/Media Room', 'Cafeteria/Canteen'],
    'sports_fitness' => ['Indoor Sports', 'Outdoor Sports', 'Karate', 'Taekwondo', 'Yoga', 'Skating', 'Horse Riding', 'Gym', 'Swimming Pool'],
    'lab_facilities' => ['Computer Lab', 'Science Lab', 'Language Lab', 'Robotics Lab'],
    'boarding' => ['Boys Hostel', 'Girls Hostel'],
    'disabled_friendly' => ['Washrooms', 'Ramps', 'Elevators'],
    'safety_security' => ['CCTV', 'GPS Bus Tracking App'],
    'advanced_facilities' => ['Medical Room', 'Transportation', 'Alumni Association', 'Day care', 'Meals']
];

// Function to check if an option is selected
function isChecked($field, $value, $facility) {
    $selected_values = explode(',', $facility[$field]);
    return in_array($value, $selected_values) ? "checked" : "";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit School Facility</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css">
</head>
<body>
<div class="container my-5">
    <h2 class="text-center mb-4">Edit School Facility - <?= $school_name ?></h2>
    
    <form action="update-school-facility.php" method="POST">
        <input type="hidden" name="facility_id" value="<?= $facility_id ?>">

        <table class="table table-bordered">
            <thead class="table-dark">
                <tr>
                    <th>Facility Type</th>
                    <th>Options</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($facilities as $key => $options) { ?>
                    <tr>
                        <td><strong><?= ucfirst(str_replace('_', ' ', $key)) ?></strong></td>
                        <td>
                            <?php foreach ($options as $option) { ?>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox" name="<?= $key ?>[]" value="<?= $option ?>" <?= isChecked($key, $option, $facility) ?>>
                                    <label class="form-check-label"><?= $option ?></label>
                                </div>
                            <?php } ?>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>

        <div class="text-center">
            <button type="submit" class="btn btn-primary">Update Facility</button>
            <a href="manage-school-facility.php" class="btn btn-secondary">Back</a>
        </div>
    </form>
</div>
</body>
</html>
