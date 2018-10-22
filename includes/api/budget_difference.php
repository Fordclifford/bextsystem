<?php
session_start();
require_once '../../config.php';
 if ($_SESSION['user_type'] == 'treasurer') {
// if session is not set this will redirect to login page
require_once '../../includes/auth_validate.php';

 $sumincome = mysql_query("SELECT sum(amount) as sum_income from estimated_income WHERE church_id=" . $_SESSION['church']);
 $row1 = mysql_fetch_assoc($sumincome); 

 $sumexpense = mysql_query("SELECT sum(amount) as sum_expense from estimated_expenses WHERE church_id=" . $_SESSION['church']);
 $row2= mysql_fetch_assoc($sumexpense);

    if ($row1['sum_income'] < $row2['sum_expense'] ) {
        echo 'lessby'. ($row2['sum_expense']- $row1['sum_income']); 
    }
     if ($row1['sum_income'] > $row2['sum_expense'] ) {
        echo 'remaining'. ($row1['sum_income']-$row2['sum_expense']); 
    }
     

    
}