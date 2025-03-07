<?php
// Include database connection
include('../includes/header.php');
include('../includes/sidebar.php');
include('../includes/db_connect.php');

// Pagination setup
$limit = 5; // Number of records per page
$page = isset($_GET['page']) ? $_GET['page'] : 1;
$offset = ($page - 1) * $limit;

// Fetch total records count
$total_query = "SELECT COUNT(*) AS total FROM school_language";
$total_result = mysqli_query($conn, $total_query);
$total_row = mysqli_fetch_assoc($total_result);
$total_records = $total_row['total'];
$total_pages = ceil($total_records / $limit);

// Fetch paginated data
$languages_query = "SELECT sl.*, s.name AS school_name FROM school_language sl 
                    JOIN schools s ON sl.school_id = s.id 
                    LIMIT $limit OFFSET $offset";
$languages_result = mysqli_query($conn, $languages_query);

// Fetch all schools
$schools_query = "SELECT id, name FROM schools";
$schools_result = mysqli_query($conn, $schools_query);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage School Languages</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css">
</head>

<body>
    <div class="container my-5">
        <!-- Language Data Table (Moved Above the Form) -->
        <h3 class="text-center" style="margin-top: 80px;">School Language List</h3>
        <table class="table table-bordered mt-3">
            <thead class="table-dark">
                <tr>
                    <th>School</th>
                    <th>Languages</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = mysqli_fetch_assoc($languages_result)): ?>
                    <tr>
                        <td><?= $row['school_name'] ?></td>
                        <td>
                            <?php
                            $fields = [
                                'english',
                                'hindi',
                                'french',
                                'spanish',
                                'german',
                                'chinese',
                                'japanese',
                                'arabic',
                                'russian',
                                'portuguese',
                                'italian',
                                'korean',
                                'bengali',
                                'urdu',
                                'turkish',
                                'sanskrit'
                            ];
                            $languages = [];
                            foreach ($fields as $field) {
                                if ($row[$field] == 1) {
                                    $languages[] = ucfirst($field);
                                }
                            }
                            echo implode(', ', $languages);
                            ?>
                        </td>
                        <td>
                            <a href="edit-school-language.php?id=<?= $row['id'] ?>" class="btn btn-primary btn-sm">Edit</a>
                            <a href="delete-school-language.php?id=<?= $row['id'] ?>" class="btn btn-danger btn-sm"
                                onclick="return confirm('Are you sure?')">Delete</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>

        <!-- Pagination -->
        <nav aria-label="Page navigation">
            <ul class="pagination justify-content-center">
                <?php if ($page > 1): ?>
                    <li class="page-item">
                        <a class="page-link" href="?page=<?= $page - 1 ?>">Previous</a>
                    </li>
                <?php endif; ?>

                <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                    <li class="page-item <?= ($i == $page) ? 'active' : '' ?>">
                        <a class="page-link" href="?page=<?= $i ?>"><?= $i ?></a>
                    </li>
                <?php endfor; ?>

                <?php if ($page < $total_pages): ?>
                    <li class="page-item">
                        <a class="page-link" href="?page=<?= $page + 1 ?>">Next</a>
                    </li>
                <?php endif; ?>
            </ul>
        </nav>

        <hr>

        <!-- Add New Language Form (Below the List) -->
        <h3 class="text-center mt-5">Manage School Language</h3>
        <form action="process-school-language.php" method="POST">
            <table class="table table-bordered">
                <thead class="table-dark">
                    <tr>
                        <th>School</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>
                            <select name="school_id" class="form-select" required>
                                <option value="">Select School</option>
                                <?php while ($row = mysqli_fetch_assoc($schools_result)): ?>
                                    <option value="<?= $row['id'] ?>"><?= $row['name'] ?></option>
                                <?php endwhile; ?>
                            </select>
                        </td>
                    </tr>
                </tbody>
            </table>

            <table class="table table-bordered">
                <thead class="table-dark">
                    <tr>
                        <th>English</th>
                        <th>Hindi</th>
                        <th>French</th>
                        <th>Spanish</th>
                        <th>German</th>
                        <th>Chinese</th>
                        <th>Japanese</th>
                        <th>Arabic</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <?php
                        $fields = ['english', 'hindi', 'french', 'spanish', 'german', 'chinese', 'japanese', 'arabic'];
                        foreach ($fields as $field) {
                            echo "<td><input type='checkbox' name='{$field}' value='1'></td>";
                        }
                        ?>
                    </tr>
                </tbody>
            </table>

            <table class="table table-bordered">
                <thead class="table-dark">
                    <tr>
                        <th>Russian</th>
                        <th>Portuguese</th>
                        <th>Italian</th>
                        <th>Korean</th>
                        <th>Bengali</th>
                        <th>Urdu</th>
                        <th>Turkish</th>
                        <th>Sanskrit</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <?php
                        $fields = ['russian', 'portuguese', 'italian', 'korean', 'bengali', 'urdu', 'turkish', 'sanskrit'];
                        foreach ($fields as $field) {
                            echo "<td><input type='checkbox' name='{$field}' value='1'></td>";
                        }
                        ?>
                    </tr>
                </tbody>
            </table>

            <div class="text-center">
                <button type="submit" class="btn btn-success">Save Languages</button>
            </div>
        </form>
    </div>

    <!-- Add this before closing </body> -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
<?php include('../includes/footer.php'); ?>
</html>