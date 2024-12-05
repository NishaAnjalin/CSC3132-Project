<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id = $_POST['user_id'];
    $name = $_POST['name'];
    $access = $_POST['access'];

    // Database connection
    $conn = new mysqli('localhost', 'root', '', 'your_database');
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Update user details
    $sql = "UPDATE users SET name = ?, access_level = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssi", $name, $access, $user_id);
    if ($stmt->execute()) {
        echo '<script>alert("User details updated successfully!"); window.location.href = "user.php";</script>';
    } else {
        echo '<script>alert("Error updating user details."); window.history.back();</script>';
    }

    $stmt->close();
    $conn->close();
}
?>
