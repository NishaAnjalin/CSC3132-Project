<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <a href="public/dashboard/dashboard.php"> go to dashboard </a>
    <?php
    $password_hash = password_hash("1234", PASSWORD_BCRYPT);
    echo "<br>".$password_hash;
    ?>
</body>
</html>
