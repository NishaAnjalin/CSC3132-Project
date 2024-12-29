<?php

require_once '../../conf/dbconf.php'; // Database configuration
require_once '../function/fun.php';  // Helper functions

// Check if the user is authenticated
if (!isAuthenticated()) {
    header('Location: ../../login/login.php');
    exit();
}

// Fetch subjects from the database
$stmt = $conn->prepare("SELECT id, subject_code,subject_name FROM subjects ORDER BY subject_name ASC");
$stmt->execute();
$result = $stmt->get_result();
$subjects = $result->fetch_all(MYSQLI_ASSOC);
$stmt->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <title>Manage Subjects</title>
</head>
<body class="bg-gray-800 text-white">
<div class="container mx-auto p-8">
    <a href="dashboard.php?content=../../public/user/user_panel.php" class="bg-blue-500 text-white px-6 py-2 rounded">Back</a>
        <!-- Header and Add Button -->
        <div class="flex justify-between items-center mb-4">
            <h1 class="text-2xl font-bold">Manage Subjects</h1>
            <button 
                class="bg-blue-500 text-white px-4 py-2 rounded" 
                onclick="openAddModal()">Add Subject
            </button>
        </div>
        <!-- List Subjects -->
        <table class="w-full bg-gray-900 rounded text-left text-white">
            <thead>
                <tr class="border-b border-gray-700">
                    <th class="p-4">subject_Code</th>
                    <th class="p-4">Subject Name</th>
                    <th class="p-4 text-center">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($subjects as $index => $subject): ?>
                    <tr class="border-b border-gray-700">
                        <td class="p-4"><?php echo $subject['subject_code']; ?></td>
                        <td class="p-4"><?php echo htmlspecialchars($subject['subject_name']); ?></td>
                        <td class="p-4 text-center">
                            <!-- Update Button -->
                            <button class="bg-blue-500 text-white px-3 py-1 rounded" 
                                onclick="openUpdateModal(<?php echo $subject['id']; ?>, '<?php echo $subject['subject_name']; ?>', '<?php echo $subject['subject_code']; ?>')">
                                Update
                            </button>

                            <!-- Delete Button -->
                            <button 
                                class="bg-red-500 text-white px-3 py-1 rounded" 
                                onclick="confirmDelete(<?php echo $subject['id']; ?>)">Delete
                            </button>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <!-- Add Subject Form -->
        <div id="AddModal" class="hidden fixed inset-0 flex items-center justify-center bg-black bg-opacity-50">
            <div class="bg-white p-6 rounded shadow-md w-96">
                <h2 class="text-xl font-bold mb-4">Add New Subject</h2>
                <form action="../user/modals/subject_actions.php" method="POST">
                    <input type="hidden" name="action" value="add">
                    <div class="mb-4">
                        <input type="text" name="subject_code" placeholder="Enter Subject Code" class="bg-gray-300 p-2 rounded w-full" required>
                    </div>
                    <div class="mb-4">
                        <input type="text" name="subject_name" placeholder="Enter Subject Name" class="bg-gray-300 p-2 rounded w-full" required>
                    </div>
                    <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Add Subject</button>
                    <button type="button" onclick="closeModal()" class="bg-red-500 text-white px-4 py-2 rounded">Cancel</button>
                </form>
            </div>
        </div>

        <!-- Update Modal -->
        <div id="updateModal" class="hidden fixed inset-0 flex items-center justify-center bg-black bg-opacity-50">
            <div class="bg-white p-6 rounded shadow-md w-96">
                <h2 class="text-lg font-bold mb-4">Update Subject</h2>
                <form action="../user/modals/subject_actions.php" method="POST">
                    <input type="hidden" name="action" value="update">
                    <input type="hidden" id="subject_id" name="subject_id">
                    <div class="mb-4">
                        <label class="block text-gray-700">Subject Name</label>
                        <input type="text" id="subject_name" name="subject_name" class="bg-gray-300 p-2 rounded w-full" required>
                    </div>
                    <div class="mb-4">
                        <label class="block text-gray-700">Subject Code</label>
                        <input type="text" id="subject_code" name="subject_code" class="bg-gray-300 p-2 rounded w-full" required>
                    </div>
                    <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded">Update</button>
                    <button type="button" onclick="closeModal()" class="bg-red-500 text-white px-4 py-2 rounded">Cancel</button>
                </form>
            </div>
        </div>

        <!-- Delete Confirmation Modal -->
        <div id="deleteConfirmation" class="hidden fixed inset-0 flex items-center justify-center bg-black bg-opacity-50">
            <div class="bg-white p-6 rounded shadow-md w-96">
                <h2 class="text-lg font-bold mb-4">Confirm Delete</h2>
                <p class="mb-4">Are you sure you want to delete this subject?</p>
                <form action="../user/modals/subject_actions.php" method="POST">
                    <input type="hidden" name="action" value="delete">
                    <input type="hidden" id="delete_subject_id" name="subject_id">
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

        function openUpdateModal(id, name,sub_code) {
            document.getElementById('subject_id').value = id;
            document.getElementById('subject_name').value = name;
            document.getElementById('subject_code').value = sub_code;
            document.getElementById('updateModal').classList.remove('hidden');
        }

        function confirmDelete(id) {
            document.getElementById('delete_subject_id').value = id;
            document.getElementById('deleteConfirmation').classList.remove('hidden');
        }

        function closeModal() {
            document.getElementById('AddModal').classList.add('hidden');
            document.getElementById('updateModal').classList.add('hidden');
            document.getElementById('deleteConfirmation').classList.add('hidden');
        }
    </script>
</body>
</html
