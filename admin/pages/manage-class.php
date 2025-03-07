<?php
include('../includes/header.php');
include('../includes/sidebar.php');
?>

<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center">
        <h2 class="mb-4" style="margin-top:80px;">Manage Classes</h2>
        <button class="btn btn-view-all btn-outline-primary" onclick="window.location.href='add-class.php';">
            Click To Add Class
        </button>
    </div>


    <!-- Search Bar -->
    <form method="GET" action="manage-class.php" class="mb-4">
        <div class="input-group">
            <input type="text" name="search" class="form-control" placeholder="Search class by name..."
                value="<?php echo isset($_GET['search']) ? $_GET['search'] : ''; ?>">
            <button type="submit" class="btn btn-primary">Search</button>
        </div>
    </form>

    <!-- Classes Table -->
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Serial No</th>
                <th>Class Name</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php
            include('../includes/db_connect.php'); // Include database connection
            
            // Fetch search query if available
            $search = isset($_GET['search']) ? mysqli_real_escape_string($conn, $_GET['search']) : '';

            // SQL query to fetch classes
            $sql = "SELECT * FROM classes";
            if (!empty($search)) {
                $sql .= " WHERE class_name LIKE '%$search%'";
            }
            $result = mysqli_query($conn, $sql);

            if (mysqli_num_rows($result) > 0) {
                $serial_no = 1;
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<tr>
                        <td>{$serial_no}</td>
                        <td>{$row['class_name']}</td>
                        <td>
                            <a href='edit-class.php?id={$row['id']}' class='btn btn-sm btn-warning'>Edit</a>
                            <a href='delete-class.php?id={$row['id']}' onclick='return confirm(\"Are you sure you want to delete this class?\");' class='btn btn-sm btn-danger'>Delete</a>
                        </td>
                    </tr>";
                    $serial_no++;
                }
            } else {
                echo "<tr><td colspan='3' class='text-center'>No classes found.</td></tr>";
            }

            // Close the database connection
            mysqli_close($conn);
            ?>
        </tbody>
    </table>
</div>

<?php include('../includes/footer.php'); ?>