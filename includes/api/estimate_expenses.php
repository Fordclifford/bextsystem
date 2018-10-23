<?php
 
session_start();
require_once '../../config.php';
 if ($_SESSION['user_type'] == 'treasurer') {
// if session is not set this will redirect to login page
require_once '../../includes/auth_validate.php';
 $year = date("Y");
 $sumexpense = mysql_query("SELECT total_estimated_expenses as sum_expense from financial_year WHERE year='$year' AND church_id=" . $_SESSION['church']);
 $row = mysql_fetch_assoc($sumexpense); 


  if ($row['sum_expense']>0)
 {
     echo 'expensesumokay'.$row['sum_expense'];
 }

 if ($row['sum_expense']==0)
 {
     echo 'expensesumzero'.$row['sum_expense'];
 }
 
}