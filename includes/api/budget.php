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
    
}