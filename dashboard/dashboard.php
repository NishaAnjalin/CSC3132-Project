<html>
<head>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
</head>
<body class="bg-gray-800">
    <div class="flex">
        <!-- Sidebar -->
        <div class="bg-blue-700 w-20 h-screen flex flex-col items-center py-6">
            <!-- Sidebar Header -->
            <div class="text-white text-lg font-bold mb-6">Menu</div>
            <!-- Sidebar Links -->
            <a href="?content=../pages/timetable.html" class="fas fa-bars text-white text-2xl mb-8" title="Timetable"></a>
            <a href="?content=../pages/user.php" class="fas fa-user text-white text-2xl mb-8" title="User"></a>
            <a href="?content=../pages/settings.html" class="fas fa-cog text-white text-2xl mb-8" title="Settings"></a>
            <a href="?content=../pages/sync.html" class="fas fa-sync-alt text-white text-2xl mb-8" title="Sync"></a>
            <a href="../pages/login.php" class="fas fa-sign-out-alt text-white text-2xl" title="Logout"></a>
        </div>

        <!-- Main Content -->
        <div class="flex-1 bg-gray-200 p-8">
            <!-- Top Bar -->
            <div class="flex justify-between items-center mb-6">
                <!-- Search Bar -->
                <div class="relative">
                    <input type="text" placeholder="Search..." class="rounded-lg border-2 border-gray-400 pl-10 pr-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    <span class="absolute left-3 top-2 text-gray-500">
                        <i class="fas fa-search"></i>
                    </span>
                </div>
                
                <!-- Profile & Notifications -->
                <div class="flex items-center space-x-6">
                    <!-- Notifications -->
                    <div class="relative">
                        <i class="fas fa-bell text-gray-600 text-2xl cursor-pointer"></i>
                        <span class="absolute top-0 right-0 bg-red-500 text-white text-xs rounded-full px-2 py-1">3</span>
                    </div>
                    <!-- Profile -->
                    <div class="flex items-center space-x-3 cursor-pointer">
                        <img src="https://via.placeholder.com/40" alt="Profile" class="rounded-full w-10 h-10">
                        <div class="text-gray-700">
                            <p class="font-bold">John Doe</p>
                            <p class="text-sm">Admin</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Lab Details -->
            <!-- <div class="bg-white rounded-lg shadow p-6 mb-6">
                <h2 class="text-xl font-bold text-gray-800 mb-4">Lab Details</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6"> -->
                    <!-- Lab 1 -->
                    <!-- <div class="bg-blue-100 p-4 rounded-lg">
                        <h3 class="text-lg font-bold text-blue-800">Lab 1 (CL1)</h3>
                        <p class="text-gray-700">Equipped for computer science practicals, including high-performance systems and software for programming, web development, and database management.</p>
                        <button class="mt-4 bg-blue-700 text-white px-4 py-2 rounded">Reserve Lab 1</button>
                    </div> -->
                    <!-- Lab 2 -->
                    <!-- <div class="bg-blue-100 p-4 rounded-lg">
                        <h3 class="text-lg font-bold text-blue-800">Lab 2 (CL2)</h3>
                        <p class="text-gray-700">Designed for advanced research and development, featuring AI and ML tools, robotics kits, and virtual reality equipment.</p>
                        <button class="mt-4 bg-blue-700 text-white px-4 py-2 rounded">Reserve Lab 2</button>
                    </div>
                </div>
            </div> -->

            <!-- Dynamic Content -->
            <div class="bg-white rounded-lg shadow p-6">
                <div class="content">
                    <div class="container">
                        <?php
                        if (isset($_GET['content'])) {
                            $contentPage = $_GET['content'];
                            if (file_exists($contentPage)) {
                                include($contentPage);
                            } else {
                                echo "<p class='text-red-500'>Page not found.</p>";
                            }
                        } else {
                            echo "<p>Welcome to the dashboard! Select an option from the sidebar.</p>";
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
