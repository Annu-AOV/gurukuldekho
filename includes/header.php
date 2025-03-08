<?php
session_start();
include 'admin/includes/db_connect.php';

$api_key = "Aqy3EgvTuuvAFAQzAYsS5kNFbzcd8Qv0NLWZfwXOKXkiMLQbX4DfrJM8jJcv";

// Check if user has a valid remember token
if (!isset($_SESSION['user_id']) && isset($_COOKIE['remember_token'])) {
    $remember_token = $_COOKIE['remember_token'];
    $stmt = $conn->prepare("SELECT * FROM user_log WHERE remember_token = ? LIMIT 1");
    $stmt->bind_param("s", $remember_token);
    $stmt->execute();
    $result = $stmt->get_result();
  

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        $_SESSION['user_id'] = $user['phone']; // Auto-login user
    }
    $stmt->close();
}

// Handling OTP Sending
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['send_otp'])) {
        $phone = $_POST['phone'];
        $otp = rand(100000, 999999);
        
        setcookie('otp', $otp, time() + 300, "/"); // 5 minutes expiry
        setcookie('phone', $phone, time() + 300, "/");

        $api_url = "https://www.fast2sms.com/dev/bulkV2?authorization=$api_key&route=otp&variables_values=$otp&flash=0&numbers=$phone";
        $ch = curl_init($api_url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_exec($ch);
        curl_close($ch);

        echo json_encode(["status" => "success", "message" => "OTP sent successfully"]);
        exit;
    }

    // OTP Verification and Login Handling
    if (isset($_POST['verify_otp'])) {
        $entered_otp = $_POST['otp'];
        $stored_otp = $_COOKIE['otp'] ?? '';
        $stored_phone = $_COOKIE['phone'] ?? '';

        if (!$stored_otp) {
            echo json_encode(["status" => "error", "message" => "OTP expired. Please request again."]);
            exit;
        } elseif ($entered_otp == $stored_otp) {
            // Remove OTP cookies
            setcookie("otp", "", time() - 3600, "/");
            setcookie("phone", "", time() - 3600, "/");

            // Check if the phone number exists in the database
            $stmt = $conn->prepare("SELECT * FROM user_log WHERE phone = ? LIMIT 1");
            $stmt->bind_param("s", $stored_phone);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                $user = $result->fetch_assoc();
            } else {
                // If user does not exist, create a new entry
                $stmt = $conn->prepare("INSERT INTO user_log (phone, status) VALUES (?, 'Active')");
                $stmt->bind_param("s", $stored_phone);
                $stmt->execute();
                $stmt->close();

                $stmt = $conn->prepare("SELECT * FROM user_log WHERE phone = ? LIMIT 1");
                $stmt->bind_param("s", $stored_phone);
                $stmt->execute();
                $result = $stmt->get_result();
                $user = $result->fetch_assoc();
            }
            $stmt->close();

            // Generate a random remember token
            $remember_token = bin2hex(random_bytes(32));
            $stmt = $conn->prepare("UPDATE user_log SET remember_token = ? WHERE phone = ?");
            $stmt->bind_param("ss", $remember_token, $stored_phone);
            $stmt->execute();
            $stmt->close();


            // Set session and persistent cookie
            $_SESSION['user_id'] = $user['phone'];
           
            setcookie("remember_token", $remember_token, time() + (90 * 24 * 60 * 60), "/"); // 30 days expiry

            echo json_encode(["status" => "success", "message" => "OTP verified successfully"]);
            exit;
        } else {
            echo json_encode(["status" => "error", "message" => "Invalid OTP. Please try again."]);
            exit;
        }
    }
}
?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GuruKul Dekho</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        /* Header Styling */
        .header-container {
            position: fixed;
            top: 0;
            width: 100%;
            background-color: #f8f9fa;
            z-index: 1030;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            padding: 10px 20px;
        }

        .rounded-border {
            border: 2px solid #ddd;
            border-radius: 50%;
            padding: 8px;
        }

        .bi-person::before {
            margin-right: 20px;
        }

        /* .location{
            position: absolute;
        } */

        .form-select {
            width: 100px;
        }


        .navbar-container {
            margin-top: 80px;
            background-color: #ffffff;
            padding: 0 1rem;
            font-weight: 600;
            font-size: 1.1rem;
            font-family: 'Poppins', sans-serif;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .nav-link {
            color: #333;
            text-decoration: none;
            padding: 5px 15px;
            transition: color 0.3s ease;
        }

        .nav-link:hover {
            color: black;
        }

        /* Mobile Toggle Menu */
        .mobile-menu {
            position: fixed;
            top: 0;
            left: -100%;
            height: 100%;
            width: 250px;
            background-color: #f8f9fa;
            box-shadow: 2px 0 5px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease-in-out;
            z-index: 1040;
        }

        .mobile-menu.active {
            left: 0;
        }

        .mobile-menu .menu-header {
            padding: 15px;
            font-weight: bold;
            border-bottom: 1px solid #ddd;
        }

        .mobile-menu .menu-item {
            padding: 10px 15px;
            border-bottom: 1px solid #ddd;
        }

        @media (max-width: 768px) {
            .desktop-menu {
                display: none;
            }

            .toggle-icon {
                display: inline-block;
            }
        }

        @media (min-width: 769px) {
            .toggle-icon {
                display: none;
            }
        }
    </style>


    <style>
        /* Dropdown Menu */
        .custom-dropdown {
            display: none;
            position: absolute;
            top: 60px;
            right: 20px;
            background: white;
            border-radius: 10px;
            box-shadow: 0px 5px 15px rgba(0, 0, 0, 0.2);
            min-width: 230px;
            z-index: 1000;
        }

        /* Dropdown Items */
        .custom-dropdown a {
            display: block;
            padding: 10px 15px;
            font-size: 14px;
            text-decoration: none;
            color: black;
            transition: 0.3s;
        }

        .custom-dropdown a:hover {
            background: #f0f0f0;
        }

        /* Active Selection */
        .custom-dropdown a.active {
            background: #0099ff;
            color: white;
        }

        /* Logout Button */
        .logout-btn {
            display: block;
            width: 90%;
            margin: 10px auto;
            padding: 10px;
            border: 1px solid #007bff;
            background: white;
            color: #007bff;
            text-align: center;
            border-radius: 8px;
            transition: 0.3s;
        }

        .logout-btn:hover {
            background: #007bff;
            color: white;
        }

        /* Toggle Icon */
        .fs-5 {
            font-size: 24px;
            cursor: pointer;
        }

        /* Submenu Styling */
        .submenu {
            display: none;
            background: #e0e0e0;
            border-radius: 5px;
            margin: 0;
            padding: 0;
            list-style: none;
        }

        .submenu a {
            padding: 8px 15px;
            display: block;
            font-size: 13px;
            color: black;
        }

        .submenu a:hover {
            background: #d0d0d0;
        }

        /* Arrow Icon */
        .arrow {
            float: right;
            transition: transform 0.3s ease;
        }

        .rotate {
            transform: rotate(180deg);
        }
    </style>



    <style>
        /* Modal Styles */
        .modal {
            display: none;
            position: fixed;
            z-index: 1000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            justify-content: center;
            align-items: center;
        }

        .modal-content {
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            width: 400px;
            text-align: center;
            position: relative;
        }

        .close-btn {
            position: absolute;
            top: 10px;
            right: 15px;
            cursor: pointer;
            font-size: 20px;
            color: red;
        }

        button {
            padding: 10px 20px;
            margin: 10px;
            border: none;
            cursor: pointer;
        }

        .btn-primary {
            background: blue;
            color: white;
        }

        .btn-success {
            background: green;
            color: white;
        }

        .hidden {
            display: none;
        }
    </style>
</head>

<body>
    <?php

    // Fetch city data
    $cityQuery = "SELECT id, city_name FROM city";
    $result = $conn->query($cityQuery);
    ?>

    <!-- Header -->
    <div class="container-fluid header-container">
        <div class="row align-items-center">
            <!-- Mobile Toggle Icon -->
            <div class="col-2 d-md-none">
                <i class="bi bi-list fs-4 toggle-icon" onclick="toggleMenu()"></i>
            </div>

            <!-- Logo and City Search -->
            <div class="col-md-3 col-3 d-flex align-items-center">
                <img src="../admin/uploads/school_photos/logo.jpg" alt="Logo" class="me-2"
                    style="width: 50px; height: 50px;">
                <select class="form-select" id="citySelect" onchange="setCityCookie()">
                    <option value="">Select City</option>
                    <?php
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo "<option value='" . $row['id'] . "'>" . $row['city_name'] . $row['statea'] . "</option>";
                        }
                    }
                    ?>
                </select>
            </div>

            <!-- Second Column: Search Bar -->
            <div class="col-6"></div>

            <!-- Bag, Profile -->
            <div class="col-md-3 d-none d-md-flex justify-content-end align-items-center">
                <div class="rounded-border bg-white me-3">
                    <i class="bi bi-bag fs-5"></i>
                </div>


                <?php if (isset($_SESSION['user_id'])) { ?>
                    <!-- User Dashboard Link (Shown when user is logged in) -->
                    <a href="../pages/user-dashboard.php">
                        <i class="bi bi-person fs-5"></i>
                    </a>
                <?php } else { ?>
                    <!-- Sign In Button (Shown when user is not logged in) -->
                    <button id="openModalBtn" class="btn-primary">Sign In</button>
                <?php } ?>



                <!-- Modal Structure -->
                <div id="loginModal" class="modal">
                    <div class="modal-content" style="width:50%;">
                        <div class="modal-body p-0">
                            <div class="d-flex">

                                <!-- Left Panel Content -->
                                <div class="col-lg-5 left-panel d-flex flex-column justify-content-center left-side-image"
                                    style="background-image: url(../auth/imagebg.svg);">

                                    <div class="mb-5 d-flex">
                                        <span class=""> </span>
                                        <p class="mb-0">Discover, compare, shortlist your preferred schools, and much
                                            more.</p>
                                    </div>
                                    <div class="mb-5 d-flex">
                                        <span class=""></span>
                                        <p class="mb-0">Apply to multiple schools using a common application form.</p>
                                    </div>
                                    <div class="mb-5 d-flex">
                                        <span class=""></span>
                                        <p class="mb-0">Stay up to date with admissions, fee structures, facilities, and
                                            more.
                                        </p>
                                    </div>
                                    <div class="mb-5 d-flex">
                                        <span class=""></span>
                                        <p class="mb-0">Lakhs of parents trust us for our industry-leading free
                                            counseling
                                            services.</p>
                                    </div>
                                </div>

                                <!-- Right Panel Content (Login Form) -->
                                <div class="col-lg-7 d-flex align-items-center justify-content-center">
                                    <!-- Close Button positioned at top-right -->
                                    <button type="button" class="close-btn position-absolute top-0 end-0 m-3"
                                        data-bs-dismiss="modal" aria-label="Close"> <span
                                            class="close-btn">&times;</span></button>

                                    <div class=" p-4 " style="width: 400px;">

                                        <h4 class="text-center">Login to continue</h4>

                                        <div id="mobile-login">
                                            <form method="POST">
                                                <div class="my-3 gap-2 d-flex">
                                                    <input type="text" class="form-control" id="phone" name="phone"
                                                        placeholder="Enter Phone Number" required>
                                                </div>
                                                <button type="button" id="sendOtpBtn" class="btn btn-primary mt-2">Send
                                                    OTP</button>

                                                <div id="otpSection" class="my-3" style="display: none;">
                                                    <label for="otp" class="form-label">Enter the OTP you received on
                                                        your
                                                        mobile phone:</label>
                                                    <div class="d-flex gap-2">
                                                        <input type="text" class="form-control" id="otp"
                                                            aria-describedby="otpHelp" placeholder="Enter OTP">
                                                        <button type="button" id="verifyOtpBtn"
                                                            class="btn btn-success">Verify
                                                            OTP</button>
                                                    </div>
                                                </div>

                                                <div id="nameSection" class="my-3 hidden" style="">
                                                    <label for="name" class="form-label">Enter Your Name</label>
                                                    <div class="d-flex gap-2">
                                                        <input type="text" class="form-control" id="name"
                                                            name="user_name" placeholder="enter your name">
                                                    </div>
                                                </div>

                                                <button type="submit" id="loginUser" name="submit_user"
                                                    class="mt-3 btn btn-success w-100" disabled>Login</button>
                                            </form>

                                            <div class="line-with-text">
                                                <span>OR</span>
                                            </div>

                                            <div onclick="showGoogleLogin()"
                                                class="d-flex justify-content-center gap-3 p-3 align-items-center"
                                                style="box-shadow: rgba(149, 157, 165, 0.2) 0px 8px 24px;">
                                                <div>
                                                    <svg version="1.1" xmlns="http://www.w3.org/2000/svg" width="18px"
                                                        height="18px" viewBox="0 0 48 48" class="abcRioButtonSvg">
                                                        <g>
                                                            <path fill="#EA4335"
                                                                d="M24 9.5c3.54 0 6.71 1.22 9.21 3.6l6.85-6.85C35.9 2.38 30.47 0 24 0 14.62 0 6.51 5.38 2.56 13.22l7.98 6.19C12.43 13.72 17.74 9.5 24 9.5z">
                                                            </path>
                                                            <path fill="#4285F4"
                                                                d="M46.98 24.55c0-1.57-.15-3.09-.38-4.55H24v9.02h12.94c-.58 2.96-2.26 5.48-4.78 7.18l7.73 6c4.51-4.18 7.09-10.36 7.09-17.65z">
                                                            </path>
                                                            <path fill="#FBBC05"
                                                                d="M10.53 28.59c-.48-1.45-.76-2.99-.76-4.59s.27-3.14.76-4.59l-7.98-6.19C.92 16.46 0 20.12 0 24c0 3.88.92 7.54 2.56 10.78l7.97-6.19z">
                                                            </path>
                                                            <path fill="#34A853"
                                                                d="M24 48c6.48 0 11.93-2.13 15.89-5.81l-7.73-6c-2.15 1.45-4.92 2.3-8.16 2.3-6.26 0-11.57-4.22-13.47-9.91l-7.98 6.19C6.51 42.62 14.62 48 24 48z">
                                                            </path>
                                                            <path fill="none" d="M0 0h48v48H0z"></path>
                                                        </g>

                                                    </svg>
                                                </div>
                                                <div>Login with google</div>
                                            </div>
                                        </div>

                                        <div id="google-login" style="display:none;">
                                            <p>Google login configuration</p>

                                            <div class="line-with-text">
                                                <span>OR</span>
                                            </div>

                                            <div onclick="showMobileLogin()"
                                                class="d-flex justify-content-center gap-3 p-3 align-items-center"
                                                style="box-shadow: rgba(149, 157, 165, 0.2) 0px 8px 24px;">
                                                <div>
                                                    <svg version="1.1" xmlns="http://www.w3.org/2000/svg" width="18px"
                                                        height="18px" viewBox="0 0 48 48" class="abcRioButtonSvg">
                                                        <g>
                                                            <path fill="#EA4335"
                                                                d="M24 9.5c3.54 0 6.71 1.22 9.21 3.6l6.85-6.85C35.9 2.38 30.47 0 24 0 14.62 0 6.51 5.38 2.56 13.22l7.98 6.19C12.43 13.72 17.74 9.5 24 9.5z">
                                                            </path>
                                                            <path fill="#4285F4"
                                                                d="M46.98 24.55c0-1.57-.15-3.09-.38-4.55H24v9.02h12.94c-.58 2.96-2.26 5.48-4.78 7.18l7.73 6c4.51-4.18 7.09-10.36 7.09-17.65z">
                                                            </path>
                                                            <path fill="#FBBC05"
                                                                d="M10.53 28.59c-.48-1.45-.76-2.99-.76-4.59s.27-3.14.76-4.59l-7.98-6.19C.92 16.46 0 20.12 0 24c0 3.88.92 7.54 2.56 10.78l7.97-6.19z">
                                                            </path>
                                                            <path fill="#34A853"
                                                                d="M24 48c6.48 0 11.93-2.13 15.89-5.81l-7.73-6c-2.15 1.45-4.92 2.3-8.16 2.3-6.26 0-11.57-4.22-13.47-9.91l-7.98 6.19C6.51 42.62 14.62 48 24 48z">
                                                            </path>
                                                            <path fill="none" d="M0 0h48v48H0z"></path>
                                                        </g>

                                                    </svg>
                                                </div>
                                                <div>Login with Mobile Number</div>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


                <!-- login script -->
                <script>
                    document.addEventListener("DOMContentLoaded", function () {
                        let modal = document.getElementById("loginModal");
                        let openModalBtn = document.getElementById("openModalBtn");
                        let closeModalBtn = document.querySelector(".close-btn");

                        openModalBtn.addEventListener("click", function () {
                            modal.style.display = "flex";
                        });

                        closeModalBtn.addEventListener("click", function () {
                            modal.style.display = "none";
                        });

                        window.addEventListener("click", function (event) {
                            if (event.target === modal) {
                                modal.style.display = "none";
                            }
                        });

                        document.getElementById("sendOtpBtn").addEventListener("click", function () {
                            let phone = document.getElementById("phone").value;
                            if (phone.length == 10) {
                                fetch("login-users.php", {
                                    method: "POST",
                                    headers: { "Content-Type": "application/x-www-form-urlencoded" },
                                    body: "send_otp=true&phone=" + phone
                                })
                                    .then(response => response.json())
                                    .then(data => {
                                        alert(data.message);
                                        if (data.status === "success") {
                                            document.getElementById("otpSection").classList.remove("hidden");
                                            // document.getElementById("nameSection").classList.remove("hidden");
                                        }
                                    });
                            } else {
                                alert("Enter a valid 10-digit phone number.");
                            }
                        });

                        document.getElementById("verifyOtpBtn").addEventListener("click", function () {
                            let otp = document.getElementById("otp").value;
                            if (otp.length == 6) {
                                fetch("login-users.php", {
                                    method: "POST",
                                    headers: { "Content-Type": "application/x-www-form-urlencoded" },
                                    body: "verify_otp=true&otp=" + otp
                                })
                                    .then(response => response.json())
                                    .then(data => {
                                        alert(data.message);
                                        if (data.status === "success") {
                                            window.location.href = "../pages/home-page.php";
                                        }
                                    });
                            } else {
                                alert("Enter a valid 6-digit OTP.");
                            }
                        });
                    });
                </script>

                <!-- also login script -->
                <script>
                    document.addEventListener("DOMContentLoaded", function () {
                        document.getElementById("sendOtpBtn").addEventListener("click", function () {
                            let phone = document.getElementById("phone").value;
                            if (phone.length === 10) {
                                fetch("", {
                                    method: "POST",
                                    headers: { "Content-Type": "application/x-www-form-urlencoded" },
                                    body: new URLSearchParams({ send_otp: true, phone: phone })
                                })
                                    .then(response => response.json())
                                    .then(res => {
                                        alert(res.message);
                                        if (res.status === "success") {
                                            document.getElementById("otpSection").style.display = "block";
                                        }
                                    });
                            } else {
                                alert("Enter a valid 10-digit phone number.");
                            }
                        });

                        document.getElementById("verifyOtpBtn").addEventListener("click", function () {
                            let otp = document.getElementById("otp").value;
                            if (otp.length === 6) {
                                fetch("", {
                                    method: "POST",
                                    headers: { "Content-Type": "application/x-www-form-urlencoded" },
                                    body: new URLSearchParams({ verify_otp: true, otp: otp })
                                })
                                    .then(response => response.json())
                                    .then(res => {
                                        alert(res.message);
                                        if (res.status === "success") {
                                            document.getElementById("nameSection").classList.remove("hidden");
                                            document.getElementById("otpSection").classList.add("hidden");
                                            document.getElementById("loginUser").disabled = false;

                                        }
                                    });
                            } else {
                                alert("Enter a valid 6-digit OTP.");
                            }
                        });
                    });
                </script>
                




                <!-- toggle dropdown -->
                <div>
                    <!-- Toggle Dropdown -->
                    <i class="bi bi-list fs-5" id="toggleDropdown"></i>
                    <div class="custom-dropdown" id="dropdownMenu">
                        <a href="#" class="active">Explore Schools</a>
                        <a href="#">Compare Schools</a>
                        <a href="#">Delhi Recommendations</a>
                        <a href="#" id="manageAccountToggle">Manage your Account <i class="bi bi-chevron-down arrow"
                                id="arrowIcon"></i></a>
                        <ul class="submenu" id="manageAccountMenu">
                            <li><a href="../auth/user-edit-account.php">Edit Account</a></li>
                            <li><a href="#">Manage Child</a></li>
                            <li><a href="#">Counsellor Suggestion</a></li>
                            <li><a href="#">Application Status</a></li>
                        </ul>
                        <a href="../auth/user-logout.php" class="logout-btn">Logout</a>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <!-- Navbar -->
    <div class="container-fluid navbar-container desktop-menu" style="height: 60px; background-color: #eaf2fc;
                    margin-top: 70px;">
        <div class="row">
            <div class="col-md-6 d-flex justify-content-start" style="margin-top:10px;">
                <a href="home-page.php" class="nav-link">Home</a>
                <a href="#" class="nav-link" style="padding-left: 15px;
                 padding-right: 15px;">Explore Schools</a>
                <a href="#" class="nav-link">Compare Schools</a>
            </div>
            <div class="col-md-6 d-flex justify-content-end" style="margin-top:10px;">
                <a href="#" class="nav-link">Application Status</a>
                <a href="manage-child.php" class="nav-link" style="padding-left: 15px;
                  padding-right: 15px;">Manage Child</a>
                <a href="#" class="nav-link">Ask a Question</a>
            </div>
        </div>
    </div>

    <!-- Mobile Menu -->
    <div id="mobileMenu" class="mobile-menu">
        <div class="menu-header d-flex justify-content-between align-items-center">
            <span>Menu</span>
            <i class="bi bi-x fs-4" onclick="toggleMenu()"></i>
        </div>
        <div class="menu-item">
            <i class="bi bi-person fs-5 me-2"></i> Profile
        </div>
        <div class="menu-item">Home</div>
        <div class="menu-item">Explore Schools</div>
        <div class="menu-item">Compare Schools</div>
        <div class="menu-item">Application Status</div>
        <div class="menu-item">Manage Child</div>
        <div class="menu-item">Ask a Question</div>

    </div>

    <!-- JavaScript -->
    <script>
        function toggleMenu() {
            const menu = document.getElementById('mobileMenu');
            menu.classList.toggle('active');
        }
    </script>

    <!-- JavaScript -->
    <script>
        // Function to set the selected city's ID in cookies
        function setCityCookie() {
            const citySelect = document.getElementById("citySelect");
            const cityId = citySelect.value;

            if (cityId) {
                // Set cookie
                document.cookie = `selected_city=${cityId}; path=/; max-age=86400;`;
                console.log("City ID saved to cookie:", cityId);
            }
        }

        // Preselect city if the cookie exists
        document.addEventListener("DOMContentLoaded", () => {
            const cookies = document.cookie.split("; ");
            const cityCookie = cookies.find(cookie => cookie.startsWith("selected_city="));
            if (cityCookie) {
                const cityId = cityCookie.split("=")[1];
                const citySelect = document.getElementById("citySelect");
                citySelect.value = cityId;
            }
        });
    </script>

    <script>
        function setCityCookie() {
            const citySelect = document.getElementById("citySelect");
            const cityId = citySelect.value;

            if (cityId) {
                // Set cookie
                document.cookie = `selected_city=${cityId}; path=/; max-age=86400;`;
                console.log("City ID saved to cookie:", cityId);

                // Reload page to reflect changes
                window.location.reload();
            }
        }
    </script>

    <script>
        fetch("../api/school-nearby.php")
            .then(response => {
                if (!response.ok) {
                    throw new Error("Network response was not ok");
                }
                return response.json(); // Convert response to JSON
            })
            .then(data => console.log(data)) // Display JSON data in console
            .catch(error => console.error("Error:", error)); // Handle errors
    </script>


    <!-- header  right toggle icon fs-5 js-->
    <script>
        // Toggle Main Dropdown
        document.getElementById("toggleDropdown").addEventListener("click", function () {
            var dropdown = document.getElementById("dropdownMenu");
            dropdown.style.display = dropdown.style.display === "block" ? "none" : "block";
        });

        // Close dropdown if clicked outside
        document.addEventListener("click", function (event) {
            var dropdown = document.getElementById("dropdownMenu");
            var toggleIcon = document.getElementById("toggleDropdown");
            if (!toggleIcon.contains(event.target) && !dropdown.contains(event.target)) {
                dropdown.style.display = "none";
            }
        });

        // Toggle Submenu
        document.getElementById("manageAccountToggle").addEventListener("click", function (event) {
            event.preventDefault();
            var submenu = document.getElementById("manageAccountMenu");
            var arrowIcon = document.getElementById("arrowIcon");

            if (submenu.style.display === "block") {
                submenu.style.display = "none";
                arrowIcon.classList.remove("rotate");
            } else {
                submenu.style.display = "block";
                arrowIcon.classList.add("rotate");
            }
        });
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>




</body>

</html>