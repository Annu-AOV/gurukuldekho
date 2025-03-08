<?php
include '../admin/includes/db_connect.php';

if (!isset($_POST['school_ids']) || empty($_POST['school_ids'])) {
    echo json_encode(['error' => 'No schools selected.']);
    exit;
}

$schoolIds = implode(',', array_map('intval', $_POST['school_ids']));

// Fetch school details
$schoolQuery = "SELECT id, name, admission_status, classes_offered, board, year_of_establishment, school_type, medium_of_instruction 
                FROM schools WHERE id IN ($schoolIds)";
$schoolResult = $conn->query($schoolQuery);

$schoolsData = [];
while ($school = $schoolResult->fetch_assoc()) {
    $schoolsData[$school['id']] = $school;
}

// Fetch school facilities
$facilityQuery = "SELECT school_id, extra_curricular, class_facilities, infrastructure, sports_fitness, lab_facilities, 
                         boarding, disabled_friendly, safety_security, advanced_facilities 
                  FROM school_facility WHERE school_id IN ($schoolIds)";
$facilityResult = $conn->query($facilityQuery);

while ($facility = $facilityResult->fetch_assoc()) {
    $schoolsData[$facility['school_id']]['facilities'] = $facility;
}

echo json_encode(array_values($schoolsData));
?>
