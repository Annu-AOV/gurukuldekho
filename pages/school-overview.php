<?php
include('../admin/includes/db_connect.php'); // Database connection file

// Get school ID from URL (from viewschool-details.php)
$school_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($school_id > 0) {
    // Fetch school details
    $school_query = "SELECT name, city_id, admission_status FROM schools WHERE id = ?";
    $stmt = $conn->prepare($school_query);
    $stmt->bind_param("i", $school_id);
    $stmt->execute();
    $school_result = $stmt->get_result();
    $school = $school_result->fetch_assoc();

    // Fetch admission details
    $admission_query = "SELECT class, session, last_application_date, application_fee FROM admissions WHERE school_id = ?";
    $stmt = $conn->prepare($admission_query);
    $stmt->bind_param("i", $school_id);
    $stmt->execute();
    $admission_result = $stmt->get_result();

    // Fetch fee structure details
    $session_filter = isset($_GET['session']) ? $_GET['session'] : date("Y") . "-" . (date("Y") + 1);
    $fee_query = "SELECT class, session FROM fee_structure WHERE school_id = ? AND session = ?";
    $stmt = $conn->prepare($fee_query);
    $stmt->bind_param("is", $school_id, $session_filter);
    $stmt->execute();
    $fee_result = $stmt->get_result();

    // Fetch all available sessions for dropdown
    $session_query = "SELECT DISTINCT session FROM fee_structure WHERE school_id = ?";
    $stmt = $conn->prepare($session_query);
    $stmt->bind_param("i", $school_id);
    $stmt->execute();
    $session_result = $stmt->get_result();

    // Fetch the documents for the selected school
    $document_query = "SELECT * FROM school_documents WHERE school_id = '$school_id'";
    $document_result = mysqli_query($conn, $document_query);

    // School name ka slug generate karna
    $school_name = strtolower(str_replace(' ', '_', $school['name']));
    $target_dir = "../admin/assets/uploads/school_photos/" . $school_name . "/";

    // School media data fetch karna
    $query = "SELECT * FROM school_medias WHERE school_id = $school_id";
    $result = mysqli_query($conn, $query);
    $media = mysqli_fetch_assoc($result);

    // Photos categories
    $photo_categories = ['sports', 'classroom', 'labs', 'medical_facilities', 'boarding', 'campus_architecture', 'activities', 'extra_curricular', 'cafeteria', 'library', 'other_photos'];

    // Images Array
    $all_photos = [];
    foreach ($photo_categories as $category) {
        if (!empty($media[$category])) {
            $photos = explode(',', $media[$category]);
            foreach ($photos as $photo) {
                $all_photos[] = $target_dir . $photo;
            }
        }
    }

    // Check if videos exist
    $video_links = !empty($media['videos']) ? explode(',', $media['videos']) : [];

    // SQL query to fetch quick fact data
    $query = "SELECT * FROM school_quickfact WHERE school_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('i', $school_id); // Bind school_id as an integer
    $stmt->execute();
    $result = $stmt->get_result();

    // Check if the query returned any data
    if ($result->num_rows > 0) {
        $quickFact = $result->fetch_assoc(); // Fetch the data
    } else {
        $quickFact = []; // In case no data is found
    }

    // Fetch languages for the given school
    $language_query = "SELECT * FROM school_language WHERE school_id = $school_id";
    $language_result = mysqli_query($conn, $language_query);

    // Fetch school facility data
    $query = "SELECT * FROM school_facility WHERE school_id = '$school_id'";
    $result = mysqli_query($conn, $query);
    $facility = mysqli_fetch_assoc($result);

    $facilities = [
        'extra_curricular' => 'Extra Curricular',
        'class_facilities' => 'Class',
        'infrastructure' => 'Infrastructure',
        'sports_fitness' => 'Sports & Fitness',
        'lab_facilities' => 'Lab Facilities',
        'boarding' => 'Boarding',
        'disabled_friendly' => 'Disabled Friendly',
        'safety_security' => 'Safety & Security',
        'advanced_facilities' => 'Advanced Facilities'
    ];

    $icons = [
        'Art and Craft' => '🎨',
        'Dance' => '💃',
        'Debate' => '🗣️',
        'Drama' => '🎭',
        'Gardening' => '🌱',
        'Music' => '🎵',
        'Picnics and excursion' => '🧺',
        'AC Classes' => '❄️',
        'Smart Classes' => '📱',
        'Wifi' => '📶',
        'Library/Reading Room' => '📚',
        'Playground' => '🏟️',
        'Indoor Sports' => '🏓',
        'Outdoor Sports' => '⚽',
        'Swimming Pool' => '🏊',
        'Computer Lab' => '💻',
        'Science Lab' => '🔬',
        'Boys Hostel' => '🏠',
        'Girls Hostel' => '🏠',
        'CCTV' => '📹',
        'GPS Bus Tracking App' => '🚌',
        'Medical Room' => '🏥',
        'Transportation' => '🚍',
        'Cafeteria/Canteen' => '🍴',
        'Washrooms' => '🚻',
        'Auditorium/Media Room' => '🎤',
        'Karate' => '🥋',
        'Taekwondo' => '🥋',
        'Yoga' => '🧘',
        'Skating' => '⛸️',
        'Horse Riding' => '🐎',
        'Gym' => '🏋️',
        'Language Lab' => '📖',
        'Robotics Lab' => '🤖',
        'Ramps' => '🛤️',
        'Elevators' => '🛗',
        'Alumni Association' => '🤝',
        'Day care' => '🍼',
        'Meals' => '🍴'
    ];

    $is_logged_in = isset($_SESSION['user_id']);
    // Fetch Overall Ratings and Review Count for a Specific School
    $overall_sql = "SELECT AVG(overall_rating) AS avg_rating, COUNT(*) AS review_count FROM reviews WHERE school_id = $school_id";
    $overall_result = $conn->query($overall_sql);
    $overall_data = $overall_result->fetch_assoc();
    $avg_rating = round($overall_data['avg_rating'], 1);
    $review_count = $overall_data['review_count'];

    // Fetch Category Ratings for a Specific School
    $categories_sql = "SELECT category_name, AVG(category_rating) AS avg_category_rating FROM review_categories WHERE school_id = $school_id GROUP BY category_name";
    $categories_result = $conn->query($categories_sql);

    // Fetch Detailed Reviews for a Specific School
    $reviews_sql = "SELECT * FROM reviews WHERE school_id = $school_id ORDER BY review_date DESC";
    $reviews_result = $conn->query($reviews_sql);


    // parents also aplied sidebar section
    if ($school) {
        $city_id = $school['city_id'];

        // Fetch schools from the same city, excluding the current school
        $query = "SELECT s.id, s.name, s.photo, c.city_name, c.state 
              FROM schools s
              JOIN city c ON s.city_id = c.id
              WHERE s.city_id = ? AND s.id != ?
              LIMIT 10";

        $stmt = $conn->prepare($query);
        $stmt->bind_param("ii", $city_id, $school_id);
        $stmt->execute();
        $result = $stmt->get_result();

        $schools = [];
        while ($row = $result->fetch_assoc()) {
            $schools[] = $row;
        }
    }

    // Fetch current school details (sidebar similar school section)
    $query = "SELECT name, address, class, affiliate FROM schools WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $school_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $current_school = $result->fetch_assoc();

    $similar_schools = [];

    if ($current_school) {
        // ✅ Convert underscore (_) to space
        $school_name = str_replace('_', ' ', $current_school['name']);
        $address = $current_school['address'];
        $class = $current_school['class'];
        $affiliate = $current_school['affiliate'];

        // Fetch similar schools based on class, affiliate, or address
        $query = "SELECT id, name, photo, address FROM schools 
              WHERE (address = ? OR class = ? OR affiliate = ?) 
              AND id != ? 
              ORDER BY 
                (address = ?) DESC, 
                (class = ?) DESC, 
                (affiliate = ?) DESC
              LIMIT 6";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("sssisss", $address, $class, $affiliate, $school_id, $address, $class, $affiliate);
        $stmt->execute();
        $similar_schools = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }


    // Fetch school details
    $school_id = $_GET['id']; // Get school ID from URL parameter
    $sql = "SELECT name, description, school_mail, primary_mob, address, map_embed_code FROM schools WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $school_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $school = $result->fetch_assoc();
    $stmt->close();
    $conn->close();



} else {
    $school = null; // No valid school found
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>School Overview</title>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- jQuery & AJAX for Dynamic Review Submission and Display -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>

    <!-- content container, sidebar,sidebar video, fill admission css -->
    <style>
        .content-container {
            /* width: 65%;
            margin-left: 0;
            padding-left: 0; */
            width: 70%;
            float: left;
            padding-right: 2%;
        }

        .sidebar-container {
            width: 30%;
            float: right;
        }

        .admission-table {
            border: 1px solid #ddd;
            border-radius: 8px;
            overflow: hidden;
            background: #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .status-close {
            color: red;
            font-weight: bold;
        }

        .status-ongoing {
            color: green;
            font-weight: bold;
        }

        .apply-btn {
            width: 100px;
            background-color: #ff6c00;
            background-color: transparent;
            border: 1px solid #1978cd;
            color: #1978cd;
            font-size: 14px;
            font-weight: 500;
            border-radius: 4px;
            cursor: pointer;
            padding: 4px 10px;
            transition: all .3s ease;
        }

        .apply-btn:hover {
            box-shadow: 0 0 0 .2rem rgba(25, 120, 205, .5);
        }

        .sidebar-video {
            border: 1px solid #ddd;
            border-radius: 8px;
            overflow: hidden;
            background: #fff;
            padding: 15px;
            text-align: center;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .sidebar-video h5 {
            margin-bottom: 10px;
            font-size: 16px;
        }

        .sidebar-video iframe {
            width: 100%;
            height: 200px;
            border: none;
        }

        .btn-apply {
            background-color: #ff6c00;
            background-color: transparent;
            border: 1px solid #1978cd;
            color: #1978cd;
            font-size: 14px;
            font-weight: 500;
            border-radius: 4px;
            cursor: pointer;
            padding: 4px 10px;
            transition: all .3s ease;

        }

        .btn-apply:hover {
            box-shadow: 0 0 0 .2rem rgba(25, 120, 205, .5);
        }


        td {
            text-align: center;
        }

        .session-drop {
            color: #1978cd !important;
            border: 1px solid #545f71;
            min-width: 200px;
            padding: 6px;
            cursor: pointer;
            box-shadow: 0 2px 4px rgba(0, 0, 0, .1);
            border-radius: 4px;
        }

        .btn-downloadfee {
            background-color: rgba(21, 101, 171, .88235);
            font-weight: 600;
            border-radius: 6px;
            font-size: 12px;
            letter-spacing: .75px;
            box-shadow: 0 1px 6px 0 rgba(0, 0, 0, .07);
            cursor: pointer;
        }

        .applying-status {
            border: .8px solid #30a9ff;
            background-color: #e9f7fe;
            padding: 15px;
            border-radius: 5px;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        /* Media Query for Mobile View */
        /* Media Query for Mobile View */
        @media (max-width: 768px) {
            .content-container {
                width: 100%;
                float: none;
            }

            .sidebar-container {
                width: 100%;
                float: none;
                margin-top: 20px;
                /* Adds space between content and sidebar */
            }

            .sidebar-video iframe {
                height: 150px;
            }
        }

        .review-card {
            padding: 15px;
            border: 1px solid #ddd;
            border-radius: 5px;
            margin-bottom: 10px;
            background: #f9f9f9;
        }

        .hidden-review {
            display: none;
        }
    </style>

    <!-- document css -->
    <style>
        .doc-card {
            border-radius: 10px;
            box-shadow: 0 0 10px hsla(0, 0.00%, 1.20%, 0.10);
            padding: 20px;
            background: white;
        }

        .check-icon {
            color: #13b97d;
            font-size: 1.2rem;
            margin-right: 8px;
        }
    </style>

    <!-- images section css -->
    <style>
        .gallery-section {
            width: 100%;
            max-width: 1200px;
            margin: 20px auto;
            background: white;
            border: 1px solid #e0e0e0;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            padding: 20px;
        }

        .photos {
            font-weight: 600;
            line-height: 20px;
            color: #4b4a49;
            font-size: 16px;
            padding-left: .25rem;
            margin-bottom: .5rem;
            margin-top: .5rem;
        }

        .videos {
            font-weight: 600;
            line-height: 20px;
            color: #4b4a49;
            font-size: 16px;
            padding-left: .25rem;
            margin-bottom: .5rem;
            margin-top: .5rem;
        }

        @media screen and (min-width: 767px) {
            .btn-seemore-img {
                font-size: 12px;
                line-height: 24px;
                letter-spacing: .75px;
                padding: 6px 12px;
                border-radius: 6px
            }
        }
    </style>


    <!-- Quick fact css -->
    <style>
        .quick-facts {
            width: 100%;
            max-width: 1200px;
            margin: 20px auto;
            background: white;
            border: 1px solid #e0e0e0;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            padding: 20px;
        }

        .quick-facts-header {
            font-size: 1.5rem;
            font-weight: 700;
            color: #545f71;
            margin-bottom: 40px;
            line-height: 20px;
            margin-top: 2px;
        }


        .quick-facts-content {
            display: grid;
            grid-template-columns: 1fr 2fr;
            gap: 20px;
            align-items: center;
        }

        .quick-facts-image {
            display: flex;
            justify-content: center;
            align-items: center;
            width: 300px;
            gap: 25px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            height: 130px;
        }

        .quick-facts-image img {
            width: 100px;
            height: auto;
        }

        .quick-facts-info {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 10px;
        }

        .quick-facts-item {
            color: #555;
            font-size: 16px;
        }

        .quick-facts-item span {
            display: block;
            font-weight: 500;
            color: #3d4d6a;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .quick-facts-content {
                grid-template-columns: 1fr;
                /* Single column layout */
                text-align: center;
            }

            .quick-facts-image img {
                width: 80px;
                /* Smaller image for mobile */
            }

            .quick-facts-info {
                grid-template-columns: repeat(2, 1fr);
                /* Two columns instead of three */
                gap: 15px;
            }
        }

        @media (max-width: 375px) {
            .quick-facts {
                padding: 15px;
            }

            .quick-facts-header {
                font-size: 1.3rem;
            }

            .quick-facts-info {
                grid-template-columns: 1fr;
                /* Single column for very small screens */
                gap: 10px;
            }
        }
    </style>

    <!-- language css -->
    <style>
        .language-card {
            border-radius: 8px;
            box-shadow: 0 0 10px hsla(0, 0.00%, 1.20%, 0.10);
            padding: 20px;
            background: white;
            border: 1px solid #e0e0e0;
        }

        .check-icon {
            color: #13b97d;
            font-size: 1.2rem;
            margin-right: 8px;
        }
    </style>

    <!-- School facility css -->
    <style>
        .facility-section {
            /* border: 1px solid #ddd; */
            padding: 5px;
            margin-bottom: 10px;
            /* background: #fff; */
            border-radius: 8px;
        }

        .facility-title {
            font-size: 16px;
            margin-bottom: 15px;
            padding: 10px;
            background-color: #e5f1fc;
            display: inline-block;
            font-weight: 600;
            line-height: 24px;
            letter-spacing: .75px;
            margin-top: 10px;
            color: #545f71;
            border-radius: 2px;
        }

        .facility-icons {
            display: flex;
            flex-wrap: wrap;
            gap: 15px;
        }

        .facility-item {
            display: flex;
            align-items: center;
            gap: 8px;
            padding: 10px;
            color: #545f71;
            font-weight: 400;
            line-height: 18px;
            letter-spacing: -.02em;
        }

        .see-more {
            cursor: pointer;
            color: #007bff;
            font-weight: bold;
            text-align: center;
        }

        .facility-section.d-none {
            display: none;
        }
    </style>

    <!-- about us css -->
    <style>
        .about-section {
            background: #fff;
            border-radius: 10px;
            border: 1px solid #e0e0e0;
            padding: 20px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
        }

        .about-header {
            display: flex;
            align-items: center;
            font-size: 20px;
            font-weight: bold;
            border-left: 5px solid #007bff;
            padding-left: 10px;
            margin-bottom: 10px;
            color: #545f71;
        }

        .about-description {
            max-height: 100px;
            overflow: hidden;
            color: #7d8085;
            transition: max-height 0.5s ease-out;
        }

        .sees-mores {
            cursor: pointer;
            color: #007bff;
            font-weight: bold;
            text-align: center;
        }
    </style>

    <!-- review and rating css -->
    <style>
        .rating {
            color: gold;
        }

        .card-rating {
            border: 1px solid #dee2e6;
            padding: 15px;
            text-align: center;
            border-radius: 10px;
            background-color: #f0f8ff;

        }

        .review-card {
            border: 1px solid #ddd;
            padding: 15px;
            border-radius: 10px;
            background-color: #fff;
            margin-bottom: 15px;
        }

        .review-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .see-more-btn {
            cursor: pointer;
            color: #007bff;
            font-weight: bold;
            text-align: center;
        }

        .see-less-btn {
            cursor: pointer;
            color: #007bff;
            font-weight: bold;
            text-align: center;
        }
    </style>

    <!-- Adress and contact css -->
    <style>
        .btn-call {
            background-color: transparent;
            border: 1px solid #1978cd;
            color: #1978cd;
            font-size: 14px;
            font-weight: 500;
            border-radius: 4px;
            cursor: pointer;
            padding: 4px 10px;
            transition: all .3sease;
        }

        .map-container {
            width: 220px;
            height: 180px;
            overflow: hidden;
            border-radius: 8px;
            background: #f8f9fa;
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
            font-weight: bold;
            color: #6c757d;
        }

        .map-container iframe {
            width: 100%;
            height: 100%;
            border: 0;
        }
    </style>

    <!-- sidebar photo section -->
    <style>
        .photos-section {
            background: #fff;
            padding: 15px;
            border-radius: 10px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
            text-align: left;
        }

        .photos-section h3 {
            font-size: 18px;
            color: #1a73e8;
            margin-bottom: 10px;
        }

        .photos-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 20px;
        }

        .photos-item img {
            width: 100%;
            height: 80px;
            object-fit: cover;
            border-radius: 5px;
        }

        .btn-view-all {
            cursor: pointer;
            color: #007bff;
            font-weight: bold;
            text-align: center;
            background: none;
        }
    </style>

    <!-- parents also applied sidebar section css -->
    <style>
        .parents-applied-section {
            background: #fff;
            padding: 15px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            max-height: 450px;
            /* Set a fixed height */
        }

        .parents-applied-title {
            font-size: 18px;
            font-weight: bold;
            margin-bottom: 10px;
            position: sticky;
            top: 0;
            background: #fff;
            padding: 10px 0;
            z-index: 10;
        }

        /* Scrollable school list */
        .school-list {
            max-height: 350px;
            /* Adjust as needed */
            overflow-y: auto;
            /* Enables vertical scrolling */
            scrollbar-width: thin;
            /* Firefox */
            scrollbar-color: #6c757d;
            /* Blue scrollbar */
        }

        /* Webkit Browsers (Chrome, Edge, Safari) */
        .school-list::-webkit-scrollbar {
            width: 5px;
            /* Thin scrollbar */
        }

        .school-list::-webkit-scrollbar-track {
            background: #f0f0f0;
            border-radius: 10px;
        }

        .school-list::-webkit-scrollbar-thumb {
            background: #007bff;
            border-radius: 10px;
            transition: background 0.3s ease-in-out;
        }

        .school-list::-webkit-scrollbar-thumb:hover {
            background: #0056b3;
        }

        .school-card {
            background: #f8f8f8;
            border-radius: 10px;
            padding: 15px;
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 10px;
            border: 1px solid #ddd;
            transition: 0.3s;
            margin-bottom: 10px;
        }

        .school-card:hover {
            background: #e9f5ff;
            border-color: #007bff;
        }

        .school-card img {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            object-fit: cover;
        }

        .school-info {
            text-align: left;
        }

        .school-info h4 {
            font-size: 14px;
            margin: 0;
            font-weight: 600;
        }

        .school-info p {
            font-size: 12px;
            color: gray;
            margin: 2px 0 0;
        }
    </style>

    <!-- sidebar similar school section css-->
    <style>
        .similar-schools-section {
            background: #fff;
            padding: 15px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        .similar-school-list {
            display: flex;
            flex-direction: column;
            gap: 10px;
            max-height: 400px;
            /* Scrollable */
            overflow-y: auto;
        }

        .similar-school-card {
            display: flex;
            align-items: center;
            background: #f9f9f9;
            padding: 10px;
            border-radius: 10px;
            text-decoration: none;
            color: #333;
            transition: 0.3s;
        }

        .similar-school-card:hover {
            background: #e3e3e3;
        }

        .similar-school-card img {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            margin-right: 10px;
        }

        .similar-school-info h4 {
            font-size: 14px;
            margin: 0;
        }

        .similar-school-info p {
            font-size: 12px;
            color: #777;
            margin: 0;
        }

        /* Smooth Scrolling */
        .similar-school-list::-webkit-scrollbar {
            width: 6px;
        }

        .similar-school-list::-webkit-scrollbar-thumb {
            background: #007bff;
            border-radius: 10px;
        }

        .similar-school-list::-webkit-scrollbar-track {
            background: #f1f1f1;
        }
    </style>


</head>

<body>
    <div class="container mt-4 content-container"> <!--content-container -->

        <!-- fill admission form section -->
        <div class="fiil-addmission p-4 bg-white shadow rounded">
            <!-- <div class="content-container"> -->
            <?php if ($school): ?>
                <h6 style="font-weight: 400;
           font-size: 12px;
              line-height: 14px;
                  margin-bottom: 4px;
           color: #8a8a8a;"><?php echo htmlspecialchars($school['name']); ?> </h6>
                <div class="d-flex justify-content-between">
                    <h4
                        style="color: #545f71;font-weight: 700;line-height: 20px; border-left: 5px solid #007bff;padding-left: 10px;">
                        Fill Admission Form
                        <span class="ml-2" style="font-weight:500;">|</span>
                        <!-- <span class="badge"
                            style="margin-left: 60px;color: #545f71; background-color: #e2fff1;padding: 3px 10px;font-size: 14px;       font-weight: 600;letter-spacing: -.02em;cursor: pointer;">
                            <i class="bi bi-mortarboard-fill" style="margin-right: 8px;color: green;"></i>Application
                            Partner</span> -->
                        <span class="badge application-partner-tooltip"
                            style="margin-left: 60px; color: #545f71; background-color: #e2fff1; padding: 3px 10px; font-size: 14px; font-weight: 600; letter-spacing: -.02em; cursor: pointer;"
                            data-bs-toggle="tooltip" data-bs-html="true"
                            title="<b>Application Partner</b><br>This is to confirm that Ezyschooling is the Official Application Partner and is rightly sanctioned to accept your application on behalf of the school. Please note that when you submit your application form, it gets directly submitted to the school.">
                            <i class="bi bi-mortarboard-fill" style="margin-right: 8px; color: green;"></i> Application
                            Partner
                        </span>
                        <script>
                            document.addEventListener('DOMContentLoaded', function () {
                                var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
                                var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
                                    return new bootstrap.Tooltip(tooltipTriggerEl);
                                });
                            });
                        </script>

                    </h4>

                    <!-- Add Child Button -->
                    <!-- <button type="button" class="btn btn-primary" id="addChildBtn"
                        style="padding: 5px 12px; font-size: 14px; font-weight: 600; border-radius: 5px;">
                        <i class="bi bi-plus-lg"></i> Add Child
                    </button> -->

                    <button type="button" class="btn btn-primary" id="addChildBtn"
                        style="padding: 5px 12px; font-size: 14px; font-weight: 600; border-radius: 5px;">
                        <i class="bi bi-plus-lg"></i> Add Child
                    </button>

                    <script>
                        document.getElementById("addChildBtn").addEventListener("click", function () {
                            window.location.href = "add-child.php";
                        });
                    </script>

                </div>

                <div class="admission-table mt-3" id="admission-sec">
                    <table class="table table-bordered">
                        <thead class="table-light">
                            <tr>
                                <th style="color: #4b4a49; text-align:center;">Class</th>
                                <th style="color: #4b4a49; text-align:center;">Session</th>
                                <th style="color: #4b4a49; text-align:center;">Application Date</th>
                                <th style="color: #4b4a49; text-align:center;">Status</th>
                                <th style="color: #4b4a49; text-align:center;">Application Fee</th>
                                <th style="color: #4b4a49; text-align:center;">Apply</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $admission_count = 0; ?>
                            <?php while ($row = $admission_result->fetch_assoc()):
                                $today = date('Y-m-d');
                                $status = ($today > $row['last_application_date']) ? "Close" : "Ongoing";
                                ?>
                                <tr class="<?php echo ($admission_count >= 4) ? 'd-none admission-row' : ''; ?>">
                                    <td><?php echo htmlspecialchars($row['class']); ?></td>
                                    <td><?php echo htmlspecialchars($row['session']); ?></td>
                                    <td>
                                        <?php if ($status === "Close"): ?>
                                            Application closed on
                                            <?php echo date('d M, Y', strtotime($row['last_application_date'])); ?>
                                        <?php else: ?>
                                            Last Date
                                            <strong><?php echo date('d M, Y', strtotime($row['last_application_date'])); ?></strong>
                                        <?php endif; ?>
                                    </td>
                                    <td class="<?php echo ($status === "Close") ? 'status-close' : 'status-ongoing'; ?>">
                                        <?php echo $status; ?>
                                    </td>
                                    <td>₹ <?php echo number_format($row['application_fee'], 2); ?></td>
                                    <td>
                                        <?php if ($status === "Close"): ?>
                                            <button class="btn btn-outline-secondary apply-btn">Notify Me</button>
                                        <?php else: ?>
                                            <button class="btn btn-primary apply-btn">Apply</button>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                                <?php $admission_count++; ?>
                            <?php endwhile; ?>
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="6" class="text-center">
                                    <button id="toggle-admissions-btn" class="btn btn-link">See All Classes</button>
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>

        <?php else: ?>
            <div class="alert alert-warning text-center mt-4">
                <strong>No school selected!</strong> Please choose a school to view its details.
            </div>
        <?php endif; ?>



        <!-- Fee Structure section -->
        <div class="fee-structure mt-4 p-4 bg-white shadow rounded">
            <h6 style="font-weight: 400; font-size: 12px; line-height: 14px; margin-bottom: 4px; color: #8a8a8a;">
                <?php echo htmlspecialchars($school['name']); ?>
            </h6>
            <h4 style="color: #545f71;border-left: 5px solid #007bff; padding-left: 10px;">Fees Structure</h4>
            <div class="d-flex justify-content-between">
                <!-- Session Dropdown -->
                <form method="GET">
                    <select name="session" class="form-select d-inline-block w-auto session-drop"
                        onchange="this.form.submit()">
                        <?php while ($row = $session_result->fetch_assoc()): ?>
                            <option value="<?php echo $row['session']; ?>" <?php echo ($session_filter === $row['session']) ? 'selected' : ''; ?>>
                                <?php echo $row['session']; ?>
                            </option>
                        <?php endwhile; ?>
                    </select>
                </form>

                <!-- Download Fees Button -->
                <button class="btn btn-primary btn-downloadfee">Download Fees</button>
            </div>

            <table class="table table-bordered mt-3"
                style="border: 1px solid #ddd; border-radius: 8px; overflow: hidden; background: #fff; box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);">
                <thead class="table-light">
                    <tr>
                        <th style="color: #4b4a49; text-align:center;">Class</th>
                        <th style="color: #4b4a49; text-align:center;">Session</th>
                        <th style="color: #4b4a49; text-align:center;">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $fee_count = 0; ?>
                    <?php if ($fee_result->num_rows > 0): ?>
                        <?php while ($row = $fee_result->fetch_assoc()): ?>
                            <tr class="<?php echo ($fee_count >= 4) ? 'd-none fee-row' : ''; ?>">
                                <td><?php echo htmlspecialchars($row['class']); ?></td>
                                <td><?php echo htmlspecialchars($row['session']); ?></td>
                                <td>
                                    <!-- Redirect to Fee Structure Tab -->
                                    <a class="btn btn-primary apply-btn" onclick="openFeeTab()"
                                        style="font-size: 14px;font-weight:600; letter-spacing: .75px;">
                                        See Details
                                    </a>
                                    <script>
                                        function openFeeTab() {
                                            let FeeTab = new bootstrap.Tab(document.getElementById("fee-structure-tab"));
                                            FeeTab.show();
                                        }
                                    </script>
                                </td>
                            </tr>
                            <?php $fee_count++; ?> <!-- Increment the count -->
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="3" class="text-center">No Fee Structure Available</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="3" class="text-center">
                            <button id="toggle-fees-btn" class="btn btn-link">See All Classes</button>
                        </td>
                    </tr>
                </tfoot>
            </table>

        </div>


        <!--apply now section-->
        <div class="applying-status mt-4">
            <!-- Left Column -->
            <div style="flex: 1; padding-right: 10px;">
                <ul style="list-style-type: disc; margin: 0; padding: 0 20px; font-size: 14px; color: #004085;">
                    <li><?php echo htmlspecialchars($school['name']); ?> is accepting applications through GurukulDekho.
                    </li>
                    <li>No need to submit a hard copy of the form to the school.</li>
                    <li>Applying through GurukulDekho is the same as applying on the school's website or visiting the
                        school.</li>
                </ul>
            </div>
            <!-- Right Column -->
            <div style="text-align: center;">
                <a href="viewschool-details.php?id=<?php echo $school_id; ?>#admission-sec"
                    class="btn btn-primary btn-apply">Apply Now</a>
            </div>
        </div>


        <!-- School Documents Section -->
        <div class="document-sec mt-4">
            <div class="doc-card p-4">
                <small
                    style="font-weight: 400; font-size: 12px; line-height: 14px; margin-bottom: 4px; color: #8a8a8a;">
                    <?php echo htmlspecialchars($school['name']); ?></small>
                <h4 class="fw-bold" style="color: #545f71; border-left: 5px solid #007bff;padding-left: 10px;">Documents
                    Required</h4>

                <div class="row">
                    <?php
                    // Fetch the documents and display them
                    if (mysqli_num_rows($document_result) > 0) {
                        $document_fields = [
                            'address_proof' => 'Address Proof',
                            'birth_certificate' => 'Birth Certificate',
                            'medical_certificate' => 'Medical Certificate',
                            'photo' => 'Applicant Photo',
                            'caste_certificate' => 'Caste Certificate',
                            'family_photo' => 'Family Photo',
                            'last_school_details' => 'Last School Details',
                            'parent_guardian_photo' => 'Parent/Guardian Photo',
                            'religion_proof' => 'Religion Proof',
                            'report_card' => 'Report Card',
                            'differently_abled_proof' => 'Differently Abled Proof',
                            'sibling_alumni_proof' => 'Sibling Alumni Proof',
                            'first_girl_child' => 'First Girl Child',
                            'aadhaar_card' => 'Aadhaar Card'
                        ];

                        // Loop through the document fields and show them
                        while ($row = mysqli_fetch_assoc($document_result)) {
                            foreach ($document_fields as $field_key => $field_name) {
                                $is_required = $row[$field_key] == 1 ? 'Required' : 'Optional';
                                echo "<div class='col-md-6'>
                                <p>
                                    <span class='check-icon'> <i class='bi bi-check-circle-fill'></i></span>
                                    $field_name
                                    <small class='text-muted'>($is_required)</small>
                                </p>
                              </div>";
                            }
                        }
                    } else {
                        echo "<p>No documents found for this school.</p>";
                    }
                    ?>
                </div>

                <!-- <p class="see-all">See All<i class="bi bi-chevron-down" style="margin-left: 10px;"></i></p> -->
            </div>
        </div>


        <!-- Gallery Section -->
        <div class="gallery-section mt-4 p-3 bg-white shadow-sm rounded">
            <small style="font-weight: 400; font-size: 12px; line-height: 14px; margin-bottom: 4px; color: #8a8a8a;">
                <?php echo htmlspecialchars($school['name']); ?></small>
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h4 class="fw-bold" style="color: #545f71; border-left: 5px solid #007bff;padding-left: 10px;">
                    Photos &
                    Videos</h4>
                <button class="btn btn-seemore-img" onclick="openPhotoTab()"
                    style=" font-size: 10px; font-weight: 600;line-height: 16px; letter-spacing: .75px; padding: 6px 12px;border-radius: 4px;color: #1978cd; border: none; background: linear-gradient(92.81deg, #dbedfd 2.34%, rgba(205, 230, 252, 0) 150.96%); box-shadow: 0 1px 6px 0 rgba(0, 0, 0, .07);">See
                    More Images</button>
            </div>

            <script>
                function openPhotoTab() {
                    let photoTab = new bootstrap.Tab(document.getElementById("photo-tab"));
                    photoTab.show();
                }
            </script>

            <!-- Photos Section -->
            <h3 class="mb-2 photos">Photos</h3>
            <div class="row g-2">
                <?php if (!empty($all_photos)): ?>
                    <?php $photo_count = count($all_photos); ?>
                    <?php for ($i = 0; $i < min(3, $photo_count); $i++): ?>
                        <div class="col-3">
                            <div class="position-relative">
                                <img src="<?= $all_photos[$i] ?>" alt="School Photo" class="img-fluid rounded shadow-sm"
                                    style="height: 100px; object-fit: cover; width: 100%;" data-bs-toggle="modal"
                                    data-bs-target="#imageModal" onclick="openModal(<?= $i ?>)">
                            </div>
                        </div>
                    <?php endfor; ?>

                    <?php if ($photo_count > 3): ?>
                        <div class="col-3">
                            <div class="position-relative rounded overflow-hidden shadow-sm"
                                style="height: 100px; width: 100%; cursor: pointer;" data-bs-toggle="modal"
                                data-bs-target="#imageModal" onclick="openModal(3)">
                                <img src="<?= $all_photos[3] ?>" class="img-fluid"
                                    style="filter: brightness(40%); width: 100%; height: 100%; object-fit: cover;">
                                <div class="position-absolute top-50 start-50 translate-middle text-white fw-bold fs-5">
                                    +<?= $photo_count - 3 ?>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>
                <?php else: ?>
                    <div class="col-12 text-center text-muted">
                        <p class="fs-5">No Image Available for this School</p>
                    </div>
                <?php endif; ?>
            </div>

            <!-- Videos Section -->
            <!-- <h3 class="mt-4 videos">Videos</h3>
            <div class="row">
                <?php if (!empty($media['videos'])): ?>
                    <div class="col-3">
                        <div class="position-relative">
                            <a href="<?= $media['videos'] ?>" target="_blank" class="d-block">
                                <img src="https://img.youtube.com/vi/<?= explode('=', $media['videos'])[1] ?>/0.jpg"
                                    class="img-fluid rounded shadow-sm"
                                    style="height: 100px; width: 100%; object-fit: cover;">
                                <div class="position-absolute top-50 start-50 translate-middle">
                                    <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/7/78/YouTube_social_white_squircle.svg/120px-YouTube_social_white_squircle.svg.png"
                                        width="50">
                                </div>
                            </a>
                        </div>
                    </div>
                <?php else: ?>
                    <div class="col-12 text-center text-muted">
                        <p class="fs-5">No Video Available for this School</p>
                    </div>
                <?php endif; ?>
            </div> -->

            <!-- Videos Section -->
            <!-- Videos Section -->
            <h3 class="mt-4 videos">Videos</h3>
            <div class="row">
                <?php if (!empty($video_links)): ?>
                    <?php foreach ($video_links as $video):
                        $video = trim($video); // Remove spaces
                
                        // If video is from YouTube
                        if (strpos($video, 'youtube.com') !== false || strpos($video, 'youtu.be') !== false) {
                            // Extract YouTube Video ID
                            parse_str(parse_url($video, PHP_URL_QUERY), $yt_params);
                            $video_id = isset($yt_params['v']) ? $yt_params['v'] : basename(parse_url($video, PHP_URL_PATH));
                            $thumbnail = "https://img.youtube.com/vi/{$video_id}/0.jpg";
                            ?>
                            <div class="col-md-3">
                                <div class="position-relative">
                                    <a href="<?= htmlspecialchars($video) ?>" target="_blank" class="d-block">
                                        <img src="<?= $thumbnail ?>" class="img-fluid rounded shadow-sm"
                                            style="height: 100px; width: 100%; object-fit: cover;">
                                        <div class="position-absolute top-50 start-50 translate-middle">
                                            <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/7/78/YouTube_social_white_squircle.svg/120px-YouTube_social_white_squircle.svg.png"
                                                width="50">
                                        </div>
                                    </a>
                                </div>
                            </div>
                        <?php } else {
                            // If video is a direct file in school folder
                            $video_path = $target_dir . basename($video);
                            if (file_exists($video_path)) {
                                ?>
                                <div class="col-md-3">
                                    <div class="position-relative">
                                        <video controls class="img-fluid rounded shadow-sm"
                                            style="height: 100px; width: 100%; object-fit: cover;">
                                            <source src="<?= htmlspecialchars($video_path) ?>" type="video/mp4">
                                            Your browser does not support the video tag.
                                        </video>
                                    </div>
                                </div>
                            <?php }
                        } ?>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div class="col-12 text-center text-muted">
                        <p class="fs-5">No Video Available for this School</p>
                    </div>
                <?php endif; ?>
            </div>


        </div>


        <!-- Bootstrap Modal for Image Preview -->
        <div class="modal fade" id="imageModal" tabindex="-1" aria-labelledby="imageModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="imageModalLabel">Image Preview</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body text-center">
                        <button class="btn btn-dark position-absolute top-50 start-0 translate-middle-y"
                            onclick="changeImage(-1)">&#10094;</button>
                        <img id="modalImage" src="" class="img-fluid rounded">
                        <button class="btn btn-dark position-absolute top-50 end-0 translate-middle-y"
                            onclick="changeImage(1)">&#10095;</button>
                    </div>
                </div>
            </div>
        </div>


        <!--apply now section-->
        <div class="applying-status mt-4">
            <!-- Left Column -->
            <div style="flex: 1; padding-right: 10px;">
                <ul style="list-style-type: disc; margin: 0; padding: 0 20px; font-size: 14px; color: #004085;">
                    <li><?php echo htmlspecialchars($school['name']); ?> is accepting applications through
                        GurukulDekho.
                    </li>
                    <li>No need to submit a hard copy of the form to the school.</li>
                    <li>Applying through GurukulDekho is the same as applying on the school's website or visiting
                        the
                        school.</li>
                </ul>
            </div>
            <!-- Right Column -->
            <div style="text-align: center;">
                <a href="viewschool-details.php?id=<?php echo $school_id; ?>#admission-sec"
                    class="btn btn-primary btn-apply">Apply Now</a>
            </div>
        </div>


        <!-- School quick fact section -->
        <div class="quick-facts mt-4">
            <small style="font-weight: 400; font-size: 12px; line-height: 14px; margin-bottom: 4px; color: #8a8a8a;">
                <?php echo htmlspecialchars($school['name']); ?></small>
            <div class="quick-facts-header" style="border-left: 5px solid #007bff;
               padding-left: 10px;">Quick Facts</div>
            <div class="quick-facts-content">
                <div class="quick-facts-image">
                    <!-- Replace with actual school logo image path -->
                    <img src="../admin/uploads/school_photos/quick_facts.webp" alt="School Logo">

                    <div class="quick-facts-item">
                        <span>Board</span>
                        <span style="color: #1978cd;
                       font-size: 18px;"> <?= isset($quickFact['board']) ? $quickFact['board'] : 'N/A'; ?></span>
                    </div>
                    <div class="quick-facts-item">
                        <span>Gender</span>
                        <span style="color: #1978cd;
                       font-size: 18px;"> <?= isset($quickFact['gender']) ? $quickFact['gender'] : 'N/A'; ?></span>
                    </div>
                </div>
                <div class="quick-facts-info">
                    <div class="quick-facts-item">
                        <span>Classes</span>
                        <?= isset($quickFact['class_min']) ? $quickFact['class_min'] . ' - ' . (isset($quickFact['class_max']) ? $quickFact['class_max'] : 'N/A') : 'N/A'; ?>
                    </div>
                    <div class="quick-facts-item">
                        <span>Academic Session</span>
                        <?= isset($quickFact['academic_session']) ? $quickFact['academic_session'] : 'N/A'; ?>
                    </div>
                    <div class="quick-facts-item">
                        <span>Medium</span>
                        <?= isset($quickFact['medium']) ? $quickFact['medium'] : 'N/A'; ?>
                    </div>
                    <div class="quick-facts-item">
                        <span>Student Teacher Ratio</span>
                        <?= isset($quickFact['student_teacher_ratio']) ? $quickFact['student_teacher_ratio'] : 'N/A'; ?>
                    </div>
                    <div class="quick-facts-item">
                        <span>Day/Boarding</span>
                        <?= isset($quickFact['day_boarding']) ? $quickFact['day_boarding'] : 'N/A'; ?>
                    </div>
                    <div class="quick-facts-item">
                        <span>Campus Size</span>
                        <?= isset($quickFact['campus_size']) ? $quickFact['campus_size'] : 'N/A'; ?>
                    </div>
                </div>
            </div>
        </div>

        <!-- School Languages Section -->
        <div class="mt-4">
            <div class="language-card p-4">
                <small
                    style="font-weight: 400; font-size: 12px; line-height: 14px; margin-bottom: 4px; color: #8a8a8a;">
                    <?php echo htmlspecialchars($school['name']); ?></small>
                <h4 class="fw-bold" style="color: #545f71; border-left: 5px solid #007bff;
                             padding-left: 10px;">Languages Taught</h4>

                <div class="row mt-3">
                    <?php
                    if (mysqli_num_rows($language_result) > 0) {
                        $languages = [
                            'english' => 'English',
                            'hindi' => 'Hindi',
                            'french' => 'French',
                            'spanish' => 'Spanish',
                            'german' => 'German',
                            'chinese' => 'Chinese',
                            'japanese' => 'Japanese',
                            'arabic' => 'Arabic',
                            'russian' => 'Russian',
                            'portuguese' => 'Portuguese',
                            'italian' => 'Italian',
                            'korean' => 'Korean',
                            'bengali' => 'Bengali',
                            'urdu' => 'Urdu',
                            'turkish' => 'Turkish',
                            'sanskrit' => 'Sanskrit'
                        ];

                        // Loop through the languages and display them
                        while ($row = mysqli_fetch_assoc($language_result)) {
                            foreach ($languages as $field_key => $field_name) {
                                if ($row[$field_key] == 1) { // Check if the language is available
                                    echo "<div class='col-auto mb-2' style='display: flex; align-items: center;'>
                                    <span class='check-icon' style='color: #13b97d; font-size: 14px;' >
                                  <i class='bi bi-check-circle-fill'></i>
                                    </span>
                                    <span style='margin-left: 8px; font-size: 1rem; color: #545f71; font-weight: 500;'>
                                        $field_name
                                    </span>
                                  </div>";
                                }
                            }
                        }
                    } else {
                        echo "<p>No languages found for this school.</p>";
                    }
                    ?>
                </div>
            </div>
        </div>


        <!-- School Fcility section -->
        <div class="container mt-4" style="border: 1px solid #e0e0e0; background: #fff; border-radius: 8px;
                     box-shadow: 0 0 10px hsla(0, 0.00%, 1.20%, 0.10);">
            <small
                style="font-weight: 400; font-size: 12px; line-height: 14px; margin-bottom: 4px; color: #8a8a8a;margin-left:15px;">
                <?php echo htmlspecialchars($school['name']); ?></small>
            <h4 class="fw-bold" style="color: #545f71;margin-left: 15px; border-left: 5px solid #007bff;
                     padding-left: 10px;">Facilities</h4>

            <!-- Wrap all facility sections in a container for toggling -->
            <div class="facility-sections">
                <?php foreach ($facilities as $key => $title): ?>
                    <div class="facility-section">
                        <div class="facility-title"> <?= $title ?> </div>
                        <div class="facility-icons">
                            <?php
                            $items = isset($facility[$key]) && $facility[$key] != '' ? explode(',', $facility[$key]) : [];
                            if (!empty($items)) {
                                foreach ($items as $item) {
                                    // Check if an icon exists for this item
                                    $icon = isset($icons[$item]) ? $icons[$item] : '';
                                    echo "<div class='facility-item'>$icon$item</div>";
                                }
                            } else {
                                echo "<div class='facility-item text-muted'>❌ No $title</div>";
                            }
                            ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>

            <!-- See More/See Less button -->
            <div class="see-more">
                <a href="javascript:void(0);" id="toggle-facilities-btn">See Less ▼</a>
            </div>
        </div>


        <!-- apply now section -->
        <div class="applying-status mt-4">
            <!-- Left Column -->
            <div style="flex: 1; padding-right: 10px;">
                <ul style="list-style-type: disc; margin: 0; padding: 0 20px; font-size: 14px; color: #004085;">
                    <li><?php echo htmlspecialchars($school['name']); ?> is accepting applications through
                        GurukulDekho.
                    </li>
                    <li>No need to submit a hard copy of the form to the school.</li>
                    <li>Applying through GurukulDekho is the same as applying on the school's website or visiting
                        the
                        school.</li>
                </ul>
            </div>
            <!-- Right Column -->
            <div style="text-align: center;">
                <a href="viewschool-details.php?id=<?php echo $school_id; ?>#admission-sec"
                    class="btn btn-primary btn-apply">Apply Now</a>
            </div>
        </div>


        <!-- About us section -->
        <div class="mt-4">
            <div class="about-section">
                <small
                    style="font-weight: 400; font-size: 12px; line-height: 14px; margin-bottom: 4px; color: #8a8a8a;">
                    <?php echo htmlspecialchars($school['name']); ?></small>
                <div class="about-header">About Us</div>
                <p class="about-description" id="desc"><?= nl2br($school['description']) ?></p>
                <p class="sees-mores" onclick="toggleDesc()">See More ▼</p>
            </div>
        </div>



        <!-- Review & Rating Section -->
        <div class="card p-4 mt-3" style="box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1); border:none;">

            <small style="font-weight: 400; font-size: 12px; line-height: 14px; margin-bottom: 4px; color: #8a8a8a;">
                <?php echo htmlspecialchars($school['name']); ?></small>

            <!-- Review & Rating Header -->
            <div class="d-flex justify-content-between align-items-center">
                <h4 class="fw-bold" style="color: #545f71;border-left: 5px solid #007bff;
         padding-left: 10px;">Review & Rating</h4>
                <a href="#reviews" class="btn btn-outline-primary" id="detailedReviewBtn">See Detailed Reviews</a>
            </div>

            <!-- Overall Rating -->
            <div class="text-center mt-3">
                <div class="d-flex justify-content-center align-items-center">
                    <span class="rating text-warning fs-4"><?php echo str_repeat('⭐', round($avg_rating)); ?></span>
                    <h4 class="ms-2 mb-0" style="color: #545f71;"><?php echo number_format($avg_rating, 1); ?> out
                        of 5
                    </h4>
                </div>
                <p class="text-success"><i class="bi bi-chat-left-text"></i> <?php echo $review_count; ?> reviews
                </p>
            </div>

            <!-- Category Ratings (with Icons & Single Star) -->
            <div class="row mt-3 text-center justify-content-center">
                <?php
                $category_icons = [
                    'Infrastructure' => 'bi bi-building',
                    'Admission Process' => 'bi bi-journal-check',
                    'Value for Money' => 'bi bi-cash-coin',
                    'Sports' => 'bi bi-dribbble',
                    'Extra Curricular' => 'bi bi-music-note-beamed'
                ];
                while ($row = $categories_result->fetch_assoc()) {
                    $category = $row['category_name'];
                    ?>
                    <div class="col-md-2 col-6 mb-3">
                        <div class="shadow-sm"
                            style="    border-radius: 4px; background-color: #f6fbff;border: 1px solid #dee2e6;">
                            <i class="<?php echo $category_icons[$category] ?? 'bi bi-star'; ?> fs-4 text-primary"></i>
                            <h6 class="mt-2" style="color: #636363;font-weight: 500;letter-spacing: .25px;">
                                <?php echo $category; ?>
                            </h6>
                            <div class="d-flex justify-content-center w-100 gap-1">
                                <p class="text-warning mb-1">⭐</p> <!-- Only one star shown -->
                                <strong style="color:#4d4444;"><?php echo round($row['avg_category_rating'], 1); ?> out
                                    of
                                    5</strong>
                            </div>
                        </div>
                    </div>
                <?php } ?>
            </div>

            <!-- Write Review Section -->
            <div class="text-center mt-4">
                <h6 style="color: #545f71;font-size: 14px;font-weight: 600;font-family: Poppins, sans-serif;">Write
                    a
                    helpful review</h6>
                <p
                    style="color: #7d8085;font-size:16px;font-weight: 400;letter-spacing: -.16px;font-family: Poppins, sans-serif;">
                    Help other parents to decide the right school for their child
                </p>

                <?php if ($is_logged_in) { ?>
                    <button class="btn btn-primary mt-2" data-bs-toggle="modal" data-bs-target="#writeReviewModal">
                        Write a Review
                    </button>
                <?php } else { ?>
                    <button class="btn btn-primary mt-2" onclick="showLoginPopup()">Write a Review</button>
                <?php } ?>
            </div>

            <!-- Review Modal -->
            <div class="modal fade" id="writeReviewModal" tabindex="-1" aria-labelledby="writeReviewModalLabel"
                aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="writeReviewModalLabel">Review & Rating</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form id="reviewsForms" method="POST" action="submit_review.php">
                                <input type="hidden" name="school_id" value="<?php echo $school_id; ?>">

                                <!-- Name Field -->
                                <div class="mb-3">
                                    <label for="reviewer_name" class="form-label">Your Name</label>
                                    <input type="text" class="form-control" id="reviewer_name" name="reviewer_name"
                                        required>
                                </div>

                                <!-- Overall Rating -->
                                <div class="mb-3">
                                    <label for="overall_rating" class="form-label">Overall Rating</label>
                                    <div class="d-flex">
                                        <?php for ($i = 1; $i <= 5; $i++) { ?>
                                            <div class="form-check me-2">
                                                <input class="form-check-input" type="radio" name="overall_rating"
                                                    id="overall_<?php echo $i; ?>" value="<?php echo $i; ?>" required>
                                                <label class="form-check-label" for="overall_<?php echo $i; ?>">
                                                    <?php echo str_repeat('⭐', $i); ?>
                                                </label>
                                            </div>
                                        <?php } ?>
                                    </div>
                                </div>

                                <!-- Category Ratings -->
                                <h5>Category Ratings</h5>
                                <?php
                                $categories = ['Infrastructure', 'Admission Process', 'Value for Money', 'Sports', 'Extra Curricular'];
                                foreach ($categories as $category) { ?>
                                    <div class="mb-3">
                                        <label class="form-label"><?php echo $category; ?></label>
                                        <div class="d-flex">
                                            <?php for ($i = 1; $i <= 5; $i++) { ?>
                                                <div class="form-check me-2">
                                                    <input class="form-check-input" type="radio"
                                                        name="<?php echo strtolower(str_replace(' ', '_', $category)); ?>_rating"
                                                        id="<?php echo strtolower(str_replace(' ', '_', $category)) . '_' . $i; ?>"
                                                        value="<?php echo $i; ?>" required>
                                                    <label class="form-check-label"
                                                        for="<?php echo strtolower(str_replace(' ', '_', $category)) . '_' . $i; ?>">
                                                        <?php echo str_repeat('⭐', $i); ?>
                                                    </label>
                                                </div>
                                            <?php } ?>
                                        </div>
                                    </div>
                                <?php } ?>

                                <!-- Review Text -->
                                <div class="mb-3">
                                    <label for="review_text" class="form-label">Your Review</label>
                                    <textarea class="form-control" id="review_text" name="review_text" rows="3"
                                        required></textarea>
                                </div>

                                <button type="submit" class="btn btn-primary">Submit</button>
                            </form>
                            <div id="responseMessage"></div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Login Alert Modal -->
            <div class="modal fade" id="loginPopupModal" tabindex="-1" aria-labelledby="loginPopupModalLabel"
                aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="loginPopupModalLabel">Alert</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            You have to login first.
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-primary" onclick="redirectToHome()">OK</button>
                        </div>
                    </div>
                </div>
            </div>

        </div>


        <!-- address & contact section -->
        <div class="address-contact-map mt-4">
            <div class="card p-4" style="box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);border: none;">
                <small
                    style="font-weight: 400; font-size: 12px; line-height: 14px; margin-bottom: 4px; color: #8a8a8a;">
                    <?php echo htmlspecialchars($school['name']); ?></small>
                <h4 class="fw-bold" style="color: #545f71;border-left: 5px solid #007bff;
                     padding-left: 10px;">Address & Contact</h4>

                <div class="contact-container d-flex justify-content-between">
                    <div class="contact-details mt-3">
                        <p style="color:#6a7682"><i class="bi bi-envelope"></i>
                            <?= htmlspecialchars($school['school_mail']) ?></p>
                        <p style="color:#6a7682"><i class="bi bi-telephone"></i>
                            <?= htmlspecialchars($school['primary_mob']) ?></p>
                        <p style="color:#6a7682"><i class="bi bi-pin-map"></i>
                            <?= htmlspecialchars($school['address']) ?></p>
                        <a href="tel:<?= htmlspecialchars($school['primary_mob']) ?>"
                            class="btn btn-outline-primary btn-call">Call
                            School</a>
                    </div>
                    <div class="map-container">
                        <?php if (!empty($school['map_embed_code'])): ?>
                            <?= $school['map_embed_code'] ?>
                        <?php else: ?>
                            Map Not Available!
                        <?php endif; ?>
                    </div>
                </div>

            </div>
        </div>

    </div>


    <!-- Sidebar -->
    <div class="sidebar-container" style="margin-top: 25px;">

        <!-- sidebar video -->
        <div class="sidebar-video">
            <h5>Step by Step Guide to Applying</h5>
            <iframe width="560" height="315" src="https://www.youtube.com/embed/Video-id" frameborder="0"
                allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen>
            </iframe>
        </div>

        <!-- sidebar photo section -->
        <?php
        // Sirf 6 photos dikhane ke liye
        $photos_to_display = array_slice($all_photos, 0, 6);

        // Agar photos available hain tabhi section render hoga
        if (!empty($photos_to_display)) {
            ?>
            <div class="photos-section mt-4">
                <small style="font-weight: 400; font-size: 12px; line-height: 14px; margin-bottom: 4px; color: #8a8a8a;">
                    <?php echo htmlspecialchars($school['name']); ?></small>
                <h3 style="color: #545f71;border-left: 5px solid #007bff;
                     padding-left: 10px;">Photos</h3>
                <div class="photos-grid">
                    <?php
                    foreach ($photos_to_display as $photo) {
                        echo "<div class='photos-item'><img src='$photo' alt='School Photo'></div>";
                    }
                    ?>
                </div>
                <button class="btn w-100 mt-2 btn-view-all btn-outline-primary"
                    onclick="document.getElementById('photo-tab').click();">
                    View All
                </button>
            </div>
            <?php
        } // Condition yahan close ki gayi hai
        ?>

        <!-- parents also applied to  -->
        <div class="parents-applied-section mt-4">
            <div>
                <small
                    style="font-weight: 400; font-size: 12px; line-height: 14px; margin-bottom: 4px; color: #8a8a8a;">
                    <?php echo htmlspecialchars($school['name']); ?></small>
                <h4 class="fw-bold mb-3"
                    style="border-left: 5px solid #007bff; padding-left: 10px; color: #545f71; margin-top: 2px;">Parents
                    also applied to</h4>
            </div>
            <div class="school-list">
                <?php foreach ($schools as $school) { ?>
                    <a href="javascript:void(0);" onclick="redirectTodetaills(<?php echo $school['id']; ?>)"
                        class="school-card">
                        <img src="<?php echo $school['photo']; ?>" alt="<?php echo $school['name']; ?>">
                        <div class="school-info">
                            <h4 style="color: #555959;"><?php echo $school['name']; ?></h4>
                            <p>📍 <?php echo $school['city_name']; ?>, <?php echo $school['state']; ?></p>
                        </div>
                    </a>
                <?php } ?>
            </div>
        </div>

        <!-- apply now section -->
        <div class="apply-section d-flex align-items-center mt-4"
            style="border: 1px solid #ddd; border-radius: 8px; padding: 15px; background: #fff; box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);">
            <!-- Left Image Section -->
            <div style="flex: 1; text-align: center;">
                <img src="../admin/uploads/homepage_images/how_to_apply.webp" alt="Admissions"
                    style="max-width: 100px;" />
            </div>

            <!-- Right Content Section -->
            <div style="flex: 2; padding-left: 15px;">
                <h6 style="font-size: 16px; font-weight: 600; color: #333;">Looking for Admissions?</h6>
                <p style="font-size: 14px; color: #555; margin: 8px 0;">
                    Apply to
                    <strong><?php echo htmlspecialchars($current_school['name'] ?? "Unknown School"); ?></strong> via
                    GurukulDekho now.
                </p>
                <a href="#admission" class="btn-apply-now" id="reviewapplynowBtn"
                    style="background-color: #1978cd; color: white; border: none; padding: 8px 15px; font-size: 14px; font-weight: bold; border-radius: 4px; text-decoration: none; display: inline-block; transition: all 0.3s;">
                    Apply Now
                </a>
            </div>
        </div>


        <!-- ✅ Frontend Section -->
        <div class="similar-schools-section mt-4">
            <small style="font-weight: 400; font-size: 12px; color: #8a8a8a;">
                <?php echo htmlspecialchars($school_name); ?>
            </small>
            <h3 style="color: #545f71; border-left: 5px solid #007bff; padding-left: 10px;">Similar Schools</h3>

            <?php if (!empty($similar_schools)) { ?>
                <div class="school-list">
                    <?php foreach ($similar_schools as $school) { ?>
                        <a href="javascript:void(0);" onclick="redirectToSimilar(<?php echo $school['id']; ?>)"
                            class="school-card">
                            <img src="<?php echo $school['photo'] ?: 'default-school.png'; ?>"
                                alt="<?php echo htmlspecialchars($school['name']); ?>">
                            <div class="school-info">
                                <h4 style="color: #555959;"><?php echo htmlspecialchars($school['name']); ?></h4>
                                <p>📍 <?php echo htmlspecialchars($school['address']); ?></p>
                            </div>
                        </a>
                    <?php } ?>
                </div>
            <?php } else { ?>
                <p style="color: #8a8a8a; text-align: center;">No similar schools found.</p>
            <?php } ?>
        </div>
        
    </div>

    <!-- admission and fee Structure js -->
    <script>
        // Toggle Admissions Table Rows
        document.getElementById('toggle-admissions-btn').addEventListener('click', function () {
            const rows = document.querySelectorAll('.admission-row');
            const button = this;

            rows.forEach(row => row.classList.toggle('d-none'));

            button.textContent = (button.textContent === 'See All Classes') ? 'See Less' : 'See All Classes';
        });

        // Toggle Fee Structure Table Rows
        document.getElementById('toggle-fees-btn').addEventListener('click', function () {
            const rows = document.querySelectorAll('.fee-row');
            const button = this;

            rows.forEach(row => row.classList.toggle('d-none'));

            button.textContent = (button.textContent === 'See All Classes') ? 'See Less' : 'See All Classes';
        });

        document.getElementById('toggle-facilities-btn').addEventListener('click', function () {
            const sections = document.querySelectorAll('.facility-section');
            const button = this;

            // Toggle visibility for the extra sections
            sections.forEach((section, index) => {
                if (index >= 2) {  // Change 2 to the number of sections you want visible initially
                    section.classList.toggle('d-none');
                }
            });

            // Change the button text based on the visibility state
            button.textContent = (button.textContent === 'See More') ? 'See Less ▲' : 'See More ▼';
        });

    </script>

    <!-- About us js -->
    <script>
        function toggleDesc() {
            var desc = document.getElementById("desc");
            if (desc.style.maxHeight === "100px") {
                desc.style.maxHeight = "1000px";
                document.querySelector(".sees-mores").innerHTML = "See Less ▲";
            } else {
                desc.style.maxHeight = "100px";
                document.querySelector(".sees-mores").innerHTML = "See More ▼";
            }
        }
    </script>

    <!-- redirect to review tab by click see detailed review -->
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            // "See Detailed Reviews" बटन क्लिक करने पर Reviews Tab एक्टिव करें
            document.getElementById("detailedReviewBtn").addEventListener("click", function () {
                let reviewTab = document.getElementById('reviews-tab');
                let reviewPane = document.getElementById('reviews');

                if (reviewTab && reviewPane) {
                    reviewTab.classList.add("active");
                    reviewPane.classList.add("show", "active");

                    // बाकी टैब्स को डी-एक्टिवेट करें
                    document.querySelectorAll(".nav-link").forEach(tab => tab.classList.remove("active"));
                    document.querySelectorAll(".tab-pane").forEach(pane => pane.classList.remove("show", "active"));

                    reviewTab.classList.add("active");
                    reviewPane.classList.add("show", "active");
                }
            });
        });
    </script>

    <!--review section js  -->
    <script>
        function showLoginPopup() {
            var loginModal = new bootstrap.Modal(document.getElementById('loginPopupModal'));
            loginModal.show();
        }

        function redirectToHome() {
            window.location.href = '../pages/home-page.php';
        }

        $(document).ready(function () {

            // Handle form submission via AJAX
            $("#reviewsForms").submit(function (e) {
                e.preventDefault();

                let submitButton = $(this).find("button[type='submit']");
                submitButton.prop("disabled", true).text("Submitting...");

                $.ajax({
                    type: "POST",
                    url: "submit_review.php",
                    data: $(this).serialize(),
                    success: function (response) {
                        let responseData = JSON.parse(response);

                        $('#writeReviewModal').modal('hide');

                        let newReviewHTML = `
                        <div class="review-card border p-3 mb-2 shadow-sm rounded">
                            <div class="review-header d-flex justify-content-between">
                                <h6 class="fw-bold">${$('#reviewer_name').val()}</h6>
                                <small class="text-muted">${new Date().toLocaleDateString()}</small>
                            </div>
                            <span class="rating text-warning">${'⭐'.repeat(parseInt($('input[name="overall_rating"]:checked').val()))}</span>
                            <p class="mt-2">${$('#review_text').val()}</p>
                        </div>
                    `;
                        $('#reviewsList').prepend(newReviewHTML);

                        $("#reviewsForms")[0].reset();
                        submitButton.prop("disabled", false).text("Submit");

                    },
                    error: function () {
                        alert("Error submitting review. Please try again.");
                        submitButton.prop("disabled", false).text("Submit");
                    }
                });
            });
        });

    </script>

    <!-- Image Section JS -->
    <script>
        let images = <?= json_encode($all_photos) ?>;
        let currentIndex = 0;

        function openModal(index) {
            currentIndex = index;
            document.getElementById('modalImage').src = images[currentIndex];
        }

        function changeImage(step) {
            currentIndex += step;
            if (currentIndex < 0) {
                currentIndex = images.length - 1;
            } else if (currentIndex >= images.length) {
                currentIndex = 0;
            }
            document.getElementById('modalImage').src = images[currentIndex];
        }
    </script>

    <!-- JavaScript to Open add child Modal -->
    <script>
        $(document).ready(function () {
            $("#addChildBtn").click(function () {
                <?php if (isset($_SESSION['user_id'])) { ?>
                    // Agar user logged in hai to modal open ho
                    $("#addChildModal").modal('show');
                <?php } else { ?>
                    // Agar user logged in nahi hai to home-page.php par redirect karega alert message ke sath
                    alert("You have to log in first!");
                    window.location.href = "home-page.php";
                <?php } ?>
            });
        });


        $(document).ready(function () {
            $("#addChildBtn").click(function () {
                $("#addChildModal").modal('show');
            });

            // Jab Modal Close Ho, Form Reset Ho Jaye
            $('#addChildModal').on('hidden.bs.modal', function () {
                $(this).find('form')[0].reset();
            });
        });
    </script>


    <!-- parents also aplied sidebar js -->
    <script>
        function redirectTodetaills(schoolId) {
            window.location.href = '../pages/viewschool-details.php?id=' + schoolId;
        }
    </script>

    <!-- parents also aplied sidebar js -->
    <script>
        function redirectToSimilar(schoolId) {
            window.location.href = '../pages/viewschool-details.php?id=' + schoolId;
        }
    </script>

    <!-- Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>