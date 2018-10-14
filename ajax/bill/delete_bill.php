<?php
session_start();
require_once '../../includes/auth_validate.php';
require_once '../../coreadmin/config/config.php';
require_once 'dbconfig.php';
require_once 'config.php';
                         
$del_id = filter_input(INPUT_POST, 'id');
if ($del_id && $_SERVER['REQUEST_METHOD'] == 'POST'){
   $church_id = $_SESSION['church'];
           
    
$status = true;
         // select image from db to delete

        $stmt_select = $dbo->prepare('SELECT image FROM bill WHERE id =:uid');
        $stmt_select->execute(array(':uid' => $del_id));
        $imgRow = $stmt_select->fetch(PDO::FETCH_ASSOC);
        $img = "no-image.png";
        if ($imgRow['image'] !== $img) {
            unlink("../../uploads/" . $imgRow['image']);
                   } 
        // it will delete an actual record from db
        $stmt_delete = $dbo->prepare('DELETE FROM bill WHERE id =:uid');
        $stmt_delete->bindParam(':uid', $del_id);


        $id = $del_id;
        $id_query = mysql_query("SELECT financial_year,source from bill WHERE id =$id");
        if (!$id_query) {
             $status = false;
                die("error1!");
                $_SESSION['failure']= "Error!";
                exit(mysql_error($conn));
        }
      
        $id_row = mysql_fetch_assoc($id_query);
        $yr_id = $id_row['financial_year'];
        $category = $id_row['source'];
      $stmt_delete->execute();
        $sum_amt = mysql_query("SELECT SUM(amount) AS sum FROM bill WHERE source=$category AND church_id=$church_id AND financial_year=$yr_id");
        $sum_row = mysql_fetch_assoc($sum_amt);
        $sum = $sum_row['sum'];

        $bala = mysql_query("SELECT amount AS amount FROM actual_income WHERE id=$category ");
        $bal_row = mysql_fetch_assoc($bala);
        $amt_val = $bal_row['amount'];

       echo  $bal_val = $amt_val - $sum;
        $upd_query = mysql_query("UPDATE actual_income SET balance='$bal_val' WHERE id=$category");

        if (!$upd_query) {
            $status = false;
                die("error1!");
                $_SESSION['failure']= "Error2 !";
                exit(mysql_error($conn));
        }
        $ch = mysql_query("Select *  FROM bill WHERE church_id = $church_id AND financial_year = $yr_id ");
        if (mysql_num_rows($ch) > 0) {
            $update_query = mysql_query("UPDATE financial_year F
    SET total_bills =
    (SELECT SUM(amount) FROM bill
    WHERE church_id = '$church_id' AND financial_year = $yr_id)
    WHERE church_id = '$church_id' AND id = $yr_id");
            if (!$update_query) {
                $status = false;
                die("error1!");
                $_SESSION['failure']= "Error3 !";
                exit(mysql_error($conn));
            }
        }
        if (mysql_num_rows($ch) == 0) {
            $tot = 0.00;
            $update_query = mysql_query("UPDATE financial_year F
    SET total_bills = '$tot' WHERE church_id = '$church_id' AND id = $yr_id");
            if (!$update_query) {
                $status = false;
                die("error1!");
                $_SESSION['failure']= "Sorry Data Could Not Updated !";
                exit(mysql_error($conn));
            }
        }

        $sumincome_query = mysql_query("SELECT total_actual_income AS Income from financial_year  WHERE church_id = $church_id AND id =$yr_id ");
        $sumbills_query = mysql_query("SELECT total_bills AS Bills from financial_year  WHERE church_id = $church_id AND id =$yr_id ");
        $incomerow = mysql_fetch_assoc($sumincome_query);
        $sum_income = $incomerow['Income'];


        $expenserow = mysql_fetch_assoc($sumbills_query);
        $sum_bill = $expenserow['Bills'];

        $balance = $sum_income - $sum_bill;

        if ($balance == 0) {
            $balan = 0.00;
        } if ($balance != 0) {
            $balan = $balance;
        }

        $bal_query = mysql_query("UPDATE financial_year
    SET balance = '$balan' WHERE church_id = $church_id AND id = $yr_id");

        if (!$bal_query) {
            $status = false;
            die("error3!");
            exit(mysql_error($conn));
        }

        
        
           if ($status)
    {
        $_SESSION['info'] = "Record deleted successfully!";
        header('location: ../../bills.php');
        exit;
    }
    if(!$status)
    {
    	$_SESSION['failure'] ="Unable to delete record!";
    	header('location: ../../bills.php');
        exit;
    }
}    
