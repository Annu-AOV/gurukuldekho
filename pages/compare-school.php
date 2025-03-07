<?php
include '../admin/includes/db_connect.php'; // Database connection
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Compare Schools</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
        }

        .sticky-section {
            position: sticky;
            top: 0;
            background: #fff;
            padding: 10px 0;
            z-index: 1000;
            border-bottom: 2px solid #ddd;
            text-align: center;
        }

        .school-box {
            border: 2px dashed #ddd;
            padding: 15px;
            text-align: center;
            cursor: pointer;
            min-height: 120px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-direction: column;
            font-size: 16px;
            width: 100%;
            height: 120px;
        }

        .school-box img {
            width: 80px;
            height: 80px;
            border-radius: 10px;
            margin-bottom: 5px;
        }

        .compare-table th,
        .compare-table td {
            text-align: center;
            vertical-align: middle;
        }
    </style>
</head>

<body>
    <div class="container mt-4">
        <h3>Compare Schools</h3>
        <div class="row sticky-section" id="selected-schools">
            <?php for ($i = 1; $i <= 4; $i++): ?>
                <div class="col-md-3">
                    <div class="school-box" id="box_<?php echo $i; ?>" onclick="openSchoolPopup(<?php echo $i; ?>)">
                        <div class="plus-icon">+</div>
                        <p>Add School</p>
                    </div>
                </div>
            <?php endfor; ?>
        </div>

        <button class="btn btn-primary mt-3" id="compare-btn" style="display:none;" onclick="compareSchools()">Compare
            Schools</button>

        <table class="table table-bordered mt-4 compare-table" id="compare-table" style="display: none;">
            <thead>
                <tr>
                    <th>Average Fee</th>
                    <th>Admission Status</th>
                    <th>Classes Offered</th>
                    <th>Board</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td id="fee_1"></td>
                    <td id="status_1"></td>
                    <td id="classes_1"></td>
                    <td id="board_1"></td>
                </tr>
            </tbody>
        </table>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        var selectedSchools = [];
        function openSchoolPopup(index) {
            let schoolId = prompt("Enter School ID:");
            if (schoolId) {
                $.ajax({
                    url: 'fetch-school.php',
                    type: 'GET',
                    data: { id: schoolId },
                    success: function (response) {
                        let data = JSON.parse(response);
                        if (data.success) {
                            selectedSchools[index - 1] = data;
                            $('#box_' + index).html(`<img src="${data.photo}" alt="${data.name}"><p>${data.name}</p>`);
                            checkCompareButton();
                        }
                    }
                });
            }
        }

        function checkCompareButton() {
            $('#compare-btn').toggle(selectedSchools.length > 1);
        }

        function compareSchools() {
            if (selectedSchools.length > 1) {
                $('#compare-table').show();
                for (let i = 0; i < selectedSchools.length; i++) {
                    $('#fee_' + (i + 1)).text(selectedSchools[i].fee);
                    $('#status_' + (i + 1)).text(selectedSchools[i].status);
                    $('#classes_' + (i + 1)).text(selectedSchools[i].classes);
                    $('#board_' + (i + 1)).text(selectedSchools[i].board);
                }
            }
        }
    </script>
</body>

</html>