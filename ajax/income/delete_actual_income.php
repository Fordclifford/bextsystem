<?php
session_start();
require_once '../../includes/auth_validate.php';
require_once '../../coreadmin/config/config.php';
$del_id = filter_input(INPUT_POST, 'id');
if ($del_id && $_SERVER['REQUEST_METHOD'] == 'POST'){
  
    $db = getDbInstance();
    $db->where('id', $del_id);
    $status = $db->delete('actual_income');
 
    if ($status)
    {
        $_SESSION['info'] = "Record deleted successfully!";
        header('location: ../actual_income.php');
        exit;
    }
    if(!$status)
    {
    	$_SESSION['failure'] ="Unable to delete record, check to confirm that no bills are associated with the record";
    	header('location: ../actual_income.php');
        exit;
    }
   

}
