<?php
session_start();
require_once '../../includes/auth_validate.php';
require_once '../../coreadmin/config/config.php';


//serve POST method, After successful insert, redirect to churches.php page.
if ($_SERVER['REQUEST_METHOD'] == 'POST')
{
   
    //Mass Insert Data. Keep "name" attribute in html form same as column name in mysql table.
$data_to_store = filter_input_array(INPUT_POST);

    //Insert timestamp
    $db = getDbInstance();
    
    $data_to_store['church_id']=$_SESSION['church'];
    $last_id = $db->insert ('actual_income', $data_to_store);
     

    if($last_id)
    {
    	$_SESSION['success'] = "Record added successfully!";
    	exit;
    }
}

//We are using same form for adding and editing. This is a create form so declare $edit = false.
?>



