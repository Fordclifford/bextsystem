<?php
 
session_start();
require_once '../../config.php';
 if ($_SESSION['user_type'] == 'treasurer') {
// if session is not set this will redirect to login page
require_once '../../includes/auth_validate.php';
  $income = mysql_query("SELECT  * FROM actual_income WHERE church_id=" . $_SESSION['church']);
   if (mysql_num_rows($income) == 0) {
   echo 'actual_not_exist';     
 } 

    
}