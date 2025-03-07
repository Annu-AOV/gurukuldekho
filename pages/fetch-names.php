<?php
    include('../admin/includes/db_connect.php'); // Database connection file
    

    $names = [];

    // Fetch school names
    $schoolQuery = "SELECT name FROM schools ORDER BY RAND() LIMIT 5";
    $schoolResult = $conn->query($schoolQuery);
    while ($row = $schoolResult->fetch_assoc()) {
        $names[] = $row['name'];
    }

    // Fetch university names
    $universityQuery = "SELECT university_name FROM universities ORDER BY RAND() LIMIT 5";
    $universityResult = $conn->query($universityQuery);
    while ($row = $universityResult->fetch_assoc()) {
        $names[] = $row['university_name'];
    }

    // Return as JSON
    echo json_encode($names);
    ?>