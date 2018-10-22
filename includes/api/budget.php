<?php
 
session_start();
require_once '../../config.php';
 if ($_SESSION['user_type'] == 'treasurer') {
// if session is not set this will redirect to login page
require_once '../../includes/auth_validate.php';
  $budget = mysql_query("SELECT expense_name,church_id FROM estimated_expenses WHERE church_id=" . $_SESSION['church']);
   if (mysql_num_rows($budget) == 0) {
   echo 'expenses_not_exist';     
 } 
    
  $income = mysql_query("SELECT source_name,church_id FROM estimated_income WHERE church_id=" . $_SESSION['church']);
  if (mysql_num_rows($income) == 0) {
        echo 'income_not_exist'; 
    }
    
  $sumincome = mysql_query("SELECT sum(amount) as sum_income from estimated_income WHERE church_id=" . $_SESSION['church']);
  $row = mysql_fetch_assoc($sumincome); 
$incomesum = $row['sum_income'];

$sumexpenses= mysql_query("SELECT sum(amount) as sum_expenses from estimated_expenses WHERE church_id=" . $_SESSION['church']);
  $row = mysql_fetch_assoc($sumexpenses); 
$expensesum = $row['sum_expenses'];

    if ($incomesum < $expensesum ) {
        echo 'income_less'; 
    }
    
}