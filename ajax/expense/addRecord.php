<?php
ob_start();
session_start();
if (isset($_POST['expense']) && isset($_POST['amount'])) {
    // include Database connection file
    include("dbconnect.php");
    // get values
    $expense = $_POST['expense'];
    $amount = $_POST['amount'];
     $church_id=$_SESSION['church']; 
      $year = $_POST['year'];


    $query = mysql_query("INSERT INTO budget_expenses (expense_name,amount,church_id,financial_year,balance)VALUES('$expense', '$amount','$church_id','$year','$amount')");
     if (!$query) {
        exit(mysql_error($conn));

    }

    $update_query = mysql_query("UPDATE financial_year F
    SET total_expenses =
    (SELECT SUM(amount) FROM budget_expenses
    WHERE church_id = $church_id AND financial_year = $year)
    WHERE church_id = $church_id AND id = $year");
      if (!$update_query) {
                die("error1!");
                exit(mysql_error($conn));
            }

    else{
    echo "1 Record Added!";
    }
}
ob_end_flush();
?>
