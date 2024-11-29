<html>
<head>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css"></link>
</head>
<body class="bg-gray-800">
    <div class="flex">
        <!-- Sidebar -->
        <div class="bg-blue-700 w-16 h-screen flex flex-col items-center py-4">
            <a href="?content=../page/timetable.html" class="fas fa-bars text-white mb-8"></a>
            <a href="?content=../page/user.html" class="fas fa-user text-white mb-8"></a>
            <a href="" class="fas fa-cog text-white mb-8"></a>
            <a href="" class="fas fa-sync-alt text-white mb-8"></a>
            <a href="../page/login.html" class="fas fa-sign-out-alt text-white"></a>
        </div>
        <!-- Main Content -->
        <div class="flex-1 bg-gray-200 p-8">
            <div class="top-bar text-center">
                
              </div>
            <div class="content">
              <div class="container">
                <?php
                      if(isset($_GET['content'])){
                          $contentPage=$_GET['content'];
                          if(file_exists($contentPage)){
                              include($contentPage);
                          }
                      }else{
                        
                      }
                      
                  ?>
              </div>
              </div>
        </div>
    </div>

    
</body>
</html>