<?php
session_start();
include 'db.php';
include 'session_check.php';

if (!isset($_SESSION['employee_id'])) {
    header("Location: enter_tax_details.php");
    exit();
}

$employee_id = $_SESSION['employee_id'];
$result = $conn->query("SELECT * FROM employees WHERE id = $employee_id");
$employee = $result->fetch_assoc();

$total_income = $employee['salary'] + $employee['business_income'] + $employee['capital_gains'] + $employee['other_income'];
$taxable_income = $total_income + $employee['allowances'] - $employee['deductions'];

function calculateTax($income) {
    if ($income <= 400000) return 0;
    elseif ($income <= 800000) return ($income - 400000) * 0.05;
    elseif ($income <= 1200000) return (400000 * 0.05) + ($income - 800000) * 0.10;
    elseif ($income <= 1600000) return (400000 * 0.05) + (400000 * 0.10) + ($income - 1200000) * 0.15;
    elseif ($income <= 2000000) return (400000 * 0.05) + (400000 * 0.10) + (400000 * 0.15) + ($income - 1600000) * 0.20;
    elseif ($income <= 2400000) return (400000 * 0.05) + (400000 * 0.10) + (400000 * 0.15) + (400000 * 0.20) + ($income - 2000000) * 0.25;
    else return (400000 * 0.05) + (400000 * 0.10) + (400000 * 0.15) + (400000 * 0.20) + (400000 * 0.25) + ($income - 2400000) * 0.30;
}

$tax_amount = calculateTax($taxable_income);
$tax_rate = ($tax_amount / $taxable_income) * 100;

// Insert into tax_calculations table
$stmt = $conn->prepare("INSERT INTO tax_calculations (employee_id, taxable_income, tax_amount, tax_rate) VALUES (?, ?, ?, ?)");
$stmt->bind_param("iddd", $employee_id, $taxable_income, $tax_amount, $tax_rate);
$stmt->execute();
$stmt->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Tax Calculation Result</title>
    <link rel="stylesheet" href="dashboard_tax.css">
</head>
<body>
    <div class="dashboard-container">
        <h1>Tax Calculation Result</h1>
        <table>
            <tr><th>Employee Name</th><td><?php echo $employee['name']; ?></td></tr>
            <tr><th>Employee Type</th><td><?php echo $employee['category']; ?></td></tr>
            <tr><th>Total Income (₹)</th><td><?php echo number_format($total_income, 2); ?></td></tr>
            <tr><th>Total Deductions (₹)</th><td><?php echo number_format($employee['deductions'], 2); ?></td></tr>
            <tr><th>Taxable Income (₹)</th><td><?php echo number_format($taxable_income, 2); ?></td></tr>
            <tr><th>Tax Amount (₹)</th><td><?php echo number_format($tax_amount, 2); ?></td></tr>
        </table>
        <a href="dashboard.php" class="btn">Go to Dashboard</a>
    </div>
</body>
</html>
