<?php
include '../admin/includes/db_connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $school_id = $_POST['school_id'];
    $reviewer_name = $_POST['reviewer_name'];
    $overall_rating = $_POST['overall_rating'];
    $review_text = $_POST['review_text'];
    $review_date = date('Y-m-d');

    // Insert into reviews table
    $stmt = $conn->prepare("INSERT INTO reviews (school_id, reviewer_name, review_date, overall_rating, review_text) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("issds", $school_id, $reviewer_name, $review_date, $overall_rating, $review_text);
    if ($stmt->execute()) {
        $review_id = $stmt->insert_id; // Get the last inserted ID

        // Insert category ratings into review_categories table
        $categories = ['Infrastructure', 'Admission Process', 'Value for Money', 'Sports', 'Extra Curricular'];
        foreach ($categories as $category) {
            $category_key = strtolower(str_replace(' ', '_', $category)) . '_rating';
            if (isset($_POST[$category_key])) {
                $category_rating = $_POST[$category_key];
                $stmt_cat = $conn->prepare("INSERT INTO review_categories (review_id, school_id, category_name, category_rating) VALUES (?, ?, ?, ?)");
                $stmt_cat->bind_param("iisd", $review_id, $school_id, $category, $category_rating);
                $stmt_cat->execute();
            }
        }

        // Send JSON response with new review data
        echo json_encode(["status" => "success", "reviewer_name" => $reviewer_name, "review_text" => $review_text, "overall_rating" => $overall_rating]);
    } else {
        // Return error message
        echo json_encode(["status" => "error", "message" => "Error: " . $stmt->error]);
    }
}
?>
