<?php
include('../includes/header.php');
include('../includes/sidebar.php');
//  session_start();

// Check if admin is logged in
if (!isset($_SESSION['admin'])) {
    header("Location: ../login.php");
    exit();
}

// Include your database connection file
include('../includes/db_connect.php');

// Fetch total counts from the database
$totalUsers = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as total FROM user_log"))['total'];
$totalUniversities = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as total FROM universities"))['total'];
$totalSchools = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as total FROM schools"))['total'];
$totalCourses = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as total FROM courses"))['total'];
$totalCities = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as total FROM city"))['total'];

// Fetch latest registered users
$latestUsersResult = mysqli_query($conn, "SELECT name FROM user_log ORDER BY created_at DESC LIMIT 5");
$latestUsers = [];
while ($row = mysqli_fetch_assoc($latestUsersResult)) {
    $latestUsers[] = $row['name'] ?: 'Unknown';
}
?>

<div class="container mt-4">
    <h2 class="mb-3" style="margin-top:80px;">Admin Dashboard</h2>
    <div class="row g-4">
        <!-- Dashboard Cards -->
        <?php
        $cards = [
            ["Total Users", $totalUsers, "manage-student.php", "primary"],
            ["Total Universities", $totalUniversities, "manage-university.php", "success"],
            ["Total Schools", $totalSchools, "manage-school.php", "danger"],
            ["Total Courses", $totalCourses, "manage-course.php", "info"],
            ["Total Cities Covered", $totalCities, "manage-city.php", "warning"],
        ];
        foreach ($cards as $card) : ?>
            <div class="col-md-4">
                <div class="card bg-<?= $card[3] ?> text-white shadow">
                    <div class="card-body">
                        <h5 class="card-title"> <?= $card[0] ?> </h5>
                        <p class="fs-3"> <?= $card[1] ?> </p>
                        <a href="<?= $card[2] ?>" class="btn btn-light">View Details</a>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>

        <!-- Latest Registered Users -->
        <div class="col-md-4">
            <div class="card bg-secondary text-white shadow">
                <div class="card-body">
                    <h5 class="card-title">Latest Registered Users</h5>
                    <ul class="list-group list-group-flush">
                        <?php foreach ($latestUsers as $user) : ?>
                            <li class="list-group-item">
                                <a href="manage-student.php?search=<?= ($user === 'Unknown') ? '' : $user ?>" class="text-dark text-decoration-none"> <?= $user ?> </a>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                    <a href="manage-student.php" class="btn btn-light mt-2">View All Users</a>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include('../includes/footer.php'); ?>
