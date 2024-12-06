<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Sanitize and validate input
    $user_id = isset($_POST['user_id']) ? intval($_POST['user_id']) : 0;
    $notifications = isset($_POST['notifications']) ? trim($_POST['notifications']) : '';
    $theme = isset($_POST['theme']) ? trim($_POST['theme']) : '';
    $language = isset($_POST['language']) ? trim($_POST['language']) : '';

    // Validate required fields
    if ($user_id <= 0 || empty($notifications) || empty($theme) || empty($language)) {
        echo '<script>alert("Invalid input. Please try again."); window.history.back();</script>';
        exit;
    }

    // Connect to the database
    $conn = new mysqli('127.0.0.1:3306', 'root', 'mariadb', 'timetable_management');

    if ($conn->connect_error) {
        error_log("Database connection failed: " . $conn->connect_error); // Log error
        echo '<script>alert("Failed to connect to the database. Please try again later."); window.history.back();</script>';
        exit;
    }

    // Prepare and execute the update query
    $sql = "UPDATE settings SET notifications = ?, theme = ?, language = ? WHERE user_id = ?";
    $stmt = $conn->prepare($sql);

    if ($stmt) {
        $stmt->bind_param("sssi", $notifications, $theme, $language, $user_id);

        if ($stmt->execute()) {
            echo '<script>alert("Settings updated successfully!"); window.location.href = "settings.php";</script>';
        } else {
            error_log("Error updating settings: " . $stmt->error); // Log error
            echo '<script>alert("Error updating settings. Please try again."); window.history.back();</script>';
        }

        $stmt->close();
    } else {
        error_log("Failed to prepare SQL statement: " . $conn->error); // Log error
        echo '<script>alert("Error updating settings. Please try again."); window.history.back();</script>';
    }

    $conn->close();
} else {
    // Redirect non-POST requests
    header("Location: settings.php");
    exit;
}
