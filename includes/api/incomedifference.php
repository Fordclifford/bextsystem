<?php
session_start();
require_once '../../config.php';
 if ($_SESSION['user_type'] == 'treasurer') {
// if session is not set this will redirect to login page
require_once '../../includes/auth_validate.php';

 $sumincome = mysql_query("SELECT sum(amount) as sum_income from actual_income WHERE church_id=" . $_SESSION['church']);
 $row1 = mysql_fetch_assoc($sumincome); 

 $sumbill = mysql_query("SELECT sum(amount) as sum_bill from bill WHERE church_id=" . $_SESSION['church']);
 $row2 = mysql_fetch_assoc($sumbill); 

    if ($row1['sum_income'] < $row2['sum_bill'] ) {
        echo 'lessby'. ($row2['sum_bill']- $row1['sum_income']); 
    }
     if ($row1['sum_income'] > $row2['sum_bill'] ) {
        echo 'remaining'. ($row1['sum_income']-$row2['sum_bill']); 
    }
     

    
}