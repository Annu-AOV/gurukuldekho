<?php
ob_start(); // Output buffering start
// session_start();
if (isset($_GET['redirect']) && $_GET['redirect'] == 'signin') {
    echo "<script>alert('Now you can sign in from here');</script>";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gurukul Dekho</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- Header Styling  -->
    <style>
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
            content: "\f4e1";
            margin-right: 20px;
        }

        .form-select {
            width: 100px;
        }

        .navbar-container {
            margin-top: 70px;
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

        /* Search bar styling*/
        /* .search-container {
            margin-top: 20px;
        } */

        .search-input {
            width: 60%;
            padding: 10px;
            font-size: 1rem;
            border-radius: 5px;
            border: 1px solid #ccc;
            background-color: #fff;
            display: flex;
            box-shadow: 12px 16px 19px 5px rgba(0, 0, 0, .1);
        }

        .input-group-txt {
            padding: 10px;
            border-radius: 0;
            border: 0;
            font-size: 16px;
            cursor: pointer;
            color: #0a78cd !important;
            transition: color .3s ease;
        }

        .voice-search-icon {
            /* background: rgba(45, 119, 198, .37); */
            position: absolute;
            margin-left: 351px;
            /* background-color: #fff; */
            background: none;
            height: 38px;
        }

        .search-button {
            position: absolute;
            margin-left: 420px;
            /* background-color: #fff; */
            background: none;
            border-left: 2px solid #d3d3d3;
            height: 38px;
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

        .pro {
            border-bottom: 0;
        }

        .bi-person-circle::before {
            margin-top: 5px;
            margin-right: 10px;
        }

        .mobile-menu .menu-header {
            padding: 15px;
            font-weight: bold;
            border-bottom: 1px solid #ddd;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .mobile-menu .menu-item {
            padding: 10px 15px;
            border-bottom: 1px solid #ddd;
        }

        .mobile-menu .menu-item i {
            margin-right: 10px;
        }

        /* 
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
        } */

        @media (max-width: 768px) {
            .desktop-menu {
                display: none;
            }

            .toggle-icon {
                display: inline-block;
            }

            .mobile-header-search {
                display: flex;
                align-items: center;
                gap: 10px;
                padding: 10px 15px;
                border-bottom: 1px solid #ddd;
            }

            .mobile-header-search select {
                flex: 1;
            }

            .mobile-header-search input {
                flex: 3;
            }
        }

        @media (min-width: 769px) {
            .toggle-icon {
                display: none;
            }
        }

        @media (max-width: 768px) {
            .voice-search-icon {
                margin-left: 140px;
            }

            .search-button {
                margin-left: 210px;
            }
        }
    </style>

    <!-- search bar popup css -->
    <style>
        .popup-overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.6);
            justify-content: center;
            align-items: center;
            z-index: 9999;
        }

        .popup-contents {
            background: white;
            padding: 20px;
            border-radius: 10px;
            text-align: center;
            width: 50%;
            position: relative;
        }

        .popup-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .close-btn {
            background: none;
            border: none;
            font-size: 24px;
            cursor: pointer;
        }

        .search-results {
            margin-top: 15px;
            text-align: left;
        }

        .voice-icon {
            background: rgba(45, 119, 198, .37);
            position: absolute;
            margin-left: 341px;
            /* background-color: #fff; */
            background: none;
            height: 38px;
        }

        .search-icon {
            position: absolute;
            margin-left: 410px;
            /* background-color: #fff; */
            background: none;
            border-left: 2px solid #d3d3d3;
            height: 35px;
        }
    </style>

    <!-- header right toggle menu css-->
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
</head>

