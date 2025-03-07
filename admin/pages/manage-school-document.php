<?php
// Include database connection
include('../includes/header.php');
include('../includes/sidebar.php');
include('../includes/db_connect.php');

// Pagination settings
$limit = 5; // Number of records per page
$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
$offset = ($page - 1) * $limit;

// Fetch school data from the schools table
$schools_query = "SELECT id, name FROM schools";
$schools_result = mysqli_query($conn, $schools_query);

// Fetch paginated document details from school_documents table
$documents_query = "SELECT sd.*, s.name AS school_name 
                    FROM school_documents sd
                    JOIN schools s ON sd.school_id = s.id
                    LIMIT $limit OFFSET $offset";
$documents_result = mysqli_query($conn, $documents_query);

// Get total record count
$total_query = "SELECT COUNT(*) AS total FROM school_documents";
$total_result = mysqli_query($conn, $total_query);
$total_row = mysqli_fetch_assoc($total_result);
$total_pages = ceil($total_row['total'] / $limit);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage School Documents</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css">
</head>

<body>
    <div class="container my-5" style="overflow-y: overlay;">
        <h2 class="text-center mb-4" style="margin-top:30px;">Manage School Documents</h2>

        <!-- Document Management Form -->
        <form action="process-school-document.php" method="POST">
            <table class="table table-bordered">
                <thead class="table-dark">
                    <tr>
                        <th>School</th>
                        <th>Address Proof</th>
                        <th>Birth Certificate</th>
                        <th>Medical Certificate</th>
                        <th>Photo</th>
                        <th>Caste Certificate</th>
                        <th>Family Photo</th>
                        <th>Last School Details</th>
                        <th>Parent/Guardian's Photo</th>
                        <th>Religion Proof</th>
                        <th>Report Card</th>
                        <th>Differently Abled Proof</th>
                        <th>Sibling Alumni Proof</th>
                        <th>First Girl Child</th>
                        <th>Aadhaar Card</th>
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

                        <!-- Document Checkboxes -->
                        <?php
                        $fields = [
                            'address_proof',
                            'birth_certificate',
                            'medical_certificate',
                            'photo',
                            'caste_certificate',
                            'family_photo',
                            'last_school_details',
                            'parent_guardian_photo',
                            'religion_proof',
                            'report_card',
                            'differently_abled_proof',
                            'sibling_alumni_proof',
                            'first_girl_child',
                            'aadhaar_card'
                        ];
                        foreach ($fields as $field) {
                            echo "<td><input type='checkbox' name='{$field}' value='1'></td>";
                        }
                        ?>
                    </tr>
                </tbody>
            </table>

            <!-- Submit Button -->
            <div class="text-center">
                <button type="submit" class="btn btn-success">Save Documents</button>
            </div>
        </form>

        <hr>

        <!-- Saved Documents Table -->
        <h3 class="text-center mt-4">Saved School Documents</h3>
        <table class="table table-bordered mt-3">
            <thead class="table-dark">
                <tr>
                    <th>#</th>
                    <th>School Name</th>
                    <th>Documents</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if (mysqli_num_rows($documents_result) > 0) {
                    $counter = $offset + 1;
                    while ($row = mysqli_fetch_assoc($documents_result)) {
                        echo "<tr>";
                        echo "<td>{$counter}</td>";
                        echo "<td>{$row['school_name']}</td>";

                        // Show document availability
                        echo "<td>";
                        $docs = [];
                        foreach ($fields as $field) {
                            if ($row[$field] == 1) {
                                $docs[] = ucfirst(str_replace("_", " ", $field));
                            }
                        }
                        echo implode(", ", $docs);
                        echo "</td>";

                        // Edit and Delete buttons
                        echo "<td>
                            <a href='edit-school-document.php?id={$row['id']}' class='btn btn-warning btn-sm'>Edit</a>
                            <a href='delete-school-document.php?id={$row['id']}' class='btn btn-danger btn-sm' onclick='return confirm(\"Are you sure you want to delete this record?\")'>Delete</a>
                          </td>";
                        echo "</tr>";
                        $counter++;
                    }
                } else {
                    echo "<tr><td colspan='4' class='text-center'>No records found</td></tr>";
                }
                ?>
            </tbody>
        </table>

        <!-- Pagination -->
        <nav aria-label="Page navigation">
            <ul class="pagination justify-content-center">
                <?php if ($page > 1): ?>
                    <li class="page-item"><a class="page-link" href="?page=<?php echo $page - 1; ?>">Previous</a></li>
                <?php endif; ?>

                <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                    <li class="page-item <?php echo ($i == $page) ? 'active' : ''; ?>">
                        <a class="page-link" href="?page=<?php echo $i; ?>"><?php echo $i; ?></a>
                    </li>
                <?php endfor; ?>

                <?php if ($page < $total_pages): ?>
                    <li class="page-item"><a class="page-link" href="?page=<?php echo $page + 1; ?>">Next</a></li>
                <?php endif; ?>
            </ul>
        </nav>

    </div>

    <!-- Add this before closing </body> -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
<?php include('../includes/footer.php'); ?>

</html>