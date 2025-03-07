<?php
include '../admin/includes/db_connect.php';

header('Content-Type: application/json');

if (isset($_GET['latitude']) && isset($_GET['longitude'])) {
    $latitude = $_GET['latitude'];
    $longitude = $_GET['longitude'];
    $radius = 10; // Search radius in km

    $query = "
        SELECT id, name, address, admission_status, latitude, longitude, 
        (6371 * acos(cos(radians($latitude)) * cos(radians(latitude)) 
        * cos(radians(longitude) - radians($longitude)) + sin(radians($latitude)) 
        * sin(radians(latitude)))) AS distance
        FROM schools
        HAVING distance <= $radius
        ORDER BY distance ASC
        LIMIT 20
    ";

    $result = mysqli_query($conn, $query);

    if ($result) {
        $schools = [];
        while ($row = mysqli_fetch_assoc($result)) {
            $schools[] = $row;
        }
        echo json_encode(['status' => 'success', 'schools' => $schools]);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Database query failed']);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request']);
}
?>
