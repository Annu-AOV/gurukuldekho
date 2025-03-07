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

    // Fetch current school details
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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- jQuery & AJAX for Dynamic Review Submission and Display -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
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

        .applying-status {
            border: .8px solid #30a9ff;
            background-color: #e9f7fe;
            padding: 15px;
            border-radius: 5px;
            display: flex;
            align-items: center;
            justify-content: space-between;
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
            scrollbar-color: rgb(51, 52, 53) #f0f0f0;
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
            color: black;
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

    <!-- sidebar photo section css -->
    <style>
        .photos-sections {
            background: #fff;
            padding: 15px;
            border-radius: 10px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
            text-align: left;
        }

        .photos-sections h3 {
            font-size: 18px;
            color: #1a73e8;
            margin-bottom: 10px;
        }

        .phootos-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 20px;
        }

        .photos-items img {
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

    <!-- sidebar similar school section css -->
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
    <div class="container mt-4 content-container">

        <!--apply now section-->
        <div class="applying-status">
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
                <!-- <a href="#?id=<?php echo $school_id; ?>#admission-sec"
                    class="btn btn-primary btn-apply">Apply Now</a> -->

                <a href="#admission" class="btn btn-outline-primary" id="applyNowBtn">Apply Now</a>
            </div>
        </div>

        <!-- Review & Rating Section -->
        <div class="card p-4 mt-4" style="box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1); border:none;">

            <small style="font-weight: 400; font-size: 12px; line-height: 14px; margin-bottom: 4px; color: #8a8a8a;">
                <?php echo htmlspecialchars($school['name']); ?></small>

            <!-- Review & Rating Header -->

            <h4 class="fw-bold" style="color: #545f71;border-left: 5px solid #007bff;
         padding-left: 10px;">Review & Rating</h4>


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
                    Help other parents to decide the right school for their child</p>

                <?php if ($is_logged_in) { ?>
                    <button class="btn btn-primary mt-2" data-bs-toggle="modal" data-bs-target="#reviewModal">
                        Write a Review
                    </button>
                <?php } else { ?>
                    <button class="btn btn-primary mt-2" onclick="showLoginPopup()">Write a Review</button>
                    <script> function showLoginPopup() {
                            var loginAlertModal = new bootstrap.Modal(document.getElementById('loginAlertModal'));
                            loginAlertModal.show();
                        }
                        function redirectToHome() {
                            window.location.href = '../pages/home-page.php';
                        }
                    </script>
                <?php } ?>
            </div>

            <!-- review modal -->
            <div class="modal fade" id="reviewModal" tabindex="-1" aria-labelledby="reviewModalLabel"
                aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="reviewModalLabel">Review & Rating</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form id="reviewForm" method="POST" action="submit_review.php">
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
            <div class="modal fade" id="loginAlertModal" tabindex="-1" aria-labelledby="loginAlertModalLabel"
                aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="loginAlertModalLabel">Alert</h5>
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

            <!-- Detailed Reviews Section -->
            <h5 class="mt-4" style="color:#4b4a49;">Detailed Reviews</h5>
            <div id="reviewsList">
                <?php while ($review = $reviews_result->fetch_assoc()) { ?>
                    <div class="review-card border p-3 mb-2 shadow-sm rounded">
                        <div class="review-header d-flex justify-content-between">
                            <h6 class="fw-bold" style="color: #545f71;"><?php echo $review['reviewer_name']; ?></h6>
                            <small
                                class="text-muted"><?php echo date("d M, Y", strtotime($review['review_date'])); ?></small>
                        </div>
                        <span
                            class="rating text-warning"><?php echo str_repeat('⭐', round($review['overall_rating'])); ?></span>
                        <p class="mt-2" style="color:#6a7682"><?php echo $review['review_text']; ?></p>
                    </div>
                <?php } ?>
            </div>

            <!-- Show More/Less Reviews -->
            <div id="show-more-reviews" class="text-center mt-3">
                <p class="see-more-btn" style="display: none;" onclick="toggleReviews(true)">
                    See More ▼
                </p>
                <p class="see-less-btn" style="display: none;" onclick="toggleReviews(false)">
                    See Less ▲
                </p>
            </div>
        </div>

        <!-- apply section -->
        <div class="apply-section d-flex align-items-center mt-4"
            style="border: 1px solid #ddd; border-radius: 8px; padding: 15px; background: #fff; box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);">
            <!-- Left Image Section -->
            <div style="flex: 1; text-align: start;">
                <img src="../admin/uploads/homepage_images/how_to_apply.webp" alt="Admissions"
                    style="max-width: 100px;" />
            </div>

            <!-- Right Content Section -->
            <div class="d-flex justify-content-between align-items-center" style="flex: 2; padding-left: 15px;">
                <div class="d-flex align-items-start flex-column justify-content-center">
                    <h6 style="font-size: 16px; font-weight: 600; color: #333;">Looking for Admissions?</h6>
                    <p style="font-size: 14px; color: #555; margin: 8px 0;">
                        Apply to <strong><?php echo htmlspecialchars($school['name']); ?></strong> via GurukulDekho now.
                    </p>
                </div>
                <a href="#admission" class="btn-apply-now" id="reviewapplynowBtn"
                    style="background-color: #1978cd; color: white; border: none; padding: 8px 25px; font-size: 14px; font-weight: bold; border-radius: 4px; text-decoration: none; display: inline-block; transition: all 0.3s;">
                    Apply Now
                </a>
            </div>
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
                <!-- <a href="#?id=<?php echo $school_id; ?>#admission-sec"
                    class="btn btn-primary btn-apply">Apply Now</a> -->

                <a href="#admission" class="btn btn-outline-primary" id="applyBtnNow">Apply Now</a>
            </div>
        </div>

    </div>


    <!-- Sidebar -->
    <div class="sidebar-container" style="margin-top: 25px;">

        <!-- sidebar apply now section -->
        <div class="apply-section d-flex align-items-center"
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
                    Apply to <strong><?php echo htmlspecialchars($school['name']); ?></strong> via GurukulDekho now.
                </p>
                <a href="#admission" class="btn-apply-now" id="reviewapplynowBtn"
                    style="background-color: #1978cd; color: white; border: none; padding: 8px 15px; font-size: 14px; font-weight: bold; border-radius: 4px; text-decoration: none; display: inline-block; transition: all 0.3s;">
                    Apply Now
                </a>
            </div>
        </div>

        <!-- video section sidebar -->
        <div class="sidebar-video mt-4">
            <h5>Step by Step Guide to Applying</h5>
            <iframe width="560" height="315" src="https://www.youtube.com/embed/Video-id" frameborder="0"
                allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture"
                allowfullscreen></iframe>
        </div>


        <!-- parents also applied to -->
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
                    <a href="javascript:void(0);" onclick="redirectTodetail(<?php echo $school['id']; ?>)"
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

        <!-- sidebar photo section -->
        <?php
        // Sirf 6 photos dikhane ke liye
        $photos_to_display = array_slice($all_photos, 0, 6);

        // Agar photos available hain tabhi section render hoga
        if (!empty($photos_to_display)) {
            ?>
            <div class="photos-sections mt-4">
                <small style="font-weight: 400; font-size: 12px; line-height: 14px; margin-bottom: 4px; color: #8a8a8a;">
                <?php echo htmlspecialchars($current_school['name'] ?? "Unknown School"); ?></small>
                <h3 style="color: #545f71;border-left: 5px solid #007bff;
                     padding-left: 10px;">Photos</h3>
                <div class="phootos-grid">
                    <?php
                    foreach ($photos_to_display as $photo) {
                        echo "<div class='photos-items'><img src='$photo' alt='School Photo'></div>";
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


        <!-- ✅ Similar school Section -->
        <div class="similar-schools-section mt-4">
        <?php if ($current_school) { ?>
        <small style="font-weight: 400; font-size: 12px; color: #8a8a8a;">
        <?php echo htmlspecialchars($school_name); ?>
        </small>
    <?php } ?>
            <h4 style="color: #545f71; border-left: 5px solid #007bff; padding-left: 10px;">Similar Schools</h4>

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



    <!--review section js  -->
    <script>
        $(document).ready(function () {
            // Initially show only first 2 reviews
            toggleReviews(false);

            // Handle form submission via AJAX
            $("#reviewForm").submit(function (e) {
                e.preventDefault(); // Prevent default form submission

                // Disable submit button & show loading state
                let submitButton = $(this).find("button[type='submit']");
                submitButton.prop("disabled", true).text("Submitting...");

                $.ajax({
                    type: "POST",
                    url: "submit_review.php",
                    data: $(this).serialize(),
                    success: function (response) {
                        let responseData = JSON.parse(response);

                        // Close modal smoothly
                        $('#reviewModal').modal('hide');

                        // Add new review at the top
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
                        $('#reviewsList').prepend(newReviewHTML); // Add review at the top

                        // Update review count
                        let newReviewCount = parseInt($('#review-count').text()) + 1;
                        $('#review-count').text(newReviewCount + ' reviews');

                        // Reset form & enable button again
                        $("#reviewForm")[0].reset();
                        submitButton.prop("disabled", false).text("Submit");

                        // Show reviews correctly
                        toggleReviews(true);
                    },
                    error: function () {
                        alert("Error submitting review. Please try again.");
                        submitButton.prop("disabled", false).text("Submit");
                    }
                });
            });
        });

        // Toggle "See More ▼" and "See Less ▲" for reviews
        function toggleReviews(showAll) {
            let reviews = $('.review-card');

            if (reviews.length > 2) {
                if (showAll) {
                    reviews.show();
                    $('.see-more-btn').hide();
                    $('.see-less-btn').show();
                } else {
                    reviews.slice(2).hide();
                    $('.see-more-btn').show();
                    $('.see-less-btn').hide();
                }
            }
        }

    </script>

    <!-- click on all applynow button rediect to admission tab -->
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            // Select all "Apply Now" buttons
            let applyButtons = document.querySelectorAll("#applyNowBtn, #reviewapplynowBtn, #applyBtnNow");

            applyButtons.forEach(button => {
                button.addEventListener("click", function (event) {
                    event.preventDefault(); // Prevent default anchor behavior

                    // Find and activate the "Admission" tab
                    let admissionTab = document.querySelector("#admission-tab");
                    if (admissionTab) {
                        let tab = new bootstrap.Tab(admissionTab);
                        tab.show(); // Show the tab
                    }
                });
            });
        });
    </script>

    <!-- parents also aplied sidebar js -->
    <script>
        function redirectTodetail(schoolId) {
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