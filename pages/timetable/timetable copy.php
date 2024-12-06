<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dynamic Timetable</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
</head>
<body class="bg-gray-900 text-white">

    <!-- Main Content -->
    <div class="flex-1 bg-gray-800 p-4">
        <div class="flex justify-between items-center mb-4">
            <div class="flex space-x-2">
                <button class="bg-blue-500 text-white px-4 py-2 rounded-full" aria-label="Class 1">CL 1</button>
                <button class="bg-gray-300 text-gray-800 px-4 py-2 rounded-full" aria-label="Class 2">CL 2</button>
            </div>
            <h1 class="text-xl font-bold">Dynamic Time Table</h1>
            <button class="bg-gray-300 text-gray-800 px-4 py-2 rounded-full flex items-center" aria-label="Add New Entry">
                <i class="fas fa-plus mr-2"></i> ADD NEW
            </button>
        </div>

        <div class="bg-gray-100 text-gray-800 p-4 rounded-lg">
            <div class="grid grid-cols-6 gap-4">
                <!-- Time Slots -->
                <div class="col-span-1">
                    <?php
                    $timeSlots = [
                        "8:30 AM", "9:30 AM", "10:30 AM", "11:30 AM",
                        "12:30 PM", "1:30 PM", "2:30 PM", "3:30 PM", "4:30 PM"
                    ];
                    foreach ($timeSlots as $slot) {
                        echo "<div class='text-center py-2'>$slot</div>";
                    }
                    ?>
                </div>

                <!-- Days Schedule -->
                <div class="col-span-5 grid grid-cols-5 gap-4">
                    <?php
                    // Simulated timetable data
                    $timetable = [
                        "Monday" => [
                            ["course" => "CSC3122", "room" => "CL 1", "color" => "green"],
                            ["course" => "CSC2122", "room" => "CL 1", "color" => "red"],
                            ["course" => "IT2122", "room" => "CL 1", "color" => "green"]
                        ],
                        "Tuesday" => [
                            ["course" => "CSC3122", "room" => "CL 1", "color" => "green"],
                            ["course" => "CSC3122", "room" => "CL 1", "color" => "red"],
                            ["course" => "CSC2234", "room" => "CL 1", "color" => "blue"]
                        ],
                        "Wednesday" => [
                            ["course" => "CSC3122", "room" => "CL 1", "color" => "blue"]
                        ],
                        "Thursday" => [
                            ["course" => "CSC1123", "room" => "CL 1", "color" => "red"],
                            ["course" => "CSC1123", "room" => "CL 1", "color" => "blue"]
                        ],
                        "Friday" => [
                            ["course" => "CSC2123", "room" => "CL 1", "color" => "green"],
                            ["course" => "CSC3122", "room" => "CL 1", "color" => "blue"]
                        ]
                    ];

                    // Generate timetable dynamically
                    foreach ($timetable as $day => $slots) {
                        echo '<div class="space-y-4">';
                        foreach ($slots as $slot) {
                            echo '<div class="bg-white p-2 rounded-lg border-l-4 border-' . $slot['color'] . '-500">';
                            echo '<div class="flex justify-between">';
                            echo "<span>{$slot['course']}</span>";
                            echo '<i class="fas fa-caret-down" aria-hidden="true"></i>';
                            echo '</div>';
                            echo "<div>{$slot['room']}</div>";
                            echo '</div>';
                        }
                        echo '</div>';
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
