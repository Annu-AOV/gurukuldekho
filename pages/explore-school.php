<?php
include "../includes/header2.php";

$selected_city_id = isset($_COOKIE['selected_city']) ? $_COOKIE['selected_city'] : null;
$city_name = "Unknown City";

// Fetch city name if city_id is available
if ($selected_city_id) {
    $queryCity = "SELECT city_name FROM city WHERE id = ?";
    $stmt = $conn->prepare($queryCity);
    $stmt->bind_param("i", $selected_city_id);
    $stmt->execute();
    $resultCity = $stmt->get_result();

    if ($row = $resultCity->fetch_assoc()) {
        $city_name = $row['city_name'];
    }
}

?>

<!-- Breadcrumb -->
<style>
    .breadcrumb-item {
        font-weight: 600;
    }
</style>

<!-- Main area -->
<style>
    .filter-sidebar {
        width: 250px;
        background-color: #eaf2fc;
    }

    .filter-btn {
        display: none;
    }

    @media (max-width: 768px) {
        .filter-btn {
            display: block;
        }

        .filter-sidebar {
            width: 100%;

            height: 100%;
            background: white;
            padding: 20px;
            transition: left 0.3s ease-in-out;
            z-index: 1050;
            border-right: 1px solid #ddd;
            position: fixed;
            top: 0;
            left: 0;
            left: -100%;
        }

        .filter-sidebar.show {
            left: 0;
        }
    }
</style>

<!-- HTML Code -->
<div>
    <!-- BreadCrum -->
    <div class="px-5">
        <nav aria-label="breadcrumb" class="py-3" style="padding-left:1rem;">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="./home-page.php" style="text-decoration: none;" class="text-dark">Home</a></li>
                <li class="breadcrumb-item"><a><?php echo $city_name ?></a></li>
                <?php if (!empty($_GET)) : ?>
                    <li class="breadcrumb-item active text-primary" aria-current="page">
                        <?php echo htmlspecialchars(implode(', ', array_values($_GET))); ?>
                    </li>
                <?php endif; ?>

            </ol>
        </nav>
    </div>

    <!-- Main Content area -->
    <div class="mb-3 mx-2">
        <button class="btn btn-primary filter-btn" onclick="openFilter()">Filters</button>
        <div class="d-flex gap-3">
            <!-- Filter Area -->
            <div id="filterSidebar" class="filter-sidebar">
                <button class="btn btn-danger mb-3 d-md-none" onclick="closeFilter()">Close</button>
                <h5>Filters</h5>
                <input type="text" class="form-control mb-2" placeholder="Search your Location">
                <input type="range" class="form-range" min="3" max="15" step="3">
                <h6>Popular Area</h6>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="sector45">
                    <label class="form-check-label" for="sector45">Sector 45</label>
                </div>
                <h6>Popular Area</h6>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="sector45">
                    <label class="form-check-label" for="sector45">Sector 45</label>
                </div>
                <h6>Popular Area</h6>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="sector45">
                    <label class="form-check-label" for="sector45">Sector 45</label>
                </div>
                <h6>Popular Area</h6>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="sector45">
                    <label class="form-check-label" for="sector45">Sector 45</label>
                </div>
                <h6>Popular Area</h6>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="sector45">
                    <label class="form-check-label" for="sector45">Sector 45</label>
                </div>
                <h6>Popular Area</h6>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="sector45">
                    <label class="form-check-label" for="sector45">Sector 45</label>
                </div>
                <h6>Popular Area</h6>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="sector45">
                    <label class="form-check-label" for="sector45">Sector 45</label>
                </div>
                <h6>Popular Area</h6>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="sector45">
                    <label class="form-check-label" for="sector45">Sector 45</label>
                </div>
                <h6>Popular Area</h6>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="sector45">
                    <label class="form-check-label" for="sector45">Sector 45</label>
                </div>
                <h6>Popular Area</h6>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="sector45">
                    <label class="form-check-label" for="sector45">Sector 45</label>
                </div>
                <h6>Popular Area</h6>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="sector45">
                    <label class="form-check-label" for="sector45">Sector 45</label>
                </div>
                <h6>Popular Area</h6>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="sector45">
                    <label class="form-check-label" for="sector45">Sector 45</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="sector62A">
                    <label class="form-check-label" for="sector62A">Sector 62A</label>
                </div>
            </div>
            <!-- Cards Area -->
            <div class="bg-danger w-100">
                <h3>Schools in Sector 132, Noida</h3>
                <div class="row">
                    <div class="container mt-4">
                        <div class="row">

                            <div class="col-md-6">
                                <div class="card" style="position: relative;">
                                    <img src="../admin/uploads/school_photos/s1.jpeg" style="height: 200px; width: 100%;" class="card-img-top" alt="Somerville International School">
                                    <div class="card-body">
                                        <div class="d-flex align-items-center" style="position: absolute; top: 160px;">
                                            <div style="position: relative;">
                                                <img src="../admin/uploads/school_photos/s2.jpg" class="me-2" alt="Somerville Logo" style="width: 50px; height: 50px; position:relative">
                                                <p style="position:absoulute;top:0;">4K Views</p>
                                            </div>
                                            <h5 class="card-title mb-0">Somerville International School</h5>
                                        </div>
                                        <p class="card-text"><i class="bi bi-geo-alt"></i> Sector 132, Noida</p>
                                        <p><strong>Classes:</strong> Nursery - 12 Class</p>
                                        <p><strong>Board:</strong> CBSE</p>
                                        <p><strong>Monthly Fees:</strong> 12.50K - 13.25K</p>
                                        <p>We believe in fostering an environment where students...</p>
                                        <button class="btn btn-primary w-100">Request A Callback</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function openFilter() {
        document.getElementById("filterSidebar").classList.add("show");
    }

    function closeFilter() {
        document.getElementById("filterSidebar").classList.remove("show");
    }
</script>

<?php
include "../includes/footer.php"
?>