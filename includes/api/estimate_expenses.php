<?php
 
session_start();
require_once '../../config.php';
 if ($_SESSION['user_type'] == 'treasurer') {
// if session is not set this will redirect to login page
require_once '../../includes/auth_validate.php';

 $sumexpense = mysql_query("SELECT sum(amount) as sum_expense from estimated_expenses WHERE church_id=" . $_SESSION['church']);
 $row = mysql_fetch_assoc($sumexpense); 
echo 'expensesum'.$row['sum_expense'];
   
}