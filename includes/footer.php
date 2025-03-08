<!-- Footer CSS -->
<style>
    .footer-content ul {
        list-style: none;
    }

    .footer-content a {
        color: white;
        text-decoration: none;
    }

    .footer-content a:hover {
        text-decoration: underline;
    }
</style>

<!-- PHP -->
<?php
// Fetch states from the database
$sql = "
    SELECT DISTINCT c.state 
    FROM schools s
    JOIN city c ON s.city_id = c.id
    WHERE s.school_type = 'Boarding'
";
$resultBoardingState = $conn->query($sql);

// Fetch city from the database
$sql = "
    SELECT DISTINCT c.city_name 
    FROM schools s
    JOIN city c ON s.city_id = c.id
    WHERE s.school_type = 'Boarding'
";
$resultBoardingCity = $conn->query($sql);

// Fetch city from the database
$sql = "SELECT DISTINCT city_name FROM city";
$resultCity = $conn->query($sql);
?>

<!-- Footer -->
<div class="container-fluid bg-dark text-light py-3 footer-content"
    style="clear:both;background-color: #181828; color: white;">
    <div class="row">
        <div class="col-md-3">
            <div>
                <h5>Boarding Schools in States</h5>
                <ul>
                    <?php
                    if ($resultBoardingState->num_rows > 0) {
                        while ($row = $resultBoardingState->fetch_assoc()) {
                            echo "<li><a href='../pages/explore-school.php?state=" . urlencode($row['state']) . "'>Boarding Schools in " . htmlspecialchars($row['state']) . "</a></li>";
                        }
                    } else {
                        echo "<li>No states found</li>";
                    }
                    ?>
                </ul>
            </div>
            <div>
                <h5>Popular Boarding Search</h5>
                <ul>
                    <?php
                    if ($resultBoardingState->num_rows > 0) {
                        while ($row = $resultBoardingState->fetch_assoc()) {
                            echo "<li><a href='../pages/explore-school.php?state=" . urlencode($row['state']) . "'>Boarding Schools in " . htmlspecialchars($row['state']) . "</a></li>";
                        }
                    } else {
                        echo "<li>No states found</li>";
                    }
                    ?>
                </ul>
            </div>
        </div>
        <div class="col-md-3">
            <h5>Boarding Schools in Cities</h5>
            <ul>
                <?php
                if ($resultBoardingCity->num_rows > 0) {
                    while ($row = $resultBoardingCity->fetch_assoc()) {
                        echo "<li><a href='../pages/explore-school.php?city=" . urlencode($row['city_name']) . "'>Boarding Schools in " . htmlspecialchars($row['city_name']) . "</a></li>";
                    }
                } else {
                    echo "<li>No states found</li>";
                }
                ?>
            </ul>
        </div>
        <div class="col-md-3">
            <h5>Schools</h5>
            <ul>
                <?php
                if ($resultCity->num_rows > 0) {
                    while ($row = $resultCity->fetch_assoc()) {
                        echo "<li><a href='../pages/explore-school.php?city=" . urlencode($row['city_name']) . "'>Boarding Schools in " . htmlspecialchars($row['city_name']) . "</a></li>";
                    }
                } else {
                    echo "<li>No states found</li>";
                }
                ?>
            </ul>
        </div>
        <div class="col-md-3">
            <h5>Parents</h5>
            <ul>
                <li><a href="#">Schools Near Me</a></li>
                <li><a href="#">Compare Schools</a></li>
                <li><a href="#">Search for School</a></li>
                <li><a href="#">Parenting Tips</a></li>
            </ul>
        </div>
        <div class="col-md-3">
            <h5>About</h5>
            <ul>
                <li><a href="../pages/about-us.php">About Us</a></li>
                <li><a href="../pages/privacy-policy.php">Privacy Policy</a></li>
                <li><a href="../pages/refund-policy.php">Refund Policy</a></li>
                <li><a href="../pages/term-of-service.php">Terms of Use</a></li>
                <li><a href="../pages/faqs.php" title="Frequenty asked question">FAQ</a></li>
                <li><a href="#">Contact Us</a></li>
            </ul>
            <div class="social-icons">
                <a href="#"><i class="fab fa-facebook"></i></a>
                <a href="#"><i class="fab fa-twitter"></i></a>
                <a href="#"><i class="fab fa-instagram"></i></a>
                <a href="#"><i class="fab fa-linkedin"></i></a>
            </div>
        </div>
        <div class="row">
            <hr style="border-color: rgba(252, 241, 241, 0.2);">
            <!-- Copyright Text -->
            <div class="col-12 col-sm-6 text-center text-sm-start">
                <p class="mb-0">&copy; 2025 Ezyschooling</p>

            </div>
            <!-- Footer Logo -->
            <div class="col-12 col-sm-6 text-center text-sm-end">
                <img src="https://cdn.ezyschooling.com/ezyschooling/main-02/client/img/logo.8009820.webp"
                    alt="Footer Logo" class="footer-logo" loading="lazy">
            </div>

        </div>
    </div>



    <!-- Optional JavaScript -->
    <!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html> -->