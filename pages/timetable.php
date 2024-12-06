<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Default Time Table</title>
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
            <h1 class="text-xl font-bold">Default Time Table</h1>
            <button class="bg-gray-300 text-gray-800 px-4 py-2 rounded-full flex items-center" aria-label="Add New Entry">
                <i class="fas fa-plus mr-2"></i> ADD NEW
            </button>
        </div>

        <div class="bg-gray-100 text-gray-800 p-4 rounded-lg">
            <div class="grid grid-cols-6 gap-4">

                <!-- Timetable Section -->
                <div class="col-span-5">
                    <table class="table-auto w-full border-collapse">
                        <thead>
                            <tr class="bg-gray-300 text-gray-800">
                                <th class="p-2">Monday</th>
                                <th class="p-2">Tuesday</th>
                                <th class="p-2">Wednesday</th>
                                <th class="p-2">Thursday</th>
                                <th class="p-2">Friday</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            // Sample timetable data
                            $timetable = [
                                ['CSC3122', 'CL 1'],
                                ['CSC3122', 'CL 1'],
                                ['CSC3122', 'CL 1'],
                                ['CSC3122', 'CL 1'],
                                ['CSC3122', 'CL 1'],
                            ];

                            // Simulate rows for time slots
                            for ($i = 0; $i < 3; $i++) {
                                echo '<tr>';
                                foreach ($timetable as $entry) {
                                    echo '<td class="p-2">';
                                    echo '<div class="bg-white p-2 rounded-lg border-l-4 border-green-500">';
                                    echo '<div class="flex justify-between">';
                                    echo "<span>{$entry[0]}</span>";
                                    echo '<i class="fas fa-caret-down"></i>';
                                    echo '</div>';
                                    echo "<div>{$entry[1]}</div>";
                                    echo '</div>';
                                    echo '</td>';
                                }
                                echo '</tr>';
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
