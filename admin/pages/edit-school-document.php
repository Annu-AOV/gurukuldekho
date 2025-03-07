<?php
// Include database connection
include('../includes/header.php');
include('../includes/sidebar.php');
include('../includes/db_connect.php');

// Get the document ID from URL
if (!isset($_GET['id']) || empty($_GET['id'])) {
    echo "<script>alert('Invalid Request!'); window.location.href='manage-school-documents.php';</script>";
    exit;
}

$id = intval($_GET['id']);

// Fetch document details
$query = "SELECT * FROM school_documents WHERE id = $id";
$result = mysqli_query($conn, $query);

if (!$result || mysqli_num_rows($result) == 0) {
    echo "<script>alert('Record not found!'); window.location.href='manage-school-documents.php';</script>";
    exit;
}

$row = mysqli_fetch_assoc($result);

// Fetch school data
$schools_query = "SELECT id, name FROM schools";
$schools_result = mysqli_query($conn, $schools_query);

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    foreach ($_POST as $key => $value) {
        $_POST[$key] = ($value == '1') ? 1 : 0;
    }

    $update_query = "UPDATE school_documents SET ";
    foreach ($row as $key => $value) {
        if ($key !== 'id' && $key !== 'school_id') {
            $update_query .= "$key = '{$_POST[$key]}', ";
        }
    }
    $update_query = rtrim($update_query, ', ') . " WHERE id = $id";

    if (mysqli_query($conn, $update_query)) {
        echo "<script>alert('Updated Successfully!'); window.location.href='manage-school-document.php';</script>";
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
    <title>Edit School Document</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css">
</head>
<body>
<div class="container my-5">
    <h2 class="text-center mb-4">Edit School Document</h2>
    <form action="" method="POST">
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
                        <select name="school_id" class="form-select" disabled>
                            <?php
                            while ($school = mysqli_fetch_assoc($schools_result)) {
                                $selected = ($school['id'] == $row['school_id']) ? 'selected' : '';
                                echo "<option value='{$school['id']}' $selected>{$school['name']}</option>";
                            }
                            ?>
                        </select>
                    </td>

                    <!-- Document Checkboxes -->
                    <?php
                    $fields = [
                        'address_proof', 'birth_certificate', 'medical_certificate', 'photo', 'caste_certificate',
                        'family_photo', 'last_school_details', 'parent_guardian_photo', 'religion_proof', 'report_card',
                        'differently_abled_proof', 'sibling_alumni_proof', 'first_girl_child', 'aadhaar_card'
                    ];
                    foreach ($fields as $field) {
                        $checked = ($row[$field] == 1) ? "checked" : "";
                        echo "<td><input type='checkbox' name='{$field}' value='1' $checked></td>";
                    }
                    ?>
                </tr>
            </tbody>
        </table>

        <!-- Submit Button -->
        <div class="text-center">
            <button type="submit" class="btn btn-primary">Update</button>
            <a href="manage-school-documents.php" class="btn btn-secondary">Cancel</a>
        </div>
    </form>
</div>
</body>
</html>
