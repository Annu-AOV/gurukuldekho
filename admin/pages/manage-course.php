<?php
include('../includes/header.php');
include('../includes/sidebar.php');
include('../includes/db_connect.php'); // Include database connection
?>

<div class="container mt-4">
    <h2 class="mb-4" style="margin-top:80px;">Manage Courses</h2>

    <!-- Search Bar -->
    <div class="mb-4">
        <form method="GET" action="manage-course.php" class="d-flex">
            <input type="text" class="form-control me-2" name="search" placeholder="Search for a course..." value="<?php echo isset($_GET['search']) ? $_GET['search'] : ''; ?>">
            <button type="submit" class="btn btn-primary">Search</button>
        </form>
    </div>

    <!-- Course Table -->
    <table class="table table-bordered table-striped">
        <thead class="table-dark">
            <tr>
                <th>Serial No.</th>
                <th>Course Name</th>
                <th>Duration(In month)</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php
            // Fetch courses based on search query if provided
            $search = isset($_GET['search']) ? $_GET['search'] : '';
            $query = "SELECT * FROM courses WHERE course_name LIKE '%$search%' ORDER BY id DESC";
            $result = mysqli_query($conn, $query);

            if (mysqli_num_rows($result) > 0) {
                $counter = 1;
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<tr>
                        <td>{$counter}</td>
                        <td>{$row['course_name']}</td>
                        <td>{$row['duration']}</td>
                        <td>
                            <a href='edit-course.php?id={$row['id']}' class='btn btn-sm btn-warning'>Edit</a>
                            <a href='delete-course.php?id={$row['id']}' class='btn btn-sm btn-danger' onclick=\"return confirm('Are you sure you want to delete this course?');\">Delete</a>
                        </td>
                    </tr>";
                    $counter++;
                }
            } else {
                echo "<tr><td colspan='4' class='text-center'>No courses found</td></tr>";
            }
            ?>
        </tbody>
    </table>
</div>

<?php include('../includes/footer.php'); ?>