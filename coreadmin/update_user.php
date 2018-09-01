<?php
//update.php
$connect = mysqli_connect("localhost", "root", "", "bext_system");
$query = "
 UPDATE users SET ".$_POST["name"]." = '".$_POST["value"]."'
 WHERE id = '".$_POST["pk"]."'";
mysqli_query($connect, $query);
?>
