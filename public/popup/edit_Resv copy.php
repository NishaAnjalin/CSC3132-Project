<?php
// Retrieve POST data
$subject = $_POST['subject'] ?? '';
$status = $_POST['status'] ?? '';
$start_time = $_POST['start_time'] ?? '';
$end_time = $_POST['end_time'] ?? '';
$id = $_POST['id'] ?? '';
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
        <?php echo "$start_time   $end_time   $subject   $id  $day  $status"; ?>

        <h2 class="text-xl font-bold mb-4">Edit Reservation</h2>

        <div class="mb-4">
            <label class="block text-gray-700">Subject</label>
            <select id="popup-subject" class="w-full p-2 border border-gray-300 rounded-lg">
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
        <select id="popup-stime" class="w-full p-2 border border-gray-300 rounded-lg">
            <option value="08:30:00" <?php echo ($start_time == '08:30:00') ? 'selected' : ''; ?>>08:30:00</option>
            <option value="09:30:00" <?php echo ($start_time == '09:30:00') ? 'selected' : ''; ?>>09:30:00</option>
            <option value="10:30:00" <?php echo ($start_time == '10:30:00') ? 'selected' : ''; ?>>10:30:00</option>
            <option value="11:30:00" <?php echo ($start_time == '11:30:00') ? 'selected' : ''; ?>>11:30:00</option>
            <option value="12:30:00" <?php echo ($start_time == '12:30:00') ? 'selected' : ''; ?>>12:30:00</option>
            <option value="13:30:00" <?php echo ($start_time == '13:30:00') ? 'selected' : ''; ?>>13:30:00</option>
            <option value="14:30:00" <?php echo ($start_time == '14:30:00') ? 'selected' : ''; ?>>14:30:00</option>
            <option value="15:30:00" <?php echo ($start_time == '15:30:00') ? 'selected' : ''; ?>>15:30:00</option>
        </select>
    </div>
    <div class="w-1/2">
        <label class="block text-gray-700">End Time</label>
        <select id="popup-etime" class="w-full p-2 border border-gray-300 rounded-lg">
            <option value="09:30:00" <?php echo ($end_time == '09:30:00') ? 'selected' : ''; ?>>09:30:00</option>
            <option value="10:30:00" <?php echo ($end_time == '10:30:00') ? 'selected' : ''; ?>>10:30:00</option>
            <option value="11:30:00" <?php echo ($end_time == '11:30:00') ? 'selected' : ''; ?>>11:30:00</option>
            <option value="12:30:00" <?php echo ($end_time == '12:30:00') ? 'selected' : ''; ?>>12:30:00</option>
            <option value="13:30:00" <?php echo ($end_time == '13:30:00') ? 'selected' : ''; ?>>13:30:00</option>
            <option value="14:30:00" <?php echo ($end_time == '14:30:00') ? 'selected' : ''; ?>>14:30:00</option>
            <option value="15:30:00" <?php echo ($end_time == '15:30:00') ? 'selected' : ''; ?>>15:30:00</option>
            <option value="16:30:00" <?php echo ($end_time == '16:30:00') ? 'selected' : ''; ?>>16:30:00</option>
        </select>
    </div>
</div>


        <div class="mb-4">
            <label class="block text-gray-700">Reservation ID</label>
            <input type="text" id="popup-id" class="w-full p-2 border border-gray-300 rounded-lg" value="<?php echo $id; ?>" readonly>
        </div>

        <div class="flex justify-between">
            <button class="bg-red-500 text-white px-4 py-2 rounded-lg" onclick="closePopup()">Cancel</button>
            <button class="bg-green-500 text-white px-4 py-2 rounded-lg">Update</button>
        </div>
    </div>

    <script>
        // Close popup function
        function closePopup() {
            const popupDiv = document.getElementById('popup');
            popupDiv.innerHTML = ''; // Clear the popup content
            popupDiv.classList.add('hidden'); // Hide the popup
        }
    </script>
</body>
</html>
