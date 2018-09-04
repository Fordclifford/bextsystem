<?php
//update.php
$error=false;
$connect = mysqli_connect("localhost", "root", "", "bext_system");
if ($_POST["name"] =="email" || $_POST["name"]=="user_name"){
 $sql2 = "SELECT * from users where ".$_POST["name"]." = '".$_POST["value"]."'";
 $result = mysqli_query($connect, $sql2);
 if( $count = mysqli_num_rows($result)>0)
 {
echo  $errMSG = $_POST["name"]." Already Taken!";
   $error=true;
   $errTyp="danger";
 }
}
if(!$error){
$query = "
 UPDATE users SET ".$_POST["name"]." = '".$_POST["value"]."'
 WHERE id = '".$_POST["pk"]."'";

 if(mysqli_query($connect, $query))
 {

  echo $_POST["name"]. ' Successfully Updated';
 }
}
?>
