<?php
// Database connection
include '../admin/includes/db_connect.php';
include '../includes/header2.php';

// Fetch all schools for search functionality
$sql = "SELECT id, name, address, photo, admission_status, class_minimum, class_maximum, affiliate, estd, school_type FROM schools";
$result = $conn->query($sql);
$schools = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $schools[] = $row;
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Compare Schools</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
        .sticky-box {
            position: sticky;
            top: 10px;
            background: white;
            z-index: 1000;
            padding: 20px 0;
        }

        .compare-box {
            border: 2px solid #ddd;
            border-radius: 10px;
            text-align: center;
            width: 100%;
            min-height: 150px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            cursor: pointer;
            position: relative;
        }

        .compare-box img {
            width: 100%;
            height: 100px;
            object-fit: cover;
            border-radius: 10px;
        }

        .compare-box i {
            font-size: 30px;
            color: #007bff;
        }

        .compare-box a {
            text-decoration: none;
            font-weight: bold;
            color: #007bff;
        }

        .close-btn {
            position: absolute;
            top: 5px;
            right: 10px;
            font-size: 18px;
            color: red;
            cursor: pointer;
        }

        .modal-body {
            max-height: 400px;
            overflow-y: auto;
        }

        .school-item {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 10px;
            border-bottom: 1px solid #ddd;
            cursor: pointer;
        }

        .school-item img {
            width: 50px;
            height: 50px;
            object-fit: cover;
            border-radius: 5px;
        }

        #compare-table {
            display: none;
            margin-top: 20px;
        }
    </style>
</head>

<body>
    <div class="container mt-4">
        <nav>
            <a href="#">Home</a> / <span style="color: red;">Compare Schools</span>
        </nav>
        <h3 class="mt-3">Confused? Easy way to compare schools</h3>

        <div class="sticky-box">
            <div class="row g-3">
                <?php for ($i = 0; $i < 4; $i++) { ?>
                    <div class="col-md-3 col-6">
                        <div class="compare-box" onclick="openSchoolPopup(<?php echo $i; ?>)" id="box-<?php echo $i; ?>">
                            <i class="fas fa-plus-circle"></i>
                            <a href="#">Add School</a>
                        </div>
                    </div>
                <?php } ?>
            </div>
        </div>

        <div id="intro-section">
            <h5 class="mt-4"><b>Not sure which school to choose?</b></h5>
            <p>Use our comparison tool to easily compare schools side by side.</p>
            <p>Click on <a href="#" style="color: #007bff; font-weight: bold;">Add School</a> to start comparing fees,
                facilities, academics, and more.</p>
        </div>

        <table class="table table-bordered" id="compare-table">
            <thead>
                <tr>
                    <th>Details</th>
                    <th id="school-1"></th>
                    <th id="school-2"></th>
                    <th id="school-3"></th>
                    <th id="school-4"></th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Admission Status</td>
                    <td id="admission-1"></td>
                    <td id="admission-2"></td>
                    <td id="admission-3"></td>
                    <td id="admission-4"></td>
                </tr>
                <tr>
                    <td>Classes Offered</td>
                    <td id="classes-1"></td>
                    <td id="classes-2"></td>
                    <td id="classes-3"></td>
                    <td id="classes-4"></td>
                </tr>
                <tr>
                    <td>Year Of Establishment</td>
                    <td id="estd-1"></td>
                    <td id="estd-2"></td>
                    <td id="estd-3"></td>
                    <td id="estd-4"></td>
                </tr>
                <tr>
                    <td>Affiliate</td>
                    <td id="affiliate-1"></td>
                    <td id="affiliate-2"></td>
                    <td id="affiliate-3"></td>
                    <td id="affiliate-4"></td>
                </tr><tr>
                    <td>School Type</td>
                    <td id="school_type-1"></td>
                    <td id="school_type-2"></td>
                    <td id="school_type-3"></td>
                    <td id="school_type-4"></td>
                </tr>
            </tbody>
        </table>
    </div>

    <div class="modal fade" id="schoolModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5>Select Your School</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <input type="text" class="form-control mb-2" id="searchSchool" placeholder="Search school...">
                    <div id="schoolList">
                        <?php foreach ($schools as $school) { ?>
                            <div class="school-item"
                                onclick="selectSchool(<?php echo $school['id']; ?>, '<?php echo $school['name']; ?>', '<?php echo $school['admission_status']; ?>', '<?php echo $school['class_minimum']; ?> - <?php echo $school['class_maximum']; ?>', '<?php echo $school['estd']; ?>',  '<?php echo $school['affiliate']; ?>',  '<?php echo $school['school_type']; ?>', '<?php echo $school['photo']; ?>')">
                                <b><?php echo $school['name']; ?></b>
                            </div>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        let selectedBoxIndex = null;

        function openSchoolPopup(index) {
            selectedBoxIndex = index;
            $('#schoolModal').modal('show');
        }

        function selectSchool(id, name, admission, classes, estd, affiliate, school_type, photo) {
            let box = document.getElementById('box-' + selectedBoxIndex);
            box.innerHTML = `
                <img src="${photo}" alt="School">
                <b>${name}</b>
                <a href="viewschool-details.php?id=${id}" class="btn btn-primary btn-sm">View Details</a>
            `;

            document.getElementById('school-' + (selectedBoxIndex + 1)).innerText = name;
            document.getElementById('admission-' + (selectedBoxIndex + 1)).innerText = admission;
            document.getElementById('classes-' + (selectedBoxIndex + 1)).innerText = classes;
            document.getElementById('estd-' + (selectedBoxIndex + 1)).innerText = estd;
            document.getElementById('affiliate-' + (selectedBoxIndex + 1)).innerText = affiliate;
            document.getElementById('school_type-' + (selectedBoxIndex + 1)).innerText = school_type;

            document.getElementById('compare-table').style.display = 'table';
            document.getElementById('intro-section').style.display = 'none';

            $('#schoolModal').modal('hide');
        }

        document.getElementById('searchSchool').addEventListener('input', function () {
            let filter = this.value.toLowerCase();
            let items = document.querySelectorAll('.school-item');
            items.forEach(item => {
                let text = item.innerText.toLowerCase();
                item.style.display = text.includes(filter) ? '' : 'none';
            });
        });
    </script>

</body>

</html>
