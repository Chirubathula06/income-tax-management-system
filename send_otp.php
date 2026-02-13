<?php
session_start();
include 'db.php';
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Load PHPMailer
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';
require 'PHPMailer/src/Exception.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];

    // Check if email exists in the database
    $sql = "SELECT id FROM registrations WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        // Generate 6-digit OTP
        $otp = rand(100000, 999999);
        $_SESSION['otp'] = $otp;
        $_SESSION['email'] = $email;

        // Store OTP in the database
        $update_sql = "UPDATE registrations SET otp = ? WHERE email = ?";
        $update_stmt = $conn->prepare($update_sql);
        $update_stmt->bind_param("is", $otp, $email);
        $update_stmt->execute();

        // Configure PHPMailer for Gmail SMTP
        $mail = new PHPMailer(true);
        try {
            // Gmail SMTP Configuration
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'chiranjeevibathula06@gmail.com'; // Replace with your Gmail
            $mail->Password = 'rota zpzc kpqd rcgs'; // Use Gmail App Password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = 587;

            // Sender & Recipient
            $mail->setFrom('chiranjeevibathula06@gmail.com', 'Income Tax Management');
            $mail->addAddress($email);

            // Email content
            $mail->isHTML(true);
            $mail->Subject = 'Your OTP for Password Reset';
            $mail->Body = "<h3>Your OTP is: <strong>$otp</strong></h3>";

            // Send email
            $mail->send();

            // Redirect user to OTP verification page
            header("Location: verify_otp.html");
            exit();
        } catch (Exception $e) {
            echo "Failed to send OTP. Error: " . $mail->ErrorInfo;
        }
    } else {
        echo "Email not found.";
    }

    $stmt->close();
    $conn->close();
}
?>
