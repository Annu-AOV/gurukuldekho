<?php
session_start();
include '../admin/includes/db_connect.php'; // Database connection file

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: home-page.php");
    exit();
}

$user_phone = $_SESSION['user_id']; // Phone number as user ID
$message = "";

// Fetch user details from user_log table
$sql = "SELECT * FROM user_log WHERE phone = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $user_phone);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

// Ensure $user is not null
$name = $user['name'] ?? '';
$email = $user['email'] ?? 'N/A';
$phone = $user['phone'] ?? '';
$city = $user['city'] ?? '';
$state = $user['state'] ?? '';
$neighbourhood = $user['neighbourhood'] ?? '';
$pincode = $user['pincode'] ?? '';
$school_type = $user['school_type'] ?? '';
$monthly_budget = $user['monthly_budget'] ?? '';
$area = $user['area'] ?? '';

// Handle form submission for personal details
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['name'])) {
    $name = $_POST['name'];
    $city = $_POST['city'];
    $state = $_POST['state'];
    $neighbourhood = $_POST['neighbourhood'];
    $pincode = $_POST['pincode'];

    $update_sql = "UPDATE user_log SET name=?, city=?, state=?, neighbourhood=?, pincode=? WHERE phone=?";
    $stmt = $conn->prepare($update_sql);
    $stmt->bind_param("ssssss", $name, $city, $state, $neighbourhood, $pincode, $user_phone);

    if ($stmt->execute()) {
        $message = "<div class='alert alert-success'>Profile updated successfully.</div>";
        header("Refresh:1");
    } else {
        $message = "<div class='alert alert-danger'>Error updating profile.</div>";
    }
}

// Handle form submission for preferences
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['school_type'])) {
    $school_type = $_POST['school_type'];
    $monthly_budget = $_POST['monthly_budget'];

    $update_sql = "UPDATE user_log SET school_type=?, monthly_budget=? WHERE phone=?";
    $stmt = $conn->prepare($update_sql);
    $stmt->bind_param("sss", $school_type, $monthly_budget, $user_phone);

    if ($stmt->execute()) {
        $message = "<div class='alert alert-success'>Preferences updated successfully.</div>";
        header("Refresh:1");
    } else {
        $message = "<div class='alert alert-danger'>Error updating preferences.</div>";
    }
}
?>

<?php include '../includes/header2.php'; ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">


    <style>
        .sidebar {
            height: 100vh;
            overflow-y: auto;
            scrollbar-width: thin;
            scrollbar-color: #ccc #f8f9fa;
            border-radius: 10px;
        }

        .sidebar::-webkit-scrollbar {
            width: 5px;
        }

        .sidebar::-webkit-scrollbar-thumb {
            background-color: #ccc;
            border-radius: 5px;
        }

        .sidebar::-webkit-scrollbar-track {
            background: #f8f9fa;
        }

        .sidebar h4 {
            font-size: 16px;
            font-weight: 600;
            padding-bottom: 10px;
            border-bottom: 1px solid #ddd;
        }

        .nav-item {
            display: flex;
            align-items: center;
            padding: 10px 5px;
            border-radius: 5px;
            transition: background 0.3s;
        }

        .nav-item a {
            color: #333;
            text-decoration: none;
            font-size: 14px;
            font-weight: 500;
            display: flex;
            align-items: center;
            gap: 10px;
            width: 100%;
        }

        .nav-item:hover {
            background: #f0f0f0;
        }

        .nav-item i {
            font-size: 16px;
            color: #3171f4;
        }
    </style>
</head>

