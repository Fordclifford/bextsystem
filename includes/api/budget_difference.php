<?php
session_start();
require_once '../../config.php';
 if ($_SESSION['user_type'] == 'treasurer') {
// if session is not set this will redirect to login page
require_once '../../includes/auth_validate.php';
$year = date("Y");
 $sum = mysql_query("SELECT total_estimated_income,total_estimated_expenses from financial_year WHERE year='$year' AND church_id=" . $_SESSION['church']);
 $row = mysql_fetch_assoc($sum); 
    if ($row['total_estimated_income'] < $row['total_estimated_expenses'] ) {
        echo 'lessby'. ($row['total_estimated_expenses']-$row['total_estimated_income']); 
    }
     if ($row['total_estimated_income'] > $row['total_estimated_expenses'] ) {
        echo 'remaining'. ($row['total_estimated_income']-$row['total_estimated_expenses']); 
    }
    
     

    
}