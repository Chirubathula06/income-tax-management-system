<?php
$host = "localhost";
$user = "root"; // Change if using a different user
$password = ""; // Set your MySQL password
$database = "income_tax_management";

$conn = new mysqli($host, $user, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
