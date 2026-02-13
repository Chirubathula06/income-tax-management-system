<?php
session_start();
include 'session_check.php';  // Ensure user is logged in
include 'db.php';  // Database connection

if (!isset($_SESSION['employee_id'])) {
    echo "<script>alert('Session expired. Please login again.'); window.location.href='loginn.html';</script>";
    exit();
}

$employee_id = $_SESSION['employee_id'];

$sql = "SELECT * FROM tax_payments WHERE employee_id = ? ORDER BY payment_date DESC";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $employee_id);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Payment History</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: url('https://images.pexels.com/photos/4386367/pexels-photo-4386367.jpeg?cs=srgb&dl=pexels-karolina-grabowska-4386367.jpg&fm=jpg') no-repeat center center fixed;
            background-size: cover;
            text-align: center;
            margin: 0;
            padding: 0;
        }
        .container {
            width: 70%;
            background-color: rgba(255, 255, 255, 0.95);
            padding: 20px;
            margin: 50px auto;
            border-radius: 10px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.2);
        }
        h2 {
            color: #333;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            background: white;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: center;
        }
        th {
            background-color: #007bff;
            color: white;
        }
        tr:nth-child(even) {
            background-color: #f2f2f2;
        }
        .btn {
            display: inline-block;
            margin-top: 15px;
            padding: 10px 15px;
            background-color: #28a745;
            color: white;
            text-decoration: none;
            border-radius: 5px;
        }
        .btn:hover {
            background-color: #218838;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Your Payment History</h2>
        <?php if ($result->num_rows > 0) { ?>
        <table>
            <tr>
                <th>Transaction ID</th>
                <th>Amount Paid</th>
                <th>Payment Method</th>
                <th>Status</th>
                <th>Date</th>
            </tr>
            <?php while ($row = $result->fetch_assoc()) { ?>
            <tr>
                <td><?php echo htmlspecialchars($row['transaction_id']); ?></td>
                <td>₹<?php echo number_format($row['amount_paid'], 2); ?></td>
                <td><?php echo htmlspecialchars($row['payment_method']); ?></td>
                <td><?php echo htmlspecialchars($row['status']); ?></td>
                <td><?php echo htmlspecialchars($row['payment_date']); ?></td>
            </tr>
            <?php } ?>
        </table>
        <?php } else { ?>
            <p>No payment history found.</p>
        <?php } ?>
        <a href="dashboard.php" class="btn">Back to Dashboard</a>
    </div>
</body>
</html>
