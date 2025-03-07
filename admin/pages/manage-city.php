<?php
include('../includes/header.php');
include('../includes/sidebar.php');
include('../includes/db_connect.php'); // Database connection
?>

<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center">
        <h2 class="mb-4" style="margin-top: 80px;">Manage Cities</h2>
        <button class="btn btn-view-all btn-outline-primary" onclick="window.location.href='add-city.php';">
            Click To Add City
        </button>
    </div>


    <!-- Search Bar -->
    <form method="GET" action="" class="mb-3">
        <div class="input-group">
            <input type="text" class="form-control" name="search" placeholder="Search by City name"
                value="<?php echo isset($_GET['search']) ? $_GET['search'] : ''; ?>">
            <button type="submit" class="btn btn-primary">Search</button>
        </div>
    </form>

    <!-- Table -->
    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>Serial No.</th>
                <th>City Name</th>
                <th>Pin Code</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php
            // Pagination Variables
            $limit = 10; // Number of records per page
            $page = isset($_GET['page']) ? $_GET['page'] : 1; // Current page number
            $offset = ($page - 1) * $limit; // Offset for query
            
            // Search Functionality
            $search = isset($_GET['search']) ? $_GET['search'] : '';
            $whereClause = $search ? "WHERE city_name LIKE '%$search%'" : '';

            // Fetch total records count
            $countQuery = "SELECT COUNT(*) as total FROM city $whereClause";
            $countResult = mysqli_query($conn, $countQuery);
            $totalRecords = mysqli_fetch_assoc($countResult)['total'];
            $totalPages = ceil($totalRecords / $limit);

            // Fetch data with pagination
            $query = "SELECT * FROM city $whereClause LIMIT $limit OFFSET $offset";
            $result = mysqli_query($conn, $query);

            if (mysqli_num_rows($result) > 0) {
                $serial = $offset + 1;
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<tr>";
                    echo "<td>" . $serial++ . "</td>";
                    echo "<td>" . $row['city_name'] . "</td>";
                    echo "<td>" . $row['pincode'] . "</td>";
                    echo "<td>
                            <a href='edit-city.php?city=" . urlencode($row['city_name']) . "' class='btn btn-sm btn-warning'>Edit</a>
                            <a href='delete-city.php?city=" . urlencode($row['city_name']) . "' class='btn btn-sm btn-danger' onclick='return confirm(\"Are you sure you want to delete this city?\")'>Delete</a>
                          </td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='4' class='text-center'>No records found</td></tr>";
            }
            ?>
        </tbody>
    </table>

    <?php
    if (isset($_GET['message'])) {
        if ($_GET['message'] == 'success') {
            echo "<p class='alert alert-success'>City deleted successfully!</p>";
        } elseif ($_GET['message'] == 'error') {
            echo "<p class='alert alert-danger'>Failed to delete the city. Please try again.</p>";
        }
    }
    ?>

    <!-- Pagination -->
    <nav>
        <ul class="pagination justify-content-center">
            <?php if ($page > 1): ?>
                <li class="page-item">
                    <a class="page-link" href="?page=<?php echo $page - 1; ?>&search=<?php echo $search; ?>">Previous</a>
                </li>
            <?php endif; ?>

            <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                <li class="page-item <?php echo ($i == $page) ? 'active' : ''; ?>">
                    <a class="page-link" href="?page=<?php echo $i; ?>&search=<?php echo $search; ?>"><?php echo $i; ?></a>
                </li>
            <?php endfor; ?>

            <?php if ($page < $totalPages): ?>
                <li class="page-item">
                    <a class="page-link" href="?page=<?php echo $page + 1; ?>&search=<?php echo $search; ?>">Next</a>
                </li>
            <?php endif; ?>
        </ul>
    </nav>
</div>

<?php include('../includes/footer.php'); ?>