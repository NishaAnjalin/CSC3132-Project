<?php
// Database connection and fetching users from the database
require_once '../../conf/dbconf.php'; // Database configuration
require_once '../function/fun.php';  // Helper functions

// Check if the user is authenticated
if (!isAuthenticated()) {
    header('Location: ../../login/login.php');
    exit();
}

// Fetch users from the database
$stmt = $conn->prepare("SELECT admin_id, username, admin_type FROM admin ORDER BY username ASC");
$stmt->execute();
$result = $stmt->get_result();
$users = $result->fetch_all(MYSQLI_ASSOC);
$stmt->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <title>Manage Users</title>
</head>
<body class="bg-gray-800 text-white">
<div class="container mx-auto p-8">
    <a href="dashboard.php?content=../../public/user/user_panel.php" class="bg-blue-500 text-white px-6 py-2 rounded">Back</a>
    
    <!-- Header and Add Button -->
    <div class="flex justify-between items-center mb-4">
        <h1 class="text-2xl font-bold">Manage Users</h1>
        <button class="bg-blue-500 text-white px-4 py-2 rounded" onclick="openAddModal()">Add User</button>
    </div>

    <!-- List Users -->
    <table class="w-full bg-gray-900 rounded text-left text-white">
        <thead>
            <tr class="border-b border-gray-700">
                <th class="p-4">Username</th>
                <th class="p-4">Role</th>
                <th class="p-4 text-center">Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($users as $index => $user): ?>
                <tr class="border-b border-gray-700">
                    <td class="p-4"><?php echo htmlspecialchars($user['username']); ?></td>
                    <td class="p-4"><?php echo htmlspecialchars($user['admin_type']); ?></td>
                    <td class="p-4 text-center">
                        <!-- Update Button -->
                        <button class="bg-blue-500 text-white px-3 py-1 rounded" 
                            onclick="openUpdateModal(<?php echo $user['admin_id']; ?>, '<?php echo $user['username']; ?>', '<?php echo $user['admin_type']; ?>')">
                            Update
                        </button>

                        <!-- Delete Button -->
                        <button class="bg-red-500 text-white px-3 py-1 rounded" onclick="confirmDelete(<?php echo $user['admin_id']; ?>)">Delete</button>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <!-- Add User Form -->
    <div id="AddModal" class="hidden fixed inset-0 flex items-center justify-center bg-black bg-opacity-50">
        <div class="bg-white p-6 rounded shadow-md w-96">
            <h2 class="text-xl font-bold mb-4">Add New User</h2>
            <form action="../user/modals/user_actions.php" method="POST">
                <input type="hidden" name="action" value="add">
                <div class="mb-4">
                    <input type="text" name="username" placeholder="Enter Username" class="bg-gray-300 p-2 rounded w-full" required>
                </div>
                <div class="mb-4">
                    <select name="admin_type" id="" class="w-full p-2 border border-gray-300 rounded-lg">
                        <option value="superadmin">Super Admin</option>
                        <option value="moderator">Moderator</option>
                        <option value="editor">Editor</option>
                    </select>                    
                </div>
                <div class="mb-4">
                    <input type="password" name="password" placeholder="Enter Password" class="bg-gray-300 p-2 rounded w-full" required>
                </div>
                <div class="flex justify-between">
                    <button type="button" onclick="closeModal()" class="bg-red-500 text-white px-4 py-2 rounded">Cancel</button>
                    <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Add User</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Update Modal -->
    <div id="updateModal" class="hidden fixed inset-0 flex items-center justify-center bg-black bg-opacity-50">
        <div class="bg-white p-6 rounded shadow-md w-96">
            <h2 class="text-lg font-bold mb-4">Update User</h2>
            <form action="../user/modals/user_actions.php" method="POST">
                <input type="hidden" name="action" value="update">
                <input type="hidden" id="admin_id" name="admin_id">
                <div class="mb-4">
                    <label class="block text-gray-700">Username</label>
                    <input type="text" id="username" name="username" class="bg-gray-300 p-2 rounded w-full" required>
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700">Role</label>
                    <select name="admin_type" id="admin_type" class="w-full p-2 border border-gray-300 rounded-lg">
                        <option value="superadmin">Super Admin</option>
                        <option value="moderator">Moderator</option>
                        <option value="editor">Editor</option>
                    </select>                    
                </div>
                <div class="mb-4">
                    <input type="password" name="password" placeholder="Enter Password" class="bg-gray-300 p-2 rounded w-full">
                </div>
                <div class="flex justify-between">
                    <button type="button" onclick="closeModal()" class="bg-red-500 text-white px-4 py-2 rounded">Cancel</button>
                    <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Update</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <div id="deleteConfirmation" class="hidden fixed inset-0 flex items-center justify-center bg-black bg-opacity-50">
        <div class="bg-white p-6 rounded shadow-md w-96">
            <h2 class="text-lg font-bold mb-4">Confirm Delete</h2>
            <p class="mb-4">Are you sure you want to delete this user?</p>
            <form action="../user/modals/user_actions.php" method="POST">
                <input type="hidden" name="action" value="delete">
                <input type="hidden" id="admin_id1" name="admin_id">
                <div class="flex justify-between">
                    <button type="button" onclick="closeModal()" class="bg-gray-500 text-white px-4 py-2 rounded">Cancel</button>
                    <button type="submit" class="bg-red-500 text-white px-4 py-2 rounded">Delete</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function openAddModal() {
        document.getElementById('AddModal').classList.remove('hidden');
    }

    function openUpdateModal(id, username, role) {
        document.getElementById('admin_id').value = id;
        document.getElementById('username').value = username;
        document.getElementById('admin_type').value = role; // This sets the correct role in the dropdown
        document.getElementById('updateModal').classList.remove('hidden');
    }

    function confirmDelete(id) {
        document.getElementById('admin_id1').value = id;
        document.getElementById('deleteConfirmation').classList.remove('hidden');
    }

    function closeModal() {
        document.getElementById('AddModal').classList.add('hidden');
        document.getElementById('updateModal').classList.add('hidden');
        document.getElementById('deleteConfirmation').classList.add('hidden');
    }
</script>

</body>
</html>
