<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $newPassword = $_POST['newPassword'];
    $confirmPassword = $_POST['confirmPassword'];

    // Simple validation
    if ($newPassword !== $confirmPassword) {
        echo '<script>alert("Passwords do not match!"); window.history.back();</script>';
        exit;
    }

    // Password strength validation
    if (strlen($newPassword) < 6 || !preg_match('/[A-Z]/', $newPassword) || !preg_match('/[0-9]/', $newPassword)) {
        echo '<script>alert("Password must be at least 6 characters long, include an uppercase letter, and a number."); window.history.back();</script>';
        exit;
    }

    // Simulate saving the password (you would normally save this to a database)
    // Ensure you hash passwords for secure storage
    $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);

    // Mock success message
    echo '<script>alert("Password updated successfully!"); window.location.href = "index.html";</script>';
}
?>
