<?php
//constant variable (variable name, value)
define('SERVERNAME', '127.0.0.1');
define('USERNAME', 'root');
define('PASSWORD', '');
define('DBNAME', 'lab_resv_sys');
try{
	//connect with database
$conn = mysqli_connect(SERVERNAME,USERNAME,PASSWORD,DBNAME);

if (!$conn) {
	die("connection failed".mysqli_connect_error()); //die - stop process after that
} else {
	echo "Connection successfully <br>";
	}
}
catch (Exception $e){
	die($e->getMessage());
}

//echo "abc <br>"


?>

