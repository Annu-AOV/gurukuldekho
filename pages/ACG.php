<?php
session_start();
if (!isset($_SESSION['step'])) {
    $_SESSION['step'] = 0;
    $_SESSION['formData'] = [];
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['field']) && isset($_POST['value'])) {
    $_SESSION['formData'][$_POST['field']] = $_POST['value'];
    $_SESSION['step']++;
}


$steps = [
    "Type of School",
    "Location",
    "Select Class",
    "Monthly Budget",
    "Preferred Board",
    "Review Details",
    "Recommendation Ready"
];

$currentStep = $_SESSION['step'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AI Consultant</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body class="bg-light d-flex justify-content-center align-items-center vh-100">
    <div class="card p-4 shadow" style="width: 400px;">
        <h4 class="text-center mb-3"><?php echo $steps[$currentStep]; ?></h4>
        
        <form method="POST">
            <?php if ($currentStep == 0) { ?>
                <button name="field" value="schoolType" type="submit" class="btn btn-primary w-100 mb-2">Day School</button>
                <button name="field" value="schoolType" type="submit" class="btn btn-primary w-100 mb-2">Boarding School</button>
                <button name="field" value="schoolType" type="submit" class="btn btn-primary w-100">Online School</button>
            <?php } elseif ($currentStep == 1) { ?>
                <input type="text" name="value" class="form-control mb-2" placeholder="Enter Location" required>
                <input type="hidden" name="field" value="location">
                <button type="submit" class="btn btn-primary w-100">Next</button>
            <?php } elseif ($currentStep == 2) { ?>
                <select name="value" class="form-control mb-2">
                    <?php for ($i = 1; $i <= 12; $i++) echo "<option>Class $i</option>"; ?>
                </select>
                <input type="hidden" name="field" value="class">
                <button type="submit" class="btn btn-primary w-100">Next</button>
            <?php } elseif ($currentStep == 3) { ?>
                <input type="number" name="value" class="form-control mb-2" placeholder="Enter Budget" required>
                <input type="hidden" name="field" value="budget">
                <button type="submit" class="btn btn-primary w-100">Next</button>
            <?php } elseif ($currentStep == 4) { ?>
                <select name="value" class="form-control mb-2">
                    <option>CBSE</option>
                    <option>ICSE</option>
                    <option>State Board</option>
                </select>
                <input type="hidden" name="field" value="board">
                <button type="submit" class="btn btn-primary w-100">Next</button>
            <?php } elseif ($currentStep == 5) { ?>
                <p><strong>School Type:</strong> <?php echo $_SESSION['formData']['schoolType']; ?></p>
                <p><strong>Location:</strong> <?php echo $_SESSION['formData']['location']; ?></p>
                <p><strong>Class:</strong> <?php echo $_SESSION['formData']['class']; ?></p>
                <p><strong>Budget:</strong> <?php echo $_SESSION['formData']['budget']; ?></p>
                <p><strong>Board:</strong> <?php echo $_SESSION['formData']['board']; ?></p>
                <button type="submit" class="btn btn-success w-100">Confirm</button>
            <?php } else { ?>
                <p class="text-success">Your recommendation is almost ready!</p>
            <?php } ?>
        </form>
    </div>
</body>
</html>
