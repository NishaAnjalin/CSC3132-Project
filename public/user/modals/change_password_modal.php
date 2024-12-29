<form id="changePasswordForm" action="../user/modals/change_password_action.php" method="POST" onsubmit="return validateChangePasswordForm()">
    <h2 class="text-lg font-bold mb-4">Change Password</h2>
    <div class="mb-4">
        <label class="block text-gray-700">Current Password</label>
        <input type="password" name="old_password" id="old_password" class="bg-gray-300 p-2 rounded w-full" required>
    </div>
    <div class="mb-4">
        <label class="block text-gray-700">New Password</label>
        <input type="password" name="new_password" id="new_password" class="bg-gray-300 p-2 rounded w-full" required>
    </div>
    <div class="mb-4">
        <label class="block text-gray-700">Re-enter New Password</label>
        <input type="password" name="confirm_password" id="confirm_password" class="bg-gray-300 p-2 rounded w-full" required>
    </div>
    <div id="error_message" class="text-red-500 mb-4 hidden"></div>
    <div class="flex justify-between">
        <button type="button" onclick="closeModal()" class="bg-red-500 text-white px-4 py-2 rounded">Cancel</button>
        <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded">Update</button>
    </div>
</form>

<script>
    function validateChangePasswordForm() {
        const oldPassword = document.getElementById("old_password").value;
        const newPassword = document.getElementById("new_password").value;
        const confirmPassword = document.getElementById("confirm_password").value;
        const errorMessage = document.getElementById("error_message");

        if (newPassword.length < 8) {
            errorMessage.textContent = "New password must be at least 8 characters long.";
            errorMessage.classList.remove("hidden");
            return false;
        }

        if (newPassword !== confirmPassword) {
            errorMessage.textContent = "New passwords do not match.";
            errorMessage.classList.remove("hidden");
            return false;
        }

        errorMessage.classList.add("hidden");
        return true;
    }
</script>
