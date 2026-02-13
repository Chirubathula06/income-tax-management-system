<?php
session_start();
include 'session_check.php';  // Ensure session validation
include 'db.php';  // Ensure database connection

$employee_id = $_SESSION['employee_id'];
$tax_due = $_SESSION['tax_due'];  // Ensure tax due is stored in the session

// Debug: Check if database connection is working
if (!$conn) {
    die("Database connection failed: " . mysqli_connect_error());
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $amount = $_POST['amount'];
    $payment_method = $_POST['payment_method'];
    $transaction_id = uniqid("TXN_"); // Generate unique transaction ID

    // Debug: Check if tax already paid
    $check_sql = "SELECT * FROM tax_payments WHERE employee_id = ? AND amount_paid = ? AND status = 'Completed'";
    $check_stmt = $conn->prepare($check_sql);
    if (!$check_stmt) {
        die("SQL Error (Check Payment): " . $conn->error);
    }
    $check_stmt->bind_param("id", $employee_id, $tax_due);
    $check_stmt->execute();
    $check_result = $check_stmt->get_result();

    if ($check_result->num_rows > 0) {
        echo "<script>alert('You have already paid this tax amount.'); window.location.href='dashboard.php';</script>";
        exit();
    }

    // Ensure exact payment amount
    if ($amount != $tax_due) {
        echo "<script>alert('Invalid payment amount. Please pay the exact tax due.');</script>";
    } else {
        // Insert payment record
        $sql = "INSERT INTO tax_payments (employee_id, amount_paid, payment_method, transaction_id, status) 
                VALUES (?, ?, ?, ?, 'Completed')";
        $stmt = $conn->prepare($sql);
        
        // Debug: Check if SQL query failed
        if (!$stmt) {
            die("SQL Error (Insert Payment): " . $conn->error);
        }
        
        $stmt->bind_param("idss", $employee_id, $amount, $payment_method, $transaction_id);
        if ($stmt->execute()) {
            echo "<script>alert('Payment Successful! Transaction ID: " . $transaction_id . "'); window.location.href='dashboard.php';</script>";
        } else {
            echo "<script>alert('Payment Failed. Please try again.');</script>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Pay Tax</title>
    <script>
        function showPaymentDetails() {
            var method = document.getElementById("payment_method").value;
            var detailsDiv = document.getElementById("payment_details_div");

            if (method == "UPI") {
                detailsDiv.innerHTML = '<label>UPI ID:</label><input type="text" name="payment_details" required placeholder="Enter UPI ID">';
            } else if (method == "Credit Card" || method == "Debit Card") {
                detailsDiv.innerHTML = '<label>Card Number:</label><input type="text" name="payment_details" required placeholder="Enter Card Number">';
            } else if (method == "Net Banking") {
                detailsDiv.innerHTML = '<label>Bank Reference Number:</label><input type="text" name="payment_details" required placeholder="Enter Bank Reference">';
            } else {
                detailsDiv.innerHTML = "";
            }
        }
    </script>
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
            width: 40%;
            background-color: rgba(255, 255, 255, 0.9);
            padding: 20px;
            margin: 100px auto;
            border-radius: 10px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.2);
        }
        h2 { color: #333; }
        select, input {
            width: 80%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 16px;
        }
        .btn {
            background-color: #28a745;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
        }
        .btn:hover { background-color: #218838; }
    </style>
</head>
<body>
    <div class="container">
        <h2>Pay Your Tax</h2>
        <form method="post" action="">
            <label>Tax Amount: <span class="amount">₹<?php echo $tax_due; ?></span></label><br><br>
            <label>Payment Method:</label>
            <select id="payment_method" name="payment_method" required onchange="showPaymentDetails()">
                <option value="">Select Payment Method</option>
                <option value="UPI">UPI</option>
                <option value="Credit Card">Credit Card</option>
                <option value="Debit Card">Debit Card</option>
                <option value="Net Banking">Net Banking</option>
            </select><br><br>
            
            <div id="payment_details_div"></div> <!-- Dynamic Payment Details -->

            <input type="hidden" name="amount" value="<?php echo $tax_due; ?>">
            <button type="submit" class="btn">Pay Now</button>
        </form>
    </div>
</body>
</html>
