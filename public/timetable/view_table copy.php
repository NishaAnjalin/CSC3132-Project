<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lab Timetable</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 font-sans">
<?php
// Database connection
require '../../conf/dbconf.php';

// Lab ID initialization
$lab_id = isset($_GET['lab_id']) ? intval($_GET['lab_id']) : 1;

// Days array
$days = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday'];

// Initialize timetable structure
$timetable = [];
foreach ($days as $day) {
    $timetable[$day] = [];
    for ($hour = 8; $hour < 16; $hour++) {
        $start = sprintf('%02d:30:00', $hour);
        $end = sprintf('%02d:30:00', $hour + 1);
        $timetable[$day][] = [
            'start_time' => $start,
            'end_time' => $end,
            'status' => 'available',
        ];
    }
}

// Fetch timetable data from the database
$stmt = $conn->prepare("
    SELECT day_of_week, start_time, end_time, status, subject_code, id
    FROM timetable_slots
    WHERE lab_id = ?
    ORDER BY FIELD(day_of_week, 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday'), start_time");
$stmt->bind_param("i", $lab_id);
$stmt->execute();
$result = $stmt->get_result();

// Overwrite the timetable with database data
while ($row = $result->fetch_assoc()) {
    foreach ($timetable[$row['day_of_week']] as &$slot) {
        if ($slot['start_time'] === $row['start_time']) {
            $slot['end_time'] = $row['end_time'];
            $slot['subject_code'] = $row['subject_code'];
            $slot['id'] = $row['id'];
            $slot['status'] = $row['status'];
        }
    }
}
?>
<div class="container mx-auto px-4 py-6">
    <h1 class="text-2xl font-bold text-center text-gray-800 mb-6">Lab Timetable (Lab <?php echo $lab_id; ?>)</h1>
    <div class="flex justify-center space-x-4 mb-6">
        <a href="view_timetable.php?lab_id=1" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">CL1</a>
        <a href="view_timetable.php?lab_id=2" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">CL2</a>
    </div>

    <table class="table-auto w-full border-collapse border border-gray-300">
        <thead>
            <tr class="bg-blue-500 text-white">
                <th class="border border-gray-300 px-4 py-2">Time</th>
                <?php foreach ($days as $day): ?>
                    <th class="border border-gray-300 px-4 py-2"><?php echo $day; ?></th>
                <?php endforeach; ?>
            </tr>
        </thead>
        <tbody>
            <?php
            for ($hour = 8; $hour < 16; $hour++) {
                $start_time = sprintf('%02d:30:00', $hour);
                $end_time = sprintf('%02d:30:00', $hour + 1);

                echo "<tr class=''>";
                echo "<td class='border border-gray-300 px-4 py-2 text-center'>" . date('h:i A', strtotime($start_time)) . " - " . date('h:i A', strtotime($end_time)) . "</td>";

                foreach ($days as $day) {
                    $slot = array_filter($timetable[$day], function ($s) use ($start_time) {
                        return $s['start_time'] === $start_time;
                    });

                    $slot = current($slot); // Get the first matching slot or null

                    $status = $slot['status'] ?? 'available';
                    $subject = $slot['subject_code'] ?? 'None';
                    $stime = $slot['start_time'] ?? 'None';
                    $etime = $slot['end_time'] ?? 'None';
                    $id = $slot['id'] ?? 'None';

                    $display_status = ucfirst($status);
                    $display_subject = ($subject !== 'None') ? "{$subject}" : "";
                    $display_stime = ($stime !== 'None') ? "{$stime}" : "";
                    $display_etime = ($etime !== 'None') ? "{$etime}" : "";
                    $display_id = ($id !== 'None') ? "{$id}" : "";

                    echo "<td class='hover:bg-gray-100 border border-gray-300 px-4 py-2 text-center'>";
                    echo "<div class='font-medium text-gray-800'>{$display_subject}</div>";
                    echo "<div class='font-medium text-gray-800'>{$display_status}</div>";
                    echo "<div class='font-medium text-gray-800'>{$display_id}</div>";
                    echo "</td>";
                }

                echo "</tr>";
            }
            ?>
        </tbody>
    </table>
</div>
</body>
</html>
