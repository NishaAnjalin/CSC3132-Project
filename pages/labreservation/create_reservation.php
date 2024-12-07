<?php
require_once '../../dbconf.php';

session_start();
if (!isset($_SESSION['user'])) {
    header('Location: ../login.php');
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id = $_SESSION['user'];
    $lab_name = $_POST['lab_name'];
    $reservation_date = $_POST['reservation_date'];
    $time_slot = $_POST['time_slot'];

    //$conn = getConnection();
    $stmt = $conn->prepare("INSERT INTO reservations (user_id, lab_name, reservation_date, time_slot) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $user_id, $lab_name, $reservation_date, $time_slot);

    if ($stmt->execute()) {
        echo '<script>alert("Reservation Successful!"); window.location.href="../dashboard/dashboard.php";</script>';
    } else {
        echo '<script>alert("Reservation Failed. Try again."); window.history.back();</script>';
    }
}
?>

<form action="create_reservation.php" method="POST">
    Lab Name: <input type="text" name="lab_name" required><br>
    Reservation Date: <input type="date" name="reservation_date" required><br>
    Time Slot: <input type="text" name="time_slot" placeholder="e.g., 10:00 AM - 12:00 PM" required><br>
    <input type="submit" value="Reserve Lab">
</form>
