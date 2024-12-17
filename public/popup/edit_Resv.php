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
    <style>
        .hidden { display: none; }
    </style>
</head>
<body>
    <div id="popup" class="bg-white rounded-lg shadow-lg p-6 w-96">
        <?php echo "$start_time   $end_time   $subject   $id  $lab_id   $day   $status"; ?>

        <h2 class="text-xl font-bold mb-4">Edit Reservation</h2>

        <form action="" method="POST" id="reservationForm">
            <div class="mb-4">
                <label class="block text-gray-700">Subject</label>
                <select name="popup_subject" id="popup-subject" class="w-full p-2 border border-gray-300 rounded-lg">
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
                <select name="popup_status" id="popup-status" class="w-full p-2 border border-gray-300 rounded-lg">
                    <option value="available" <?php echo $status === 'available' ? 'selected' : ''; ?>>Available</option>
                    <option value="reserved" <?php echo $status === 'reserved' ? 'selected' : ''; ?>>Reserved</option>
                    <option value="cancelled" <?php echo $status === 'cancelled' ? 'selected' : ''; ?>>Cancelled</option>
                </select>
            </div>

            <div class="flex space-x-4 mb-4">
                <div class="w-1/2">
                    <label class="block text-gray-700">Start Time</label>
                    <input type="text" id="popup-stime" name="start_time" class="w-full p-2 border border-gray-300 rounded-lg" value="<?= $start_time ?>" readonly>
                </div>
                <div class="w-1/2">
                    <label class="block text-gray-700">End Time</label>
                    <input type="text" id="popup-etime" name="end_time" class="w-full p-2 border border-gray-300 rounded-lg" value="<?= $end_time ?>" readonly>
                </div>
            </div>

            <div>
                <input type="hidden" id="popup-id" name="id" value="<?php echo $id; ?>">
                <input type="hidden" id="popup-labid" name="lab_id" value="<?php echo $lab_id; ?>">
                <input type="hidden" id="popup-day" name="day" value="<?php echo $day; ?>">

                <div class="flex justify-between">
                    <button type="button" class="bg-red-500 text-white px-4 py-2 rounded-lg" onclick="closePopup()">Cancel</button>
                    <button type="submit" class="submit bg-green-500 text-white px-4 py-2 rounded-lg">Update</button>
                </div>
            </div>
        </form>
    </div>

    <script>
        // Close popup function
        function closePopup() {
            const popupDiv = document.getElementById('popup');
            popupDiv.classList.add('hidden'); // Hide the popup
        }
    </script>

    
</body>
</html>
