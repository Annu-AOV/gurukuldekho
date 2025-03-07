<?php
// Include database connection
include('../includes/header.php');
include('../includes/sidebar.php');
include('../includes/db_connect.php');

$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($id == 0) {
    echo "<script>alert('Invalid ID!'); window.location.href='manage-school-language.php';</script>";
    exit();
}

// Fetch existing data
$query = "SELECT * FROM school_language WHERE id = $id";
$result = mysqli_query($conn, $query);
$row = mysqli_fetch_assoc($result);

if (!$row) {
    echo "<script>alert('Record not found!'); window.location.href='manage-school-language.php';</script>";
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    foreach ($_POST as $key => $value) {
        $_POST[$key] = ($value == '1') ? 1 : 0;
    }

    $update_query = "UPDATE school_language SET ";
    foreach ($row as $key => $value) {
        if ($key !== 'id' && $key !== 'school_id') {
            $update_query .= "$key = '{$_POST[$key]}', ";
        }
    }
    $update_query = rtrim($update_query, ', ') . " WHERE id = $id";

    if (mysqli_query($conn, $update_query)) {
        echo "<script>alert('Updated Successfully!'); window.location.href='manage-school-lang.php';</script>";
    } else {
        echo "Error updating record: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit School Language</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css">
</head>
<body>
<div class="container my-5">
    <h2 class="text-center mb-4">Edit School Language</h2>
    
    <form method="POST">
        <table class="table table-bordered">
            <thead class="table-dark">
                <tr>
                    <th>School</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>
                        <?php
                        // Fetch school name
                        $school_query = "SELECT name FROM schools WHERE id = {$row['school_id']}";
                        $school_result = mysqli_query($conn, $school_query);
                        $school = mysqli_fetch_assoc($school_result);
                        echo "<input type='text' class='form-control' value='{$school['name']}' readonly>";
                        ?>
                    </td>
                </tr>
            </tbody>
        </table>

        <table class="table table-bordered">
            <thead class="table-dark">
                <tr>
                    <th>English</th><th>Hindi</th><th>French</th><th>Spanish</th>
                    <th>German</th><th>Chinese</th><th>Japanese</th><th>Arabic</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <?php
                    $fields = ['english', 'hindi', 'french', 'spanish', 'german', 'chinese', 'japanese', 'arabic'];
                    foreach ($fields as $field) {
                        $checked = $row[$field] == 1 ? "checked" : "";
                        echo "<td><input type='checkbox' name='{$field}' value='1' $checked></td>";
                    }
                    ?>
                </tr>
            </tbody>
        </table>

        <table class="table table-bordered">
            <thead class="table-dark">
                <tr>
                    <th>Russian</th><th>Portuguese</th><th>Italian</th><th>Korean</th>
                    <th>Bengali</th><th>Urdu</th><th>Turkish</th><th>Sanskrit</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <?php
                    $fields = ['russian', 'portuguese', 'italian', 'korean', 'bengali', 'urdu', 'turkish', 'sanskrit'];
                    foreach ($fields as $field) {
                        $checked = $row[$field] == 1 ? "checked" : "";
                        echo "<td><input type='checkbox' name='{$field}' value='1' $checked></td>";
                    }
                    ?>
                </tr>
            </tbody>
        </table>

        <div class="text-center">
            <button type="submit" class="btn btn-primary">Update Languages</button>
            <a href="manage-school-lang.php" class="btn btn-secondary">Cancel</a>
        </div>
    </form>
</div>
</body>
<?php include('../includes/footer.php'); ?>
</html>
