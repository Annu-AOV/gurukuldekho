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
            padding: 15px 0;
            z-index: 1000;
            border-bottom: 2px solid #ddd;
            text-align: center;
        }
        .school-box {
            border: 2px dashed #ddd;
            padding: 20px;
            text-align: center;
            cursor: pointer;
            min-height: 150px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-direction: column;
            font-size: 18px;
            width: 100%;
            height: 150px;
        }
        .school-box img {
            width: 100px;
            height: 100px;
            border-radius: 10px;
            margin-bottom: 5px;
        }
        .school-box .plus-icon {
            font-size: 30px;
            color: #007bff;
            margin-bottom: 5px;
        }
        .modal-body {
            max-height: 400px;
            overflow-y: auto;
        }
        .school-list-item {
            padding: 10px;
            border-bottom: 1px solid #ddd;
            cursor: pointer;
            display: flex;
            align-items: center;
        }
        .school-list-item img {
            width: 40px;
            height: 40px;
            margin-right: 10px;
            border-radius: 50%;
        }
        .school-details {
            margin-top: 10px;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
            background: #f9f9f9;
        }
    </style>
</head>
<body>
    <div class="container mt-4">
        <h3>Confused? Easy way to compare schools</h3>
        <div class="row sticky-section" id="selected-schools">
            <?php for ($i = 1; $i <= 4; $i++): ?>
                <div class="col-md-3">
                    <div class="school-box" id="box_<?php echo $i; ?>" onclick="openSchoolPopup(<?php echo $i; ?>)">
                        <div class="plus-icon">+</div>
                        <p>Add School</p>
                    </div>
                    <div id="details_<?php echo $i; ?>" class="school-details" style="display: none;"></div>
                </div>
            <?php endfor; ?>
        </div>
        
        <button class="btn btn-primary mt-3" id="compare-btn" style="display:none;" onclick="compareSchools()">Compare Schools</button>

        <!-- School Selection Modal -->
        <div class="modal" id="schoolModal">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Select Your School</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <input type="text" class="form-control" id="search-school" placeholder="Search School...">
                        <div id="school-list" class="mt-2">
                            <!-- Schools will be displayed here -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        var selectedBox = null;

        function openSchoolPopup(index) {
            selectedBox = index;
            $('#schoolModal').modal('show');
        }

        $('#search-school').on('input', function() {
            var searchText = $(this).val();
            $.ajax({
                url: '?fetch_schools=1&query=' + searchText,
                type: 'GET',
                success: function(response) {
                    $('#school-list').html(response);
                }
            });
        });

        function selectSchool(id, name, photo, address, status) {
            var imgSrc = photo ? '' + photo : 'default-school.png';
            $('#box_' + selectedBox).html(`<img src="${imgSrc}" alt="${name}"><p>${name}</p>`);
            $('#details_' + selectedBox).html(`<strong>Address:</strong> ${address}<br><strong>Status:</strong> ${status}`).show();
            $('#schoolModal').modal('hide');
            checkCompareButton();
        }

        function checkCompareButton() {
            let filledBoxes = 0;
            $('.school-box img').each(function() {
                if ($(this).attr('src') !== 'default-school.png') {
                    filledBoxes++;
                }
            });
            if (filledBoxes > 1) {
                $('#compare-btn').show();
            } else {
                $('#compare-btn').hide();
            }
        }

        function compareSchools() {
            let schoolIds = [];
            $('.school-box img').each(function() {
                if ($(this).attr('src') !== 'default-school.png') {
                    schoolIds.push($(this).parent().attr('id').split('_')[1]);
                }
            });
            if (schoolIds.length > 1) {
                window.location.href = 'compare-result.php?schools=' + schoolIds.join(',');
            }
        }
    </script>

    <?php
    if (isset($_GET['fetch_schools'])) {
        $query = isset($_GET['query']) ? $_GET['query'] : '';
        $sql = "SELECT id, name, photo, address, admission_status FROM schools WHERE name LIKE '%$query%' LIMIT 10";
        $result = mysqli_query($conn, $sql);

        while ($row = mysqli_fetch_assoc($result)) {
            $imgSrc = $row['photo'] ? '' . $row['photo'] : 'default-school.png';
            echo "<div class='school-list-item' onclick=\"selectSchool({$row['id']}, '{$row['name']}', '{$row['photo']}', '{$row['address']}', '{$row['admission_status']}')\">";
            echo "<img src='$imgSrc'><span>{$row['name']}</span>";
            echo "</div>";
        }
        exit;
    }
    ?>
</body>
</html>
