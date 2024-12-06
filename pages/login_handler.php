<?php
session_start();

// Connect to the database
$servername = "localhost";
$username = "root";
$password = "mariadb";
$dbname = "timetable_management";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Database connection failed: " . $conn->connect_error);
}

// Check for CSRF token
if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
    $_SESSION['message'] = "Invalid request. Please try again.";
    $_SESSION['message_type'] = "invalid";
    header("Location: login.php");
    exit();
}

// Get form data and sanitize
$username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_STRING);
$password = $_POST['password']; // Password is sanitized differently

// Fetch user from the database
$sql = "SELECT username, password FROM users WHERE username = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 1) {
    $user = $result->fetch_assoc();
    
    // Verify password
    if (password_verify($password, $user['password'])) {
        $_SESSION['message'] = "Login successful! Welcome back.";
        $_SESSION['message_type'] = "valid";
        $_SESSION['user'] = $user['username']; // Store logged-in user
        header("Location: dashboard.php"); // Redirect to dashboard
        exit();
    }
}

// Invalid credentials
$_SESSION['message'] = "Invalid username or password. Please try again.";
$_SESSION['message_type'] = "invalid";
header("Location: login.php");
exit();
?>
