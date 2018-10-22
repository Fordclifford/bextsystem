<?php
//update.php
$error=false;
//update.php
session_start();
require_once './config/config.php';
require_once 'includes/auth_validate.php';
if ($_SERVER['REQUEST_METHOD'] == 'POST'){
    if ($_POST["name"] =="email" || $_POST["name"]=="user_name"){
        $db = getDbInstance();
        $db->where($_POST["name"],$_POST["value"]);
       if( $db->getValue ("users", "count(*)")>0)
 {
echo  $_SESSION['failure'] = $_POST["name"]." Already Taken!";
   $error=true;
 }
}
    if(!$error){
  $db = getDbInstance();
$data = Array($_POST["name"] => $_POST["value"]);      
$db->where('id',$_POST["pk"]);
$last_id=$db->update('users', $data);

if($last_id)
{
    	echo $_SESSION['success'] ="Successfully Updated ".$_POST["name"];
}


   }
}
?>