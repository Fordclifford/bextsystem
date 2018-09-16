<?php
//update.php
session_start();
require_once '../../includes/auth_validate.php';
require_once '../../coreadmin/config/config.php';
if ($_SERVER['REQUEST_METHOD'] == 'POST'){
$db = getDbInstance();
$data = Array($_POST["name"] => $_POST["value"]);      
$db->where('id',$_POST["pk"]);
$last_id=$db->update('actual_income', $data);

     if($last_id)
{
    	echo $_SESSION['success'] ="Successfully Updated ".$_POST["name"];
       
}
  
   }
?>