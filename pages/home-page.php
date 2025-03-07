<?php
// Include the header.php file
include('../includes/header.php');

// Database connection
$conn = new mysqli("localhost", "root", "", "gurukuldekho");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get the selected city ID from cookies
$selected_city_id = isset($_COOKIE['selected_city']) ? intval($_COOKIE['selected_city']) : null;

// SQL Query to fetch schools based on selected city
$schools = [];
if ($selected_city_id) {
    $query = "SELECT schools.id, schools.name, schools.affiliate, schools.photo, city.city_name 
              FROM schools 
              JOIN city ON schools.city_id = city.id 
              WHERE city.id = $selected_city_id";
} else {
    // Default query to show schools without filtering by city
    $query = "SELECT schools.id, schools.name, schools.affiliate, schools.photo, city.city_name 
              FROM schools 
              JOIN city ON schools.city_id = city.id";
}

$result = $conn->query($query);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $schools[] = $row;
    }
}

?>
<?php
// Database connection
$conn = new mysqli("localhost", "root", "", "gurukuldekho");

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Initialize the variable
$universities = [];

// Fetch universities based on selected city or all universities
$selected_city_id = isset($_COOKIE['selected_city']) ? $_COOKIE['selected_city'] : null;

if ($selected_city_id) {
    $query = "SELECT universities.id, universities.university_name, universities.affiliate, universities.photo, city.city_name 
              FROM universities 
              JOIN city ON universities.city_id = city.id 
              WHERE city.id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $selected_city_id);
    $stmt->execute();
    $result = $stmt->get_result();
} else {
    $query = "SELECT universities.id, universities.university_name, universities.affiliate, universities.photo, city.city_name 
              FROM universities
              JOIN city ON universities.city_id = city.id";
    $result = $conn->query($query);
}

if ($result && $result->num_rows > 0) {
    $universities = $result->fetch_all(MYSQLI_ASSOC);
}

// Fetch schools where city_id matches the selected city
$queryLocality = "SELECT address_locality, COUNT(*) as school_count FROM schools WHERE city_id = ? GROUP BY address_locality";
$stmt = $conn->prepare($queryLocality);
$stmt->bind_param("i", $selected_city_id);
$stmt->execute();
$result = $stmt->get_result();

$localities = [];
while ($row = $result->fetch_assoc()) {
    if (!empty($row['address_locality'])) { // Ensure locality is not empty or null
        $localities[] = $row;
    }
}

