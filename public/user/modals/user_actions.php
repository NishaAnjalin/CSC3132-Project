<?php
require_once '../../../conf/dbconf.php'; // Database configuration
require_once '../../function/fun.php';  // Helper functions

// Ensure the user is authenticated
// Uncomment when authentication is needed
// if (!isAuthenticated()) {
//     header('Location: ../../login/login.php');
//     exit();
// }

// Ensure session is started
session_start();

// Check the action type (add, update, delete)
if (isset($_POST['action'])) {
    $action = $_POST['action'];

    // Handle 'add' action
    if ($action === 'add') {
        if (isset($_POST['username'], $_POST['admin_type'], $_POST['password'])) {
            $username = $_POST['username'];
            $admin_type = $_POST['admin_type'];
            $password = $_POST['password'];

            // Hash the password before storing
            $passwordHash = password_hash($password, PASSWORD_BCRYPT);

            // Validate the username and admin type (optional but recommended)
            if (!empty($username) && !empty($admin_type)) {
                // Prepare and execute the insert query
                $stmt = $conn->prepare("INSERT INTO admin (username, admin_type, password) VALUES (?, ?, ?)");
                $stmt->bind_param("sss", $username, $admin_type, $passwordHash);

                if ($stmt->execute()) {
                    $_SESSION['success'] = "User added successfully!";
                } else {
                    $_SESSION['error'] = "Failed to add user!";
                }
                $stmt->close();
            } else {
                $_SESSION['error'] = "Username and role are required!";
            }
        } else {
            $_SESSION['error'] = "All fields are required!";
        }
    }

    // Handle 'update' action
    elseif ($action === 'update') {
        if (isset($_POST['admin_id'], $_POST['username'], $_POST['admin_type'])) {
            $admin_id = $_POST['admin_id'];
            $username = $_POST['username'];
            $admin_type = $_POST['admin_type'];

            // If password is provided, hash it
            if (!empty($_POST['password'])) {
                $password = $_POST['password'];
                $passwordHash = password_hash($password, PASSWORD_BCRYPT);

                // Prepare and execute the update query with password
                $stmt = $conn->prepare("UPDATE admin SET username = ?, admin_type = ?, password = ? WHERE admin_id = ?");
                $stmt->bind_param("sssi", $username, $admin_type, $passwordHash, $admin_id);
            } else {
                // If no password provided, update only username and admin_type
                $stmt = $conn->prepare("UPDATE admin SET username = ?, admin_type = ? WHERE admin_id = ?");
                $stmt->bind_param("ssi", $username, $admin_type, $admin_id);
            }

            if ($stmt->execute()) {
                $_SESSION['success'] = "User updated successfully!";
            } else {
                $_SESSION['error'] = "Failed to update user!";
            }
            $stmt->close();
        }
    }

    // Handle 'delete' action
    elseif ($action === 'delete') {
        if (isset($_POST['admin_id'])) {
            $admin_id = $_POST['admin_id'];

            // Prepare and execute the delete query
            $stmt = $conn->prepare("DELETE FROM admin WHERE admin_id = ?");
            $stmt->bind_param("i", $admin_id);

            if ($stmt->execute()) {
                $_SESSION['success'] = "User removed successfully!";
            } else {
                $_SESSION['error'] = "Failed to remove user!";
            }
            $stmt->close();
        }
    }

    // Redirect back to the user management page
    header('Location: ../../dashboard/dashboard.php?content=../../public/user/modals/manage_users_modal.php');
    exit();
} else {
    // If no action is set, redirect back to user management page
    header('Location: ../../dashboard/dashboard.php?content=../../public/user/modals/manage_users_modal.php');
    exit();
}
?>
