<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Load PHPMailer from the correct path
require __DIR__ . '/PHPMailer/src/PHPMailer.php';
require __DIR__ . '/PHPMailer/src/SMTP.php';
require __DIR__ . '/PHPMailer/src/Exception.php';

// Database connection
$conn = new mysqli("localhost", "root", "", "income_tax_management");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Retrieve form data
$name = $_POST['name'];
$email = $_POST['email'];
$message = $_POST['message'];

// Store data in the database
$sql = "INSERT INTO contacts (name, email, message) VALUES ('$name', '$email', '$message')";

if ($conn->query($sql) === TRUE) {
    // Send Email using PHPMailer
    $mail = new PHPMailer(true);

    try {
        // SMTP Configuration
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'chiranjeevibathula06@gmail.com'; // Change to your email
        $mail->Password = 'rota zpzc kpqd rcgs'; // Use an App Password for Gmail
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        // Email Settings
        $mail->setFrom($email, $name);
        $mail->addAddress('chiranjeevibathula06@gmail.com'); // Replace with website admin email
        $mail->Subject = "New Contact Form Submission";
        $mail->Body = "Name: $name\nEmail: $email\nMessage:\n$message";

        // Send Email
        if ($mail->send()) {
            echo "Message sent successfully.";
        } else {
            echo "Message could not be sent.";
        }
    } catch (Exception $e) {
        echo "Mailer Error: " . $mail->ErrorInfo;
    }
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

// Close connection
$conn->close();
?>
