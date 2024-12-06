<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validate and sanitize inputs
    $user_id = isset($_POST['user_id']) ? intval($_POST['user_id']) : 0;
    $name = isset($_POST['name']) ? trim($_POST['name']) : '';
    $access = isset($_POST['access']) ? trim($_POST['access']) : '';

    // Check for required fields
    if ($user_id <= 0 || empty($name) || empty($access)) {
        echo '<script>alert("Invalid input. Please try again."); window.history.back();</script>';
        exit;
    }

    // Database connection
    $conn = new mysqli('localhost', 'root', 'mariadb', 'timetable_management');

    // Check connection
    if ($conn->connect_error) {
        error_log("Database connection failed: " . $conn->connect_error); // Log error
        echo '<script>alert("Database connection failed. Please try again later."); window.history.back();</script>';
        exit;
    }

    // Update user details
    $sql = "UPDATE users SET name = ?, access_level = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);

    if ($stmt) {
        $stmt->bind_param("ssi", $name, $access, $user_id);
        if ($stmt->execute()) {
            echo '<script>alert("User details updated successfully!"); window.location.href = "user.php";</script>';
        } else {
            error_log("Failed to update user: " . $stmt->error); // Log error
            echo '<script>alert("Error updating user details. Please try again."); window.history.back();</script>';
        }
        $stmt->close();
    } else {
        error_log("Failed to prepare SQL statement: " . $conn->error); // Log error
        echo '<script>alert("Error updating user details. Please try again."); window.history.back();</script>';
    }

    $conn->close();
} else {
    // Redirect to the user page if accessed directly
    header("Location: user.php");
    exit;
}