<body>
    <div class="container-fluid">
        <div class="row">
            <nav class="col-md-3 col-lg-2 d-md-block bg-white shadow-lg sidebar p-4">
                <h4 class="text-primary"><i class="fas fa-user-cog"></i> Profile Settings</h4>
                <ul class="nav flex-column">
                    <li class="nav-item"><a class="nav-link" href="#"><i class="fas fa-tasks"></i> Track Application</a>
                    </li>
                    <li class="nav-item"><a class="nav-link" href="#"><i class="fas fa-question-circle"></i> Asked
                            Questions</a></li>
                    <li class="nav-item"><a class="nav-link" href="#"><i class="fas fa-user-tie"></i> Counsellor
                            Suggestions</a></li>
                    <li class="nav-item"><a class="nav-link" href="#"><i class="fas fa-map-marker-alt"></i> Delhi
                            Recommendations</a></li>
                    <li class="nav-item"><a class="nav-link" href="#"><i class="fas fa-calculator"></i> Points
                            Calculator</a></li>
                    <li class="nav-item"><a class="nav-link" href="#"><i class="fas fa-lock"></i> Admission
                            Predictor</a></li>
                    <li class="nav-item"><a class="nav-link" href="#"><i class="fas fa-child"></i> Age Criteria</a></li>
                    <li class="nav-item"><a class="nav-link" href="#"><i class="fas fa-comments"></i> Expert Talk</a>
                    </li>
                    <li class="nav-item"><a class="nav-link" href="#"><i class="fas fa-shopping-cart"></i> Purchase
                            History</a></li>
                </ul>
            </nav>

            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 bg-white shadow-lg rounded-lg">
                <div class="container mt-4">
                    <?= $message; ?>
                    <div class="card p-3 mb-4">
                        <h5 class="card-title">TELL US ABOUT YOURSELF</h5>
                        <form method="POST">
                            <div class="row mb-3">
                                <div class="col-md-4">
                                    <label class="form-label">Name</label>
                                    <input type="text" class="form-control" name="name"
                                        value="<?= htmlspecialchars($name) ?>">
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">Email</label>
                                    <input type="email" class="form-control" value="<?= htmlspecialchars($email) ?>"
                                        disabled>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">Mobile Number</label>
                                    <input type="text" class="form-control" name="phone"
                                        value="<?= htmlspecialchars($phone) ?>">
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-4">
                                    <label class="form-label">Your Pincode</label>
                                    <input type="text" class="form-control" name="pincode"
                                        value="<?= htmlspecialchars($pincode) ?>">
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">Your City</label>
                                    <input type="text" class="form-control" name="city"
                                        value="<?= htmlspecialchars($city) ?>">
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">Your State</label>
                                    <input type="text" class="form-control" name="state"
                                        value="<?= htmlspecialchars($state) ?>">
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary">Save Changes</button>
                        </form>
                    </div>

                    <div class="card p-4 bg-white shadow-lg">
                        <h5 class="card-title">TELL US ABOUT YOUR PREFERENCES</h5>
                        <form method="POST">
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label class="form-label">School Type</label>
                                    <select class="form-select" name="school_type">
                                        <option value="Day" <?= ($school_type == 'Day') ? 'selected' : '' ?>>Day Schools
                                        </option>
                                        <option value="Boarding" <?= ($school_type == 'Boarding') ? 'selected' : '' ?>>
                                            Boarding Schools</option>
                                        <option value="Online" <?= ($school_type == 'Online') ? 'selected' : '' ?>>Online
                                            Schools</option>
                                    </select>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">Monthly Budget</label>
                                    <select class="form-control" name="monthly_budget">
                                        <option value="" disabled selected>--- Select Monthly Budget ---</option>
                                        <option value="5000" <?= ($monthly_budget == '5000') ? 'selected' : '' ?>>Below
                                            ₹5,000</option>
                                        <option value="10000" <?= ($monthly_budget == '10000') ? 'selected' : '' ?>>₹5,000
                                            - ₹10,000</option>
                                        <option value="20000" <?= ($monthly_budget == '20000') ? 'selected' : '' ?>>₹10,000
                                            - ₹20,000</option>
                                        <option value="50000" <?= ($monthly_budget == '50000') ? 'selected' : '' ?>>₹20,000
                                            - ₹50,000</option>
                                        <option value="50000+" <?= ($monthly_budget == '50000+') ? 'selected' : '' ?>>Above
                                            ₹50,000</option>
                                    </select>
                                </div>

                            </div>
                            <button type="submit" class="btn btn-primary">Save Changes</button>
                        </form>
                    </div>

                </div>
            </main>
        </div>
    </div>
</body>
<?php include '../includes/footer.php'; ?>

</html>