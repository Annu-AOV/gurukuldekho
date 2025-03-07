<?php
session_start();
include('includes/db_connect.php'); // Include your database connection

// Check if admin is already logged in
if (isset($_SESSION['admin'])) {
    header("Location: pages/dashboard.php");
    exit();
}

$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    if (!empty($email) && !empty($password)) {
        $query = "SELECT * FROM admin WHERE email = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();
        $admin = $result->fetch_assoc();

        if ($admin && password_verify($password, $admin['password'])) {
            $_SESSION['admin'] = $admin['id'];
            header("Location: pages/dashboard.php");
            exit();
        } else {
            $error = "Invalid Email or Password!";
        }
    } else {
        $error = "All fields are required!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            background: linear-gradient(135deg, #7f8c8d, #2c3e50);
        }
        .login-container {
            background: rgba(255, 255, 255, 0.2);
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.3);
            backdrop-filter: blur(10px);
            text-align: center;
            width: 350px;
            color: white;
        }
        .profile-img {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            margin-bottom: 10px;
        }
        .login-container h3 {
            margin-bottom: 20px;
        }
        .form-control {
            background: rgba(255, 255, 255, 0.3);
            border: none;
            padding: 10px;
            border-radius: 5px;
            color: white;
        }
        .form-control::placeholder {
            color: rgba(255, 255, 255, 0.7);
        }
        .btn-login {
            width: 100%;
            background: #3498db;
            border: none;
            padding: 10px;
            border-radius: 5px;
            color: white;
            font-size: 16px;
            cursor: pointer;
        }
        .btn-login:hover {
            background: #2980b9;
        }
        .remember-me {
            display: flex;
            align-items: center;
            margin: 10px 0;
        }
        .remember-me input {
            margin-right: 8px;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <img src="../admin/assets/uploads/glogo.png" alt="Profile" class="profile-img">
        <h3>Login</h3>
        <?php if ($error): ?>
            <div class="alert alert-danger"><?= $error ?></div>
        <?php endif; ?>
        <form action="" method="POST">
            <div class="mb-3">
                <input type="email" name="email" class="form-control" placeholder="Username" required>
            </div>
            <div class="mb-3">
                <input type="password" name="password" class="form-control" placeholder="Password" required>
            </div>
            <div class="remember-me">
                <input type="checkbox" id="remember">
                <label for="remember">Remember Me</label>
            </div>
            <button type="submit" class="btn-login">Log In</button>
        </form>
    </div>
</body>
</html>
