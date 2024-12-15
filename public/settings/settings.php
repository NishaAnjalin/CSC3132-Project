<?php
// Start session and connect to the database
//session_start();
$servername = "127.0.0.1:3306"; // Updated to correct localhost IP
$username = "root";
$password = "mariadb";
$dbname = "timetable_management";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch user ID from session
//$user_id = $_SESSION['user_id'] ?? 1; // Fallback to 1 if session is not set (for testing)

// Fetch user settings
//$sql = "SELECT * FROM settings WHERE user_id = ?";
//$stmt = $conn->prepare($sql);
//$stmt->bind_param("i", $user_id);
//$stmt->execute();
//$result = $stmt->get_result();
//$settings = $result->fetch_assoc() ?: ['notifications' => 'Enabled', 'theme' => 'Light', 'language' => 'English'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <title>Settings</title>
</head>
<body class="bg-gray-900 text-gray-100">
    <div class="min-h-screen flex items-center justify-center">
        <div class="bg-gray-800 text-gray-100 p-6 rounded shadow-md w-full max-w-lg">
            <h2 class="text-2xl font-bold mb-4">Settings</h2>
            <form action="update_settings.php" method="POST">
                <!-- Hidden User ID -->
                <input type="hidden" name="user_id" value="<?php echo htmlspecialchars($user_id); ?>">

                <!-- Notifications -->
                <div class="mb-4">
                    <label class="block text-gray-400 font-bold mb-2">Notifications</label>
                    <select name="notifications" class="bg-gray-700 text-gray-100 p-2 rounded w-full focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="Enabled" <?php echo ($settings['notifications'] === 'Enabled') ? 'selected' : ''; ?>>Enabled</option>
                        <option value="Disabled" <?php echo ($settings['notifications'] === 'Disabled') ? 'selected' : ''; ?>>Disabled</option>
                    </select>
                </div>

                <!-- Theme -->
                <div class="mb-4">
                    <label class="block text-gray-400 font-bold mb-2">Theme</label>
                    <select name="theme" class="bg-gray-700 text-gray-100 p-2 rounded w-full focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="Light" <?php echo ($settings['theme'] === 'Light') ? 'selected' : ''; ?>>Light</option>
                        <option value="Dark" <?php echo ($settings['theme'] === 'Dark') ? 'selected' : ''; ?>>Dark</option>
                    </select>
                </div>

                <!-- Language -->
                <div class="mb-4">
                    <label class="block text-gray-400 font-bold mb-2">Language</label>
                    <select name="language" class="bg-gray-700 text-gray-100 p-2 rounded w-full focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="English" <?php echo ($settings['language'] === 'English') ? 'selected' : ''; ?>>English</option>
                        <option value="Spanish" <?php echo ($settings['language'] === 'Spanish') ? 'selected' : ''; ?>>Spanish</option>
                        <option value="French" <?php echo ($settings['language'] === 'French') ? 'selected' : ''; ?>>French</option>
                    </select>
                </div>

                <!-- Save Button -->
                <div class="text-right">
                    <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded">Save Changes</button>
                </div>
            </form>
        </div>
    </div>
</body>
</html>

<?php
$conn->close();
?>
