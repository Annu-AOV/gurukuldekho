<?php
// Include database connection
include('../includes/db_connect.php');
include('../includes/header.php');
include('../includes/sidebar.php');

// Fetch school names for selection
$sql = "SELECT id, name FROM schools";
$result = $conn->query($sql);

// Handle form submission for media upload
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['submit'])) {
    $school_id = $_POST['school_id'];
    $school_name_query = "SELECT name FROM schools WHERE id = '$school_id'";
    $school_result = $conn->query($school_name_query);
    $school = $school_result->fetch_assoc();
    $school_name = strtolower(str_replace(' ', '_', $school['name']));
    $target_dir = "../assets/uploads/school_photos/" . $school_name . "/";

    if (!file_exists($target_dir)) {
        mkdir($target_dir, 0777, true);
    }

    function uploadFile($file, $target_dir)
    {
        $file_names = [];
        if (isset($file['name'])) {
            if (is_array($file['name'])) {
                foreach ($file['name'] as $key => $filename) {
                    $target_file = basename($file['name'][$key]);
                    if (move_uploaded_file($file['tmp_name'][$key], $target_dir . $target_file)) {
                        $file_names[] = $target_file;
                    }
                }
            } else {
                $target_file = basename($file['name']);
                if (move_uploaded_file($file['tmp_name'], $target_dir . $target_file)) {
                    $file_names[] = $target_file;
                }
            }
        }
        return $file_names;
    }

    $categories = ["sports", "classroom", "labs", "medical_facilities", "boarding", "campus_architecture", "activities", "extra_curricular", "cafeteria", "library", "other_photos"];
    $uploaded_files = [];
    foreach ($categories as $category) {
        $uploaded_files[$category] = implode(',', uploadFile($_FILES[$category], $target_dir));
    }

    // Store video links instead of file uploads
    $videos = trim($_POST['videos']);

    $sql = "INSERT INTO school_medias (school_id, " . implode(", ", $categories) . ", videos) 
            VALUES ('$school_id', '" . implode("', '", $uploaded_files) . "', '$videos')";

    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('Media added successfully!'); window.location.href='manage-school-media.php';</script>";
    } else {
        echo "Error: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage School Media</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>

<body>
    <div class="container mt-5">
        <div class="d-flex justify-content-between align-items-center">
            <h2 class="text-center mb-4" style="margin-top:70px;">Add Media for Schools</h2>
            <button class="btn btn-view-all btn-outline-primary" onclick="window.location.href='manage-school-media.php';">
                Go To Manage School Media
            </button>
        </div>

        <form action="add-school-media.php" method="post" enctype="multipart/form-data" class="p-4 border rounded">
            <div class="form-group">
                <label for="school_id">Select School:</label>
                <select name="school_id" id="school_id" class="form-control" required>
                    <?php while ($row = $result->fetch_assoc()) { ?>
                        <option value="<?php echo $row['id']; ?>"><?php echo $row['name']; ?></option>
                    <?php } ?>
                </select>
            </div>

            <?php $categories = ["Sports", "Classroom", "Labs", "Medical Facilities", "Boarding", "Campus Architecture", "Activities", "Extra Curricular", "Cafeteria", "Library", "Other Photos"]; ?>
            <div class="row">
                <?php foreach ($categories as $category) {
                    $field = strtolower(str_replace(' ', '_', $category)); ?>
                    <div class="col-md-4 mb-3">
                        <div class="border p-3 rounded">
                            <label for="<?php echo $field; ?>"><?php echo $category; ?> Images:</label>
                            <input type="file" name="<?php echo $field; ?>[]" id="<?php echo $field; ?>" multiple class="form-control">
                        </div>
                    </div>
                <?php } ?>
            </div>

            <!-- Video Links Input -->
            <div class="form-group">
                <label for="videos">YouTube/Vimeo Video Links (Comma Separated):</label>
                <input type="text" name="videos" id="videos" class="form-control" placeholder="Enter video links">
                <small class="text-muted">Example: https://www.youtube.com/watch?v=XXXXX, https://vimeo.com/XXXXX</small>
            </div>

            <button type="submit" name="submit" class="btn btn-primary btn-block">Upload Media</button>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
<?php include('../includes/footer.php'); ?>
</html>
