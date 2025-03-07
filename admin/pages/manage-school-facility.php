<?php
// Include database connection
include('../includes/header.php');
include('../includes/sidebar.php');
include('../includes/db_connect.php');

// Fetch school data from the schools table
$schools_query = "SELECT id, name FROM schools";
$schools_result = mysqli_query($conn, $schools_query);

// Pagination settings
$limit = 5; // Records per page
$page = isset($_GET['page']) ? (int) $_GET['page'] : 1;
$offset = ($page - 1) * $limit;

// Total records count
$total_query = "SELECT COUNT(*) as total FROM school_facility";
$total_result = mysqli_query($conn, $total_query);
$total_row = mysqli_fetch_assoc($total_result);
$total_records = $total_row['total'];
$total_pages = ceil($total_records / $limit);

// Fetch school facility details with pagination
$facilities_query = "SELECT * FROM school_facility LIMIT $limit OFFSET $offset";
$facilities_result = mysqli_query($conn, $facilities_query);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage School Facilities</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> <!-- jQuery -->
</head>

<body>
    <div class="container my-5" style="overflow-y: overlay;">
        <h2 class="text-center mb-4" style="margin-top: 30px;">Manage School Facilities</h2>
        <form action="process-school-facility.php" method="POST">
            <table class="table table-bordered">
                <thead class="table-dark">
                    <tr>
                        <th>School</th>
                        <th>Extra Curricular</th>
                        <th>Class Facilities</th>
                        <th>Infrastructure</th>
                        <th>Sports & Fitness</th>
                        <th>Lab Facilities</th>
                        <th>Boarding</th>
                        <th>Disabled Friendly</th>
                        <th>Safety & Security</th>
                        <th>Advanced Facilities</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>
                            <select name="school_id" class="form-select" required>
                                <option value="">Select School</option>
                                <?php
                                while ($row = mysqli_fetch_assoc($schools_result)) {
                                    echo "<option value='{$row['id']}'>{$row['name']}</option>";
                                }
                                ?>
                            </select>
                        </td>

                        <?php
                        $facilities = [
                            'extra_curricular' => ['Art and Craft', 'Dance', 'Debate', 'Drama', 'Gardening', 'Music', 'Picnics and excursion'],
                            'class_facilities' => ['AC Classes', 'Smart Classes', 'Wifi'],
                            'infrastructure' => ['Library/Reading Room', 'Playground', 'Auditorium/Media Room', 'Cafeteria/Canteen'],
                            'sports_fitness' => ['Indoor Sports', 'Outdoor Sports', 'Karate', 'Taekwondo', 'Yoga', 'Skating', 'Horse Riding', 'Gym', 'Swimming Pool'],
                            'lab_facilities' => ['Computer Lab', 'Science Lab', 'Language Lab', 'Robotics Lab'],
                            'boarding' => ['Boys Hostel', 'Girls Hostel'],
                            'disabled_friendly' => ['Washrooms', 'Ramps', 'Elevators'],
                            'safety_security' => ['CCTV', 'GPS Bus Tracking App'],
                            'advanced_facilities' => ['Medical Room', 'Transportation', 'Alumni Association', 'Day care', 'Meals']
                        ];

                        $icons = [
                            'Art and Craft' => '🎨',
                            'Dance' => '💃',
                            'Debate' => '🗣️',
                            'Drama' => '🎭',
                            'Gardening' => '🌱',
                            'Music' => '🎵',
                            'Picnics and excursion' => '🧺',
                            'AC Classes' => '❄️',
                            'Smart Classes' => '📱',
                            'Wifi' => '📶',
                            'Library/Reading Room' => '📚',
                            'Playground' => '🏟️',
                            'Indoor Sports' => '🏓',
                            'Outdoor Sports' => '⚽',
                            'Swimming Pool' => '🏊',
                            'Computer Lab' => '💻',
                            'Science Lab' => '🔬',
                            'Boys Hostel' => '🏠',
                            'Girls Hostel' => '🏠',
                            'CCTV' => '📹',
                            'GPS Bus Tracking App' => '🚌',
                            'Medical Room' => '🏥',
                            'Transportation' => '🚍',
                            'Cafeteria/Canteen' => '🍴',
                            'Washrooms' => '🚻',
                            'Auditorium/Media Room' => '🎤',
                            'Karate' => '🥋',
                            'Taekwondo' => '🥋',
                            'Yoga' => '🧘',
                            'Skating' => '⛸️',
                            'Horse Riding' => '🐎',
                            'Gym' => '🏋️',
                            'Language Lab' => '📖',
                            'Robotics Lab' => '🤖',
                            'Ramps' => '🛤️',
                            'Elevators' => '🛗',
                            'Alumni Association' => '🤝',
                            'Day care' => '🍼',
                            'Meals' => '🍴'
                        ];

                        foreach ($facilities as $key => $options) {
                            echo "<td>";
                            foreach ($options as $option) {
                                echo "<div class='form-check'>
                                    <input class='form-check-input' type='checkbox' name='{$key}[]' value='{$option}'>
                                    <label class='form-check-label'>{$option}</label>
                                  </div>";
                            }
                            echo "<div>No {$key}</div>"; // Default No Option
                            echo "</td>";
                        }
                        ?>
                    </tr>
                </tbody>
            </table>
            <div class="text-center">
                <button type="submit" class="btn btn-success">Save Facilities</button>
            </div>
        </form>


        <h3 class="text-center my-4">Saved School Facilities</h3>
        <table class="table table-bordered">
            <thead class="table-dark">
                <tr>
                    <th>School Name</th>
                    <th>Extra Curricular</th>
                    <th>Class Facilities</th>
                    <th>Infrastructure</th>
                    <th>Sports & Fitness</th>
                    <th>Lab Facilities</th>
                    <th>Boarding</th>
                    <th>Disabled Friendly</th>
                    <th>Safety & Security</th>
                    <th>Advanced Facilities</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                while ($facility = mysqli_fetch_assoc($facilities_result)) {
                    $school_name_query = "SELECT name FROM schools WHERE id = '{$facility['school_id']}'";
                    $school_name_result = mysqli_query($conn, $school_name_query);
                    $school_name = mysqli_fetch_assoc($school_name_result)['name'];

                    echo "<tr>
                        <td>{$school_name}</td>
                        <td>" . ($facility['extra_curricular'] ?: 'No Extra Curricular') . "</td>
                        <td>" . ($facility['class_facilities'] ?: 'No Class Facilities') . "</td>
                        <td>" . ($facility['infrastructure'] ?: 'No Infrastructure') . "</td>
                        <td>" . ($facility['sports_fitness'] ?: 'No Sports & Fitness') . "</td>
                        <td>" . ($facility['lab_facilities'] ?: 'No Lab Facilities') . "</td>
                        <td>" . ($facility['boarding'] ?: 'No Boarding') . "</td>
                        <td>" . ($facility['disabled_friendly'] ?: 'No Disabled Friendly') . "</td>
                        <td>" . ($facility['safety_security'] ?: 'No Safety & Security') . "</td>
                        <td>" . ($facility['advanced_facilities'] ?: 'No Advanced Facilities') . "</td>
                        <td>
                        <a href='edit-school-facility.php?id={$facility['id']}' class='btn btn-warning btn-sm'>Edit</a>
                        
                             <a href='delete-school-facility.php?id={$facility['id']}' class='btn btn-danger btn-sm' onclick='return confirm(\"Are you sure you want to delete this record?\")'>Delete</a>
                        </td>                     
                    </tr>";
                }
                ?>
            </tbody>
        </table>

        <!-- Pagination Controls for Saved Facilities -->
        <nav>
            <ul class="pagination justify-content-center">
                <li class="page-item <?= ($page <= 1) ? 'disabled' : '' ?>">
                    <a class="page-link" href="?page=<?= $page - 1 ?>">Previous</a>
                </li>
                <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                    <li class="page-item <?= ($i == $page) ? 'active' : '' ?>">
                        <a class="page-link" href="?page=<?= $i ?>"><?= $i ?></a>
                    </li>
                <?php endfor; ?>
                <li class="page-item <?= ($page >= $total_pages) ? 'disabled' : '' ?>">
                    <a class="page-link" href="?page=<?= $page + 1 ?>">Next</a>
                </li>
            </ul>
        </nav>


    </div>


</body>
<?php include('../includes/footer.php'); ?>

</html>