<?php
session_start();
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $sql = "SELECT id, password FROM registrations WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();
    
    if ($stmt->num_rows > 0) {
        $stmt->bind_result($id, $hashed_password);
        $stmt->fetch();
        
        if (password_verify($password, $hashed_password)) {
            $_SESSION["employee_id"] = $id;
            $_SESSION["email"] = $email;

            // Store login details
            $ip_address = $_SERVER['REMOTE_ADDR'];
            $login_sql = "INSERT INTO logins (user_id, email, ip_address) VALUES (?, ?, ?)";
            $login_stmt = $conn->prepare($login_sql);
            $login_stmt->bind_param("iss", $id, $email, $ip_address);
            $login_stmt->execute();
            $login_stmt->close();

            header("Location: dashboard.php");
            exit();
        } else {
            echo "Invalid email or password.";
        }
    } else {
        echo "No user found.";
    }

    $stmt->close();
    $conn->close();
}
?>
