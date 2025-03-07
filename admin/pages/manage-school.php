<?php
include('../includes/header.php');
include('../includes/sidebar.php');
include('../includes/db_connect.php'); // Database connection
?>

<div class="container mt-4" id="manage_school">
<div class="d-flex justify-content-between align-items-center">
        <div>
        <h2 class="mb-4" style="margin-top:80px">Manage Schools</h2></div>
        <button class="btn btn-view-all btn-outline-primary" onclick="window.location.href='add-school.php';">
         Click To Add School
        </button>
    </div>
  

    <!-- Search Bar -->
    <form method="GET" action="" class="mb-3">
        <div class="input-group">
            <input type="text" class="form-control" name="search" placeholder="Search by School Name"
                value="<?php echo isset($_GET['search']) ? $_GET['search'] : ''; ?>">
            <button type="submit" class="btn btn-primary">Search</button>
        </div>
    </form>

    <!-- Table -->
    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>Serial No.</th>
                <th>School Name</th>
                <th>Address</th>
               <th>Action</th>
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
            $whereClause = $search ? "WHERE name LIKE '%$search%'" : '';

            // Fetch total records count
            $countQuery = "SELECT COUNT(*) as total FROM schools $whereClause";
            $countResult = mysqli_query($conn, $countQuery);
            $totalRecords = mysqli_fetch_assoc($countResult)['total'];
            $totalPages = ceil($totalRecords / $limit);

            // Fetch data with pagination
            $query = "SELECT * FROM schools $whereClause LIMIT $limit OFFSET $offset";
            $result = mysqli_query($conn, $query);

            if (mysqli_num_rows($result) > 0) {
                $serial = $offset + 1;
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<tr>";
                    echo "<td>" . $serial++ . "</td>";
                    echo "<td>" . $row['name'] . "</td>";
                    echo "<td>" . $row['address'] . "</td>";
                    // echo "<td>" . $row['city'] . "</td>";
                    echo "<td>
                          <a href='../pages/edit-school.php?id=" . $row['id'] . "' class='btn btn-sm btn-warning'>Edit</a>
                            <a href='../pages/delete-school.php?id=" . $row['id'] . "' class='btn btn-sm btn-danger' onclick='return confirm(\"Are you sure you want to delete this school?\")'>Delete</a>
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
            echo "<p class='alert alert-success'>School deleted successfully!</p>";
        } elseif ($_GET['message'] == 'error') {
            echo "<p class='alert alert-danger'>Failed to delete the school. Please try again.</p>";
        }
    }
    ?>

    <?php
    if (isset($_GET['id'])) {
        $schoolId = intval($_GET['id']); // Sanitize the input to avoid SQL injection
    
        // Fetch school details from the database
        $query = "SELECT * FROM schools WHERE id = $schoolId";
        $result = mysqli_query($conn, $query);

        if ($result && mysqli_num_rows($result) > 0) {
            $school = mysqli_fetch_assoc($result);
            // Display school details
            echo "<h1>" . $school['name'] . "</h1>";
            // echo "<p>City: " . $school['city'] . "</p>";
            echo "<p>Address: " . $school['address'] . "</p>";
            echo "<p>Affiliate: " . $school['affiliate'] . "</p>";
            echo "<p>Description: " . $school['description'] . "</p>";
            echo "<img src='../admin/uploads/school_photos/" . $school['photo'] . "' alt='School Photo' style='width:300px; height:auto;'>";
        } else {
            echo "<p>School details not found.</p>";
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