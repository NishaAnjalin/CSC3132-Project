<?php
session_start(); // Start the session for CSRF token management

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // CSRF token validation
    if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
        die('CSRF token mismatch.');
    }

    $newPassword = $_POST['newPassword'];
    $confirmPassword = $_POST['confirmPassword'];

    // Validate password match
    if ($newPassword !== $confirmPassword) {
        echo "Error: Passwords do not match.";
        exit;
    }

    // Password strength validation
    if (strlen($newPassword) < 8 || 
        !preg_match('/[A-Z]/', $newPassword) || 
        !preg_match('/[0-9]/', $newPassword) || 
        !preg_match('/[\W]/', $newPassword)) {
        echo "Error: Password must be at least 8 characters long, include an uppercase letter, a number, and a special character.";
        exit;
    }

    // Hash the password
    $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);

    // Simulate saving password (replace with database query)
    // Example: Update user table with the hashed password
    // $query = $pdo->prepare("UPDATE users SET password = ? WHERE id = ?");
    // $query->execute([$hashedPassword, $userId]);

    echo "Password updated successfully!";
    exit;
}

// Generate CSRF token
$_SESSION['csrf_token'] = bin2hex(random_bytes(32));
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Change Password</title>
</head>
<body>
    <form action="changepass.php" method="POST">
        <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($_SESSION['csrf_token']); ?>">
        <label for="newPassword">New Password:</label>
        <input type="password" name="newPassword" id="newPassword" required>
        <br>
        <label for="confirmPassword">Confirm Password:</label>
        <input type="password" name="confirmPassword" id="confirmPassword" required>
        <br>
        <button type="submit">Change Password</button>
    </form>
</body>
</html>
