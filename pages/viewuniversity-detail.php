<?php
session_start();
// Include necessary files
include('../includes/header2.php');   //for school view
// include('../includes/sidebar.php');


// Get the school ID from the URL
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $universityId = $_GET['id'];

    // Connect to the database
    include('../admin/includes/db_connect.php'); // Ensure you have a valid database connection file

    // Increment views if not already visited in this session
    if (!isset($_SESSION['visited_universities'])) {
        $_SESSION['visited_universities'] = [];
    }

    if (!in_array($universityId, $_SESSION['visited_universities'])) {
        $update_query = "UPDATE universities SET views = views + 1 WHERE id = ?";
        $stmt = $conn->prepare($update_query);
        $stmt->bind_param("i", $universityId);
        $stmt->execute();

        $_SESSION['visited_schools'][] = $universityId;
    }


    // Fetch data from the database
    // $query = "SELECT id, name, address, city, affiliate, estd, views, photo, class_minimum, class_maximum 
    //       FROM schools 
    //        WHERE id = ?";
    // $stmt = $conn->prepare($query);
    // $stmt->bind_param("i", $schoolId);
    // $stmt->execute();
    // $result = $stmt->get_result();

    $query = "
    SELECT 
        universities.id, 
        universities.university_name, 
        universities.address, 
        city.city_name, 
        city.pincode, 
        city.state, 
       universities.affiliate, 
        universities.estd, 
       universities.views, 
        universities.photo, 
        universities.class_minimum, 
        universities.class_maximum 
    FROM 
       universities 
    LEFT JOIN 
        city 
    ON 
        universities.city_id = city.city_name 
    WHERE 
        universities.id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $universityId);
    $stmt->execute();
    $result = $stmt->get_result();


    // Format the class range
    // $formattedClass = $school['class_minimum'] . " - " . $school['class_maximum'] . " Class";

    // Check if the school exists
    if ($result->num_rows > 0) {
        $university = $result->fetch_assoc();
    } else {
        echo "<div class='alert alert-danger'>Universitu not found.</div>";
        exit;
    }
} else {
    echo "<div class='alert alert-danger'>Invalid University ID.</div>";
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

    <style>
        /* <?php include('path-to-your-css-file.css'); ?>
        Adjust the path */ .university-header-section {
            background-color: #747070;
            /* Adjust as needed */
            padding: 15px;
            color: white;
            /* border-radius: 8px; */
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .university-logo {
            width: 94px;
            height: 94px;
            object-fit: contain;
            border-radius: 4px;
            box-shadow: 0 0 6px 0 rgba(0, 0, 0, .16078);
        }

        .university-name {
            font-size: 24px;
            font-weight: 600;
            margin: 0;
            color: white;
        }

        .university-address {
            font-size: 18px;
            color: white;

        }

        .university-info-list {
            list-style: none;
            padding: 0;
            margin: 5px 0 0;
            display: flex;
            gap: 10px;
            font-size: 16px;
            flex-wrap: wrap;
            color: #777;
        }

        .university-info-list li {
            position: relative;
            padding-left: 15px;
            color: white;
        }

        .university-info-list li i {
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

        .badges .badge {
            display: inline-block;
            font-size: 12px;
            color: #fff;
            padding: 5px 10px;
            border-radius: 15px;
            margin-right: 5px;
        }

        .badge.application-partner {
            background-color: #007bff;
            /* Blue */
        }

        .badge.verified-by-school {
            background-color: #28a745;
            /* Green */
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

        /* Show the popup on hover */
        .badge-wrapper:hover .popup-content {
            opacity: 1;
            visibility: visible;
        }

        @media (max-width: 768px) {

            /* Logo and Text Scaling */
            .university-logo {
                width: 75px;
                height: 75px;
            }

            .university-name {
                font-size: 20px;
            }

            .university-address {
                font-size: 14px;
            }

            /* Adjusting Info List for Stacking */
            .university-info-list {
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
    </style>
</head>

<body>
    <div class="container-fluid">
        <section class="university-header-section" style="margin-top: 5px;">
            <div class="container">
                <div class="row align-items-center">
                    <!-- Left Section -->
                    <div class="col-md-8 d-flex align-items-center">
                        <!-- School Logo -->
                        <img src="<?php echo htmlspecialchars($university['photo']); ?>" alt="University Logo"
                            class="university-logo me-3">
                        <!-- School Details -->
                        <div>
                            <h2 class="university-name"><?php echo htmlspecialchars($university['university_name']); ?>
                            </h2>
                            <p class="university-address"><?php echo htmlspecialchars($university['address']); ?></p>
                            <ul class="university-info-list">
                                <li><i
                                        class="bib bi-book-fill"></i><?php echo htmlspecialchars($university['affiliate']); ?>
                                </li>
                                <li><i
                                        class="bib bi-building-fill"></i><?php echo htmlspecialchars($university['class_minimum'] . " - " . $university['class_maximum'] . " Class"); ?>
                                </li>
                                <li><i
                                        class="bib bi-pin-fill"></i><?php echo "Estd. " . htmlspecialchars($university['estd']); ?>
                                </li>

                            </ul>
                            <ul class="university-info-list">
                                <li><i
                                        class="bi bi-eye-fill"></i><?php echo "Views: " . (isset($university['views']) ? $university['views'] : 0); ?>
                                </li>
                            </ul>
                        </div>
                    </div>

                    <!-- Right Section -->
                    <div class="col-md-4 text-end">
                        <!-- <div class="badges mb-2"> -->
                        <div class="badge-wrapper">
                            <span class="badge application-partner">Application Partner</span>
                            <div class="popup-content">
                                <h5 class="popup-header text-start">Application Partner</h5>
                                <p class="popup-text text-start">
                                    This is to confirm that GurukulDekho is the Official Application Partner and is
                                    rightly sanctioned to accept your application on behalf of the school. Please note
                                    that when you submit your application form, it gets directly submitted to the
                                    university.
                                </p>
                            </div>
                            <span class="badge verified-by-university">Verified By University</span>
                        </div>
                        <div class="action-buttons">
                            <button class="btn btn-primary apply-now-btn">Apply Now</button>
                            <button class="btn btn-secondary compare-btn">Compare</button>
                        </div>
                        <p class="application-note mt-2">
                            <i class="bi bi-check-circle"></i> Accepting applications through GurukulDekho
                        </p>
                    </div>
                </div>
            </div>
        </section>
    </div>
</body>
<?php include('../includes/footer.php'); ?>

</html>