$conn->close()
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gurukul Dekho</title>
    <!-- Add any additional CSS or JS files if needed -->
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <style>
        /* Background color and padding for the section */
        .custom-section {
            /* background-color: skyblue;
            padding: 60px 0; */
            height: 270px;
            max-width: 100%;
            width: 100%;
            background-image: url(https://cdn.ezyschooling.com/ezyschooling/main-02/client/img/hero-1300-min.b32f120.webp);
            background-size: cover;
            background-repeat: no-repeat;
            background-position: 50%;
            border-bottom-left-radius: 20px;
            border-bottom-right-radius: 20px;
        }

        /* Styling for the "Find the right school" heading */
        .find-school-heading {
            margin-top: 50px;
            font-family: Poppins, sans-serif;
            font-size: 32px;
            font-weight: 600;
            letter-spacing: .2px;
            color: #fff;
            text-align: center;
            margin-bottom: 10px;
        }

        /* Styling for the "Your admission, our responsibility" text */
        .admission-responsibility {
            font-weight: bold;
            /* font-size: 1.3rem; */
            font-size: 15px;
            color: #fff;
        }

        /* Search bar styling*/
        .search-container {
            margin-top: 20px;
        }

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

        .input-group-text {
            padding: 10px;
            border-radius: 0;
            border: 0;
            font-size: 16px;
            cursor: pointer;
            color: #0a78cd !important;
            transition: color .3s ease;
        }

        .voice-search-icon {
            background: rgba(45, 119, 198, .37);
            position: absolute;
            margin-left: 391px;
            /* background-color: #fff; */
            background: none;
            height: 38px;
        }

        .search-button {
            position: absolute;
            margin-left: 470px;
            /* background-color: #fff; */
            background: none;
            border-left: 2px solid #d3d3d3;
            height: 25px;
        }

        /* Styling for the "How to apply in schools?" link */
        .how-to-apply-link {
            display: block;
            margin-left: 260px;
            margin-top: 20px;
            font-size: 1.2rem;
            font-weight: bold;
            color: #fff;
            text-decoration: none;
        }

        @media (max-width: 768px) {
            body {
                width: 110vw;
                overflow-x: hidden;
                margin-top: 72px;
                /* Optional: hides horizontal scrolling if needed */
            }

            .search-button {
                margin-left: 240px;
            }

            .voice-search-icon {
                margin-left: 175px;
            }

            .find-school-heading {
                color: #fff;
                display: flex;
                padding-top: 20px;
                margin-bottom: 5px;
                font-size: 24px;
                font-weight: 600;
                -webkit-box-pack: center;
                justify-content: center;
                -webkit-box-align: center;
                align-items: center;
                margin-top: 0px;
            }

            .search-input {
                width: 90%;
                padding: 10px;
                border: 1px solid #ccc;
                border-radius: 5px;
                cursor: pointer;
            }
        }
    </style>

    <!-- CSS Styles -->
    <style>
        .slider-card {
            transition: transform 0.3s ease-in-out;
        }

        .slider-card:hover {
            transform: translateY(-10px);
        }

        .homepage_heading h4 {
            font-size: 25px;
            margin-bottom: .5rem;
            font-weight: 600;
            line-height: 1.2;
            font-family: Poppins, sans-serif;
        }

        .content_heading p {
            font-family: Poppins;
            font-size: 15px;
            font-weight: 600;
            color: #848484;
            margin-top: 0;
            margin-bottom: 3rem;
        }

        @media (max-width: 768px) {
            .carousel-inner .row>.col-sm-6 {
                flex: 0 0 100%;
                max-width: 100%;
            }

            .homepage_heading h4 {
                font-size: 1.25rem;
            }

            .content_heading p {
                font-size: 1rem;
            }

            .school-details-btn {
                font-size: 0.9rem;
                padding: 0.5rem 1rem;
            }
        }
    </style>

    <style>
        /* Custom CSS for centering */
        .section-content {
            text-align: center;
            margin-top: 50px;
        }

        .btn-primary {
            background-color: #007bff;
            /* Primary color */
        }

        .section3 {
            width: 80%;
            margin: auto;
            padding: 0 20px;
            background: #e2f5ff;
            border-radius: 25px;
            height: 200px;
        }

        /* Mobile view adjustments */
        @media (max-width: 576px) {
            .section-content {
                margin-top: 20px;
            }

            .btn-primary {
                width: 100%;
            }
        }
    </style>

    <!-- search popup css -->
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

        .popup-content {
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

    <!-- apply easily css -->
    <style>
        .apply-section {
            background-color: #e6f3ff;
            /* Light blue background */
            /* padding: 50px 20px; */
        }

        .apply-content {
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .apply-text {
            max-width: 50%;
        }

        .apply-text h2 {
            font-size: 24px;
            font-weight: bold;
            margin-bottom: 10px;
        }

        .apply-text p {
            font-size: 16px;
            margin-bottom: 15px;
        }

        .apply-text ul {
            list-style: none;
            padding: 0;
        }

        .apply-text ul li {
            font-size: 16px;
            margin-bottom: 10px;
            display: flex;
            align-items: center;
        }

        .apply-text ul li i {
            font-size: 18px;
            color: #007bff;
            margin-right: 8px;
        }

        .apply-btn {
            background-color: #007bff;
            color: white;
            padding: 12px 20px;
            border-radius: 5px;
            font-size: 16px;
            text-decoration: none;
            display: inline-block;
            font-weight: bold;
        }

        .apply-btn:hover {
            background-color: #0056b3;
        }

        .apply-image img {
            max-width: 100%;
            height: auto;
        }

        /* Mobile View Adjustments */
        @media (max-width: 768px) {
            .apply-content {
                flex-direction: column;
                text-align: center;
            }

            .apply-text {
                max-width: 100%;
            }

            .apply-image {
                display: none;
                /* Hides image on mobile */
            }
        }
    </style>

    <!-- did you know css -->
    <style>
        .did-you-know {
            background-color: #1877d2;
            /* Blue background */
            color: white;
            text-align: center;
            padding: 50px 20px;
            position: relative;
            overflow: hidden;
        }

        .did-you-know h6 {
            opacity: 0.8;
            font-size: 16px;
            text-transform: uppercase;
        }

        .did-you-know h2 {
            font-size: 24px;
            font-weight: bold;
            margin: 10px 0;
        }

        .did-you-know p {
            font-size: 18px;
            opacity: 0.9;
        }

        /* Background text styling */
        .background-text {
            font-size: 100px;
            font-weight: bold;
            color: rgba(255, 255, 255, 0.1);
            /* Light transparent text */
            position: absolute;
            bottom: 10px;
            left: 50%;
            transform: translateX(-50%);
            white-space: nowrap;
            text-transform: uppercase;
            letter-spacing: 5px;
        }

        /* Carousel indicators */
        .carousel-indicators [data-bs-target] {
            background-color: white;
            width: 10px;
            height: 10px;
            border-radius: 50%;
        }

        .carousel-indicators .active {
            background-color: black;
        }
    </style>

    <!-- how to apply ezyschooling steps css -->
    <style>
        .apply-gurukul-section {
            background: #f8fafb;
            border-radius: 25px;
            padding: 20px;
            justify-content: center;
        }

        .step-card img {
            width: 50px;
            height: 50px;
        }

        .step-card p {
            font-size: 14px;
            font-weight: bold;
            color: #333;
        }

        .step-number {
            position: absolute;
            top: 50%;
            left: -2%;
            transform: translateY(-55%);
            font-family: Roboto;
            font-size: 60px;
            font-weight: 400;
            color: #fff;
            text-shadow: 2px 2px 0 #3171f4, 2px -2px 0 #3171f4, -2px 2px 0 #3171f4, -2px -2px 0 #3171f4, 2px 0 0 #3171f4, 0 2px 0 #3171f4, -2px 0 0 #3171f4, 0 -2px 0 #3171f4;
        }

        .step-card {
            text-align: center;
            padding: 15px;
            background: linear-gradient(230.45deg, #f4fbfe 1.91%, #fff);
            height: 190px;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: space-between;
            box-shadow: 0 0 9px 2px rgba(0, 0, 0, .05);
            border-radius: 0 10px 10px 0;
            margin-top: auto;
        }

        .step-btn {
            border: none;
            border-radius: 5px;
            width: 140px;
            height: 35px;
            font-family: Poppins;
            font-size: 14px;
            display: flex;
            justify-content: center;
            align-items: center;
            margin: auto;
        }

        @media (max-width: 768px) {
            .apply-gurukul-section {
                flex-direction: column;
                text-align: center;
            }

            .col-md-5 {
                order: 2;
            }

            .col-md-7 {
                order: 1;
            }

            .row.g-3 {
                display: flex;
                flex-direction: column;
                align-items: center;
            }

            .col-md-4 {
                width: 100%;
            }

            .step-card {
                width: 90%;
                margin-bottom: 15px;
            }

            .step-number {
                font-size: 30px;
                top: -15px;
            }
        }
    </style>

    <!-- Popular localities -->
    <style>
         .locality-card {
            border: 1px solid #ddd;
            border-radius: 10px;
            padding: 15px;
            transition: all 0.3s ease-in-out;
        }
        .locality-card:hover {
            box-shadow: rgba(149, 157, 165, 0.2) 0px 8px 24px;
        }
    </style>

    <!-- Smart search -->
    <style>
        .custom-section-smart-search {
            background-color: #e3f2fd; /* Light blue background */
            border-radius: 15px;
            padding: 30px;
        }
        .btn-custom {
            border-radius: 8px;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
        }
        .btn-custom i {
            margin-left: 8px;
        }
        .animated-image {
            position: absolute; /* Position relative to the parent container */
            top: 0;
            left:150px;
            animation: moveImage 5s ease-in-out infinite;
        }

        @keyframes moveImage {
            0% {
                transform: translate(10%, 60%); /* Start at the original position */
            }
            25% {
                transform: translate(80%, 100%); /* Move horizontally */
            }
            50% {
                transform: translate(370%, 50%); /* Move diagonally */
            }
            75% {
                transform: translate(330%, 125%); /* Move vertically */
            }
            100% {
                transform: translate(10%, 60%); /* Return to the original position */
            }
        }
    </style>

</head>

<body>
    <!-- Main Content -->
    <section class="custom-section">
        <div class="container">
            <!-- First Row: Find the right school -->
            <div class="row justify-content-center">
                <div class="col-md-8 text-center">
                    <h2 class="find-school-heading">Find the right school</h2>
                </div>
            </div>

            <!-- Second Row: Your admission, our responsibility -->
            <div class="row justify-content-center">
                <div class="col-md-8 text-center" style="font-weight: 510;
                 font-family: poppins sans-serif;">
                    <p class="admission-responsibility">Your admission, our responsibility</p>
                </div>
            </div>

            <!-- Third Row: Search bar -->
            <div class="row justify-content-center">
                <div class="col-md-8 text-center">
                    <form class="search-container d-flex justify-content-center align-items-center"
                        id="openSearchPopup">
                        <!-- Search Input -->
                        <!-- <input type="text" placeholder="Search here..." class="search-input" required readonly
                            style="width: 70%; padding: 10px; border: 1px solid #ccc; border-radius: 5px; cursor: pointer;"> -->

                        <input type="search" id="dynamicPlaceholder" name="query" placeholder="Loading..."
                            class="search-input" required
                            style="width: 70%; padding: 10px; border: 1px solid #ccc; border-radius: 5px; cursor: pointer;">

                        <!-- Voice Search Button -->
                        <button type="button" class="input-group-text voice-search-icon animation-behind"
                            onclick="startVoiceSearch()">
                            <i class="bi bi-mic"></i>
                        </button>

                        <!-- Search Button -->
                        <button type="button" class="input-group-text search-button">
                            <i class="bi bi-search"></i>
                        </button>
                    </form>
                </div>
            </div>

            <!-- Search Popup -->
            <div id="searchPopup" class="popup-overlay">
                <div class="popup-content">
                    <div class="popup-header">
                        <h2 style="margin-left: 180px;">Find the right <span style="color: blue;">school</span></h2>
                        <button class="close-btn" onclick="closeSearchPopup()">&times;</button>
                    </div>

                    <!-- Search Bar in Popup -->
                    <div class="search-container d-flex justify-content-center align-items-center">
                        <input type="text" id="popupSearchInput" placeholder="Search here..." class="search-input"
                            required style="width: 70%; padding: 10px; border: 1px solid #ccc; border-radius: 5px;">

                        <button type="button" class="input-group-text voice-icon animation-behind"
                            onclick="startVoiceSearch()">
                            <i class="bi bi-mic"></i>
                        </button>

                        <button type="button" class="input-group-text search-icon" onclick="performSearch()">
                            <i class="bi bi-search"></i>
                        </button>
                    </div>

                    <!-- Search Results -->
                    <div id="searchResults" class="search-results"></div>
                </div>
            </div>


            <!-- Third Row: How to apply in schools link -->
            <div class="row justify-content-center">
                <div class="col-md-8 text-center">
                    <a href="#" class="how-to-apply-link">💡 How to Apply in Schools?</a>
                </div>
            </div>
        </div>
    </section>

    <!--School Section with heading, paragraph, and slider -->
    <section class="my-5">
        <div class="container">
            <!-- Centered Heading -->
            <div class="row">
                <div class="col-md-12 text-center mt-4 homepage_heading">
                    <h4>Most Applied Schools In <span class="text-primary"> <?php
                    if ($selected_city_id && !empty($schools)) {
                        echo $schools[0]['city_name']; // Display the name of the selected city
                    } else {
                        echo "All Cities"; // Default text if no city is selected
                    }
                    ?></span></h4>
                </div>
            </div>

            <!-- Centered Paragraph -->
            <div class="row">
                <div class="col-md-12 text-center content_heading">
                    <p>Apply to our parent's top applied schools</p>
                </div>
            </div>

            <!-- School Slider -->
            <div id="schoolSlider" class="carousel slide" data-bs-ride="carousel">
                <div class="carousel-inner">
                    <?php
                    // Split schools into chunks of 4 for each slide
                    $is_mobile = isset($_SERVER['HTTP_USER_AGENT']) && preg_match('/Mobile|Android|iPhone/', $_SERVER['HTTP_USER_AGENT']);
                    $chunk_size = $is_mobile ? 1 : 4;
                    $chunked_schools = array_chunk($schools, $chunk_size);
                    foreach ($chunked_schools as $index => $chunk) {
                        $active = $index === 0 ? 'active' : '';
                        echo '<div class="carousel-item ' . $active . '">';
                        echo '<div class="row">';
                        foreach ($chunk as $school) {
                            echo '
                     <div class="col-md-3 col-sm-6 mb-4">
                        <div class="card slider-card shadow rounded-3 h-100">
                           <img src="' . $school['photo'] . '" class="card-img-top rounded-top-3"" alt="' . $school['name'] . '">
                          <div class="card-body d-flex flex-column">
                            <h5 class="card-title">' . $school['name'] . '</h5>
                            <p class="card-text mb-1">City: ' . $school['city_name'] . '</p>
                            <p class="card-text mb-2">Affiliate to: ' . $school['affiliate'] . '</p>
                        <button class="btn btn-primary mt-auto school-details-btn" onclick="redirectToDetails(' . $school['id'] . ')">View Details</button>
                    
                       </div>
                    </div>
                      </div>';
                        }
                        echo '</div></div>';

                    }
                    ?>
                </div>

                <!-- Carousel Controls -->
                <button class="carousel-control-prev" type="button" data-bs-target="#schoolSlider" data-bs-slide="prev"
                    style="width:0;">
                    <!-- <span class="carousel-control-prev-icon" aria-hidden="true"></span> -->
                    <span><i class="bi bi-arrow-left-circle-fill" style="color: black;margin-right: 80px;"></i></span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#schoolSlider" data-bs-slide="next"
                    style="width:0;">
                    <!-- <span class="carousel-control-next-icon" aria-hidden="true"></span> -->
                    <span><i class="bi bi-arrow-right-circle-fill" style="color: black;margin-left: 80px;"></i></span>
                </button>

            </div>
        </div>
    </section>


    <!--university Section with heading, paragraph, and slider -->
    <section class="my-5">
        <div class="container">
            <!-- Centered Heading -->
            <div class="row">
                <div class="col-md-12 text-center mt-4 homepage_heading">
                    <h4>Most Applied Universities In <span class="text-primary"> <?php
                    if ($selected_city_id && !empty($universities)) {
                        echo $universities[0]['city_name']; // Display the name of the selected city
                    } else {
                        echo "All Cities"; // Default text if no city is selected
                    }
                    ?></span></h4>
                </div>
            </div>

            <!-- Centered Paragraph -->
            <div class="row">
                <div class="col-md-12 text-center content_heading">
                    <p>Apply to our parent's top applied universities</p>
                </div>
            </div>
            <?php if (!empty($universities)): ?>
                <!-- School Slider -->
                <div id="universitySlider" class="carousel slide" data-bs-ride="carousel">
                    <div class="carousel-inner">
                        <?php
                        // Split schools into chunks of 4 for each slide
                        $is_mobile = isset($_SERVER['HTTP_USER_AGENT']) && preg_match('/Mobile|Android|iPhone/', $_SERVER['HTTP_USER_AGENT']);
                        $chunk_size = $is_mobile ? 1 : 4;
                        $chunked_universities = array_chunk($universities, $chunk_size);
                        foreach ($chunked_universities as $index => $chunk) {
                            $active = $index === 0 ? 'active' : '';
                            echo '<div class="carousel-item ' . $active . '">';
                            echo '<div class="row">';
                            foreach ($chunk as $university) {
                                echo '
                     <div class="col-md-3 col-sm-6 mb-4">
                        <div class="card slider-card shadow rounded-3 h-100">
                           <img src="' . $university['photo'] . '" class="card-img-top rounded-top-3" alt="' . $university['university_name'] . '">
                          <div class="card-body d-flex flex-column">
                            <h5 class="card-title">' . $university['university_name'] . '</h5>
                            <p class="card-text mb-1">City: ' . $university['city_name'] . '</p>
                            <p class="card-text mb-2">Affiliate to: ' . $university['affiliate'] . '</p>
                        <button class="btn btn-primary school-details-btn" onclick="redirectToDetail(' . $university['id'] . ')">View Details</button>
                    
                       </div>
                    </div>
                      </div>';
                            }
                            echo '</div></div>';

                        }
                        ?>
                    </div>

                    <!-- Carousel Controls -->
                    <button class="carousel-control-prev universe_leftarrow" type="button"
                        data-bs-target="#universitySlider" data-bs-slide="prev" style="width:0;">
                        <!-- <span class="carousel-control-prev-icon" aria-hidden="true"></span> -->
                        <span><i class="bi bi-arrow-left-circle-fill" style="color: black;margin-right: 80px;"></i></span>
                    </button>
                    <button class="carousel-control-next universe_rightarrow" type="button"
                        data-bs-target="#universitySlider" data-bs-slide="next" style="width:0;">
                        <!-- <span class="carousel-control-next-icon" aria-hidden="true"></span> -->
                        <span><i class="bi bi-arrow-right-circle-fill" style="color: black;margin-left: 80px;"></i></span>
                    </button>

                </div>
            <?php else: ?>
                <p class="text-center mt-4">No universities found for the selected city.</p>
            <?php endif; ?>
        </div>
    </section>

    <!-- find instant school section -->
    <section>
        <div class="container section3">
            <div class="section-content">
                <!-- First Row: Heading -->
                <div class="row">
                    <div class="col">
                        <h2 style="font-weight: 700; font-size: 1.5rem; margin-top:30px;">Find School Around Instantly!
                        </h2>
                    </div>
                </div>

                <!-- Second Row: Paragraph -->
                <div class="row">
                    <div class="col">
                        <p style="font-size: 1rem; color:#666;">Tap the button below to let us detect your location.
                            Start your
                            journey towards the perfect school nearby!</p>
                    </div>
                </div>

                <!-- Third Row: Button -->
                <div class="row">
                    <div class="col">
                        <button class="btn btn-primary" id="exploreButton">Explore School Near You</button>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Popular localities -->
    <?php if (!empty($localities)) { ?>
    <section>
        <div class="container text-center mt-5">
            <h3>Popular Localities in <span class="text-primary"><?php echo ucfirst($schools[0]['city_name']) ?></span></h3>
            <p class="text-muted">Check schools in top Localities</p>
            <div class="row g-3 mt-3">
            <?php foreach ($localities as $locality): ?>
                <div class="col-md-4 col-sm-6">
                    <div class="locality-card p-3">
                        <a href="./explore-school.php?locality=<?php echo $locality['address_locality'] ?>" style="text-decoration: none; color: black;">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h5><strong><?php echo $locality['address_locality']; ?></strong></h5>
                                    <p class="text-muted mb-0"><?php echo $locality['school_count']; ?> Schools</p>
                                </div>    
                                <div>
                                    <i class="bi bi-chevron-right"></i>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
            <?php endforeach; ?>
            </div>
        </div>
    </section>
    <?php } ?>

    <!-- Smart Search -->
    <section>
    <div class="container mt-5">
    <div class="custom-section-smart-search d-flex flex-wrap align-items-center">
        <div class="col-md-6 p-4">
            <p class="text-muted fw-semibold">
                <i class="fas fa-star text-danger"></i> Admission Consultant of Ezyschooling (ACE)
            </p>
            <h2 class="fw-bold">Not sure, which school to choose?</h2>
            <p class="text-muted">
                Our AI-powered assistant will help you find the right school for your child.
            </p>
            <a class="btn btn-primary btn-custom">
                Get Suggestions <i class="bi bi-box-arrow-right"></i>
            </a>
        </div>
        <div class="col-md-6 text-center" style="position: relative;">
            <img src="../admin/uploads/homepage_images/mac-phone.webp" style="max-width: 270px;" alt="School Selection Assistant">
            <img src="../admin/uploads/homepage_images/search2.webp" class="animated-image" style="max-width: 50px;" alt="School Selection Assistant">
        </div>
    </div>
</div>

    </section>

    <!-- apply easily section -->
    <section class="my-5">
        <div class="apply-section">
            <div class="container">
                <div class="apply-content">
                    <!-- Left Text Section -->
                    <div class="apply-text">
                        <h2>Apply Easily to Multiple Schools at Once</h2>
                        <p>Simplify your application process by submitting one application to multiple schools. Save
                            time and effort.</p>
                        <ul>
                            <li><i class="bi bi-bell"></i> Real-Time Updates & notifications on WhatsApp, SMS, and
                                emails.</li>
                            <li><i class="bi bi-graph-up"></i> Track the status of your applications with our Live
                                Application Tracking system.</li>
                            <li><i class="bi bi-file-earmark"></i> No Need to visit schools physically.</li>
                        </ul>
                        <a href="explore_school.php" class="apply-btn">Start Your Application Now →</a>
                    </div>

                    <!-- Right Image Section -->
                    <div class="apply-image">
                        <img src="../admin/uploads/homepage_images/img1.png" alt="Apply Easily">
                    </div>
                </div>
            </div>
        </div>
    </section>


    <!-- how to apply gurukuldekho steps section -->
    <?php $isLoggedIn = isset($_SESSION['user_id']); ?>
    <div class="container mt-4">
        <div class="apply-gurukul-section row align-items-center p-4">
            <div class="text-center w-100">
                <h3>How to apply with <span style="color: red;">GurukulDekho</span>?</h3>
                <p style="font-family: Poppins; font-size: 15px;font-weight: 400; color:#6c757d !important;">
                    Getting Started: Complete these steps to fill form
                </p>
            </div>

            <!-- Left Side: Video Section -->
            <div class="col-md-5 text-center">
                <iframe width="90%" height="250" src="https://www.youtube.com/embed/YOUR_VIDEO_ID" frameborder="0"
                    allowfullscreen></iframe>
            </div>

            <!-- Right Side: Steps Section -->
            <div class="col-md-7">
                <div class="row g-4 justify-content-center">
                    <?php
                    $steps = [
                        ["REGISTER YOURSELF", "user-dashboard.php", "View Account", "btn-primary", "step-1.f573b7d.webp"],
                        ["CREATE YOUR CHILD'S PROFILE", "manage-child.php", "Create Profile", "btn-primary", "step-2.b1bf1bf.webp"],
                        ["ADD SCHOOLS TO CART", "explore-school.php", "Add to Apply", "btn-primary", "step-3.37e4f80.webp"],
                        ["FILL COMMON APPLICATION FORM", "explore-school.php", "Add to Apply", "btn-primary", "step-4.45ec358.webp"],
                        ["TRACK APPLICATIONS", "explore-school.php", "Track Now", "btn-primary", "step-5.0447484.webp"]
                    ];
                    $stepNumber = 1;
                    foreach ($steps as $step) {
                        echo '<div class="col-md-4 position-relative text-center">
                            <span class="step-number">' . $stepNumber . '</span>
                            <div class="step-card">
                                <img src="../admin/uploads/homepage_images/' . $step[4] . '" alt="Step ' . $stepNumber . '">
                                <p>' . $step[0] . '</p>
                                <button class="btn ' . $step[3] . ' step-btn" data-url="' . $step[1] . '">' . $step[2] . '</button>
                            </div>
                          </div>';
                        $stepNumber++;
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>

    <!-- did you know section -->
    <section class="my-5">
        <div id="didYouKnowCarousel" class="carousel slide" data-bs-ride="carousel">
            <div class="carousel-inner">
                <div class="carousel-item active">
                    <div class="did-you-know">
                        <h6>Did you know?</h6>
                        <h2>Nine out of ten times, parents don’t get</h2>
                        <p>their first choice of school.</p>
                        <div class="background-text">GURUKUL DEKHO</div>
                    </div>
                </div>
                <div class="carousel-item">
                    <div class="did-you-know">
                        <h6>Did you know?</h6>
                        <h2>Some schools have over 100 years of history!</h2>
                        <p>These institutions have shaped generations of students.</p>
                        <div class="background-text">GURUKUL DEKHO</div>
                    </div>
                </div>
                <div class="carousel-item">
                    <div class="did-you-know">
                        <h6>Did you know?</h6>
                        <h2>Early education boosts cognitive development.</h2>
                        <p>Kids who start early tend to perform better academically.</p>
                        <div class="background-text">GURUKUL DEKHO</div>
                    </div>
                </div>
            </div>
            <div class="carousel-indicators">
                <button type="button" data-bs-target="#didYouKnowCarousel" data-bs-slide-to="0" class="active"></button>
                <button type="button" data-bs-target="#didYouKnowCarousel" data-bs-slide-to="1"></button>
                <button type="button" data-bs-target="#didYouKnowCarousel" data-bs-slide-to="2"></button>
            </div>
        </div>

    </section>

    <!-- how to apply gurukuldekho steps section  -->
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            var isLoggedIn = <?php echo isset($_SESSION['user_id']) ? 'true' : 'false'; ?>;
            document.querySelectorAll(".step-btn").forEach(button => {
                if (!isLoggedIn) {
                    button.textContent = "Login First";
                    button.classList.add("btn-danger");
                    button.setAttribute("data-url", "home-page.php");
                }

                button.addEventListener("click", function (event) {
                    if (!isLoggedIn) {
                        event.preventDefault(); // Button action rokne ke liye
                        alert("Please login first");
                        window.location.href = "home-page.php"; // Redirect to login page
                    } else {
                        window.location.href = this.getAttribute("data-url");
                    }
                });
            });
        });
    </script>


    <!-- JavaScript for fetching school details -->
    <!-- <script>
        function fetchSchoolDetails(schoolId) {
            // Make an AJAX request to fetch school details
            fetch(`get_school_details.php?id=${schoolId}`)
                .then((response) => response.json())
                .then((data) => {
                    // Display school details in an alert (you can replace this with a modal)
                    alert(
                        `Name: ${data.name}\nCity: ${data.city}\nAffiliate: ${data.affiliate}\nAddress: ${data.address}\nAdmission Status: ${data.admission_status}`
                    );
                })
                .catch((error) => console.error('Error fetching school details:', error));
        }
    </script> -->

    <!-- HTML to display the list of nearby schools
    <button id="exploreButton">Explore Nearby Schools</button>
    <ul id="schoolsList"></ul> -->


    <script>
        function redirectToDetails(schoolId) {
            // Redirect to manage-school.php with the school ID as a query parameter
            window.location.href = '../pages/viewschool-details.php?id=' + schoolId;
        }
    </script>

    <script>
        function redirectToDetail(universityId) {
            // Redirect to manage-school.php with the university ID as a query parameter
            window.location.href = '../pages/viewuniversity-detail.php?id=' + universityId;
        }
    </script>

    <script>
        function startVoiceSearch() {
            if (!('webkitSpeechRecognition' in window)) {
                alert('Your browser does not support voice search.');
                return;
            }

            const recognition = new webkitSpeechRecognition();
            recognition.lang = 'en-US';
            recognition.interimResults = false;

            recognition.onresult = function (event) {
                const query = event.results[0][0].transcript;
                window.location.href = 'search-results.php?query=' + encodeURIComponent(query);
            };

            recognition.onerror = function (event) {
                alert('Voice search failed. Please try again.');
            };

            recognition.start();
        }
    </script>

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

    <!-- explore now section -->
    <script>
        document.getElementById("exploreButton").addEventListener("click", function () {
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(successCallback, errorCallback);
            } else {
                alert("Geolocation is not supported by this browser.");
            }

            function successCallback(position) {
                const latitude = position.coords.latitude;
                const longitude = position.coords.longitude;

                // Make AJAX call to get-nearby-schools.php
                fetch(`../api/get-nearby-schools.php?latitude=${latitude}&longitude=${longitude}`)
                    .then((response) => response.json())
                    .then((data) => {
                        if (data.status === "success") {
                            // Store school data in localStorage (or pass via query string)
                            localStorage.setItem("nearbySchools", JSON.stringify(data.schools));

                            // Redirect to school-nearby.php
                            window.location.href = "../pages/school-nearby.php";
                        } else {
                            alert("Error fetching nearby schools: " + data.message);
                        }
                    })
                    .catch((error) => {
                        console.error("Error fetching schools:", error);
                        alert("Failed to fetch nearby schools. Please try again.");
                    });
            }

            function errorCallback(error) {
                alert("Unable to get location. Please allow location access and try again.");
            }
        });
    </script>

    <!-- JavaScript -->
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

    <!-- JavaScript for Dynamic Placeholder -->
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            let index = 0;
            let namesList = ["Loading..."]; // Default text before loading data

            // Function to update placeholder text
            function updatePlaceholder() {
                document.getElementById("dynamicPlaceholder").placeholder = namesList[index];
                index = (index + 1) % namesList.length;
            }

            // Fetch dynamic names from PHP
            fetch("fetch-names.php")
                .then(response => response.json())
                .then(data => {
                    if (data.length > 0) {
                        namesList = data;
                        updatePlaceholder(); // Update immediately after fetching
                        setInterval(updatePlaceholder, 3000); // Change every 3 seconds
                    }
                })
                .catch(error => console.error("Error fetching names:", error));

            setInterval(updatePlaceholder, 3000); // Default cycle if fetch fails
        });
    </script>

    <!-- did you know section -->
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            var myCarousel = new bootstrap.Carousel(document.getElementById("didYouKnowCarousel"), {
                interval: 5000, // 3 seconds per slide
                wrap: true
            });
        });
    </script>

    <!-- Include Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Bootstrap JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>

</body>

<?php include('../includes/footer.php'); ?>

</html>