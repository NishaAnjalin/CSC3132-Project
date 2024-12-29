<?php
require_once '../../../conf/dbconf.php'; // Database configuration

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
    $action = $_POST['action'];

    // Add Subject
    if ($action === 'add') {
        if (isset($_POST['subject_name'], $_POST['subject_code'])) {
            $subject_name = $_POST['subject_name'];
            $subject_code = $_POST['subject_code'];

            // Insert the new subject into the database
            $stmt = $conn->prepare("INSERT INTO subjects (subject_code, subject_name) VALUES (?, ?)");
            $stmt->bind_param("ss", $subject_code, $subject_name);

            if ($stmt->execute()) {
                header('Location: ../../dashboard/dashboard.php?content=../../public/user/modals/manage_subjects_modal.php&message=Subject added successfully');
                exit();
            } else {
                echo "Error: Unable to add subject.";
            }
            $stmt->close();
        }
    }

    // Update Subject
    elseif ($action === 'update') {
        if (isset($_POST['subject_id'], $_POST['subject_name'], $_POST['subject_code'])) {
            $subject_id = $_POST['subject_id'];
            $subject_name = $_POST['subject_name'];
            $subject_code = $_POST['subject_code'];

            // Update the subject in the database
            $stmt = $conn->prepare("UPDATE subjects SET subject_code = ?, subject_name = ? WHERE id = ?");
            $stmt->bind_param("ssi", $subject_code, $subject_name, $subject_id);

            if ($stmt->execute()) {
                header('Location: ../../dashboard/dashboard.php?content=../../public/user/modals/manage_subjects_modal.php&message=Subject updated successfully');
                exit();
            } else {
                echo "Error: Unable to update subject.";
            }
            $stmt->close();
        }
    }

    // Delete Subject
    elseif ($action === 'delete') {
        if (isset($_POST['subject_id'])) {
            $subject_id = $_POST['subject_id'];

            // Delete the subject from the database
            $stmt = $conn->prepare("DELETE FROM subjects WHERE id = ?");
            $stmt->bind_param("i", $subject_id);

            if ($stmt->execute()) {
                header('Location: ../../dashboard/dashboard.php?content=../../public/user/modals/manage_subjects_modal.php&message=Subject deleted successfully');
                exit();
            } else {
                echo "Error: Unable to delete subject.";
            }
            $stmt->close();
        }
    }
}
?>
