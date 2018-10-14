<?php
session_start();
require_once '../../includes/auth_validate.php';
require_once '../../coreadmin/config/config.php';
require_once 'config.php';

//serve POST method, After successful insert, redirect to churches.php page.
if ($_SERVER['REQUEST_METHOD'] == 'POST')
{
   
    //Mass Insert Data. Keep "name" attribute in html form same as column name in mysql table.
$data_to_store = filter_input_array(INPUT_POST);
$error = false;

    //Insert timestamp
    $db = getDbInstance();
    $church_id = $_SESSION['church'];
    $year = $_POST['financial_year_id'];
    $data_to_store['church_id']=$_SESSION['church'];
    $last_id = $db->insert ('actual_income', $data_to_store);
    
     $update_query = mysql_query("UPDATE financial_year F
    SET total_actual_income =
    (SELECT SUM(amount) FROM actual_income
    WHERE church_id = '$church_id' AND financial_year_id = $year)
    WHERE id = $year");
      if (!$update_query) {
          $error =true;
               exit(mysql_error($conn));
            }

       $sumincome_query = mysql_query("SELECT total_actual_income AS Income from financial_year  WHERE church_id = $church_id AND id =$year ");
        $sumbills_query = mysql_query("SELECT total_bills AS Bills from financial_year  WHERE church_id = $church_id AND id =$year ");
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
    SET balance = '$balan' WHERE church_id = $church_id AND id = $year");

        if (!$bal_query) {
            $error = true;
            die("error3!");
            exit(mysql_error($conn));
        }

    if($last_id && !$error)
    {        
    	echo $_SESSION['success'] = "Record added successfully!";
         exit;
    } else {
       echo  $_SESSION['failure'] = "Error Occured 2!";
    	
    }
}

//We are using same form for adding and editing. This is a create form so declare $edit = false.
?>



