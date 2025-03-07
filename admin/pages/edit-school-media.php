<?php
include('../includes/header.php');
include('../includes/sidebar.php');
include('../includes/db_connect.php');

// Check if ID is set
if (!isset($_GET['id']) || empty($_GET['id'])) {
    die("Invalid request!");
}

$id = $_GET['id'];

// Fetch existing data
$sql = "SELECT sm.*, s.name AS school_name FROM school_medias sm JOIN schools s ON sm.school_id = s.id WHERE sm.id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$media = $result->fetch_assoc();

if (!$media) {
    die("Media not found!");
}

$school_folder = strtolower(str_replace(' ', '_', $media['school_name']));
$upload_path = "../assets/uploads/school_photos/$school_folder/";

// Handle Image Deletion
if (isset($_POST['delete_image'])) {
    $image_type = $_POST['image_type'];
    $image_name = $_POST['image_name'];

    $file_path = $upload_path . $image_name;
    if (file_exists($file_path)) {
        unlink($file_path); 
    }

    $updated_images = array_filter(explode(',', $media[$image_type]), function ($img) use ($image_name) {
        return trim($img) !== trim($image_name);
    });

    $updated_images_str = implode(',', $updated_images);
    $update_query = "UPDATE school_medias SET $image_type = ? WHERE id = ?";
    $stmt = $conn->prepare($update_query);
    $stmt->bind_param("si", $updated_images_str, $id);
    $stmt->execute();
    
    echo "<script>alert('Image deleted successfully!'); window.location.href=window.location.href;</script>";
}

// Handle Image Replacement
if (isset($_POST['replace_image'])) {
    $image_type = $_POST['image_type'];
    $old_image = $_POST['old_image'];
    $new_image = $_FILES['new_image']['name'];

    if (!empty($new_image)) {
        $new_image_path = $upload_path . basename($new_image);
        move_uploaded_file($_FILES['new_image']['tmp_name'], $new_image_path);

        $images = explode(',', $media[$image_type]);
        $key = array_search($old_image, $images);
        if ($key !== false) {
            $images[$key] = $new_image;
        }
        $updated_images_str = implode(',', $images);
        $update_query = "UPDATE school_medias SET $image_type = ? WHERE id = ?";
        $stmt = $conn->prepare($update_query);
        $stmt->bind_param("si", $updated_images_str, $id);
        $stmt->execute();
        
        echo "<script>alert('Image replaced successfully!'); window.location.href=window.location.href;</script>";
    }
}

// Handle Video Update
if (isset($_POST['update_videos'])) {
    $new_videos = trim($_POST['videos']);
    $update_query = "UPDATE school_medias SET videos = ? WHERE id = ?";
    $stmt = $conn->prepare($update_query);
    $stmt->bind_param("si", $new_videos, $id);
    $stmt->execute();

    echo "<script>alert('Videos updated successfully!'); window.location.href=window.location.href;</script>";
}
?>

<div class="container mt-5">
    <h2 style="margin-top:70px;">Edit School Media</h2>
    <form method="POST" enctype="multipart/form-data">
        <div class="mb-3 border p-3">
            <label class="form-label">School Name</label>
            <input type="text" class="form-control" value="<?php echo htmlspecialchars($media['school_name']); ?>" readonly>
        </div>

        <?php 
        $sections = ['sports', 'classroom', 'labs', 'medical_facilities', 'boarding', 'campus_architecture', 'activities', 'extra_curricular', 'cafeteria', 'library', 'other_photos'];
        foreach ($sections as $section) {
        ?>
            <div class="mb-3 border p-3">
                <label class="form-label text-uppercase"><?php echo ucfirst(str_replace('_', ' ', $section)); ?> Images</label>
                <div class="row">
                    <?php foreach (explode(',', $media[$section]) as $img) { ?>
                        <div class="col-md-2 text-center">
                            <img src="<?php echo $upload_path . $img; ?>" class="img-thumbnail" width="80">
                            <form method="POST">
                                <input type="hidden" name="image_type" value="<?php echo $section; ?>">
                                <input type="hidden" name="image_name" value="<?php echo $img; ?>">
                                <button type="submit" name="delete_image" class="btn btn-sm btn-danger mt-1">Delete</button>
                            </form>
                            <form method="POST" enctype="multipart/form-data">
                                <input type="hidden" name="image_type" value="<?php echo $section; ?>">
                                <input type="hidden" name="old_image" value="<?php echo $img; ?>">
                                <input type="file" name="new_image" class="form-control form-control-sm mt-1" required>
                                <button type="submit" name="replace_image" class="btn btn-sm btn-primary mt-1">Replace</button>
                            </form>
                        </div>
                    <?php } ?>
                </div>
            </div>
        <?php } ?>

        <!-- Video Section -->
        <div class="mb-3 border p-3">
            <label class="form-label text-uppercase">Videos</label>
            <div class="row">
                <?php
                if (!empty($media['videos'])) {
                    $video_links = explode(',', $media['videos']);
                    foreach ($video_links as $video) {
                        $video = trim($video);
                        if (strpos($video, 'youtube.com') !== false || strpos($video, 'youtu.be') !== false) {
                            parse_str(parse_url($video, PHP_URL_QUERY), $yt_params);
                            $video_id = isset($yt_params['v']) ? $yt_params['v'] : basename($video);
                            ?>
                            <div class="col-md-4 mb-3">
                                <iframe width="100%" height="200" src="https://www.youtube.com/embed/<?= $video_id ?>" 
                                    frameborder="0" allowfullscreen class="rounded shadow-sm"></iframe>
                            </div>
                        <?php } elseif (strpos($video, 'vimeo.com') !== false) {
                            $video_id = (int) substr(parse_url($video, PHP_URL_PATH), 1);
                            ?>
                            <div class="col-md-4 mb-3">
                                <iframe width="100%" height="200" src="https://player.vimeo.com/video/<?= $video_id ?>" 
                                    frameborder="0" allowfullscreen class="rounded shadow-sm"></iframe>
                            </div>
                        <?php } ?>
                    <?php }
                } else { ?>
                    <div class="col-12 text-center text-muted">
                        <p class="fs-5">No Video Available</p>
                    </div>
                <?php } ?>
            </div>

            <!-- Video Input Field -->
            <form method="POST">
                <label for="videos">Update Video Links (Comma Separated):</label>
                <input type="text" name="videos" id="videos" class="form-control" placeholder="Enter YouTube/Vimeo links" 
                    value="<?= htmlspecialchars($media['videos']) ?>">
                <button type="submit" name="update_videos" class="btn btn-sm btn-primary mt-2">Update Videos</button>
            </form>
        </div>

        <a href="manage-school-media.php" class="btn btn-secondary">Back</a>
    </form>
</div>

<?php include('../includes/footer.php'); ?>
