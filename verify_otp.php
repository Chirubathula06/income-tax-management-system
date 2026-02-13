<?php
session_start();
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $entered_otp = $_POST['otp'];

    if (!isset($_SESSION['email'])) {
        die("Session expired. Please <a href='forgot_password.html'>request a new OTP</a>.");
    }

    $email = $_SESSION['email'];

    // Fetch OTP from the database
    $sql = "SELECT otp FROM registrations WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->bind_result($stored_otp);
    $stmt->fetch();
    $stmt->close();

    if ($stored_otp == $entered_otp) {
        $_SESSION['otp_verified'] = true;
        header("Location: reset_password.html"); // Redirect to password reset page
        exit();
    } else {
        echo "Invalid OTP. <a href='verify_otp.html'>Try again</a>.";
    }
}

$conn->close();
?>
