<?php
include('../admin/includes/db_connect.php');

$query = isset($_GET['q']) ? trim($_GET['q']) : '';

if ($query == '') {
    echo "<div class='alert alert-danger'>Search query cannot be empty.</div>";
    exit;
}

$sql = "
    SELECT 'school' AS type, schools.id AS institution_id, name AS institution_name, address, city.city_name 
    FROM schools 
    LEFT JOIN city ON schools.city_id = city.id 
    WHERE schools.name LIKE ? OR city.city_name LIKE ?
    
    UNION
    
    SELECT 'university' AS type, universities.id AS institution_id, university_name AS institution_name, address, city.city_name 
    FROM universities 
    LEFT JOIN city ON universities.city_id = city.id 
    WHERE universities.university_name LIKE ? OR city.city_name LIKE ?";


$stmt = $conn->prepare($sql);
$searchTerm = "%$query%";
$stmt->bind_param("ssss", $searchTerm, $searchTerm, $searchTerm, $searchTerm);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $type = $row['type'] === 'school' ? 'viewschool-details.php' : 'viewuniversity-detail.php';
        $id = $row['institution_id']; // FIXED COLUMN NAME
        $name = htmlspecialchars($row['institution_name']);
        $address = htmlspecialchars($row['address']);
        $city = htmlspecialchars($row['city_name']);

        echo "<div class='search-item' onclick='window.location.href=\"$type?id=$id\"'>";
        echo "<strong>$name</strong><br>";
        echo "<span>$address, $city</span>";
        echo "</div>";
    }
} else {
    echo "<div class='alert alert-warning'>No results found for '$query'.</div>";
}

$stmt->close();
$conn->close();
?>