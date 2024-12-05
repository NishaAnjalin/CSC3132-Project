<?php
// Connect to database
$servername = "127.0.0.1:3306";
$username = "root";
$password = "mariadb";
$dbname = "timetable_management";
";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch user details (replace 1 with a dynamic user ID or session-based user ID)
$user_id = 1; // For demonstration, assuming the user ID is 1
$sql = "SELECT name, access_level FROM users WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <title>User Management</title>
</head>
<body class="bg-gray-800">
    <!-- Main Content -->
    <div class="flex-1 bg-gray-200 p-8">
        <div class="bg-white p-6 rounded shadow-md max-w-lg mx-auto">
            <h2 class="text-xl font-bold text-gray-800 mb-4">User Details</h2>

            <!-- User Form -->
            <form action="update_user.php" method="POST">
                <!-- Hidden field for User ID -->
                <input type="hidden" name="user_id" value="<?php echo $user_id; ?>">

                <!-- User Name -->
                <div class="mb-4">
                    <label class="block text-gray-700 font-bold mb-2" for="name">Name</label>
                    <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($user['name']); ?>" 
                           class="bg-gray-300 p-2 rounded w-full focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                </div>

                <!-- User Access -->
                <div class="mb-4">
                    <label class="block text-gray-700 font-bold mb-2" for="access">Access Level</label>
                    <select id="access" name="access" 
                            class="bg-gray-300 p-2 rounded w-full focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="Admin" <?php echo ($user['access_level'] == 'Admin') ? 'selected' : ''; ?>>Admin</option>
                        <option value="Editor" <?php echo ($user['access_level'] == 'Editor') ? 'selected' : ''; ?>>Editor</option>
                        <option value="Viewer" <?php echo ($user['access_level'] == 'Viewer') ? 'selected' : ''; ?>>Viewer</option>
                    </select>
                </div>

                <!-- Change Password -->
                <div class="mb-4">
                    <button type="button" onclick="toggleModal('passwordModal')" 
                            class="bg-blue-500 text-white p-2 rounded block w-full">Change Password</button>
                </div>

                <!-- Submit Button -->
                <div class="text-right">
                    <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded">Save Changes</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Change Password Modal -->
    <div id="passwordModal" class="hidden fixed inset-0 flex items-center justify-center bg-black bg-opacity-50">
        <div class="bg-white p-6 rounded shadow-md w-96">
            <h2 class="text-black text-lg font-bold mb-4">Change Password</h2>
            <form action="change_password.php" method="POST">
                <!-- Hidden User ID -->
                <input type="hidden" name="user_id" value="<?php echo $user_id; ?>">

                <!-- New Password -->
                <div class="mb-4">
                    <label class="block text-gray-700">New Password</label>
                    <input type="password" name="new_password" class="bg-gray-300 p-2 rounded w-full" required>
                </div>

                <!-- Confirm New Password -->
                <div class="mb-4">
                    <label class="block text-gray-700">Re-enter New Password</label>
                    <input type="password" name="confirm_password" class="bg-gray-300 p-2 rounded w-full" required>
                </div>

                <!-- Buttons -->
                <div class="flex justify-between">
                    <button type="button" onclick="toggleModal('passwordModal')" class="bg-red-500 text-white p-2 rounded w-24">Cancel</button>
                    <button type="submit" class="bg-green-500 text-white p-2 rounded w-24">Update</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        // Toggle modal visibility
        function toggleModal(id) {
            const modal = document.getElementById(id);
            if (modal.classList.contains('hidden')) {
                modal.classList.remove('hidden');
            } else {
                modal.classList.add('hidden');
            }
        }
    </script>
</body>
</html>

<?php
$conn->close();
?>
