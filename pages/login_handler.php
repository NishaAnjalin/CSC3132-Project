<?php
session_start();

// Dummy credentials
$valid_username = "admin";
$valid_password = "password";

// Get form data
$username = $_POST['username'] ?? '';
$password = $_POST['password'] ?? '';

// Validate credentials
if ($username === $valid_username && $password === $valid_password) {
    $_SESSION['message'] = "Login successful! Welcome back.";
    $_SESSION['message_type'] = "valid";
    header("Location: dashboard.php"); // Redirect to dashboard
} else {
    $_SESSION['message'] = $password === $valid_password 
        ? "Invalid username. Please try again." 
        : "Invalid password. Please try again.";
    $_SESSION['message_type'] = "invalid";
    header("Location: login.php"); // Redirect back to login page
}
exit();
