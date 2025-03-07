<?php
// Include database connection
include('../includes/header.php');
include('../includes/sidebar.php');
include('../includes/db_connect.php');


// Pagination settings
$limit = 5;
$page = isset($_GET['page']) ? $_GET['page'] : 1;
$offset = ($page - 1) * $limit;

// Search functionality
$search_query = "";
if (isset($_GET['search'])) {
    $search_query = $_GET['search'];
}

// Fetch school media with pagination and search
$sql = "SELECT sm.id, s.name AS school_name, sm.sports, sm.classroom, sm.labs 
    FROM school_medias sm 
    JOIN schools s ON sm.school_id = s.id 
    WHERE s.name LIKE '%$search_query%' 
    LIMIT $limit OFFSET $offset";
$result = $conn->query($sql);

// Fetch total records for pagination
$total_sql = "SELECT COUNT(*) AS total FROM school_medias sm 
          JOIN schools s ON sm.school_id = s.id 
          WHERE s.name LIKE '%$search_query%'";
$total_result = $conn->query($total_sql);
$total_row = $total_result->fetch_assoc();
$total_pages = ceil($total_row['total'] / $limit);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage School Media</title>

    <!-- Add Bootstrap CSS for styling -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</head>

<body>
<div class="d-flex justify-content-between align-items-center">
<h2 style="margin-top: 80px;">Manage School Media</h2>
        <button class="btn btn-view-all btn-outline-primary" style="margin-top: 60px;" onclick="window.location.href='add-school-media.php';">
          Click To Add School Media
        </button>
    </div>

   

    <!-- Search Form -->
    <form method="GET" action="manage-school-media.php" class="d-flex mb-3">
        <input type="text" name="search" class="form-control me-2" placeholder="Search by school name"
            value="<?php echo htmlspecialchars($search_query); ?>">
        <button type="submit" class="btn btn-primary">Search</button>
    </form>

    <!-- Media Table -->
    <!-- Bootstrap Table -->
    <table class="table table-bordered table-striped table-hover">
        <thead class="table-dark">
            <tr>
                <th>School Name</th>
                <th>Sports</th>
                <th>Classroom</th>
                <th>Labs</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $result->fetch_assoc()) { ?>
                <tr>
                    <td><?php echo htmlspecialchars($row['school_name']); ?></td>

                    <td>
                        <?php
                        $sports_images = explode(',', $row['sports']);
                        foreach ($sports_images as $sports_image) {
                            $image_path = "../assets/uploads/school_photos/" . strtolower(str_replace(' ', '_', $row['school_name'])) . "/" . trim($sports_image);
                            echo '<img src="' . $image_path . '" class="img-thumbnail m-1" width="50" style="cursor:pointer;" data-bs-toggle="modal" data-bs-target="#imageModal" onclick="showImage(\'' . $image_path . '\')">';
                        }
                        ?>
                    </td>

                    <td>
                        <?php
                        $classroom_images = explode(',', $row['classroom']);
                        foreach ($classroom_images as $classroom_image) {
                            $image_path = "../assets/uploads/school_photos/" . strtolower(str_replace(' ', '_', $row['school_name'])) . "/" . trim($classroom_image);
                            echo '<img src="' . $image_path . '" class="img-thumbnail m-1" width="50" style="cursor:pointer;" data-bs-toggle="modal" data-bs-target="#imageModal" onclick="showImage(\'' . $image_path . '\')">';
                        }
                        ?>
                    </td>

                    <td>
                        <?php
                        $labs_images = explode(',', $row['labs']);
                        foreach ($labs_images as $labs_image) {
                            $image_path = "../assets/uploads/school_photos/" . strtolower(str_replace(' ', '_', $row['school_name'])) . "/" . trim($labs_image);
                            echo '<img src="' . $image_path . '" class="img-thumbnail m-1" width="50" style="cursor:pointer;" data-bs-toggle="modal" data-bs-target="#imageModal" onclick="showImage(\'' . $image_path . '\')">';
                        }
                        ?>
                    </td>

                    <td>
                        <a href="edit-school-media.php?id=<?php echo $row['id']; ?>" class="btn btn-sm btn-primary">Edit</a>
                        <a href="delete-school-media.php?id=<?php echo $row['id']; ?>" class="btn btn-sm btn-danger"
                            onclick="return confirm('Are you sure?');">Delete</a>
                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>

    <!-- Modal for Image Preview -->
    <div class="modal fade" id="imageModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Image Preview</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-center">
                    <img id="previewImage" src="" class="img-fluid">
                </div>
            </div>
        </div>
    </div>

    <!-- Pagination UI -->
    <nav aria-label="Page navigation">
        <ul class="pagination justify-content-center">
            <?php if ($page > 1) { ?>
                <li class="page-item">
                    <a class="page-link"
                        href="?page=<?php echo ($page - 1); ?>&search=<?php echo htmlspecialchars($search_query); ?>">Previous</a>
                </li>
            <?php } ?>

            <?php for ($i = 1; $i <= $total_pages; $i++) { ?>
                <li class="page-item <?php echo ($i == $page) ? 'active' : ''; ?>">
                    <a class="page-link"
                        href="?page=<?php echo $i; ?>&search=<?php echo htmlspecialchars($search_query); ?>"><?php echo $i; ?></a>
                </li>
            <?php } ?>

            <?php if ($page < $total_pages) { ?>
                <li class="page-item">
                    <a class="page-link"
                        href="?page=<?php echo ($page + 1); ?>&search=<?php echo htmlspecialchars($search_query); ?>">Next</a>
                </li>
            <?php } ?>
        </ul>
    </nav>

    <!-- JavaScript to Show Clicked Image in Modal -->
    <script>
        function showImage(src) {
            document.getElementById("previewImage").src = src;
        }
    </script>
</body>
<?php include('../includes/footer.php'); ?>
</html>