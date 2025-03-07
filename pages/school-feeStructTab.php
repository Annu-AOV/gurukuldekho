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

    // Default session set kar rahe hain agar koi session selected na ho
    $defaultSession = date("Y") . "-" . (date("Y") + 1);
    $session = isset($_GET['session']) ? $_GET['session'] : $defaultSession;

    // Session values fetch karna
    $sessionQuery = "SELECT DISTINCT session FROM fee_structure ORDER BY session DESC";
    $sessionResult = $conn->query($sessionQuery);

    if ($session) {
        $query = "SELECT * FROM fee_structure WHERE school_id = ? AND session = ?";
        $stmt = $conn->prepare($query);
        if ($stmt === false) {
            die("Prepare failed: " . $conn->error);
        }
        $stmt->bind_param("is", $school_id, $session);
        $stmt->execute();
        $result = $stmt->get_result();
    }
    $fees = [];
    while ($row = $result->fetch_assoc()) {
        $fees[$row['class']] = $row;
    }

    // Fetch admission details
    $admission_query = "SELECT class, session, last_application_date, application_fee FROM admissions WHERE school_id = ?";
    $stmt = $conn->prepare($admission_query);
    $stmt->bind_param("i", $school_id);
    $stmt->execute();
    $admission_result = $stmt->get_result();

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
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $name = isset($_POST['name']) ? trim($_POST['name']) : '';
        $email = isset($_POST['email']) ? trim($_POST['email']) : '';
        $phone = isset($_POST['phone']) ? trim($_POST['phone']) : '';
        $class = isset($_POST['class']) ? trim($_POST['class']) : '';
        $school_id = isset($_POST['school_id']) ? intval($_POST['school_id']) : 0;

        // School name fetch karna
        $school_name = "";
        $school_query = "SELECT name FROM schools WHERE id = $school_id";
        $school_result = $conn->query($school_query);
        if ($school_result->num_rows > 0) {
            $school_row = $school_result->fetch_assoc();
            $school_name = $school_row['name'];
        }

        // Enquiry save karna
        // $insert_query = "INSERT INTO school_admission_enquiries (name, email, phone, class, school_name) 
        //                  VALUES ('$name', '$email', '$phone', '$class', '$school_name')";
        // if ($conn->query($insert_query)) {
        //     echo "<script>alert('Enquiry submitted successfully!');</script>";
        // } else {
        //     echo "<script>alert('Error submitting enquiry!');</script>";
        // }

        // if ($conn->query($insert_query) === TRUE) {
        //     echo json_encode(["status" => "success", "message" => "Your request has been submitted successfully!"]);
        // } else {
        //     echo json_encode(["status" => "error", "message" => "Error: " . $conn->error]);
        // }

        // Enquiry save karna
        $insert_query = "INSERT INTO school_admission_enquiries (name, email, phone, class, school_name) 
