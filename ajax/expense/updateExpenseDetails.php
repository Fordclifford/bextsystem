<?php
// include Database connection file
include("dbconnect.php");
ob_start();
session_start();
// check request
if(isset($_POST)){
    // get values
    $id = $_POST['id'];
    $expense = $_POST['expense'];
    $amount = $_POST['amount'];
    $year = $_POST['year'];
     $church_id=$_SESSION['church'];

    // Updaste income details
     $query = mysql_query("UPDATE budget_expenses SET expense_name = '$expense', amount = '$amount',financial_year ='$year' WHERE sid = '$id'");
     $update_query = mysql_query("UPDATE financial_year F
    SET total_expenses =
    (SELECT SUM(amount) FROM budget_expenses
    WHERE church_id = $church_id AND financial_year = $year)
    WHERE church_id = $church_id AND id = $year");
      if (!$update_query) {
                die("error1!");
                exit(mysql_error($conn));
            }
     if (!$query) {
        exit(mysql_error());

    }
     $sum_amt = mysql_query("SELECT SUM(amount) AS sum FROM bill WHERE source=$id AND church_id=$church_id AND financial_year=$year");
       $sum_row = mysql_fetch_assoc($sum_amt);
         $sum = $sum_row['sum'];

        $bala = mysql_query("SELECT amount AS amount FROM budget_expenses WHERE sid=$id");
       $bal_row = mysql_fetch_assoc($bala);
       $amt_val = $bal_row['amount'];

        $bal_val = $amt_val - $sum;
        $upd_query=mysql_query("UPDATE budget_expenses SET balance='$bal_val' WHERE sid=$id");

     if (!$upd_query) {
        exit(mysql_error());

    }
}
 ob_end_flush();
 ?>
