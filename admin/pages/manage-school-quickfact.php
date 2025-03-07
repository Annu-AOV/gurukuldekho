<?php
// Include database connection
include('../includes/header.php');
include('../includes/sidebar.php');
include('../includes/db_connect.php');

// Fetch school data
$schools_query = "SELECT id, name FROM schools";
$schools_result = mysqli_query($conn, $schools_query);

// Pagination Settings
$records_per_page = 5;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $records_per_page;

// Fetch total records for pagination
$total_query = "SELECT COUNT(*) AS total FROM school_quickfact";
$total_result = mysqli_query($conn, $total_query);
$total_row = mysqli_fetch_assoc($total_result);
$total_records = $total_row['total'];
$total_pages = ceil($total_records / $records_per_page);

// Fetch paginated data
$quickfact_query = "SELECT sq.id, s.name AS school_name, sq.board, sq.gender, 
                           CONCAT(sq.class_min, ' - ', sq.class_max) AS classes, 
                           sq.academic_session, sq.medium, sq.student_teacher_ratio, 
                           sq.day_boarding, sq.campus_size 
                    FROM school_quickfact sq
                    INNER JOIN schools s ON sq.school_id = s.id
                    ORDER BY s.name
                    LIMIT $offset, $records_per_page";

$quickfact_result = mysqli_query($conn, $quickfact_query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage School Quick Facts</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css">

    <script>
        function scrollToTable() {
            document.getElementById("quickFactsTable").scrollIntoView({ behavior: "smooth" });
        }
    </script>
</head>
<body>
<div class="container my-5">
    <h2 class="text-center mb-4" style="margin-top: 80px;">Manage School Quick Facts</h2>

    <!-- Quick Facts Table -->
    <table class="table table-bordered">
        <thead class="table-dark">
            <tr>
                <th>#</th>
                <th>School</th>
                <th>Board</th>
                <th>Gender</th>
                <th>Classes</th>
                <th>Session</th>
                <th>Medium</th>
                <th>Student-Teacher Ratio</th>
                <th>Type</th>
                <th>Campus Size</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php if (mysqli_num_rows($quickfact_result) > 0): 
                 $count = $offset + 1;
                while ($row = mysqli_fetch_assoc($quickfact_result)): ?>
                <tr>
                    <td><?php echo $count++; ?></td>
                    <td><?php echo $row['school_name']; ?></td>
                    <td><?php echo $row['board']; ?></td>
                    <td><?php echo $row['gender']; ?></td>
                    <td><?php echo $row['classes']; ?></td>
                    <td><?php echo $row['academic_session']; ?></td>
                    <td><?php echo $row['medium']; ?></td>
                    <td><?php echo $row['student_teacher_ratio']; ?></td>
                    <td><?php echo $row['day_boarding']; ?></td>
                    <td><?php echo $row['campus_size']; ?> acres</td>
                    <td>
                        <a href="edit-schoolQuickfact.php?id=<?php echo $row['id']; ?>" class="btn btn-warning btn-sm">Edit</a>
                        <a href="delete-schoolQuickfact.php?id=<?php echo $row['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this record?');">Delete</a>
                    </td>
                </tr>
            <?php endwhile; else: ?>
                <tr>
                    <td colspan="11" class="text-center">No School Quick Facts Found</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>

      
    <!-- Pagination Buttons -->
    <div class="d-flex justify-content-center">
        <nav>
            <ul class="pagination">
                <?php if ($page > 1): ?>
                    <li class="page-item"><a class="page-link" href="?page=<?php echo $page - 1; ?>" onclick="scrollToTable()">Previous</a></li>
                <?php endif; ?>

                <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                    <li class="page-item <?php echo ($i == $page) ? 'active' : ''; ?>">
                        <a class="page-link" href="?page=<?php echo $i; ?>" onclick="scrollToTable()"><?php echo $i; ?></a>
                    </li>
                <?php endfor; ?>

                <?php if ($page < $total_pages): ?>
                    <li class="page-item"><a class="page-link" href="?page=<?php echo $page + 1; ?>" onclick="scrollToTable()">Next</a></li>
                <?php endif; ?>
            </ul>
        </nav>
    </div>

    <!-- Add New School Quick Fact Form -->
    <h3 class="text-center mt-4">Add New School Quick Fact</h3>
    <form action="process-addSchoolQuickfact.php" method="POST">
        <table class="table table-bordered">
            <thead class="table-primary">
                <tr>
                    <th>School</th>
                    <th>Board</th>
                    <th>Gender</th>
                    <th>Classes (Min - Max)</th>
                    <th>Session</th>
                    <th>Medium</th>
                    <th>Student-Teacher Ratio</th>
                    <th>Type</th>
                    <th>Campus Size</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <!-- School Dropdown -->
                    <td>
                        <select name="school_id" class="form-select" required>
                            <option value="">Select School</option>
                            <?php
                            if (mysqli_num_rows($schools_result) > 0) {
                                while ($row = mysqli_fetch_assoc($schools_result)) {
                                    echo "<option value='{$row['id']}'>{$row['name']}</option>";
                                }
                            } else {
                                echo "<option value=''>No Schools Available</option>";
                            }
                            ?>
                        </select>
                    </td>

                    <!-- Board Dropdown -->
                    <td>
                        <select name="board" class="form-select" required>
                            <option value="">Select Board</option>
                            <option value="CBSE">CBSE</option>
                            <option value="ICSE">ICSE</option>
                            <option value="State Board">State Board</option>
                            <option value="IB">IB</option>
                            <option value="Cambridge">Cambridge</option>
                        </select>
                    </td>

                    <!-- Gender Dropdown -->
                    <td>
                        <select name="gender" class="form-select" required>
                            <option value="">Select</option>
                            <option value="Boys">Boys</option>
                            <option value="Girls">Girls</option>
                            <option value="Co-ed">Co-ed</option>
                        </select>
                    </td>

                    <!-- Min-Max Class Selection -->
                    <td>
                        <div class="d-flex">
                            <input type="number" name="class_min" class="form-control" placeholder="Min" min="1" max="12" required>
                            <span class="mx-2">to</span>
                            <input type="number" name="class_max" class="form-control" placeholder="Max" min="1" max="12" required>
                        </div>
                    </td>

                    <!-- Academic Session -->
                    <td>
                        <input type="text" name="academic_session" class="form-control" placeholder="2025-2026" required>
                    </td>

                    <!-- Medium of Instruction -->
                    <td>
                        <input type="text" name="medium" class="form-control" placeholder="English / Hindi" required>
                    </td>

                    <!-- Student-Teacher Ratio -->
                    <td>
                        <input type="text" name="student_teacher_ratio" class="form-control" placeholder="E.g. 20:1" required>
                    </td>

                    <!-- Day/Boarding -->
                    <td>
                        <select name="day_boarding" class="form-select" required>
                            <option value="">Select</option>
                            <option value="Day School">Day School</option>
                            <option value="Boarding School">Boarding School</option>
                            <option value="Day & Boarding">Day & Boarding</option>
                        </select>
                    </td>

                    <!-- Campus Size -->
                    <td>
                        <input type="text" name="campus_size" class="form-control" placeholder="E.g. 5 acres" required>
                    </td>
                </tr>
            </tbody>
        </table>

        <!-- Submit Button -->
        <div class="text-center">
            <button type="submit" class="btn btn-success">Add Quick Fact</button>
        </div>
    </form>
</div>
</body>
<?php include('../includes/footer.php'); ?>
</html>
