<?php
include '../../conf/dbconf.php';
include_once '../function/fun.php';

if (isAuthenticated()) {
    logout();
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];
    echo $username . $password;


    // Prepare the SQL statement
    $stmt = $conn->prepare("SELECT password, admin_type FROM admin WHERE username = ?");
    $stmt->bind_param("s", $username);

    // Execute the statement
    $stmt->execute();

    // Bind the results
    $stmt->bind_result($password_hash, $user_type);
    $stmt->fetch();

    // Close the statement and connection
    $stmt->close();
    $conn->close();

    // Verify the password and handle the result
    if ($password_hash !== null && password_verify($password, $password_hash)) {
        session_start(); // Ensure the session is started
        $_SESSION['user'] = $username;
        $_SESSION['user_type'] = $user_type;
        header('Location: ../dashboard/dashboard.php');
        exit();
    } else {
        $error = "Invalid username or password.";
    }
}
?>
<html>
<head>
    <title>Login</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-900 flex items-center justify-center min-h-screen">
    <div class="bg-gradient-to-b from-blue-500 to-blue-300 w-full h-full flex items-center justify-center">
        <div class="bg-white bg-opacity-20 backdrop-blur-md rounded-lg p-8 w-96">
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-2xl font-bold text-gray-800">Login</h2>
                <button class="text-blue-700 text-xl font-bold">X</button>
            </div>

            <!-- Display Error Message -->
            <?php if (isset($error)): ?>
                <div class="mb-4 p-3 rounded bg-red-100 text-red-800">
                    <?php echo $error; ?>
                </div>
            <?php endif; ?>

            <!-- Display Session Message -->
            <?php if (isset($_SESSION['message'])): ?>
                <div class="mb-4 p-3 rounded <?php echo $_SESSION['message_type'] === 'valid' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800'; ?>">
                    <?php
                    echo $_SESSION['message'];
                    unset($_SESSION['message']); // Clear message after displaying
                    unset($_SESSION['message_type']);
                    ?>
                </div>
            <?php endif; ?>

            <!-- Login Form -->
            <form action="" method="POST">
                <div class="mb-4">
                    <input type="text" name="username" placeholder="Username" class="w-full p-3 rounded bg-white bg-opacity-80 focus:outline-none" required>
                </div>
                <div class="mb-4">
                    <input type="password" name="password" placeholder="Password" class="w-full p-3 rounded bg-white bg-opacity-80 focus:outline-none" required>
                </div>
                <div class="mb-6 text-right">
                    <a href="#" class="text-gray-600">Forgot password?</a>
                </div>
                <button type="submit" class="w-full bg-blue-700 text-white p-3 rounded font-bold">Sign in</button>
            </form>
        </div>
    </div>
</body>
</html>
