<?php

ob_start();
session_start();
if (isset($_POST['source']) && isset($_POST['amount'])) {
    // include Database connection file 
    include("dbconnect.php");

    // get values 
    $source = $_POST['source'];
    $amount = $_POST['amount'];
    $church_id = $_SESSION['user'];
    $year = $_POST['year'];


    //$query = "INSERT INTO income_sources (source_name, amount) VALUES('$source', '$amount')";
    $query = mysql_query("INSERT INTO income_sources (source_name,amount,church_id,financial_year)VALUES('$source', '$amount','$church_id','$year')");
    if (!$query) {
        die("error1!");
        exit(mysql_error($conn));
    }
    $update_query = mysql_query("UPDATE financial_year F
    SET total_income =
    (SELECT SUM(amount) FROM income_sources 
    WHERE church_id = $church_id AND financial_year = $year)
    WHERE church_id = $church_id AND id = $year");
    if (!$update_query) {
        die("error2!");
        exit(mysql_error($conn));
    }
    $sumincome_query = mysql_query("SELECT total_income AS Income from financial_year WHERE church_id = $church_id and id =$year");
    $sumbills_query = mysql_query("SELECT total_bills AS Bills from financial_year WHERE church_id = $church_id and id =$year");
    $incomerow = mysql_fetch_assoc($sumincome_query);
    $sum_income = $incomerow['Income'];

    $expenserow = mysql_fetch_assoc($sumbills_query);
    $sum_bill = $expenserow['Bills'];
    $balance = $sum_income - $sum_bill;

    $bal_query = mysql_query("UPDATE financial_year F
    SET balance = '$balance' WHERE church_id = $church_id AND id = $year");

    if (!$bal_query) {
        die("error3!");
        exit(mysql_error($conn));
    }
    if ($query && $update_query && $bal_query) {

        echo "1 Record Added!";
    }
}
?>