<?php

    define('host', '127.0.0.1:3306');
	define('user', 'root');
	define('pwd', 'mariadb');
	define('db', 'lab_reservation_system');

    $conn=new mysqli(host,user,pwd,db);


// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
echo "Connected successfully";

?>