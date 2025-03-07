<?php
session_start();
include '../admin/includes/db_connect.php';

$api_key = "Aqy3EgvTuuvAFAQzAYsS5kNFbzcd8Qv0NLWZfwXOKXkiMLQbX4DfrJM8jJcv";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['send_otp'])) {
        $phone = $_POST['phone'];
        $otp = rand(100000, 999999);
        setcookie('otp', $otp, time() + 300, "/"); // 5 min expiry
        setcookie('phone', $phone, time() + 300, "/");

        $api_url = "https://www.fast2sms.com/dev/bulkV2?authorization=$api_key&route=otp&variables_values=$otp&flash=0&numbers=$phone";
        $ch = curl_init($api_url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_exec($ch);
        curl_close($ch);

        echo json_encode(["status" => "success", "message" => "OTP sent successfully"]);
        exit;
    }

    if (isset($_POST['verify_otp'])) {
        $entered_otp = $_POST['otp'];
        $stored_otp = isset($_COOKIE['otp']) ? $_COOKIE['otp'] : '';
        $stored_phone = isset($_COOKIE['phone']) ? $_COOKIE['phone'] : '';

        if (!$stored_otp) {
            echo json_encode(["status" => "error", "message" => "OTP expired. Please request again."]);
        } elseif ($entered_otp == $stored_otp) {
            setcookie("otp", "", time() - 3600, "/"); // OTP delete after verification
            setcookie("phone", "", time() - 3600, "/");

            $_SESSION['user_id'] = $stored_phone;
            echo json_encode(["status" => "success", "message" => "OTP verified successfully"]);
        } else {
            echo json_encode(["status" => "error", "message" => "Invalid OTP. Please try again."]);
        }
        exit;
    }


    if (isset($_POST['submit_user'])) {
        $phone = $_POST['phone'];
        $name = $_POST['user_name'];

        // Check if the phone number already exists in the database
        $check_sql = "SELECT * FROM users WHERE phone = '$phone'";
        $check_result = $conn->query($check_sql);

        if ($check_result->num_rows > 0) {
            // User found, store session data
            $user = $check_result->fetch_assoc();

            // Set session variable
            $_SESSION['user_id'] = $user['phone'];

            // If the phone number exists, redirect to dashboard.php
            header("Location: ../pages/home-page.php");
        } else {
            // If the phone number does not exist, insert into the database
            $insert_sql = "INSERT INTO users (phone, name) VALUES ('$phone', '$name')";
            if ($conn->query($insert_sql) === TRUE) {

                // User found, store session data
                $user = $check_result->fetch_assoc();

                // Set session variable
                $_SESSION['user_id'] = $user['phone'];

                echo $_SESSION['user_id'];
                // After inserting, redirect to dashboard.php
                header("Location:../pages/home-page.php");
            } else {
                echo "<script type='text/javascript'>
                    alert('Error: " . $insert_sql . " - " . $conn->error . "');
                  </script>";
            }
        }
    }
}
?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
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
                            data-bs-dismiss="modal" aria-label="Close"> <span class="close-btn">&times;</span></button>

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
                                            <input type="text" class="form-control" id="otp" aria-describedby="otpHelp"
                                                placeholder="Enter OTP">
                                            <button type="button" id="verifyOtpBtn" class="btn btn-success">Verify
                                                OTP</button>
                                        </div>
                                    </div>

                                    <div id="nameSection" class="my-3 hidden" style="">
                                        <label for="name" class="form-label">Enter Your Name</label>
                                        <div class="d-flex gap-2">
                                            <input type="text" class="form-control" id="name" name="user_name"
                                                placeholder="enter your name">
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
                                        <svg version="1.1" xmlns="http://www.w3.org/2000/svg" width="18px" height="18px"
                                            viewBox="0 0 48 48" class="abcRioButtonSvg">
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
                                        <svg version="1.1" xmlns="http://www.w3.org/2000/svg" width="18px" height="18px"
                                            viewBox="0 0 48 48" class="abcRioButtonSvg">
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
   
</body>

</html>