<?php
 
session_start();
require_once '../../config.php';
 if ($_SESSION['user_type'] == 'treasurer') {
// if session is not set this will redirect to login page
require_once '../../includes/auth_validate.php';
 $sumincome = mysql_query("SELECT sum(amount) as sum_income from estimated_income WHERE church_id=" . $_SESSION['church']);
 $row1 = mysql_fetch_assoc($sumincome); 
echo 'estimateincome'.$row1['sum_income'];
 
}