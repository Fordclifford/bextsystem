<?php
error_reporting( ~E_DEPRECATED & ~E_NOTICE );

$host_name = "localhost";
$database = "bext_system"; // Change your database nae
$username = "root";          // Your database user id 
$password = "";   
 
 try {
$dbo = new PDO('mysql:host='.$host_name.';dbname='.$database, $username, $password);
} catch (PDOException $e) {
print "Error!: " . $e->getMessage() . "<br/>";
die();
}
