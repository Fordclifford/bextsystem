<?php
//update.php
session_start();
require_once './config/config.php';
require_once 'includes/auth_validate.php';
if ($_SERVER['REQUEST_METHOD'] == 'POST'){
$db = getDbInstance();
$data = Array($_POST["name"] => $_POST["value"]);      
$db->where('id',$_POST["pk"]);
$last_id=$db->update('church', $data);

     if($last_id)
{
    	echo $_SESSION['success'] ="Successfully Updated ".$_POST["name"];
}
  
   }
?>
