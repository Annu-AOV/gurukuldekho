<?php
// Include database connection
include('../includes/header.php');
include('../includes/sidebar.php');
include('../includes/db_connect.php');

// Pagination variables
$limit = 10; // Number of records per page
$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
$offset = ($page - 1) * $limit;

// Fetch total admissions count
$total_query = "SELECT COUNT(*) AS total FROM admissions";
$total_result = mysqli_query($conn, $total_query);
$total_row = mysqli_fetch_assoc($total_result);
$total_records = $total_row['total'];
$total_pages = ceil($total_records / $limit);

// Fetch paginated admissions data
$admission_query = "SELECT a.*, s.name AS school_name FROM admissions a 
                    JOIN schools s ON a.school_id = s.id 
                    ORDER BY a.id DESC LIMIT $limit OFFSET $offset";
$admission_result = mysqli_query($conn, $admission_query);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage School Admissions</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css">
</head>

<body>
    <div class="container my-5">
        <h2 class="text-center mb-4" style="margin-top: 80px;">Add New Admission</h2>

        <!-- Add Admission Form -->
        <form action="process-addmission.php" method="POST">
            <table class="table table-bordered">
                <thead class="table-dark">
                    <tr>
                        <th>School</th>
                        <th>Class</th>
                        <th>Session</th>
                        <th>Last Application Date</th>
                        <th>Application Fee</th>
                        <th>Admission Process</th>
                        <th>Start Date</th>
                        <th>Last Date</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <!-- School Dropdown -->
                        <td>
                            <select name="school_id" class="form-select" required>
                                <option value="">Select School</option>
                                <?php
                                $schools_query = "SELECT id, name FROM schools";
                                $schools_result = mysqli_query($conn, $schools_query);
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

                        <!-- Class Input -->
                        <td>
                            <input type="text" name="class" class="form-control" placeholder="Enter Class" required>
                        </td>

                        <!-- Session Input -->
                        <td>
                            <input type="text" name="session" class="form-control"
                                placeholder="Enter Session (e.g., 2025-2026)" required>
                        </td>

                        <!-- Last Application Date -->
                        <td>
                            <input type="date" name="last_application_date" class="form-control" required>
                        </td>

                        <!-- Application Fee -->
                        <td>
                            <input type="number" name="application_fee" class="form-control" placeholder="Enter Fee"
                                required>
                        </td>


                        <!-- Admission Process Input Field (Read-Only) -->
                        <td>
                            <input type="text" id="admissionProcessInput" name="admission_process" class="form-control"
                                placeholder="Enter admission process" readonly onclick="openModal()">
                        </td>

                        <!-- Bootstrap Modal -->
                        <div class="modal fade" id="admissionProcessModal" tabindex="-1" aria-labelledby="modalTitle"
                            aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="modalTitle">Enter Admission Process</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <textarea id="admissionProcessText" class="form-control" rows="5"
                                            placeholder="Enter admission process here..."></textarea>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary"
                                            data-bs-dismiss="modal">Close</button>
                                        <button type="button" class="btn btn-primary"
                                            onclick="saveAdmissionProcess()">Save</button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- class wise start Date -->
                        <td>
                            <input type="date" name="start_date" class="form-control" required>
                        </td>

                        <!-- class wise last Date -->
                        <td>
                            <input type="date" name="end_date" class="form-control" required>
                        </td>
                    </tr>
                </tbody>
            </table>

            <!-- Submit Button -->
            <div class="text-center">
                <button type="submit" class="btn btn-success">Add Admission</button>
            </div>
        </form>

        <!-- Saved Admission Section (Moved Below Add Admission Form) -->
        <h3 class="mt-5">Saved Admission Details</h3>
        <table class="table table-bordered">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>School</th>
                    <th>Class</th>
                    <th>Session</th>
                    <th>Last Application Date</th>
                    <th>Application Fee</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if (mysqli_num_rows($admission_result) > 0) {
                    while ($row = mysqli_fetch_assoc($admission_result)) {
                        echo "<tr>
                            <td>{$row['id']}</td>
                            <td>{$row['school_name']}</td>
                            <td>{$row['class']}</td>
                            <td>{$row['session']}</td>
                            <td>{$row['last_application_date']}</td>
                            <td>{$row['application_fee']}</td>
                            <td>
                                <a href='edit-admission.php?id={$row['id']}' class='btn btn-primary btn-sm'>Edit</a>
                                <a href='delete-admission.php?id={$row['id']}' class='btn btn-danger btn-sm' onclick='return confirm(\"Are you sure you want to delete this?\")'>Delete</a>
                            </td>
                          </tr>";
                    }
                } else {
                    echo "<tr><td colspan='7' class='text-center'>No admissions found.</td></tr>";
                }
                ?>
            </tbody>
        </table>

        <!-- Pagination -->
        <nav>
            <ul class="pagination justify-content-center">
                <li class="page-item <?php echo ($page <= 1) ? 'disabled' : ''; ?>">
                    <a class="page-link" href="?page=<?php echo $page - 1; ?>">Previous</a>
                </li>
                <?php for ($i = 1; $i <= $total_pages; $i++) { ?>
                    <li class="page-item <?php echo ($i == $page) ? 'active' : ''; ?>">
                        <a class="page-link" href="?page=<?php echo $i; ?>"><?php echo $i; ?></a>
                    </li>
                <?php } ?>
                <li class="page-item <?php echo ($page >= $total_pages) ? 'disabled' : ''; ?>">
                    <a class="page-link" href="?page=<?php echo $page + 1; ?>">Next</a>
                </li>
            </ul>
        </nav>
    </div>


<!-- JavaScript for Modal Functionality -->
<script>
    function openModal() {
        var modal = new bootstrap.Modal(document.getElementById('admissionProcessModal'));
        document.getElementById('admissionProcessText').value = document.getElementById('admissionProcessInput').value;
        modal.show();
    }

    function saveAdmissionProcess() {
        var textValue = document.getElementById('admissionProcessText').value;
        document.getElementById('admissionProcessInput').value = textValue;
        var modal = bootstrap.Modal.getInstance(document.getElementById('admissionProcessModal'));
        modal.hide();
    }
</script>

<!-- Bootstrap CSS & JS (Required for Modal) -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>


</body>

<?php include('../includes/footer.php'); ?>
</html>