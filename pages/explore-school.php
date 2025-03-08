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


// SQL Query: Count number of schools per state
$sql = "
    SELECT c.state, COUNT(s.id) AS school_count
    FROM city c
    LEFT JOIN schools s ON c.id = s.city_id
    GROUP BY c.state
    ORDER BY c.state ASC
";

$result = $conn->query($sql);

// Store states and school counts
$states = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $states[] = [
            'state' => $row['state'],
            'school_count' => $row['school_count']
        ];
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
    <div class="px-5">
        <!-- BreadCrum -->
        <div class="">
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
        <div>
            <h5>List of Best Boarding Schools in India 2025-26</h5>
            <p style="height:5rem;">As per the Latest UDISE+ Report, There are 45369 residential schools with boarding facility in India. These boarding schools are sprawled across the country, offering knowledge under different affiliations such as IB, IGCSE, CIE, and so on. With such an overwhelming number, it is normal for parents to be confused as to which boarding school to choose for their child. To ease this worry, here we have compiled a list of the best boarding schools in India. Read on to find lists of boarding schools based on fees, curriculum, location, and more such crucial details. Go through our lists to choose the best boarding school in India!</p>
        </div>
    </div>

    <!-- Main Content area -->
    <div class="mb-3 mx-2">
        <button class="btn btn-primary filter-btn" onclick="openFilter()">Filters</button>
        <div class="d-flex gap-3">
            <!-- Filter Area -->
            <div id="filterSidebar" class="filter-sidebar p-3">
                <button class="btn btn-danger mb-3 d-md-none" onclick="closeFilter()">Close</button>
                <h5>Filters</h5>

                <div>
    <div class="d-flex justify-content-between">
        <h6>State</h6>
        <span class="text-primary d-none" id="clearAll">Clear all</span>
    </div>
    <input type="text" class="form-control mb-2" id="searchState" placeholder="Search your Location">

    <div style="overflow-y: auto; max-height: 10rem;" id="stateList">
        <?php foreach ($states as $state): ?>
            <div class="w-100 d-flex justify-content-between state-item">
                <div class="d-flex gap-2 align-items-center">
                    <input type="checkbox" class="state-checkbox" value="<?php echo htmlspecialchars($state['state']); ?>" />
                    <span class="state-name"><?php echo htmlspecialchars($state['state']); ?></span>
                </div>
                <div>
                    <span>(<?php echo $state['school_count']; ?>)</span>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>

<script>
document.addEventListener("DOMContentLoaded", function () {
    let searchInput = document.getElementById("searchState");
    let stateItems = document.querySelectorAll(".state-item");
    let checkboxes = document.querySelectorAll(".state-checkbox");
    let clearAllBtn = document.getElementById("clearAll");

    // Get URL parameters
    let urlParams = new URLSearchParams(window.location.search);
    let selectedStates = urlParams.get("state") ? urlParams.get("state").split(",") : [];

    // Function to check if any checkbox is selected
    function updateClearAllVisibility() {
        let anyChecked = document.querySelectorAll(".state-checkbox:checked").length > 0;
        clearAllBtn.classList.toggle("d-none", !anyChecked); // Show or hide button
    }

    // Mark checkboxes as checked if they are in the URL params
    checkboxes.forEach(function (checkbox) {
        if (selectedStates.includes(checkbox.value)) {
            checkbox.checked = true;
        }
    });

    updateClearAllVisibility(); // Update visibility of "Clear All"

    // Search functionality
    searchInput.addEventListener("keyup", function () {
        let filter = searchInput.value.toLowerCase().trim();

        stateItems.forEach(function (item) {
            let stateName = item.querySelector(".state-name").textContent.toLowerCase();

            if (filter === "") {
                item.classList.remove("d-none");
            } else if (stateName.includes(filter)) {
                item.classList.remove("d-none");
            } else {
                item.classList.add("d-none");
            }
        });
    });

    // Update URL when checkboxes are clicked
    checkboxes.forEach(function (checkbox) {
        checkbox.addEventListener("change", function () {
            let selectedStates = [];
            document.querySelectorAll(".state-checkbox:checked").forEach(function (checkedBox) {
                selectedStates.push(encodeURIComponent(checkedBox.value));
            });

            let urlParams = new URLSearchParams(window.location.search);
            if (selectedStates.length > 0) {
                urlParams.set("state", selectedStates.join(","));
            } else {
                urlParams.delete("state");
            }

            window.history.replaceState({}, "", "?" + urlParams.toString());

            updateClearAllVisibility(); // Update visibility of "Clear All"
        });
    });

    // "Clear All" functionality
    clearAllBtn.addEventListener("click", function () {
        checkboxes.forEach(function (checkbox) {
            checkbox.checked = false; // Uncheck all checkboxes
        });

        let urlParams = new URLSearchParams(window.location.search);
        urlParams.delete("state"); // Remove 'state' param
        window.history.replaceState({}, "", "?" + urlParams.toString());

        clearAllBtn.classList.add("d-none"); // Hide "Clear All"
    });
});
</script>

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