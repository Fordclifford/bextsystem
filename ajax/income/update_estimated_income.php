<?php
//update.php
session_start();
require_once '../../includes/auth_validate.php';
require_once '../../coreadmin/config/config.php';
if ($_SERVER['REQUEST_METHOD'] == 'POST'){
$db = getDbInstance();

//if post is amount update balance ant total income
if ($_POST["name"]=="amount"){
 $data = Array($_POST["name"] => $_POST["value"]);      
$db->where('id',$_POST["pk"]);
$last=$db->update('estimated_income', $data);

 $db->where('id', $_POST["pk"]);
 $row=$db->get('estimated_income');
 $year = $row[0]['financial_year'];

 //get actual income sum for the church in the financial year
 $db->where('church_id', $_SESSION['church']);
 $db->where('financial_year', $year);
$sumIncome = $db->getValue ("estimated_income", "sum(amount)");


//update total income on financial year table 
   $db->where('id', $year);
   $updatefy = Array('total_estimated_income' => $sumIncome);  
   $last=$db->update('financial_year', $updatefy);
   
   
   //get sum of all bills
  
   if($last)
{
    
    	echo $_SESSION['success'] ="Successfully Updated ".$_POST["name"];
       
}
  

}
else {
 $data = Array($_POST["name"] => $_POST["value"]);      
$db->where('id',$_POST["pk"]);
$last_id=$db->update('estimated_income', $data);
 if($last_id)
{
    
    	echo $_SESSION['success'] ="Successfully Updated ".$_POST["name"];
       
}
}

  
   }
?>