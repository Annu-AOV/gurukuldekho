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

    // Generate folder path
    $school_name = strtolower(str_replace(' ', '_', $school['name']));
    $target_dir = "../admin/assets/uploads/school_photos/" . $school_name . "/";

    // Fetch school media
    $query = "SELECT * FROM school_medias WHERE school_id = $school_id";
    $result = mysqli_query($conn, $query);
    $media = mysqli_fetch_assoc($result);

    // Photo categories
    $photo_categories = [
        'sports' => 'Sports',
        'classroom' => 'Classroom',
        'labs' => 'Labs',
        'medical_facilities' => 'Medical Facilities',
        'boarding' => 'Boarding',
        'campus_architecture' => 'Campus Architecture',
        'activities' => 'Activities',
        'extra_curricular' => 'Extra Curricular',
        'cafeteria' => 'Cafeteria',
        'library' => 'Library',
        'other_photos' => 'Other Photos'
    ];

    // Collect all images
    $all_photos = [];
    foreach ($photo_categories as $category => $title) {
        if (!empty($media[$category])) {
            $photos = explode(',', $media[$category]);
            foreach ($photos as $photo) {
                $photo_path = $target_dir . trim($photo);
                if (!empty($photo)) {
                    $all_photos[] = $photo_path;
                }
            }
        }
    }


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
    <title>School Fee Structure Tab</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
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
    </style>
    <!-- 
    <style>
        .photo-section {
            margin-bottom: 20px;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 10px;
            background: #fff;
        }

        .photo-section h4 {
            border-bottom: 2px solid #007bff;
            padding-bottom: 5px;
        }

        .photo-grid {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            align-items: center;
        }

        .photo-thumbnail {
            width: 150px;
            height: 100px;
            object-fit: cover;
            cursor: pointer;
            border-radius: 5px;
        }

        .more-images {
            width: 150px;
            height: 100px;
            background: rgba(0, 0, 0, 0.6);
            color: white;
            display: flex;
            justify-content: center;
            align-items: center;
            cursor: pointer;
            border-radius: 5px;
        }

        .modal-body {
            position: absolute;
        }

        .nav-arrow {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            font-size: 24px;
            cursor: pointer;
            color: white;
            background: rgba(0, 0, 0, 0.5);
            padding: 10px;
            border-radius: 5px;
        }

        .prev-photo {
            left: 10px;
        }

        .next-photo {
            right: 10px;
        }

        .img-fluid {
            max-width: 100%;
            height: auto;
            border-radius: 10px;
        }

        .more-images {
            background: rgba(0, 0, 0, 0.5);
            /* Semi-transparent background */
            color: white;
            /* White text */
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 18px;
            font-weight: bold;
            height: 100px;
            /* Adjust height */
            width: 150px;
            /* Adjust width */
            border-radius: 8px;
            /* Rounded corners */
            cursor: pointer;
        }

        .more-images:hover {
            background: rgba(0, 0, 0, 0.7);
            /* Darker on hover */
        }
    </style> -->

    <!-- CSS Styling -->
    <style>
        .photo-sec {
            padding: 10px;
        }

        .section-title {
            font-size: 22px;
            font-weight: bold;
            margin-bottom: 15px;
        }

        .photo-section {
            border: 1px solid #ddd;
            border-radius: 8px;
            padding: 15px;
            margin-bottom: 20px;
            background: #fff;
        }

        .photo-category {
            font-size: 18px;
            font-weight: bold;
            margin-bottom: 10px;
            border-left: 4px solid #007bff;
            padding-left: 10px;
        }

        .photo-grid {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
        }

        .photo-box {
            position: relative;
            flex: 1 1 24%;
            max-width: 24%;
        }

        .photo-thumbnail {
            width: 100%;
            height: 120px;
            object-fit: cover;
            border-radius: 5px;
        }

        .overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.6);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: bold;
            font-size: 14px;
            border-radius: 5px;
            cursor: pointer;
        }

        .modal-body {
            position: relative;
        }

        .nav-arrow {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            font-size: 24px;
            cursor: pointer;
            color: #fff;
            background: rgba(0, 0, 0, 0.5);
            padding: 10px;
            border-radius: 50%;
            z-index: 10;
        }

        .prev-photo {
            left: 10px;
        }

        .next-photo {
            right: 10px;
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

        <!--apply now section-->
        <div class="applying-status">
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
                <!-- <a href="#?id=<?php echo $school_id; ?>#admission-sec"
                    class="btn btn-primary btn-apply">Apply Now</a> -->

                <a href="#admission" class="btn btn-outline-primary" id="applyNowBtns">Apply Now</a>
            </div>
        </div>


        <!-- Photo Section -->
        <div class="photo-sec mt-4 p-4 bg-white shadow rounded">
            <small style="font-weight: 400; font-size: 12px; line-height: 14px; margin-bottom: 4px; color: #8a8a8a;">
                <?php echo htmlspecialchars($school['name']); ?>
            </small>
            <h3 class="section-title" style="color: #545f71; border-left: 5px solid #007bff; padding-left: 10px;">
                Photos & Videos
            </h3>

            <?php
            $hasMedia = false; // Flag to check if any media exists
            
            foreach ($photo_categories as $category => $title):
                if (!empty($media[$category])):
                    $photos = explode(',', $media[$category]);
                    $hasMedia = true; // Set flag to true if media exists
                    ?>
                    <div class="photo-section">
                        <h4 class="photo-category" style="color: #545f71;"><?= $title ?></h4>
                        <div class="photo-grid">
                            <?php foreach ($photos as $index => $photo):
                                if (!empty(trim($photo))):
                                    $photo_path = $target_dir . trim($photo);
                                    if ($index < 4) { ?>
                                        <div class="photo-box">
                                            <img src="<?= $photo_path ?>" class="photo-thumbnail"
                                                onclick="openPhotoViewer('<?= $photo_path ?>')">
                                            <?php if ($index == 3) { ?>
                                                <div class="overlay" onclick="openPhotoViewer('<?= $photo_path ?>')">
                                                    <span>More Images</span>
                                                </div>
                                            <?php } ?>
                                        </div>
                                    <?php }
                                endif;
                            endforeach; ?>
                        </div>
                    </div>
                <?php endif;
            endforeach;

            // Show message if no media exists
            if (!$hasMedia): ?>
                <p class="text-center text-muted mt-3">No media found for this school.</p>
            <?php endif; ?>
        </div>


        <!-- Modal for Full-Size Images -->
        <div class="modal fade" id="photoViewerModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Image Preview</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body text-center">
                        <span class="nav-arrow prev-photo" onclick="navigatePhoto(-1)">&#10094;</span>
                        <img id="modalPhoto" class="img-fluid" src="" alt="Full Image">
                        <span class="nav-arrow next-photo" onclick="navigatePhoto(1)">&#10095;</span>
                    </div>
                </div>
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

    </div>

    <!-- Sidebar -->
    <div class="sidebar-container" style="margin-top: 25px;">

        <!-- apply now section -->
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
                    <a href="javascript:void(0);" onclick="redirectTodetails(<?php echo $school['id']; ?>)"
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

        <!-- sidebar video -->
        <div class="sidebar-video mt-4">
            <h5>Step by Step Guide to Applying</h5>
            <iframe width="560" height="315" src="https://www.youtube.com/embed/Video-id" frameborder="0"
                allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen>
            </iframe>
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
                                <h4 style="color:#555959;"><?php echo htmlspecialchars($school['name']); ?></h4>
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

    <!-- click on applynow button rediect to admission tab -->
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            document.getElementById("applyNowBtns").addEventListener("click", function (event) {
                event.preventDefault(); // Default link behavior रोकें

                let admissionTab = document.getElementById('admission-tab');
                let admissionPane = document.getElementById('admission');

                if (admissionTab && admissionPane) {
                    // बाकी टैब्स को डी-एक्टिवेट करें
                    document.querySelectorAll(".nav-link").forEach(tab => tab.classList.remove("active"));
                    document.querySelectorAll(".tab-pane").forEach(pane => pane.classList.remove("show", "active"));

                    // Admission टैब को एक्टिव करें
                    admissionTab.classList.add("active");
                    admissionPane.classList.add("show", "active");
                }
            });
        });
    </script>

    <!-- JavaScript for photo Modal -->
    <script>
        let allPhotos = [];
        let currentPhotoIndex = 0;

        function openPhotoViewer(photo) {
            allPhotos = Array.from(document.querySelectorAll(".photo-thumbnail:not(.more-images-overlay)")).map(img => img.src);
            currentPhotoIndex = allPhotos.indexOf(photo);

            if (currentPhotoIndex === -1) {
                allPhotos.push(photo); // Ensure the clicked photo is added
                currentPhotoIndex = allPhotos.length - 1;
            }

            updatePhoto();
            $('#photoViewerModal').modal('show');
        }

        function navigatePhoto(step) {
            currentPhotoIndex += step;
            if (currentPhotoIndex < 0) currentPhotoIndex = allPhotos.length - 1;
            if (currentPhotoIndex >= allPhotos.length) currentPhotoIndex = 0;
            updatePhoto();
        }

        function updatePhoto() {
            let modalPhoto = document.getElementById("modalPhoto");
            if (allPhotos[currentPhotoIndex]) {
                modalPhoto.src = allPhotos[currentPhotoIndex];
            }
        }
    </script>

    <!-- parents also aplied sidebar js -->
    <script>
        function redirectTodetails(schoolId) {
            window.location.href = '../pages/viewschool-details.php?id=' + schoolId;
        }
    </script>

    <!-- similar school sidebar js -->
    <script>
        function redirectToSimilar(schoolId) {
            window.location.href = '../pages/viewschool-details.php?id=' + schoolId;
        }
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>