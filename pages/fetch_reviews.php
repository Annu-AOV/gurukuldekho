<?php
include '../admin/includes/db_connect.php';

$school_id = isset($_GET['school_id']) ? intval($_GET['school_id']) : 0;
if ($school_id === 0) {
    echo json_encode([]);
    exit;
}

$sql = "SELECT * FROM reviews WHERE school_id = ? ORDER BY review_date DESC";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $school_id);
$stmt->execute();
$result = $stmt->get_result();

$reviews = [];
while ($row = $result->fetch_assoc()) {
    $reviews[] = $row;
}

echo json_encode($reviews);
?>


