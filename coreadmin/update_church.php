<?php
//update.php
$connect = mysqli_connect("localhost", "root", "", "bext_system");
$query = "
 UPDATE church SET ".$_POST["name"]." = '".$_POST["value"]."'
 WHERE id = '".$_POST["pk"]."'";

if(mysqli_query($connect, $query))
{
 echo 'Data Updated';
}
?>
