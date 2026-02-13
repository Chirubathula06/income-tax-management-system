<?php
session_start();
include 'db.php';
include 'session_check.php';

if (!isset($_SESSION['employee_type'])) {
    header("Location: select_employee.php");
    exit();
}

$employee_type = $_SESSION['employee_type'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = trim($_POST['name']);
    $dob = $_POST['dob'];
    $gender = $_POST['gender'];
    $email = trim($_POST['email']);
    $salary = (float) $_POST['salary'];
    $business_income = (float) $_POST['business_income'];
    $capital_gains = (float) $_POST['capital_gains'];
    $other_income = (float) $_POST['other_income'];
    $deductions = (float) $_POST['deductions'];
    $allowances = (float) $_POST['allowances'];
    $pan_card = trim($_POST['pan_card']);
    $aadhar_card = trim($_POST['aadhar_card']);

    // ✅ Check if PAN and Aadhaar are empty or '0'
    if (empty($pan_card) || $pan_card === '0') {
        die("Error: PAN Card is required and cannot be '0'.");
    }

    if (empty($aadhar_card) || $aadhar_card === '0') {
        die("Error: Aadhaar Number is required and cannot be '0'.");
    }

    // ✅ Validate PAN & Aadhaar
    if (!preg_match('/^[A-Z]{5}[0-9]{4}[A-Z]$/', $pan_card)) {
        die("Error: Invalid PAN Card format. Example: ABCDE1234F");
    }

    if (!preg_match('/^[0-9]{12}$/', $aadhar_card)) {
        die("Error: Invalid Aadhaar Number format. It should be 12 digits.");
    }

    // ✅ Check for duplicate PAN/Aadhaar
    $employee_id = $_SESSION['employee_id'] ?? 0;
    $check_sql = "SELECT id FROM employees WHERE (pan_card = ? OR aadhar_card = ?) AND id != ?";
    $check_stmt = $conn->prepare($check_sql);

    if (!$check_stmt) {
        die("SQL Prepare Error (Check): " . $conn->error);
    }

    $check_stmt->bind_param("ssi", $pan_card, $aadhar_card, $employee_id);
    $check_stmt->execute();
    $check_stmt->store_result();

    if ($check_stmt->num_rows > 0) {
        die("Error: The entered PAN or Aadhaar is already linked to another employee.");
    }
    $check_stmt->close();

    // ✅ Insert employee details
    $sql = "INSERT INTO employees (name, category, dob, gender, email, salary, business_income, capital_gains, other_income, deductions, allowances, pan_card, aadhar_card) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

    $stmt = $conn->prepare($sql);

    if (!$stmt) {
        die("SQL Prepare Error: " . $conn->error);
    }

    $stmt->bind_param("ssssssdddddss", $name, $employee_type, $dob, $gender, $email, $salary, $business_income, $capital_gains, $other_income, $deductions, $allowances, $pan_card, $aadhar_card);

    if ($stmt->execute()) {
        $_SESSION['employee_id'] = $stmt->insert_id;
        $stmt->close();
        header("Location: compute_tax.php");
        exit();
    } else {
        die("Execution Error: " . $stmt->error);
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Enter Tax Details</title>
    <link rel="stylesheet" href="dashboard_tax.css">
</head>
<body>
    <div class="dashboard-container">
        <h1>Step 2: Enter Employee Details</h1>
        <form action="" method="post">
            <label>Name:</label>
            <input type="text" name="name" required>
            
            <label>Date of Birth:</label>
            <input type="date" name="dob" required>
            
            <label>Gender:</label>
            <select name="gender" required>
                <option value="Male">Male</option>
                <option value="Female">Female</option>
                <option value="Other">Other</option>
            </select>
            
            <label>Email:</label>
            <input type="email" name="email" required>
            
            <label>PAN Card:</label>
            <input type="text" name="pan_card" required>
            
            <label>Aadhaar Number:</label>
            <input type="text" name="aadhar_card" required>
            
            <label>Salary Income (₹):</label>
            <input type="number" step="0.01" name="salary" required>
            
            <label>Business Income (₹):</label>
            <input type="number" step="0.01" name="business_income" required>
            
            <label>Capital Gains (₹):</label>
            <input type="number" step="0.01" name="capital_gains" required>
            
            <label>Other Income (₹):</label>
            <input type="number" step="0.01" name="other_income" required>
            
            <label>Total Deductions (₹):</label>
            <input type="number" step="0.01" name="deductions" required>
            
            <label>Total Allowances (₹):</label>
            <input type="number" step="0.01" name="allowances" required>
            
            <button type="submit" class="btn">Next</button> 
        </form>
    </div>
</body>
</html>
