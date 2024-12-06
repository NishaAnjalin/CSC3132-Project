<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dynamic Change Password</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
</head>
<body class="bg-gray-800 text-white">

    <!-- Trigger Button -->
    <div class="flex justify-center items-center h-screen">
        <button id="openModal" class="bg-blue-500 text-white p-3 rounded">Change Password</button>
    </div>

    <!-- Change Password Modal -->
    <div id="passwordModal" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 hidden">
        <div class="bg-white p-6 rounded shadow-md w-96">
            <h2 class="text-black text-lg font-bold mb-4 text-center">Change New Password</h2>
            <form action="changepass.php" method="POST" id="changePasswordForm">
                <!-- CSRF Token -->
                <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">

                <!-- New Password Field -->
                <div class="mb-4 relative">
                    <label class="block text-gray-700">New Password</label>
                    <input type="password" name="newPassword" id="newPassword" class="bg-gray-300 p-2 rounded w-full pr-10" required>
                    <i id="toggleNewPassword" class="fas fa-eye absolute top-1/2 right-3 transform -translate-y-1/2 cursor-pointer text-gray-500"></i>
                </div>
                
                <!-- Re-enter New Password Field -->
                <div class="mb-4 relative">
                    <label class="block text-gray-700">Re-enter the New Password</label>
                    <input type="password" name="confirmPassword" id="confirmPassword" class="bg-gray-300 p-2 rounded w-full pr-10" required>
                    <i id="toggleConfirmPassword" class="fas fa-eye absolute top-1/2 right-3 transform -translate-y-1/2 cursor-pointer text-gray-500"></i>
                </div>

                <!-- Password Strength -->
                <p id="passwordStrength" class="text-sm mb-4"></p>

                <!-- Error Messages -->
                <div id="errorMessages" class="text-red-500 text-sm mb-4 hidden">
                    <ul></ul>
                </div>

                <!-- Buttons -->
                <div class="flex justify-between">
                    <button type="button" class="bg-red-500 text-white p-2 rounded w-24" onclick="closeModal()">Cancel</button>
                    <button type="submit" id="submitButton" class="bg-green-500 text-white p-2 rounded w-24" disabled>Update</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        // Toggle visibility of passwords
        function togglePasswordVisibility(inputId, toggleIconId) {
            const passwordField = document.getElementById(inputId);
            const icon = document.getElementById(toggleIconId);
            if (passwordField.type === 'password') {
                passwordField.type = 'text';
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
            } else {
                passwordField.type = 'password';
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
            }
        }

        document.getElementById('toggleNewPassword').addEventListener('click', function () {
            togglePasswordVisibility('newPassword', 'toggleNewPassword');
        });

        document.getElementById('toggleConfirmPassword').addEventListener('click', function () {
            togglePasswordVisibility('confirmPassword', 'toggleConfirmPassword');
        });

        // Live password strength validation
        const passwordStrength = document.getElementById('passwordStrength');
        document.getElementById('newPassword').addEventListener('input', function () {
            const password = this.value;
            if (password.length < 6) {
                passwordStrength.textContent = 'Weak: Password must be at least 6 characters long.';
                passwordStrength.className = 'text-red-500';
            } else if (!/[A-Z]/.test(password)) {
                passwordStrength.textContent = 'Medium: Include at least one uppercase letter.';
                passwordStrength.className = 'text-yellow-500';
            } else if (!/[0-9]/.test(password)) {
                passwordStrength.textContent = 'Strong: Add a number for extra security.';
                passwordStrength.className = 'text-blue-500';
            } else {
                passwordStrength.textContent = 'Very Strong: Good job!';
                passwordStrength.className = 'text-green-500';
            }
            validateForm();
        });

        // Validate form inputs
        function validateForm() {
            const newPassword = document.getElementById('newPassword').value;
            const confirmPassword = document.getElementById('confirmPassword').value;
            const submitButton = document.getElementById('submitButton');
            const errorMessages = document.getElementById('errorMessages');
            const errorList = errorMessages.querySelector('ul');
            let errors = [];

            // Reset error messages
            errorList.innerHTML = '';
            errorMessages.classList.add('hidden');

            // Password match check
            if (newPassword !== confirmPassword) {
                errors.push('Passwords do not match.');
            }

            // Password strength check
            if (newPassword.length < 6) {
                errors.push('Password is too weak. It should be at least 6 characters long.');
            }

            // Display errors
            if (errors.length > 0) {
                errorMessages.classList.remove('hidden');
                errors.forEach(function (error) {
                    const li = document.createElement('li');
                    li.textContent = error;
                    errorList.appendChild(li);
                });
                submitButton.disabled = true;
            } else {
                submitButton.disabled = false;
            }
        }

        // Open and close modal
        document.getElementById('openModal').addEventListener('click', function () {
            document.getElementById('passwordModal').classList.remove('hidden');
        });

        function closeModal() {
            document.getElementById('passwordModal').classList.add('hidden');
        }
    </script>
</body>
</html>