<body>
    <?php
    // Database connection
    $conn = new mysqli("localhost", "root", "", "gurukuldekho");

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

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

            <!-- Logo -->
            <div class="col-md-3 col-3 d-flex align-items-center">
                <a href="../pages/home-page.php">
                    <img src="../admin/uploads/school_photos/logo.jpg" alt="Logo" class="me-2"
                        style="width: 50px; height: 50px;">
                </a>

                <select class="form-select" id="citySelect" onchange="setCityCookie()">
                    <option value="">Select City</option>
                    <?php
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo "<option value='" . $row['id'] . "'>" . $row['city_name'] . $row['state'] . "</option>";
                        }
                    }
                    ?>
                </select>
            </div>

            <!-- Third Row: Search bar -->
            <div class="col-md-6 text-center">
                <form class="search-container d-flex justify-content-center align-items-center" id="openSearchPopup">
                    <!-- Search Input -->
                    <input type="text" placeholder="Search here..." class="search-input" required readonly
                        style="width: 70%; padding: 10px; border: 1px solid #ccc; border-radius: 5px; cursor: pointer;">

                    <!-- Voice Search Button -->
                    <button type="button" class="input-group-txt voice-search-icon animation-behind"
                        onclick="startVoiceSearch()">
                        <i class="bi bi-mic"></i>
                    </button>

                    <!-- Search Button -->
                    <button type="button" class="input-group-txt search-button">
                        <i class="bi bi-search"></i>
                    </button>
                </form>
            </div>

            <!-- Search Popup -->
            <div id="searchPopup" class="popup-overlay">
                <div class="popup-contents">
                    <div class="popup-header">
                        <h2 style="margin-left: 170px;">Find the right <span style="color: blue;">school</span></h2>
                        <button class="close-btn" onclick="closeSearchPopup()">&times;</button>
                    </div>

                    <!-- Search Bar in Popup -->
                    <div class="search-container d-flex justify-content-center align-items-center">
                        <input type="text" id="popupSearchInput" placeholder="Search here..." class="search-input"
                            required style="width: 70%; padding: 10px; border: 1px solid #ccc; border-radius: 5px;">

                        <button type="button" class="input-group-txt voice-icon animation-behind"
                            onclick="startVoiceSearch()">
                            <i class="bi bi-mic"></i>
                        </button>

                        <button type="button" class="input-group-txt search-icon" onclick="performSearch()">
                            <i class="bi bi-search"></i>
                        </button>
                    </div>

                    <!-- Search Results -->
                    <div id="searchResults" class="search-results" style="cursor:pointer;"></div>
                </div>
            </div>


            <!-- Bag and Profile Icons -->
            <div class="col-md-3 d-none d-md-flex justify-content-end align-items-center">
                <div class="rounded-border me-3">
                    <i class="bi bi-bag fs-5"></i>
                </div>


                <?php if (isset($_SESSION['user_id'])) { ?>
                    <!-- User Dashboard Link (Shown when user is logged in) -->
                    <a href="../pages/user-dashboard.php">
                        <i class="bi bi-person fs-5"></i>
                    </a>
                <?php } else { ?>
                    <!-- Sign In Button (Shown when user is not logged in) -->
                    <a href="home-page.php?redirect=signin" class="btn btn-primary">Sign In</a>
                <?php } ?>


                <!-- header Toggle Dropdown -->
                <div>
                    <i class="bi bi-list fs-5" id="toggleDropdown"></i>
                    <div class="custom-dropdown" id="dropdownMenu">
                        <a href="#" class="active">Explore Schools</a>
                        <a href="#">Compare Schools</a>
                        <a href="#">Delhi Recommendations</a>
                        <a href="#" id="manageAccountToggle">Manage your Account <i class="bi bi-chevron-down arrow"
                                id="arrowIcon"></i></a>
                        <ul class="submenu" id="manageAccountMenu">
                            <li><a href="../auth/user-edit-account.php">Edit Account</a></li>
                            <li><a href="../pages/manage-child.php">Manage Child</a></li>
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
    <div class="container-fluid navbar-container desktop-menu" style="height: 60px; background-color: #eaf2fc;">
        <div class="row">
            <div class="col-md-6 d-flex justify-content-start" style="margin-top:15px;">
                <a href="#" class="nav-link" id="home-link">Home</a>
                <a href="school-nearby.php" class="nav-link" style="padding-left: 15px;
                padding-right: 15px;">Explore Schools</a>
                <a href="#" class="nav-link">Compare Schools</a>
            </div>
            <div class="col-md-6 d-flex justify-content-end" style="margin-top:15px;">
                <a href="#" class="nav-link">Application Status</a>
                <a href="#" class="nav-link" id="manage-link" style="padding-left: 15px;
                 padding-right: 15px;">Manage Child</a>
                <a href="#" class="nav-link">Ask a Question</a>
            </div>
        </div>
    </div>

    <!-- Mobile Menu -->
    <?php

    // Fetch city data
    $cityQuery = "SELECT id, city_name FROM city";
    $result = $conn->query($cityQuery);
    ?>

    <div id="mobileMenu" class="mobile-menu">
        <div class="menu-header">
            <span>Menu</span>
            <i class="bi bi-x fs-4" onclick="toggleMenu()"></i>
        </div>

        <!-- Search and Profile -->
        <div class="mobile-header-search">

            <div class="menu-item">
                <i class="bi bi-person-circle d-flex pro"> Profile</i>
            </div>

            <select class="form-select" id="citySelect" onchange="setCityCookie()">
                <option value="">Select City</option>
                <?php
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<option value='" . $row['id'] . "'>" . $row['city_name'] . $row['state'] . "</option>";
                    }
                }
                ?>
            </select>
        </div>

        <div class="menu-item">Home</div>
        <div class="menu-item">Explore Schools</div>
        <div class="menu-item">Compare Schools</div>
        <div class="menu-item">Application Status</div>
        <div class="menu-item">Manage Child</div>
        <div class="menu-item">Ask a Question</div>
    </div>

    <!-- JavaScript mobile toggle-->
    <script>
        function toggleMenu() {
            const menu = document.getElementById('mobileMenu');
            menu.classList.toggle('active');
        }
    </script>

    <!-- header search bar js -->
    <script>
        const searchBar = document.getElementById("search-bar");
        const searchButton = document.getElementById("search-button");
        const micButton = document.getElementById("mic-button");

        // Fetch search options
        fetch("fetch_search_options.php")
            .then(response => response.json())
            .then(data => {
                const searchOptions = data.map(item => ({
                    label: `${item.institution_name}, ${item.city_name} (${item.type})`,
                    id: item.id,
                    type: item.type
                }));

                // Autocomplete (basic example)
                searchBar.addEventListener("input", function () {
                    const query = this.value.toLowerCase();
                    const suggestions = searchOptions.filter(option =>
                        option.label.toLowerCase().includes(query)
                    );
                    console.log(suggestions); // Render suggestions as dropdown items (you can style them).
                });

                searchButton.addEventListener("click", function () {
                    const query = searchBar.value;
                    window.location.href = `search-results.php?q=${encodeURIComponent(query)}`;
                });

                // Speech-to-text functionality
                micButton.addEventListener("click", function () {
                    const recognition = new (window.SpeechRecognition || window.webkitSpeechRecognition)();
                    recognition.lang = "en-US";
                    recognition.start();

                    recognition.onresult = function (event) {
                        searchBar.value = event.results[0][0].transcript;
                    };
                });
            });
    </script>

    <!-- JavaScript for city -->
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

    <!-- set city to cookie js -->
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

    <!-- JavaScript fr search popup-->
    <script>
        document.getElementById('openSearchPopup').addEventListener('click', function (event) {
            event.preventDefault();
            document.getElementById('searchPopup').style.display = 'flex';
        });

        function closeSearchPopup() {
            document.getElementById('searchPopup').style.display = 'none';
        }

        // Function to perform search
        function performSearch() {
            let query = document.getElementById('popupSearchInput').value.trim();
            if (query === '') {
                document.getElementById('searchResults').innerHTML = "<div class='alert alert-danger'>Search query cannot be empty.</div>";
                return;
            }

            let xhr = new XMLHttpRequest();
            xhr.open("GET", "search-results.php?q=" + query, true);
            xhr.onload = function () {
                if (xhr.status === 200) {
                    document.getElementById('searchResults').innerHTML = xhr.responseText;
                }
            };
            xhr.send();
        }
    </script>

    <!-- redirect to home page -->
    <script>
        document.getElementById("home-link").addEventListener("click", function (event) {
            event.preventDefault(); // Default `#` action rokne ke liye
            window.location.href = "../pages/home-page.php"; // Redirect to home page
        });
    </script>

    <!-- redirect to manage child -->
    <script>
        document.getElementById("manage-link").addEventListener("click", function (event) {
            event.preventDefault(); // Default `#` action rokne ke liye
            window.location.href = "../pages/manage-child.php"; // Redirect to home page
        });
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