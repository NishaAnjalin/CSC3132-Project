<?php
require '../../conf/dbconf.php';

// Utility Functions
function initializeTimetable($days, $hours) {
    $timetable = [];
    foreach ($days as $day) {
        $timetable[$day] = [];
        foreach ($hours as $hour) {
            $start = sprintf('%02d:30:00', $hour);
            $end = sprintf('%02d:30:00', $hour + 1);
            $timetable[$day][] = [
                'start_time' => $start,
                'end_time' => $end,
                'status' => 'available',
                'subject_code' => null,
                'id' => null,
                'day_of_week' => $day // Include day_of_week field
            ];
        }
    }
    return $timetable;
}

function fetchTimetableData($conn, $lab_id) {
    $stmt = $conn->prepare(<<<SQL
        SELECT day_of_week, start_time, end_time, status, subject_code, id,lab_id
        FROM timetable_slots
        WHERE lab_id = ?
        ORDER BY FIELD(day_of_week, 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday'), start_time
    SQL);
    $stmt->bind_param("i", $lab_id);
    $stmt->execute();
    return $stmt->get_result();
}

function updateTimetable(&$timetable, $result) {
    while ($row = $result->fetch_assoc()) {
        foreach ($timetable[$row['day_of_week']] as &$slot) {
            if ($slot['start_time'] === $row['start_time']) {
                $slot['end_time'] = $row['end_time'];
                $slot['status'] = $row['status'];
                $slot['subject_code'] = $row['subject_code'];
                $slot['id'] = $row['id'];
                $slot['lab_id'] = $row['lab_id'];
                $slot['day_of_week'] = $row['day_of_week']; // Ensure day_of_week is set
            }
        }
    }
}

function renderTimetable($days, $timetable, $hours) {
    echo "<table class='table-auto w-full border-collapse border border-gray-300'>";
    echo "<thead><tr class='bg-blue-500 text-white'>";
    echo "<th class='border border-gray-300 px-4 py-2'>Time</th>";
    foreach ($days as $day) {
        echo "<th class='border border-gray-300 px-4 py-2'>{$day}</th>";
    }
    echo "</tr></thead><tbody>";

    foreach ($hours as $hour) {
        $start_time = sprintf('%02d:30:00', $hour);
        $end_time = sprintf('%02d:30:00', $hour + 1);

        echo "<tr>";
        echo "<td class='border border-gray-300 px-4 py-2 text-center'>" . date('h:i A', strtotime($start_time)) . " - " . date('h:i A', strtotime($end_time)) . "</td>";

        foreach ($days as $day) {
            $slot = array_filter($timetable[$day], fn($s) => $s['start_time'] === $start_time);
            $slot = current($slot) ?: ['status' => 'available', 'subject_code' => null, 'id' => null, 'start_time' => $start_time, 'day_of_week' => $day];

            $display_status = $slot['status'];
            $display_subject = $slot['subject_code'] ?? '';
            $display_id = $slot['id'] ?? '';
            $display_labid = $slot['lab_id'] ?? '';
            $display_stime = $slot['start_time'] ?? '';
            $display_etime = $slot['end_time'] ?? '';
            $display_day = $slot['day_of_week'] ?? '';

            echo "<td class='hover:bg-gray-100 border border-gray-300 px-4 py-2 text-center' 
                    onclick=\"showPopup('{$display_subject}', '{$display_status}', '{$display_stime}'
                                        , '{$display_etime}', '{$display_id}', '{$display_labid}', '{$display_day}')\">";
            echo "<div class='font-medium text-gray-800'>{$display_subject}</div>";
            echo "<div class='font-medium text-gray-800'>{$display_status}</div>";
            echo "<div class='font-medium text-gray-800'>{$display_labid}</div>";
            // echo "<div class='font-medium text-gray-800'>{$display_stime}</div>";
            echo "</td>";
        }
        echo "</tr>";
    }

    echo "</tbody></table>";
}

// Main Script
$lab_id = isset($_GET['lab_id']) ? intval($_GET['lab_id']) : 1;
$days = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday'];
$hours = range(8, 15);
$timetable = initializeTimetable($days, $hours);

$result = fetchTimetableData($conn, $lab_id);
updateTimetable($timetable, $result);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lab Timetable</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 font-sans">
<div class="container mx-auto px-4 py-6">
    <h1 class="text-2xl font-bold text-center text-gray-800 mb-6">Lab Timetable (Lab <?php echo $lab_id; ?>)</h1>
    <div class="flex justify-center space-x-4 mb-6">
        <a href="../dashboard/dashboard.php?content=../../public/timetable/view_table.php&lab_id=1" class="bg-blue-<?php echo ($lab_id == 1) ? '500' : '300'; ?> text-white px-4 py-2 rounded hover:bg-blue-600">CL1</a>
        <a href="../dashboard/dashboard.php?content=../../public/timetable/view_table.php&lab_id=2" class="bg-blue-<?php echo ($lab_id == 2) ? '500' : '300'; ?> text-white px-4 py-2 rounded hover:bg-blue-600">CL2</a>
    </div>
    <?php renderTimetable($days, $timetable, $hours); ?>
</div>

<div id="popup" class="hidden fixed inset-0 bg-gray-900 bg-opacity-50 flex items-center justify-center z-50">
    <!-- The popup content will be dynamically loaded here -->
</div>

<script>
    function showPopup(display_subject, display_status, display_start_time, display_end_time, display_id, display_labid, display_day) {
        // Prepare the form data to send to b.php
        const formData = new FormData();
        formData.append('subject', display_subject);
        formData.append('status', display_status);
        formData.append('start_time', display_start_time);
        formData.append('end_time', display_end_time);
        formData.append('id', display_id);
        formData.append('lab_id', display_labid);
        formData.append('day', display_day);

        // Send the data to b.php using Fetch API
        fetch('../popup/edit_Resv.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.text())
        .then(data => {
            // Set the received content in the popup div
            const popupDiv = document.getElementById('popup');
            popupDiv.innerHTML = data;

            // Show the popup div
            popupDiv.classList.remove('hidden');
        })
        .catch(error => {
            console.error('Error:', error);
        });
    }

    // Function to close the popup
    function closePopup() {
        const popupDiv = document.getElementById('popup');
        popupDiv.innerHTML = ''; // Clear the popup content
        popupDiv.classList.add('hidden'); // Hide the popup
    }
</script>

</body>
</html>
<?php


    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['popup_status'])) {
        $selectedSubject = $_POST['popup_subject'];
        $selectedStatus = $_POST['popup_status'];
        $popupId = $_POST['id'];
        $popupLabId = $_POST['lab_id'];

        // SQL update query
        $sql = "UPDATE timetable_slots 
                SET subject_code = ?, status = ?
                WHERE id = ? AND lab_id = ?";

        if ($stmt = $conn->prepare($sql)) {
            $stmt->bind_param("ssii", $selectedSubject, $selectedStatus, $popupId, $popupLabId);
            if ($stmt->execute()) {
                $_POST['popup_status']='';
                echo "<script>
                        alert('Record updated successfully!');
                        closePopup();
                        setTimeout(function() {
                        window.location.href = '../dashboard/dashboard.php?content=../../public/timetable/view_table.php&lab_id=$popupLabId';
                        }, 1000); // 1-second delay
                      </script>";
                      
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
