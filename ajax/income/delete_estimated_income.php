<?php
session_start();
require_once '../../includes/auth_validate.php';
require_once '../../coreadmin/config/config.php';
require_once 'config.php';
$del_id = filter_input(INPUT_POST, 'id');
if ($del_id && $_SERVER['REQUEST_METHOD'] == 'POST'){
  $error = false;
    $db = getDbInstance();
    $db->where('id', $del_id);
    
 $church_id = $_SESSION['church'];
  
    $fdb = getDbInstance();
    $fdb->where('id', $del_id);
 foreach ($fdb->get('estimated_income') as $row) {
     $fy = $row['financial_year'];
 }
  $status = $db->delete('estimated_income');
    $update_query = mysql_query("UPDATE financial_year F
    SET total_estimated_income =
    (SELECT SUM(amount) FROM estimated_income
    WHERE church_id=$church_id AND financial_year=$fy)
    WHERE id = $fy");
      if (!$update_query) {
          $error =true;
          exit(mysql_error($conn));
            }
           

    if ($status && !$error)
    {
        $_SESSION['info'] = "Record deleted successfully!";
       
    }
    if(!$status)
    {
    	$_SESSION['failure'] ="Unable to delete record!!";
    	
    }
   

}
