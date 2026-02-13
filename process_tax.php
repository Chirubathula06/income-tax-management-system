<?php
session_start();
include 'db.php';
include 'session_check.php';

if (!isset($_SESSION['employee_type'])) {
    header("Location: calculate_tax.php");
    exit();
}

$employee_type = $_SESSION['employee_type'];

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Enter Tax Details</title>
    <link rel="stylesheet" href="dashboard_tax.css">
</head>
<body>
    <div class="container">
        <h1>Step 2: Enter Your Tax Details</h1>

        <form action="compute_tax.php" method="post">
            <label>Employee Type:</label>
            <input type="text" value="<?php echo $employee_type; ?>" disabled>

            <label for="pan_card">PAN Card:</label>
            <input type="text" name="pan_card" required>

            <label for="aadhar_card">Aadhaar Number:</label>
            <input type="text" name="aadhar_card" required>

            <label for="salary">Salary Income (₹):</label>
            <input type="number" name="salary" required>

            <label for="business_income">Business Income (₹):</label>
            <input type="number" name="business_income" required>

            <label for="capital_gains">Capital Gains (₹):</label>
            <input type="number" name="capital_gains" required>

            <label for="other_income">Other Income (₹):</label>
            <input type="number" name="other_income" required>

            <label for="deductions">Total Deductions (₹):</label>
            <input type="number" name="deductions" required>

            <label for="allowances">Total Allowances (₹):</label>
            <input type="number" name="allowances" required>

            <button type="submit" class="btn">Calculate Tax</button>
        </form>
    </div>
</body>
</html>
