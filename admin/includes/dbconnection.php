<?php 
// connecting files to database
define('DBHOST', 'localhost');
define('DBUSER', 'root');
define('DBPASSWORD', '');
define('DBNAME', 'limpua');
//create a connection
$connection = mysqli_connect(DBHOST,DBUSER,DBPASSWORD,DBNAME);
//testing connection
if (!$connection) {
	die('failed to connect'.mysqli_connect_error());
}



?>