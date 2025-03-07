<?php
session_start();
include('../admin/includes/db_connect.php'); // Database connection file

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: home-page.php"); // Redirect to login if not logged in
    exit();
}

$user_id = $_SESSION['user_id'];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $child_name = $_POST['child_name'];
    $date_of_birth = $_POST['date_of_birth'];
    $gender = $_POST['gender'];
    $applying_for = $_POST['applying_for'];
    $class_applying_for = $_POST['class_applying_for'];

    $children = [];
    while ($row = $result->fetch_assoc()) {
        $children[] = $row;
    }
    $stmt->close();

    $sql = "INSERT INTO add_userchild (user_id, child_name, date_of_birth, gender, applying_for, class_applying_for) 
            VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssss", $user_id, $child_name, $date_of_birth, $gender, $applying_for, $class_applying_for);

    if ($stmt->execute()) {
        header("Location: manage-child.php?success=Child added successfully");
        exit();
    } else {
        $error = "Error adding child. Please try again.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Child</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>

<body>

    <div class="modal" id="addChildModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Make Applicant's Profile</h5>
                    <!-- <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button> -->
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                        onclick="redirectToManageChild()"></button>

                </div>
                <div class="modal-body">
                    <?php if (isset($error))
                        echo "<div class='alert alert-danger'>$error</div>"; ?>
                    <form method="POST" action="">
                        <div class="mb-3">
                            <label class="form-label">Applicant's Full Name</label>
                            <input type="text" name="child_name" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Applicant's Date of Birth</label>
                            <input type="date" name="date_of_birth" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Gender</label><br>
                            <input type="radio" name="gender" value="Male" required> Male
                            <input type="radio" name="gender" value="Female" required> Female
                            <input type="radio" name="gender" value="Other" required> Other
                        </div>
                        <div class="mb-3">
                            <label class="form-label">You are applying for</label><br>
                            <input type="radio" name="applying_for" value="Delhi" required> Delhi
                            <input type="radio" name="applying_for" value="Any Other City" required> Any Other City
                        </div>
                        <!-- <div class="mb-3">
                        <label class="form-label">Class Applying For</label>
                        <select name="class_applying_for" class="form-control" required>
                            <option value="">-- Select Grade --</option>
                            <option value="Nursery">Nursery</option>
                            <option value="KG">KG</option>
                            <option value="1">Class 1</option>
                            <option value="2">Class 2</option>
                            <option value="3">Class 3</option>
                        </select>
                    </div> -->

                        <div class="form-group">
                            <label>Class Applying For</label>
                            <select name="class_applying_for" class="form-control" required>
                                <option value="">-- Select Grade --</option>
                                <option value="Toddler">Toddler</option>
                                <option value="Nursery">Nursery</option>
                                <option value="LKG">LKG</option>
                                <option value="UKG">UKG</option>
                                <?php
                                for ($i = 1; $i <= 12; $i++) {
                                    $class = "Class $i";
                                    echo "<option value='$class'>$class</option>";
                                }
                                ?>
                            </select>
                        </div>

                        <div class="modal-footer">
                            <!-- <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button> -->
                            <button type="button" class="btn btn-secondary"
                                onclick="redirectToManageChild()">Cancel</button>

                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- <script>
        document.addEventListener('DOMContentLoaded', function () {
            var myModal = new bootstrap.Modal(document.getElementById('addChildModal'));
            myModal.show();
        });
    </script> -->

    <script>
        function redirectToManageChild() {
            window.location.href = "manage-child.php";
        }

        // document.addEventListener('DOMContentLoaded', function () {
        //     var urlParams = new URLSearchParams(window.location.search);
        //     if (urlParams.has('add_child')) {
        //         var myModal = new bootstrap.Modal(document.getElementById('addChildModal'));
        //         myModal.show();
        //     }
        // });

        document.addEventListener('DOMContentLoaded', function () {
            var myModal = new bootstrap.Modal(document.getElementById('addChildModal'));
            myModal.show();
        });
    </script>
</body>

</html>