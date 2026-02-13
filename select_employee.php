<?php
session_start();
include 'db.php';
include 'session_check.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $employee_type = $_POST['employee_type'];
    $_SESSION['employee_type'] = $employee_type;
    header("Location: enter_tax_details.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Select Employee Type</title>
    <link rel="stylesheet" href="dashboard_tax.css">
</head>
<body>
    <div class="dashboard-container">
        <h1>Step 1: Select Employee Type</h1>
        <form action="" method="post">
            <label for="employee_type">Select Employee Type:</label>
            <select name="employee_type" required>
                <option value="Professor">Professor</option>
                <option value="Lecturer">Lecturer</option>
                <option value="Admin">Admin</option>
                <option value="Support Staff">Support Staff</option>
            </select>
            <button type="submit" class="btn">Next</button>
        </form>
    </div>
</body>
</html>
