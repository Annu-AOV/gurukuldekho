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


    // Check if user is logged in and fetch details
    $user_phone = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null;
    $user = [];

    if ($user_phone) {
        $query = "SELECT name, email, phone FROM user_log WHERE phone = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("s", $user_phone);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $user = $result->fetch_assoc();
        }
    }


    // Form submit hone ke baad enquiry process karna
    // if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['enquiry_form'])) {
    
    //     $name = isset($_POST['name']) ? trim($_POST['name']) : '';
    //     $email = isset($_POST['email']) ? trim($_POST['email']) : '';
    //     $phone = isset($_POST['phone']) ? trim($_POST['phone']) : '';
    //     $class = isset($_POST['class']) ? trim($_POST['class']) : '';
    //     $school_id = isset($_POST['school_id']) ? intval($_POST['school_id']) : 0;

    //     // School name fetch karna
    //     $school_name = "";
    //     $school_query = "SELECT name FROM schools WHERE id = $school_id";
    //     $school_result = $conn->query($school_query);
    //     if ($school_result->num_rows > 0) {
    //         $school_row = $school_result->fetch_assoc();
    //         $school_name = $school_row['name'];
    //     }

    //     // Enquiry save karna
    //     $insert_query = "INSERT INTO school_admission_enquiries (name, email, phone, class, school_name) 
    //                  VALUES ('$name', '$email', '$phone', '$class', '$school_name')";
    //     if ($conn->query($insert_query)) {
    //         echo "<script>alert('Enquiry submitted successfully!');</script>";
    //         // Resetting the values
    //         $name = '';
    //         $email = '';
    //         $phone = '';
    //         $class = '';
    //         $school_name = '';

    //         // Optionally, you can unset them if you don't need them at all:
    //         unset($name, $email, $phone, $class, $school_name);


    //     } else {
    //         echo "<script>alert('Error submitting enquiry!');</script>";
    //     }
    //     // if ($conn->query($insert_query) === TRUE) {
    //     //     echo json_encode(["status" => "success", "message" => "Your request has been submitted successfully!"]);
    //     // } else {
    //     //     echo json_encode(["status" => "error", "message" => "Error: " . $conn->error]);
    //     // }
    // }

    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['enquiry_form'])) {
        // Sanitize and fetch form data
        $name = isset($_POST['name']) ? trim($_POST['name']) : '';
        $email = isset($_POST['email']) ? trim($_POST['email']) : '';
        $phone = isset($_POST['phone']) ? trim($_POST['phone']) : '';
        $class = isset($_POST['class']) ? trim($_POST['class']) : '';
        $school_id = isset($_POST['school_id']) ? intval($_POST['school_id']) : 0;
    
        // Fetch school name
        $school_name = "";
        $school_query = "SELECT name FROM schools WHERE id = ?";
        if ($stmt = $conn->prepare($school_query)) {
            $stmt->bind_param("i", $school_id);
            $stmt->execute();
            $stmt->bind_result($school_name);
            $stmt->fetch();
            $stmt->close();
        }
    
        // Insert enquiry into the database using a prepared statement
        $insert_query = "INSERT INTO school_admission_enquiries (name, email, phone, class, school_name) 
                         VALUES (?, ?, ?, ?, ?)";
        
        if ($stmt = $conn->prepare($insert_query)) {
            $stmt->bind_param("sssss", $name, $email, $phone, $class, $school_name);
    
            if ($stmt->execute()) {
              
                // After successful form submission, redirect to avoid form resubmission on page refresh
                header("Location: " . $_SERVER['REQUEST_URI']); // Redirect to the same page
                echo "<script>alert('Enquiry submited successfully!');</script>";
                exit; // Terminate the script to avoid further processing
            } else {
                echo "<script>alert('Error submitting enquiry!');</script>";
            }
            $stmt->close();
        }
    }
    

    // Fetch classes for the selected school enquiry section
    $classes = [];
    if ($school_id) {
        $query = "SELECT DISTINCT class FROM admissions WHERE school_id = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("i", $school_id);
        $stmt->execute();
        $result = $stmt->get_result();
        while ($row = $result->fetch_assoc()) {
            $classes[] = $row['class'];
        }
    }


    // Fetch admission details
    $admission_query = "SELECT class, session, last_application_date, application_fee FROM admissions WHERE school_id = ?";
    $stmt = $conn->prepare($admission_query);
    $stmt->bind_param("i", $school_id);
    $stmt->execute();
    $admission_result = $stmt->get_result();

    // Fetch the documents for the selected school
    $document_query = "SELECT * FROM school_documents WHERE school_id = '$school_id'";
    $document_result = mysqli_query($conn, $document_query);

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

    // Initialize admission process variable
    $admission_process = "";

    // Fetch admission process from the database
    $sql = "SELECT admission_process FROM admissions WHERE school_id = ? LIMIT 1";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $school_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($row = $result->fetch_assoc()) {
        $admission_process = $row['admission_process'];
    }


    // Initialize admissions data array
    $admissionsData = [];

    if ($school_id > 0) {
        // Fetch admissions data for the selected school
        $sql = "SELECT class, start_date, end_date 
            FROM admissions 
            WHERE school_id = ? 
            ORDER BY class";

        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $school_id);
        $stmt->execute();
        $result = $stmt->get_result();

        while ($row = $result->fetch_assoc()) {
            $admissionsData[] = $row; // Store data in an array
        }

        $stmt->close();
    }

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
    <title>School Admission Tab</title>
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap & Font Awesome -->
    <script src="https://kit.fontawesome.com/a076d05399.js"></script>


    <!-- fill admission form css -->
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
    </style>

    <!-- sidebar photo section -->
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

        <!-- fill admission form section -->
        <div class="fiil-addmission p-4 bg-white shadow rounded">
            <!-- <div class="content-container"> -->
            <?php if ($school): ?>
                <h6 style="font-weight: 400;
                  font-size: 12px;
              line-height: 14px;
                  margin-bottom: 4px;
                  color: #8a8a8a;"><?php echo htmlspecialchars($school['name']); ?> </h6>
                <h4 style="color: #545f71;font-weight: 700;
                 line-height: 20px; border-left: 5px solid #007bff;padding-left: 10px;">Fill Admission Form
                    <span class="ml-2" style="font-weight:500;">|</span>
                    <span class="badge" style="margin-left: 60px;
                 color: #545f71;
                  background-color: #e2fff1;
                 padding: 3px 10px;
                 font-size: 14px;
                 font-weight: 600;
                  letter-spacing: -.02em;
                  cursor: pointer;"><i class="bi bi-mortarboard-fill" style="margin-right: 8px;
                  color: green;"></i>Application Partner</span>
                </h4>

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
                                <tr class="<?php echo ($admission_count >= 4) ? 'd-none admissions-row' : ''; ?>">
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
                                    <button id="toggle-admissions-btns" class="btn btn-link">See All Classes</button>
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                </div>

            <?php endif; ?> <!-- Closing the PHP if condition -->
        </div>

        <!-- School Documents Section -->
        <div class="mt-4">
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

        <!-- Admission date section -->
        <div class="container mt-4 p-4 bg-white shadow rounded">
            <small style="font-weight: 400; font-size: 12px; line-height: 14px; margin-bottom: 4px; color: #8a8a8a;">
                <?php echo htmlspecialchars($school['name']); ?></small>
            <h4 class="fw-bold" style="border-left: 5px solid #007bff;
               padding-left: 10px;  color: #545f71; margin-top: 2px;">Admission Dates</h4>

            <div class="mt-3">
                <?php if (!empty($admissionsData)) { ?>
                    <div class="table-responsive">
                        <table class="table table-bordered text-center">
                            <thead class="table-primary">
                                <tr>
                                    <th style="color:#4b4a49;">Class</th>
                                    <th style="color:#4b4a49;">Start Date</th>
                                    <th style="color:#4b4a49;">Last Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($admissionsData as $row) { ?>
                                    <tr>
                                        <td class="fw-bold" style="color:#6c757d;"><?= htmlspecialchars($row['class']); ?></td>
                                        <td style="color:#6c757d;"><?= date("d M, Y", strtotime($row['start_date'])); ?></td>
                                        <td style="color:#6c757d;"><?= date("d M, Y", strtotime($row['end_date'])); ?></td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                <?php } else { ?>
                    <p class="text-danger">No admission data available for this session.</p>
                <?php } ?>
            </div>
        </div>

        <!-- Admission Process Section -->
        <div class="container mt-4 p-4 bg-white shadow rounded">
            <small style="font-weight: 400; font-size: 12px; line-height: 14px; margin-bottom: 4px; color: #8a8a8a;">
                <?php echo htmlspecialchars($school['name']); ?></small>
            <h4 class="fw-bold"
                style="border-left: 5px solid #007bff; padding-left: 10px; color: #545f71; margin-top: 2px;">Admission
                Process</h4>

            <?php if (!empty($admission_process)) { ?>
                <div id="admissionContent" class="mt-3">
                    <p class="text" style="color:#6c757d;">
                        <?= nl2br(htmlspecialchars($admission_process)); ?>
                    </p>
                </div>

                <!-- Show More / Show Less Button -->
                <div class="text-center mt-3">
                    <button id="toggleButton" class="btn btn-link text-primary fw-bold">
                        See More <i class="fas fa-chevron-down"></i>
                    </button>
                </div>
            <?php } else { ?>
                <p class="text-danger">No admission process available for this school.</p>
            <?php } ?>
        </div>

        <!-- Enquire About Admissions section -->
        <div class="enuire-about-admission mt-4">
            <div class="card p-4 shadow rounded" style="border: none;">
                <small
                    style="font-weight: 400; font-size: 12px; line-height: 14px; margin-bottom: 4px; color: #8a8a8a;">
                    <?php echo htmlspecialchars($school['name']); ?></small>
                <h4 class="fw-bold mb-3"
                    style="border-left: 5px solid #007bff; padding-left: 10px; color: #545f71; margin-top: 2px;">Enquire
                    About Admissions</h4>
                <form method="POST">
                    <input type="hidden" name="school_id" value="<?= $school_id; ?>">

                    <div class="row g-3">
                        <div class="col-md-6">
                            <input type="text" name="name" class="form-control"
                                value="<?= isset($user['name']) ? htmlspecialchars($user['name']) : ''; ?>"
                                placeholder="Enter Name" required>
                        </div>
                        <div class="col-md-6">
                            <input type="text" name="phone" class="form-control"
                                value="<?= isset($user['phone']) ? htmlspecialchars($user['phone']) : ''; ?>"
                                placeholder="Enter Phone Number" required readonly>
                        </div>
                        <div class="col-md-6">
                            <input type="email" name="email" class="form-control"
                                value="<?= isset($user['email']) ? htmlspecialchars($user['email']) : ''; ?>"
                                placeholder="Enter Email" required>
                        </div>
                        <div class="col-md-6">
                            <select name="class" class="form-control" required>
                                <option value="">Select Class</option>
                                <?php foreach ($classes as $class): ?>
                                    <option value="<?= $class; ?>"><?= $class; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-md-12 text-end">
                            <button type="submit"  name="enquiry_form" class="btn btn-primary">Submit</button>
                        </div>
                    </div>
                </form>
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
            <div class="photos-sections mt-4">
                <small style="font-weight: 400; font-size: 12px; line-height: 14px; margin-bottom: 4px; color: #8a8a8a;">
                    <?php echo htmlspecialchars($school['name']); ?></small>
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
                    <a href="javascript:void(0);" onclick="redirecttodetail(<?php echo $school['id']; ?>)"
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

    <!-- JavaScript for Show More / Show Less (Admission process)-->
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            let content = document.getElementById("admissionContent");
            let button = document.getElementById("toggleButton");

            if (content.innerHTML.length > 300) {
                content.style.maxHeight = "100px";
                content.style.overflow = "hidden";

                button.addEventListener("click", function () {
                    if (content.style.maxHeight === "100px") {
                        content.style.maxHeight = "none";
                        button.innerHTML = "See Less <i class='fas fa-chevron-up'></i>";
                    } else {
                        content.style.maxHeight = "100px";
                        button.innerHTML = "See More <i class='fas fa-chevron-down'></i>";
                    }
                });
            } else {
                button.style.display = "none";
            }
        });
    </script>

    <!-- js for fill admission form see all classes/see less -->
    <script>
        // Toggle Admissions Table Rows
        document.getElementById('toggle-admissions-btns').addEventListener('click', function () {
            const rows = document.querySelectorAll('.admissions-row');
            const button = this;

            rows.forEach(row => row.classList.toggle('d-none'));

            button.textContent = (button.textContent === 'See All Classes') ? 'See Less' : 'See All Classes';
        });
    </script>

    <!-- parents also aplied sidebar js -->
    <script>
        function redirecttodetail(schoolId) {
            window.location.href = '../pages/viewschool-details.php?id=' + schoolId;
        }
    </script>

    <!-- parents also aplied sidebar js -->
    <script>
        function redirectToSimilar(schoolId) {
            window.location.href = '../pages/viewschool-details.php?id=' + schoolId;
        }
    </script>
</body>

</html>