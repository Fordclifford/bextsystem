<?php

ob_start();
session_start();

// check request
if (isset($_POST['id']) && isset($_POST['id']) != "") {
$church_id = $_SESSION['user'];
    require_once 'dbconfig.php';
    require_once 'dbconnect.php';

    // it will delete an actual record from db
    $stmt_delete = $DB_con->prepare('DELETE FROM income_sources WHERE id =:uid');
    $stmt_delete->bindParam(':uid', $_POST['id']);
    $id = $_POST['id'];
    $id_query = mysql_query("SELECT financial_year AS ID from income_sources WHERE id =$id");
    if (!$id_query) {
        die("error2!");
        exit(mysql_error($conn));
    }
    $id_row = mysql_fetch_assoc($id_query);
    $yr_id = $id_row['ID'];
    $stmt_delete->execute();
    $update_query = mysql_query("UPDATE financial_year F
    SET total_income =
    (SELECT SUM(amount) FROM income_sources 
    WHERE church_id = '$church_id' AND financial_year = $yr_id)
    WHERE church_id = '$church_id' AND id = $yr_id");
    if (!$update_query) {
        die("error1!");
        $errMSG = "Sorry Data Could Not Updated !";
        exit(mysql_error($conn));
    }

    $sumincome_query = mysql_query("SELECT total_income AS Income from financial_year  WHERE church_id = $church_id AND id =$yr_id ");
    $sumbills_query = mysql_query("SELECT total_bills AS Bills from financial_year  WHERE church_id = $church_id AND id =$yr_id ");
    $incomerow = mysql_fetch_assoc($sumincome_query);
    $sum_income = $incomerow['Income'];

    $expenserow = mysql_fetch_assoc($sumbills_query);
    $sum_bill = $expenserow['Bills'];
    $balance = $sum_income - $sum_bill;

    $bal_query = mysql_query("UPDATE financial_year 
    SET balance = '$balance' WHERE church_id = $church_id AND id = $yr_id");

    if (!$bal_query) {
        die("error3!");
        exit(mysql_error($conn));
    }
}
ob_end_flush();
?>