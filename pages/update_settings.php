<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve form data
    $user_id = $_POST['user_id'];
    $notifications = $_POST['notifications'];
    $theme = $_POST['theme'];
    $language = $_POST['language'];

    // Connect to the database
    $conn = new mysqli('localhost', 'root', '', 'your_database');
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Update settings
    $sql = "UPDATE settings SET notifications = ?, theme = ?, language = ? WHERE user_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssi", $notifications, $theme, $language, $user_id);

    if ($stmt->execute()) {
        echo '<script>alert("Settings updated successfully!"); window.location.href = "settings.php";</script>';
    } else {
        echo '<script>alert("Error updating settings."); window.history.back();</script>';
    }

    $stmt->close();
    $conn->close();
}
?>
