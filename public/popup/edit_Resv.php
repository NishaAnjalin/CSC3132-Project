<?php
// Retrieve POST data
$subject = $_POST['subject'] ?? '';
$status = $_POST['status'] ?? '';
$start_time = $_POST['start_time'] ?? '';
$end_time = $_POST['end_time'] ?? '';
$id = $_POST['id'] ?? '';
$lab_id = $_POST['lab_id'] ?? '';
$day = $_POST['day'] ?? '';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Reservation</title>
</head>
<body>
    <div class="bg-white rounded-lg shadow-lg p-6 w-96">
        <?php echo "$start_time   $end_time   $subject   $id  $lab_id   $day   $status"; ?>

        <h2 class="text-xl font-bold mb-4">Edit Reservation</h2>

<form action="" method="POST">
        <div class="mb-4">
            <label class="block text-gray-700">Subject</label>
            <select id="popup-subject" class="w-full p-2 border border-gray-300 rounded-lg">
                <option value="" <?php echo $subject === '' ? 'selected' : ''; ?>>None</option>
                <option value="CSC3122" <?php echo $subject === 'CSC3122' ? 'selected' : ''; ?>>CSC3122</option>
                <option value="CSC3132" <?php echo $subject === 'CSC3132' ? 'selected' : ''; ?>>CSC3132</option>
                <option value="CSH3123" <?php echo $subject === 'CSH3123' ? 'selected' : ''; ?>>CSH3123</option>
                <option value="IT2123" <?php echo $subject === 'IT2123' ? 'selected' : ''; ?>>IT2123</option>
                <option value="IT3122" <?php echo $subject === 'IT3122' ? 'selected' : ''; ?>>IT3122</option>
            </select>
        </div>

        <div class="mb-4">
            <label class="block text-gray-700">Status</label>
            <select id="popup-status" class="w-full p-2 border border-gray-300 rounded-lg">
                <option value="available" <?php echo $status === 'available' ? 'selected' : ''; ?>>Available</option>
                <option value="reserved" <?php echo $status === 'reserved' ? 'selected' : ''; ?>>Reserved</option>
                <option value="cancelled" <?php echo $status === 'cancelled' ? 'selected' : ''; ?>>Cancelled</option>
            </select>
        </div>

        <div class="flex space-x-4 mb-4">
            <div class="w-1/2">
                <label class="block text-gray-700">Start Time</label>
                <input type="text" id="popup-stime" class="w-full p-2 border border-gray-300 rounded-lg" value="<?= $start_time?>" readonly>
                    
            </div>
            <div class="w-1/2">
                <label class="block text-gray-700">End Time</label>
                <input type="text" id="popup-etime" class="w-full p-2 border border-gray-300 rounded-lg" value="<?= $end_time?>" readonly>
            </div>
        </div>

        <div>
                <input type="hidden" id="popup-id"  value="<?php echo $id; ?>">
                <input type="hidden" id="popup-labid"  value="<?php echo $lab_id; ?>">

            <div class="flex justify-between">
                <button class="bg-red-500 text-white px-4 py-2 rounded-lg" onclick="closePopup()">Cancel</button>
                <button class="bg-green-500 text-white px-4 py-2 rounded-lg">Update</button>
            </div>
        </div>
</form>
    <script>
        // Close popup function
        function closePopup() {
            const popupDiv = document.getElementById('popup');
            popupDiv.innerHTML = ''; // Clear the popup content
            popupDiv.classList.add('hidden'); // Hide the popup
        }
    </script>

    <?php
            
         
            require_once '../../conf/dbconf.php';

            if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['popup_status'])) {
                $selectedSubject = $_POST['popup_subject'];
                $selectedStatus = $_POST['popup_status'];
                $popupId = $_POST['popup_id'];
                $popupLabId = $_POST['popup_labid'];
            
                // Example SQL update query
                $sql = "UPDATE timetable_slots 
                        SET subject_code = ?, status = ?
                        WHERE id = ? AND lab_id = ?";
            
                if ($stmt = $conn->prepare($sql)) {
                    $stmt->bind_param("ssii", $selectedSubject, $selectedStatus, $popupId, $popupLabId);
                    if ($stmt->execute()) {
                        echo "<script>alert('Record updated successfully!');</script>";
                    } else {
                        echo "<script>alert('Error updating record: {$stmt->error}');</script>";
                    }
                    $stmt->close();
                } else {
                    echo "<script>alert('Error preparing query: {$conn->error}');</script>";
                }
            
                $conn->close();
            }

            


    ?>
</body>
</html>
