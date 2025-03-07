<?php
session_start();
// Include necessary files
include('../includes/header2.php');   //for school view

// Get the school ID from the URL
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $schoolId = $_GET['id'];

    // Connect to the database
    include('../admin/includes/db_connect.php'); // Ensure you have a valid database connection file

    // Increment views if not already visited in this session
    if (!isset($_SESSION['visited_schools'])) {
        $_SESSION['visited_schools'] = [];
    }

    if (!in_array($schoolId, $_SESSION['visited_schools'])) {
        $update_query = "UPDATE schools SET views = views + 1 WHERE id = ?";
        $stmt = $conn->prepare($update_query);
        $stmt->bind_param("i", $schoolId);
        $stmt->execute();

        $_SESSION['visited_schools'][] = $schoolId;
    }

    // Extracting school ID
    $school_id = isset($_GET['id']) ? intval($_GET['id']) : 0;
    $school = [];
    $city_name = '';

    // Fetch school details if school_id is valid
    if ($school_id > 0) {
        $query = "SELECT s.*, c.city_name FROM schools s LEFT JOIN city c ON s.city_id = c.id WHERE s.id = $school_id";
        $result = mysqli_query($conn, $query);
        if ($result) {
            $school = mysqli_fetch_assoc($result);
            $city_name = $school['city_name'] ?? 'Unknown City';
        }
    }

    $query = "
    SELECT 
        schools.id, 
        schools.name, 
        schools.address, 
        city.city_name, 
        city.pincode, 
        city.state, 
        schools.affiliate, 
        schools.estd, 
        schools.views, 
        schools.photo, 
        schools.class_minimum, 
        schools.class_maximum 
    FROM 
        schools 
    LEFT JOIN 
        city 
    ON 
        schools.city_id = city.city_name 
    WHERE 
        schools.id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $schoolId);
    $stmt->execute();
    $result = $stmt->get_result();

    // Check if the school exists
    if ($result->num_rows > 0) {
        $school = $result->fetch_assoc();
    } else {
        echo "<div class='alert alert-danger'>School not found.</div>";
        exit;
    }
} else {
    echo "<div class='alert alert-danger'>Invalid School ID.</div>";
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>School Details</title>
    <!-- Add any additional CSS if needed -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">

    <style>
        /* <?php include('path-to-your-css-file.css'); ?>
        Adjust the path */ .school-header-section {
            background-color: #747070;
            /* Adjust as needed */
            padding: 15px;
            color: white;
            /* border-radius: 8px; */
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .school-logo {
            width: 100px;
            height: 100px;
            /* object-fit: contain; */
            border-radius: 4px;
            box-shadow: 0 0 6px 0 rgba(0, 0, 0, .16078);
        }

        .school-name {
            font-size: 20px;
            font-weight: 600;
            margin: 0;
            color: white;
        }

        .school-address {
            font-size: 14px;
            color: white;
            font-weight: 400;
            margin-bottom: 0;
        }

        .school-info-list {
            list-style: none;
            padding: 0;
            margin: 5px 0 0;
            display: flex;
            gap: 10px;
            font-size: 16px;
            flex-wrap: wrap;
            color: #777;
        }

        .school-info-list li {
            position: relative;
            padding-left: 15px;
            color: white;
        }

        .school-info-list li i {
            margin-right: 5px;
        }

        /* .school-info-list li::before {
            content: "•";
            position: absolute;
            left: 0;
            color: #007bff;
            /* Adjust bullet color 
        } */

        .bib::before {
            position: absolute;
            left: 0;
            color: white;
            /* Adjust bullet color*/
            margin-top: 5px;
        }

        .badge {
            display: inline-block;
            font-size: 12px;
            color: #fff;
            padding: 5px 10px;
            border-radius: 15px;
            margin-right: 5px;
        }

        .badge.application-partner {
            background-color: rgb(248, 248, 248);
            color: black;
            border-radius: 5px;
            /* padding: 2px 0; */
            border: 2px solid #f6e6a7;
            /* margin-left: 160px;
            margin-bottom: 30px;
            position: absolute; */
        }

        .badge.verified-by-school {
            background-color: rgb(248, 248, 248);
            color: black;
            border: 2px solid #f6e6a7;
        }

        .action-buttons .btn {
            font-size: 14px;
            padding: 8px 40px;
            margin-left: 5px;
        }

        .apply-now-btn {
            background-color: #007bff;
            border-color: #007bff;
            margin-top: 60px;
            /* margin-right: 55px; */
        }

        .compare-btn {
            background-color: white;
            border-color: blue;
            margin-top: 57px;
            color: black;
        }

        .application-note {
            font-size: 12px;
            color: #28a745;
        }

        .application-note i {
            margin-right: 5px;
        }
    </style>

    <style>
        /* Badge styling */
        .badge-wrapper {
            position: relative;
            display: inline-block;
        }

        .badge {
            background-color: #007bff;
            color: #fff;
            padding: 5px 10px;
            border-radius: 12px;
            font-size: 14px;
            cursor: pointer;
        }

        /* Popup styling */
        .popup-content {
            position: absolute;
            top: 100%;
            /* Position below the badge */
            left: 10%;
            /* transform: translateX(-50%); */
            transform: translateX(-50%) translateX(-10px);
            /* Center and move left */
            width: 250px;
            background: #fff;
            color: #333;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.2);
            border-radius: 8px;
            padding: 10px;
            z-index: 10;
            opacity: 0;
            visibility: hidden;
            transition: opacity 0.3s ease, visibility 0.3s ease;
        }

        /* Popup header */
        .popup-header {
            font-size: 16px;
            font-weight: 700;
            line-height: 1.2;
            margin-bottom: 8px;
            color: #007bff;
            background-color: #f7f7f7;
            border-bottom: 1px solid #ebebeb;
            font-family: Poppins, sans-serif;
        }

        /* Popup text */
        .popup-text {
            font-size: 14px;
            line-height: 1.5;
            color: #212529;
            padding: .5rem .75rem;
        }

        .compare-btn:hover {
            background: #135da0;
            color: white;
        }

        /* Show the popup on hover */
        .badge-wrapper:hover .popup-content {
            opacity: 1;
            visibility: visible;
        }

        @media (max-width: 768px) {

            /* Logo and Text Scaling */
            .school-logo {
                width: 75px;
                height: 75px;
            }

            .school-name {
                font-size: 20px;
            }

            .school-address {
                font-size: 14px;
            }

            /* Adjusting Info List for Stacking */
            .school-info-list {
                flex-direction: column;
                font-size: 14px;
            }

            /* Buttons Stacking */
            .action-buttons {
                display: flex;
                flex-direction: column;
                align-items: flex-start;
                gap: 10px;
            }

            .badge {
                font-size: 12px;
                padding: 5px 8px;
            }

            .popup-content {
                width: 90%;
            }
        }
    </style>

    <!-- Add CSS -->
    <style>
        .sticky-tabs {
            position: sticky;
            top: 60px;
            z-index: 1000;
            background-color: white;
            padding: 10px 0;
            box-shadow: 0px 2px 5px rgba(0, 0, 0, 0.1);
        }

        .nav-tabs .nav-link {
            color: #333;
            font-weight: 500;
        }

        .nav-tabs .nav-link.active {
            color: #007bff;
            font-weight: bold;
            border-bottom: 3px solid #007bff;
        }
    </style>
</head>

<body style="background-color: #f5f5f5;">

    <div class="container-fluid" style="padding-left:0;padding-right:0;">

        <!-- School view card -->
        <section class="school-header-section">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb"
                    style="color:#fff; text-decoration:none;font-size: 12px;font-weight: 500;margin-bottom:0">
                    <li class="breadcrumb-item"><a href="home-page.php"
                            style="color:#fff; text-decoration:none;font-size: 12px;font-weight: 500;">Home</a></li>

                    <li class="breadcrumb-item"><a href="#"
                            style="color:#fff; text-decoration:none;font-size: 12px;font-weight: 500;"><?php echo htmlspecialchars($city_name); ?></a>
                    </li>

                    <li class="breadcrumb-item active" aria-current="page"
                        style="color:#fff; text-decoration:none;    font-size: 12px; font-weight: 500;">
                        <?php echo htmlspecialchars($school['name'] ?? 'Unknown School'); ?>
                    </li>
                </ol>
            </nav>
            <div class="container">
                <div class="row align-items-center">
                    <!-- Left Section -->
                    <div class="col-md-8 d-flex align-items-center">
                        <!-- School Logo -->
                        <img src="<?php echo htmlspecialchars($school['photo']); ?>" alt="School Logo"
                            class="school-logo me-3">
                        <!-- School Details -->
                        <div>
                            <h3 class="school-name"><?php echo htmlspecialchars($school['name']); ?></h3>
                            <p class="school-address"><i class="fas fa-map-marker-alt"
                                    style="margin-right:5px;"></i><?php echo htmlspecialchars($school['address']); ?></p>
                            <ul class="school-info-list">
                                <li><i
                                        class="bib bi-book-fill"></i><?php echo htmlspecialchars($school['affiliate']); ?>
                                </li>
                                <li><i
                                        class="bib bi-building-fill"></i><?php echo htmlspecialchars($school['class_minimum'] . " - " . $school['class_maximum'] . " Class"); ?>
                                </li>
                                <li><i
                                        class="bib bi-pin-fill"></i><?php echo "Estd. " . htmlspecialchars($school['estd']); ?>
                                </li>

                            </ul>
                            <ul class="school-info-list">
                                <li style="padding-left:0 !important;"><i
                                        class="bi bi-eye-fill"></i><?php echo "Views: " . (isset($school['views']) ? $school['views'] : 0); ?>
                                </li>
                            </ul>
                        </div>
                    </div>

                    <!-- Right Section -->
                    <div class="col-md-4 text-end">
                        <!-- <div class="badges mb-2"> -->
                        <div class="badge-wrapper">

                            <span class="badge application-partner application-partner-tooltip" data-bs-toggle="tooltip"
                                data-bs-html="true"
                                title="<b>Application Partner</b><br>This is to confirm that Ezyschooling is the Official Application Partner and is rightly sanctioned to accept your application on behalf of the school. Please note that when you submit your application form, it gets directly submitted to the school.">
                                <i class="bi bi-mortarboard-fill" style="margin-right: 8px; color: green;"></i>
                                Application Partner
                            </span>

                            <span class="badge verified-by-school"><i class="bi bi-check-circle-fill"
                                    style="color:green; margin-right:5px"></i>Verified By School</span>
                        </div>
                        <div class="action-buttons">
                            <button class="btn btn-primary apply-now-btn"
                                style="font-weight: 600;background-color: #1564ab;border-color: #135da0;">
                                Apply Now
                            </button>

                            <button class="btn btn-secondary compare-btn"
                                style="background: #fff2f2; color: #135da0;border-color: #135da0;">Compare</button>
                        </div>
                        <p class="application-note mt-2" style="color:white;font-size: 80%; font-weight: 400;">
                            ⭐ Accepting applications through GurukulDekho
                        </p>
                    </div>

                </div>
            </div>
        </section>

        <!-- Extracting school id -->
        <?php
        // School ID ensure kar lo
        $school_id = isset($_GET['id']) ? intval($_GET['id']) : 0;
        // Fetch school details based on the ID
        // (Assuming you have a database connection)
        $school = []; // Default empty array
        if ($school_id > 0) {
            $query = "SELECT * FROM schools WHERE id = $school_id";
            $result = mysqli_query($conn, $query);
            $school = mysqli_fetch_assoc($result);
        }
        ?>

        <!-- Tab Menu -->
        <ul class="nav nav-tabs sticky-tabs" id="schoolTabs" role="tablist">
            <li class="nav-item" role="presentation"
                style="cursor: pointer;font-size: 16px;font-weight: 600;color:  #545f71 !important;">
                <button class="nav-link active" id="overview-tab" data-bs-toggle="tab" data-bs-target="#overview"
                    type="button" role="tab" aria-controls="overview" aria-selected="true">
                    Overview
                </button>
            </li>
            <li class="nav-item" role="presentation"
                style="cursor: pointer;font-size: 16px;font-weight: 600;color:  #545f71 !important;">
                <button class="nav-link" id="admission-tab" data-bs-toggle="tab" data-bs-target="#admission"
                    type="button" role="tab" aria-controls="admission" aria-selected="false">
                    Admission
                </button>
            </li>
            <li class="nav-item" role="presentation"
                style="cursor: pointer;font-size: 16px;font-weight: 600;color:  #545f71 !important;">
                <button class="nav-link" id="fee-structure-tab" data-bs-toggle="tab" data-bs-target="#fee-structure"
                    type="button" role="tab" aria-controls="fee-structure" aria-selected="false">
                    Fee Structure
                </button>
            </li>
            <li class="nav-item" role="presentation"
                style="cursor: pointer;font-size: 16px;font-weight: 600;color:  #545f71 !important;">
                <button class="nav-link" id="photo-tab" data-bs-toggle="tab" data-bs-target="#photo" type="button"
                    role="tab" aria-controls="photo" aria-selected="false">
                    Photo
                </button>
            </li>
            <!-- <li class="nav-item" role="presentation"
                style="cursor: pointer;font-size: 16px;font-weight: 600;color:  #545f71 !important;">
                <button class="nav-link" id="reviews-tab" data-bs-toggle="tab" data-bs-target="#reviews" type="button"
                    role="tab" aria-controls="reviews" aria-selected="false">
                    Reviews
                </button>
            </li> -->
            <li class="nav-item" role="presentation"
                style="cursor: pointer;font-size: 16px;font-weight: 600;color:  #545f71 !important;">
                <button class="nav-link" id="reviews-tab" data-bs-toggle="tab" data-bs-target="#reviews" type="button"
                    role="tab" aria-controls="reviews" aria-selected="false">
                    Reviews
                </button>
            </li>
        </ul>

        <!-- Tab Content -->
        <div class="tab-content border" id="schoolTabsContent">
            <!-- Overview Tab -->
            <div class="tab-pane fade show active" id="overview" role="tabpanel" aria-labelledby="overview-tab">
                <?php include '../pages/school-overview.php'; ?>
            </div>
            <!-- Admission Tab -->
            <div class="tab-pane fade" id="admission" role="tabpanel" aria-labelledby="admission-tab">
                <?php include '../pages/school-admissiontab.php'; ?>
            </div>
            <!-- Fee Structure Tab -->
            <div class="tab-pane fade" id="fee-structure" role="tabpanel" aria-labelledby="fee-structure-tab">
                <?php include '../pages/school-feeStructTab.php'; ?>
            </div>
            <!-- Photo Tab -->
            <div class="tab-pane fade" id="photo" role="tabpanel" aria-labelledby="photo-tab">
                <?php include '../pages/school-photoTab.php'; ?>
            </div>
            <!-- Reviews Tab -->
            <div class="tab-pane fade" id="reviews" role="tabpanel" aria-labelledby="reviews-tab">
                <?php include '../pages/school-reviewstab.php'; ?>
            </div>
        </div>

    </div>

    <!-- Switching window -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const tabs = document.querySelectorAll('.nav-link');
            const tabContent = document.querySelectorAll('.tab-pane');

            tabs.forEach(tab => {
                tab.addEventListener('click', function (e) {
                    e.preventDefault();

                    // Deactivate all tabs and tab contents
                    tabs.forEach(t => t.classList.remove('active'));
                    tabContent.forEach(content => content.classList.remove('show', 'active'));

                    // Activate the clicked tab and its corresponding content
                    tab.classList.add('active');
                    const targetContent = document.querySelector(tab.getAttribute('data-bs-target'));
                    targetContent.classList.add('show', 'active');
                });
            });
        });
    </script>

    <!-- Smooth Scrolling -->
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            document.querySelectorAll('.nav-link').forEach(anchor => {
                anchor.addEventListener('click', function (e) {
                    e.preventDefault();
                    const targetId = this.getAttribute("href").substring(1);
                    const targetElement = document.getElementById(targetId);
                    if (targetElement) {
                        window.scrollTo({
                            top: targetElement.offsetTop - 60,
                            behavior: "smooth"
                        });
                    }
                });
            });
        });
    </script>

    <!-- voice search mic -->
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

    <!-- applynow button by click redirect to admission tab -->
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            // सभी "Apply Now" बटन सेलेक्ट करें
            document.querySelectorAll(".apply-now-btn").forEach(button => {
                button.addEventListener("click", function (event) {
                    event.preventDefault(); // Default action रोकें

                    let admissionTab = document.getElementById('admission-tab');
                    let admissionPane = document.getElementById('admission');

                    if (admissionTab && admissionPane) {
                        // सभी टैब्स को इनएक्टिव करें
                        document.querySelectorAll(".nav-link").forEach(tab => tab.classList.remove("active"));
                        document.querySelectorAll(".tab-pane").forEach(pane => pane.classList.remove("show", "active"));

                        // "Admission" टैब को एक्टिव करें
                        admissionTab.classList.add("active");
                        admissionPane.classList.add("show", "active");
                    }
                });
            });
        });
    </script>

    <!-- admission partner tootip hover js -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
            var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl);
            });
        });
    </script>



</body>
<?php include('../includes/footer.php'); ?>

</html>