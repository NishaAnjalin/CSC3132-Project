<?php
$servername = "127.0.0.1:3306"; // Ensure this matches your local setup
$username = "root"; // Replace with your DB username
$password = "mariadb"; // Replace with your DB password
$dbname = "timetable_management"; // Ensure the database name is correct

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
// Continue with your logic
?>
