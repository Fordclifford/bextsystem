<?php
session_start();
require_once '../../includes/auth_validate.php';
require_once '../../coreadmin/config/config.php';
require_once 'config.php';
$del_id = filter_input(INPUT_POST, 'id');
if ($del_id && $_SERVER['REQUEST_METHOD'] == 'POST'){
  $error = false;
    $db = getDbInstance();
    $db->where('sid', $del_id);
    
 $church_id = $_SESSION['church'];
  
    $fdb = getDbInstance();
    $fdb->where('sid', $del_id);
 foreach ($fdb->get('estimated_expenses') as $row) {
     $fy = $row['financial_year'];
 }
  $status = $db->delete('estimated_expenses');
    $update_query = mysql_query("UPDATE financial_year F
    SET total_estimated_expenses =
    (SELECT SUM(amount) FROM estimated_expenses
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
