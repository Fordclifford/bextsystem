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
$last=$db->update('actual_income', $data);

 $db->where('id', $_POST["pk"]);
 $row=$db->get('actual_income');
 $year = $row[0]['financial_year_id'];

 //get actual income sum for the church in the financial year
 $db->where('church_id', $_SESSION['church']);
 $db->where('financial_year_id', $year);
$sumIncome = $db->getValue ("actual_income", "sum(amount)");

 $db->where('church_id', $_SESSION['church']);
 $db->where('financial_year', $year);
$sumBills = $db->getValue ("bill", "sum(amount)");

$fybalance = $sumIncome - $sumBills;

//update total income on financial year table 
   $db->where('id', $year);
   $updatefy = Array('total_actual_income' => $sumIncome,'balance'=>$fybalance);  
   $last=$db->update('financial_year', $updatefy);
   
   
   //get sum of all bills
  $db->where('source', $_POST["pk"]);
  $db->where('church_id', $_SESSION['church']);
  $db->where('financial_year', $year);
$bills = $db->getValue ("bill", "sum(amount)");

 $db->where('id', $_POST["pk"]);
$actualIndividual = $db->getValue ("actual_income", "sum(amount)");

//calculate the balance
$bal = $actualIndividual - $bills;
$db->where('id', $_POST["pk"]);
   $balance = Array('balance' => $bal);  
   $last_id=$db->update('actual_income', $balance);
   if($last_id && $last)
{
    
    	echo $_SESSION['success'] ="Successfully Updated ".$_POST["name"]." Remaining balance for  ".$row[0]['source_name']. " is ".$bal;
       
}
  

}
else {
 $data = Array($_POST["name"] => $_POST["value"]);      
$db->where('id',$_POST["pk"]);
$last_id=$db->update('actual_income', $data);
 if($last_id)
{
    
    	echo $_SESSION['success'] ="Successfully Updated ".$_POST["name"];
       
}
}

  
   }
?>