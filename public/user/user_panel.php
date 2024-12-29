<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <title>User Management Panel</title>
    
</head>
<body class="bg-gray-900 min-h-screen flex flex-col items-center justify-center">
    <h1 class="text-3xl font-bold text-white mb-8">User Management Panel</h1>

    <!-- Action Buttons -->
    <div class="space-y-4">
        <button class="bg-blue-500 text-white px-6 py-2 rounded" onclick="openModal('change_password_modal.php')">Change Password</button>
        <a href="dashboard.php?content=../../public/user/modals/manage_users_modal.php" class="bg-blue-500 text-white px-6 py-2 rounded">Manage Users</a>
        <a href="dashboard.php?content=../../public/user/modals/manage_subjects_modal.php" class="bg-blue-500 text-white px-6 py-2 rounded">Manage Subjects</a>
        <button class="bg-blue-500 text-white px-6 py-2 rounded" onclick="openModal('additional_options_modal.php')">Additional Options</button>
    </div>

    <!-- Modal Container -->
    <div id="modalContainer" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 hidden">
        <div class="modal-overlay absolute inset-0" onclick="closeModal()"></div>
        <div id="modalContent" class="bg-white p-6 rounded shadow-md w-96 relative">
            <!-- Modal content will be loaded dynamically here -->
        </div>
    </div>

    <?php if (isset($_SESSION['message'])): ?>
        <div class="mb-4 p-3 rounded <?php echo $_SESSION['message_type'] === 'success' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800'; ?>">
            <?php
            echo $_SESSION['message'];
            unset($_SESSION['message']); // Clear message after displaying
            unset($_SESSION['message_type']);
            ?>
        </div>
    <?php endif; ?>
    
    <script>
        // Open modal by loading content from a PHP file
        function openModal(modalFile) {
            const modalContainer = document.getElementById('modalContainer');
            const modalContent = document.getElementById('modalContent');

            // Fetch the modal content via AJAX
            fetch(`../user/modals/${modalFile}`)
                .then(response => response.text())
                .then(data => {
                    modalContent.innerHTML = data; // Insert the content into the modal
                    modalContainer.classList.remove('hidden'); // Show the modal
                })
                .catch(error => {
                    console.error('Error loading modal:', error);
                });
        }

        // Close the modal
        function closeModal() {
            const modalContainer = document.getElementById('modalContainer');
            modalContainer.classList.add('hidden');
        }
    </script>
</body>
</html>
