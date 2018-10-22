<?php
 
session_start();
require_once '../../config.php';
 if ($_SESSION['user_type'] == 'treasurer') {
// if session is not set this will redirect to login page
require_once '../../includes/auth_validate.php';
$output = array();
  $income = mysql_query("SELECT  source_name,balance FROM actual_income WHERE balance<0 AND church_id=".$_SESSION['church']);
 
 if (mysql_num_rows($income) > 0) {
 echo 'output';
while ($row = mysql_fetch_assoc($income)) {
 printf($row['source_name'].": %s ", $row["balance"].",\n");    
}  
 }



    
}