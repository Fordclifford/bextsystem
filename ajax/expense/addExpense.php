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
    $data_to_store['church_id']=$_SESSION['church'];
    
   $last_id = $db->insert ('estimated_expenses', $data_to_store);
   $year = $_POST['financial_year'];
     $update_query = mysql_query("UPDATE financial_year F
    SET total_estimated_expenses =
    (SELECT SUM(amount) FROM estimated_expenses
    WHERE church_id = '$church_id' AND financial_year = $year)
    WHERE id = $year");
      if (!$update_query) {
          $error =true;
                die(mysql_error($conn));
                exit(mysql_error($conn));
            }

    if($last_id && !$error)
    {
    	$_SESSION['success'] = "Record added successfully!";
    	exit;
    }
}

//We are using same form for adding and editing. This is a create form so declare $edit = false.
?>



