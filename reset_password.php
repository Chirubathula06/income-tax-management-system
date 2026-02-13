<?php
session_start();
include 'db.php';

if (!isset($_SESSION['otp_verified']) || $_SESSION['otp_verified'] !== true) {
    die("Unauthorized access. <a href='forgot_password.html'>Request a new OTP</a>.");
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $new_password = password_hash($_POST['new_password'], PASSWORD_DEFAULT);
    $email = $_SESSION['email'];

    // Update password in the database
    $sql = "UPDATE registrations SET password = ?, otp = NULL WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $new_password, $email);
    
    if ($stmt->execute()) {
        session_destroy(); // Clear session after password reset
        echo "Password reset successfully! <a href='loginn.html'>Login Here</a>";
    } else {
        echo "Error updating password.";
    }

    $stmt->close();
}

$conn->close();
?>
