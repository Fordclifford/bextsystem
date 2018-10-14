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
 foreach ($fdb->get('actual_income') as $row) {
     $fy = $row['financial_year_id'];
 }
  $status = $db->delete('actual_income');
    $update_query = mysql_query("UPDATE financial_year F
    SET total_actual_income =
    (SELECT SUM(amount) FROM actual_income
    WHERE church_id=$church_id AND financial_year=$fy)
    WHERE id = $fy");
      if (!$update_query) {
          $error =true;
          exit(mysql_error($conn));
            }
            
            $sumincome_query = mysql_query("SELECT total_actual_income AS Income from financial_year  WHERE church_id = $church_id AND id =$fy ");
        $sumbills_query = mysql_query("SELECT total_bills AS Bills from financial_year  WHERE church_id = $church_id AND id =$fy ");
        $incomerow = mysql_fetch_assoc($sumincome_query);
        $sum_income = $incomerow['Income'];


        $expenserow = mysql_fetch_assoc($sumbills_query);
        $sum_bill = $expenserow['Bills'];

        $balance = $sum_income - $sum_bill;

        if ($balance == 0) {
            $balan = 0.00;
        } if ($balance != 0) {
            $balan = $balance;
        }

        $bal_query = mysql_query("UPDATE financial_year
    SET balance = '$balan' WHERE church_id = $church_id AND id = $fy");

        if (!$bal_query) {
            $error = true;
            die("error3!");
            exit(mysql_error($conn));
        }

    if ($status && !$error)
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
