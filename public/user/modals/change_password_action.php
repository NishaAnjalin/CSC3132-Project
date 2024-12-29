<?php
session_start();
require_once '../../../conf/dbconf.php'; // Include database configuration
require_once '../../function/fun.php';  // Include helper functions

// Check if the user is authenticated
if (!isAuthenticated()) {
    header('Location: ../../login/login.php');
    exit();
}

// Check if form data is received
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id = $_SESSION['user']; // Assumes user ID is stored in the session
    $old_password = $_POST['old_password'];
    $new_password = $_POST['new_password'];

    // Fetch the current password hash for the user
    $stmt = $conn->prepare("SELECT password FROM admin WHERE username = ?");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $stmt->bind_result($current_password_hash);
    $stmt->fetch();
    $stmt->close();

    // Verify the old password
    if (!password_verify($old_password, $current_password_hash)) {
        $_SESSION['message'] = "Current password is incorrect.";
        $_SESSION['message_type'] = "error";
        header('Location: ../../dashboard/dashboard.php?content=../../public/user/user_panel.php');
        exit();
    }

    // Hash the new password
    $new_password_hash = password_hash($new_password, PASSWORD_BCRYPT);

    // Update the new password in the database
    $stmt = $conn->prepare("UPDATE admin SET password = ? WHERE username = ?");
    $stmt->bind_param("si", $new_password_hash, $user_id);

    if ($stmt->execute()) {
        $_SESSION['message'] = "Password updated successfully.";
        $_SESSION['message_type'] = "success";
    } else {
        $_SESSION['message'] = "Failed to update password.";
        $_SESSION['message_type'] = "error";
    }

    $stmt->close();
    $conn->close();

    header('Location: ../../dashboard/dashboard.php?content=../../public/user/user_panel.php');
    exit();
} else {
    header('HTTP/1.1 403 Forbidden');
    echo "Invalid request.";
    exit();
}
?>
