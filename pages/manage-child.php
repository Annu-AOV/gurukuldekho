<?php
session_start();
include('../admin/includes/db_connect.php'); // Database connection file
include('../includes/header2.php');


// Check if the user_id exists in the session
// if (isset($_SESSION['user_id'])) {
//     $user_id = $_SESSION['user_id'];
// } else {
//     // Handle the case where there is no user_id in the session
//     header("Location: home-page.php"); // Redirect to login page if not logged in
// }

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    $_SESSION['error_message'] = "Please log in to continue."; // Set error message
    header("Location: home-page.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Fetch child profiles
$sql = "SELECT * FROM add_userchild WHERE user_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $user_id); // Change "i" to "s"
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Child</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body {
            background: #f4f6f9;
        }

        .sidebar {
            width: 250px;
            height: 100vh;
            background: #fff;
            padding: 15px;
            position: fixed;
            border-right: 1px solid #ddd;
        }

        .sidebar h5 {
            margin-bottom: 20px;
            font-weight: bold;
        }

        .sidebar ul {
            padding-left: 0;
        }

        .sidebar li {
            list-style: none;
            margin: 10px 0;
        }

        .sidebar a {
            display: flex;
            align-items: center;
            text-decoration: none;
            color: #333;
            padding: 10px;
            border-radius: 5px;
            transition: 0.3s;
        }

        .sidebar a:hover,
        .sidebar .active {
            background: #007bff;
            color: #fff;
        }

        .sidebar i {
            width: 20px;
            margin-right: 10px;
        }

        .content {
            margin-left: 270px;
            padding: 20px;
        }

        .child-card {
            width: 250px;
            padding: 15px;
            border-radius: 10px;
            box-shadow: 2px 2px 10px rgba(0, 0, 0, 0.1);
            text-align: center;
            background: #fff;
            transition: 0.3s;
        }

        .child-card:hover {
            box-shadow: 4px 4px 15px rgba(0, 0, 0, 0.15);
        }

        .child-card img {
            width: 90px;
            height: 90px;
            border-radius: 50%;
            object-fit: cover;
            margin-bottom: 10px;
        }

        .btn-add {
            float: right;
            margin-bottom: 10px;
        }

        .btn-primary {
            background: #007bff;
            border: none;
            display: flex;
            align-items: center;
        }

        .btn-primary i {
            margin-right: 5px;
        }
    </style>
</head>

<body>

    <div class="d-flex">
        <!-- Sidebar -->
        <div class="sidebar">
            <h5>Profile Settings</h5>
            <ul class="list-unstyled">
                <li><a href="user-dashboard.php"><i class="fas fa-user"></i> Account</a></li>
                <li><a href="manage-child.php" class="active"><i class="fas fa-child"></i> Manage Child</a></li>
                <li><a href="#"><i class="fas fa-tasks"></i> Track Application</a></li>
                <li><a href="#"><i class="fas fa-question-circle"></i> Asked Questions</a></li>
                <li><a href="#"><i class="fas fa-users"></i> Counsellor Suggestions</a></li>
            </ul>
        </div>

        <!-- Main Content -->
        <div class="content">
            <div class="d-flex justify-content-between">
                <h3>Add/Edit Child Profiles</h3>
                <a href="add-child.php" class="btn btn-primary btn-add"><i class="fas fa-plus"></i> Add New Child</a>
            </div>
            <hr>

            <div class="d-flex flex-wrap gap-3">
                <?php
                // Check if there are any child profiles
                if ($result->num_rows > 0): ?>
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <?php
            // Set avatar based on gender
            if ($row['gender'] == 'Male') {
                $avatar = "../admin/uploads/homepage_images/boy.webp"; // Replace with actual boy avatar image
            } elseif ($row['gender'] == 'Female') {
                $avatar = "../admin/uploads/homepage_images/girl.webp"; // Replace with actual girl avatar image
            } else {
                $avatar = "default-avatar.png"; // Default avatar for 'Other' or missing gender
            }
            ?>
                        <div class="child-card">
                        <img src="<?= $avatar ?>" alt="Child Avatar">
                            <h5><?= htmlspecialchars($row['child_name']) ?></h5>
                            <p>
                                <?= (date_diff(date_create($row['date_of_birth']), date_create('today'))->format('%y years, %m months, %d days')) ?>
                                old
                                <?= ($row['gender'] == 'Male' ? 'son' : ($row['gender'] == 'Female' ? 'daughter' : 'child')) ?>
                            </p>
                            <a href="edit-child.php?id=<?= $row['id'] ?>" class="btn btn-outline-primary btn-sm">Update
                                Profile</a>
                        </div>
                    <?php endwhile; ?>
                <?php else: ?>
                    <p>No child found</p>
                <?php endif; ?>
            </div>
        </div>
    </div>

</body>

</html>
<?php
ob_end_flush(); // Output buffering flush
?>