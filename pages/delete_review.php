<?php
include('../admin/includes/db_connect.php');

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $data = json_decode(file_get_contents('php://input'), true);
    $review_id = $data['review_id'];

    $sql = "DELETE FROM reviews WHERE id = $review_id";

    if ($conn->query($sql) === TRUE) {
        echo json_encode(['status' => 'success', 'message' => 'Review deleted successfully']);
    } else {
        echo json_encode(['status' => 'error', 'message' => $conn->error]);
    }
}

$conn->close();
?>
