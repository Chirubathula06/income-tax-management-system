<?php
session_start();
include 'db.php';
include 'session_check.php';

$employee_id = $_SESSION['employee_id'];

if (!$conn) {
    die("Database connection error: " . mysqli_connect_error());
}

// Fetch employee details
$sql = "SELECT * FROM employees WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $employee_id);
$stmt->execute();
$result = $stmt->get_result();
$employee = $result->fetch_assoc();

// Fetch tax calculation history (latest first)
$sql = "SELECT * FROM tax_calculations WHERE employee_id = ? ORDER BY calculation_date DESC";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $employee_id);
$stmt->execute();
$tax_result = $stmt->get_result();

// Get the most recent tax calculation for payment
$latest_tax = $tax_result->fetch_assoc();
$tax_due = $latest_tax ? $latest_tax['tax_amount'] : 0;
$_SESSION['tax_due'] = $tax_due; // Store in session
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Dashboard</title>
    <link rel="stylesheet" href="dashboard_tax.css"> <!-- External CSS -->
</head>
<body>
    <div class="dashboard-container">
        <h1>Welcome, <?php echo htmlspecialchars($employee['name']); ?></h1>

        <h2>Your Tax Calculation History</h2>
        <table>
            <tr>
                <th>Date</th>
                <th>Taxable Income (₹)</th>
                <th>Tax Amount (₹)</th>
                <th>Tax Rate (%)</th>
            </tr>
            <?php
            // Reset result pointer and loop through tax records
            $tax_result->data_seek(0);
            while ($row = $tax_result->fetch_assoc()) { ?>
                <tr>
                    <td><?php echo date('d-m-Y', strtotime($row['calculation_date'])); ?></td>
                    <td><?php echo number_format($row['taxable_income'], 2); ?></td>
                    <td><?php echo number_format($row['tax_amount'], 2); ?></td>
                    <td><?php echo number_format($row['tax_rate'], 2); ?>%</td>
                </tr>
            <?php } ?>
        </table>

        <a href="select_employee.php" class="btn">Calculate New Tax</a>

        <?php if ($tax_due > 0) { ?>
            <p><strong>Tax Amount Due: ₹<?php echo number_format($tax_due, 2); ?></strong></p>
            <a href="pay_tax.php" class="btn pay-btn">Pay Tax</a>
        <?php } ?>
        <a href="payment_history.php" class="btn delete">Payment History </a>
        <a href="logout.php" class="btn delete">Logout</a>
    </div>
</body>
</html>
