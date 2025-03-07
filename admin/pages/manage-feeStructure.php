<?php
// Include database connection
include('../includes/header.php');
include('../includes/sidebar.php');
include('../includes/db_connect.php');

// Fetch school data from the schools table
$schools_query = "SELECT id, name FROM schools";
$schools_result = mysqli_query($conn, $schools_query);

// Pagination settings
$limit = 5; // Limit per page
$page = isset($_GET['page']) ? (int) $_GET['page'] : 1; // Current page number
$offset = ($page - 1) * $limit;

// Fetch fee structure data with pagination
$fee_query = "SELECT fs.id, fs.class, fs.session, s.name AS school_name 
              FROM fee_structure fs
              INNER JOIN schools s ON fs.school_id = s.id
              ORDER BY s.name, fs.session, fs.class
              LIMIT $limit OFFSET $offset";

$fee_result = mysqli_query($conn, $fee_query);

// Total records count
$total_query = "SELECT COUNT(*) as total FROM fee_structure";
$total_result = mysqli_query($conn, $total_query);
$total_row = mysqli_fetch_assoc($total_result);
$total_records = $total_row['total'];
$total_pages = ceil($total_records / $limit);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Fee Structure</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css">
</head>

<body>
    <div class="container my-5">
        <div class="d-flex justify-content-between align-items-center">
            <h2 class="text-center mb-4" style="margin-top: 80px;">Manage Fee Structure</h2>
            <button class="btn btn-view-all btn-outline-primary"
                onclick="window.location.href='add-schoolfeeStruct.php';">
                Click To Fee Structure
            </button>
        </div>
        <!-- Fee Structure Table -->
        <table class="table table-bordered">
            <thead class="table-dark">
                <tr>
                    <th>#</th>
                    <th>School</th>
                    <th>Class</th>
                    <th>Session</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php if (mysqli_num_rows($fee_result) > 0):
                    $count = 1;
                    while ($row = mysqli_fetch_assoc($fee_result)): ?>
                        <tr>
                            <td><?php echo $count++; ?></td>
                            <td><?php echo $row['school_name']; ?></td>
                            <td><?php echo $row['class']; ?></td>
                            <td><?php echo $row['session']; ?></td>
                            <td>
                                <a href="edit-feeStructure.php?id=<?php echo $row['id']; ?>"
                                    class="btn btn-warning btn-sm">Edit</a>
                                <a href="delete-feeStructure.php?id=<?php echo $row['id']; ?>" class="btn btn-danger btn-sm"
                                    onclick="return confirm('Are you sure you want to delete this record?');">Delete</a>
                            </td>
                        </tr>
                    <?php endwhile; else: ?>
                    <tr>
                        <td colspan="5" class="text-center">No Fee Structure Found</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>


        <!-- Pagination -->
        <nav>
            <ul class="pagination justify-content-center">
                <li class="page-item <?php echo ($page <= 1) ? 'disabled' : ''; ?>">
                    <a class="page-link" href="?page=<?php echo $page - 1; ?>">Previous</a>
                </li>

                <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                    <li class="page-item <?php echo ($i == $page) ? 'active' : ''; ?>">
                        <a class="page-link" href="?page=<?php echo $i; ?>"><?php echo $i; ?></a>
                    </li>
                <?php endfor; ?>

                <li class="page-item <?php echo ($page >= $total_pages) ? 'disabled' : ''; ?>">
                    <a class="page-link" href="?page=<?php echo $page + 1; ?>">Next</a>
                </li>
            </ul>
        </nav>


    </div>

    <!-- Add this before closing </body> -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
<?php include('../includes/footer.php'); ?>

</html>