VALUES ('$name', '$email', '$phone', '$class', '$school_name')";

        if ($conn->query($insert_query)) {
            echo json_encode(["status" => "success", "message" => "Enquiry submitted successfully!"]);
        } else {
            echo json_encode(["status" => "error", "message" => "Error submitting enquiry!"]);
        }
        exit;
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
    <!-- Bootstrap & FontAwesome (Include in your project if not already included) -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
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

        .fee-disclaimer p {
            padding-left: 4px;
            font-size: 12px;
            font-weight: 500;
            color: #7d8085;
            margin-bottom: 1rem;
        }

        td {
            color: #9ba5b7
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

    <!-- sidebar similar school section -->
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

        /* Reduce modal background opacity */
        .modal-backdrop {
            background-color: rgba(0, 0, 0, 0.3) !important;
            /* Light black background */
        }
    </style>

    <!-- sidebar help section css -->
    <style>
        .help-section {
            border: 1px solid #ddd;
            border-radius: 8px;
            padding: 15px;
            display: flex;
            align-items: center;
            gap: 60px;
            background: #fff;
            box-shadow: 0px 2px 8px rgba(0, 0, 0, 0.1);
        }

        .help-section img {
            width: 100px;
            /* height: 40px; */
        }

        .help-text {
            font-weight: bold;
            font-size: 20px;
            color: #545f71;
        }

        .callback-btn {
            background: #007bff;
            color: #fff;
            border-radius: 5px;
            padding: 8px 15px;
            text-decoration: none;
            font-weight: bold;
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .callback-btn:hover {
            background: #0056b3;
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

        <!-- fee structure section -->
        <div class="fee_struct mt-4 p-4 bg-white shadow rounded">
            <small style="font-weight: 400; font-size: 12px; line-height: 14px; margin-bottom: 4px; color: #8a8a8a;">
                <?php echo htmlspecialchars($school['name']); ?></small>
            <div class="d-flex justify-content-between">
                <h4 class="fw-bold" style="color: #545f71; border-left: 5px solid #007bff;padding-left: 10px;">Fee
                    Structure
                </h4>
                <button class="btn btn-primary">Download Fees</button>

            </div>

            <!-- Session Dropdown -->
            <form method="GET">
                <select name="session" class="form-select d-inline-block w-auto session-drop"
                    onchange="this.form.submit()">
                    <?php while ($row = $sessionResult->fetch_assoc()): ?>
                        <option value="<?php echo $row['session']; ?>" <?php echo ($session === $row['session']) ? 'selected' : ''; ?>>
                            <?php echo $row['session']; ?>
                        </option>
                    <?php endwhile; ?>
                </select>
            </form>
            <?php if (!empty($fees)): ?>
                <div class="accordion mt-2" id="feeAccordion">
                    <?php foreach ($fees as $class => $fee) { ?>
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#collapse<?= $class ?>">
                                    <span
                                        style="color: #545f71 !important; font-size: 14px !important; font-weight: 500 !important;">
                                        Fee structure for Class <?= $class ?> |</span> <span
                                        style="font-size: 12px; padding-left: 5px;font-weight: 400;line-height: 20px; letter-spacing: -.02em; color: #9ba5b7 !important;">
                                        <?= $session ?> </span>
                                </button>
                            </h2>
                            <div id="collapse<?= $class ?>" class="accordion-collapse collapse" data-bs-parent="#feeAccordion">
                                <div class="accordion-body">
                                    <table class="table table-striped table-bordered">
                                        <thead>
                                            <tr>
                                                <th style="text-align: center;font-weight: 700;color: #4b4a49;font-size: 16px;">
                                                    Type</th>
                                                <th style="text-align: center;font-weight: 700;color: #4b4a49;font-size: 16px;">
                                                    Frequency</th>
                                                <th style="text-align: center;font-weight: 700;color: #4b4a49;font-size: 16px;">
                                                    Refundable</th>
                                                <th style="text-align: center;font-weight: 700;color: #4b4a49;font-size: 16px;">
                                                    Amount</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>Security Fee</td>
                                                <td><?= $fee['frequency'] ?></td>
                                                <td><?= $fee['refundable'] ?></td>
                                                <td>₹ <?= $fee['security_fee'] ?></td>
                                            </tr>
                                            <tr>
                                                <td>Registration Fee</td>
                                                <td><?= $fee['frequency'] ?></td>
                                                <td><?= $fee['refundable'] ?></td>
                                                <td>₹ <?= $fee['registration_fee'] ?></td>
                                            </tr>
                                            <tr>
                                                <td>Admission Fee</td>
                                                <td><?= $fee['frequency'] ?></td>
                                                <td><?= $fee['refundable'] ?></td>
                                                <td>₹ <?= $fee['admission_fee'] ?></td>
                                            </tr>
                                            <tr>
                                                <td>Annual Fee</td>
                                                <td><?= $fee['frequency'] ?></td>
                                                <td><?= $fee['refundable'] ?></td>
                                                <td>₹ <?= $fee['annual_fee'] ?></td>
                                            </tr>
                                            <tr>
                                                <td>Tuition Fee</td>
                                                <td><?= $fee['frequency'] ?></td>
                                                <td><?= $fee['refundable'] ?></td>
                                                <td>₹ <?= $fee['tuition_fee'] ?></td>
                                            </tr>
                                            <tr>
                                                <td>Examination Fee</td>
                                                <td><?= $fee['frequency'] ?></td>
                                                <td><?= $fee['refundable'] ?></td>
                                                <td>₹ <?= $fee['examination_fee'] ?></td>
                                            </tr>
                                            <tr>
                                                <td>Library Fee</td>
                                                <td><?= $fee['frequency'] ?></td>
                                                <td><?= $fee['refundable'] ?></td>
                                                <td>₹ <?= $fee['library_fee'] ?></td>
                                            </tr>
                                            <tr>
                                                <td>Sports Fee</td>
                                                <td><?= $fee['frequency'] ?></td>
                                                <td><?= $fee['refundable'] ?></td>
                                                <td>₹ <?= $fee['sports_fee'] ?></td>
                                            </tr>
                                            <?php if (!empty($fee['hostel_fee'])) { ?>
                                                <tr>
                                                    <td>Hostel Fee</td>
                                                    <td><?= $fee['frequency'] ?></td>
                                                    <td><?= $fee['refundable'] ?></td>
                                                    <td>₹ <?= $fee['hostel_fee'] ?></td>
                                                </tr>
                                            <?php } ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                </div>
            <?php else: ?>
                <div class="alert alert-warning mt-3">
                    No fee structure available for this session.
                </div>
            <?php endif; ?>

            <div class="fee-disclaimer mt-4">
                <p>
                    **These fee structures are according to the best of our knowledge.
                </p>
            </div>
        </div>

        <!-- fill admission form section -->
        <div class="fiil-addmission mt-4 p-4 bg-white shadow rounded">
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
                                <tr class="<?php echo ($admission_count >= 4) ? 'd-none admission-rows' : ''; ?>">
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
                                    <button id="toggle-admissions-Btn" class="btn btn-link">See All Classes</button>
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                </div>

            <?php endif; ?> <!-- Closing the PHP if condition -->
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

    </div>

    <!-- Sidebar -->
    <div class="sidebar-container" style="margin-top: 25px;">

        <!--apply now section sidebar  -->
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

        <!-- parents also applied to section -->
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
                    <a href="javascript:void(0);" onclick="redirectsTodetail(<?php echo $school['id']; ?>)"
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

        <!-- Need Help Section -->
        <div class="need-help-section mt-4">
            <div class="help-section">
                <img src="../admin/uploads/school_photos/help.webp" alt="Help Icon" width:50%;>
                <div>
                    <p class="help-text">Need Help?</p>
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                        data-bs-target="#callbackModal">
                        Request a Callback →
                    </button>
                </div>
            </div>
        </div>

        <!-- Callback Request Modal -->
        <div class="modal fade" id="callbackModal" tabindex="-1" aria-labelledby="callbackModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title"><i class="fa fa-headset"></i> Request a Callback</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="callbackForm">
                            <input type="hidden" name="school_id" value="<?= $school_id; ?>">

                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label">Parent Name *</label>
                                    <input type="text" name="name" class="form-control"
                                        value="<?= isset($user['name']) ? htmlspecialchars($user['name']) : ''; ?>"
                                        placeholder="Enter Name" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Phone Number *</label>
                                    <div class="input-group">
                                        <span class="input-group-text">+91</span>
                                        <input type="text" name="phone" class="form-control"
                                            value="<?= isset($user['phone']) ? htmlspecialchars($user['phone']) : ''; ?>"
                                            placeholder="Enter Phone Number" required readonly>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Email Address *</label>
                                    <input type="email" name="email" class="form-control" placeholder="Enter Email"
                                        required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Class *</label>
                                    <select name="class" class="form-control" required>
                                        <option value="">--- Select Class ---</option>
                                        <?php foreach ($classes as $class): ?>
                                            <option value="<?= $class; ?>"><?= $class; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="col-md-12">
                                    <label class="form-label">Alternate Number (Optional)</label>
                                    <input type="text" name="alternate_phone" class="form-control"
                                        placeholder="Enter Alternate Number">
                                </div>
                                <div class="col-md-12 text-end">
                                    <button type="submit" name="enquiry_form" class="btn btn-primary">SUBMIT</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
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


    <!-- click on applynow button rediect to admission tab -->
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            document.getElementById("applyNowBtn").addEventListener("click", function (event) {
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

    <!-- fill admission see less and see all -->
    <script>
        // Toggle Admissions Table Rows
        document.getElementById('toggle-admissions-Btn').addEventListener('click', function () {
            const rows = document.querySelectorAll('.admission-rows');
            const button = this;

            rows.forEach(row => row.classList.toggle('d-none'));

            button.textContent = (button.textContent === 'See All Classes') ? 'See Less' : 'See All Classes';
        });
    </script>

    <!-- parents also aplied sidebar js -->
    <script>
        function redirectsTodetail(schoolId) {
            window.location.href = '../pages/viewschool-details.php?id=' + schoolId;
        }
    </script>

    <!-- Similar school sidebar js -->
    <script>
        function redirectToSimilar(schoolId) {
            window.location.href = '../pages/viewschool-details.php?id=' + schoolId;
        }
    </script>

    <script>
        $(document).ready(function () {
            $("#callbackForm").submit(function (e) {
                e.preventDefault(); // Prevent form from refreshing page

                $.ajax({
                    type: "POST",
                    url: "",
                    data: $(this).serialize(),
                    success: function (response) {
                        $("#responseMessage").html(response);
                        // Modal hide after 2 sec
                        setTimeout(function () {
                            $("#callbackModal").modal('hide');
                            $("#responseMessage").html(""); // Clear message
                        }, 2000);

                        $("#callbackForm")[0].reset(); // Reset form fields
                    }
                });
            });
        });
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>