<?php
session_start();
if (!isset($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <title>Login</title>
</head>
<body class="bg-gray-900 flex items-center justify-center min-h-screen">
    <div class="bg-gradient-to-b from-blue-500 to-blue-300 w-full h-full flex items-center justify-center">
        <div class="bg-white bg-opacity-20 backdrop-blur-md rounded-lg p-8 w-96">
            <!-- Close Button -->
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-2xl font-bold text-gray-800">Login</h2>
                <button onclick="window.location.href='index.php'" class="text-blue-700 text-xl font-bold">X</button>
            </div>

            <!-- Display Message -->
            <?php if (!empty($_SESSION['message'])): ?>
                <div class="mb-4 p-3 rounded <?php echo $_SESSION['message_type'] === 'valid' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800'; ?>">
                    <?php
                    echo $_SESSION['message'];
                    unset($_SESSION['message']); // Clear message after displaying
                    unset($_SESSION['message_type']);
                    ?>
                </div>
            <?php endif; ?>

            <!-- Login Form -->
            <form action="login_handler.php" method="POST">
                <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
                <div class="mb-4">
                    <input type="text" name="username" placeholder="Username" class="w-full p-3 rounded bg-white bg-opacity-80 focus:outline-none" required>
                </div>
                <div class="mb-4 relative">
                    <input type="password" name="password" id="password" placeholder="Password" class="w-full p-3 rounded bg-white bg-opacity-80 focus:outline-none" required>
                    <span onclick="togglePassword()" class="absolute right-3 top-1/2 transform -translate-y-1/2 cursor-pointer text-gray-600">
                        <i class="fas fa-eye"></i>
                    </span>
                </div>
                <div class="mb-6 text-right">
                    <a href="forgot_password.php" class="text-gray-600">Forgot password?</a>
                </div>
                <button type="submit" class="w-full bg-blue-700 text-white p-3 rounded font-bold">Sign in</button>
            </form>
        </div>
    </div>

    <script>
        function togglePassword() {
            const password = document.getElementById('password');
            const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
            password.setAttribute('type', type);
        }
    </script>
</body>
</html>
