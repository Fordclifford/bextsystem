<?php
 
session_start();
require_once '../../config.php';
 if ($_SESSION['user_type'] == 'treasurer') {
// if session is not set this will redirect to login page
require_once '../../includes/auth_validate.php';
  $income = mysql_query("SELECT  * FROM bill WHERE church_id=".$_SESSION['church']);
   if (mysql_num_rows($income) == 0) {
   echo 'bill_not_exist';     
 }
 $sumbill = mysql_query("SELECT sum(amount) as sum_bill from bill WHERE church_id=" . $_SESSION['church']);
 $row = mysql_fetch_assoc($sumbill); 
echo 'sumbill'.$incomesum = $row['sum_bill'];
   

    
}