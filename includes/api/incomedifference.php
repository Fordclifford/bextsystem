<?php
session_start();
require_once '../../config.php';
 if ($_SESSION['user_type'] == 'treasurer') {
// if session is not set this will redirect to login page
require_once '../../includes/auth_validate.php';
 $year = date("Y");
 $sumbill = mysql_query("SELECT balance as balance from financial_year WHERE year='$year' AND church_id=" . $_SESSION['church']);
  $row = mysql_fetch_assoc($sumbill); 

      if ($row['balance'] >0 ) {
        echo 'remaining'. $row['balance']; 
    }
     

    
}