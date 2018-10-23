<?php
 
session_start();
require_once '../../config.php';
 if ($_SESSION['user_type'] == 'treasurer') {
// if session is not set this will redirect to login page
require_once '../../includes/auth_validate.php';
 $year = date("Y");
 $sumincome = mysql_query("SELECT total_estimated_income as sum_income from financial_year WHERE year='$year' AND church_id=" . $_SESSION['church']);
 $row1 = mysql_fetch_assoc($sumincome); 

  if ($row1['sum_income']>0)
 {
     echo 'estimateincomeokay'.$row1['sum_income'];
 }

 if ($row1['sum_income']==0)
 {
     echo 'estimateincomezero'.$row1['sum_income'];
 }

 
}