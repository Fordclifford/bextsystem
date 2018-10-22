<?php
//update.php
session_start();
require_once '../../includes/auth_validate.php';
require_once '../../coreadmin/config/config.php';
if ($_SERVER['REQUEST_METHOD'] == 'POST'){
$db = getDbInstance();

//if post is amount update balance ant total expeses
if ($_POST["name"]=="amount"){
 $data = Array($_POST["name"] => $_POST["value"]);      
$db->where('sid',$_POST["pk"]);
$last1=$db->update('estimated_expenses', $data);

 $db->where('sid', $_POST["pk"]);
 $row=$db->get('estimated_expenses');
 $year = $row[0]['financial_year'];

 //get actual expense sum for the church in the financial year
 $db->where('church_id', $_SESSION['church']);
 $db->where('financial_year', $year);
$sumExp = $db->getValue ("estimated_expenses", "sum(amount)");


//update total expenses on financial year table 
   $db->where('id', $year);
   $updatefy = Array('total_estimated_expenses' => $sumExp);  
   $last2=$db->update('financial_year', $updatefy);
   
   
   //get sum of all bills
  
   if($last1 && $last2)
{
    
    	echo $_SESSION['success'] ="Success Successfully Updated ".$_POST["name"];
       
}
  

}
else {
 $data = Array($_POST["name"] => $_POST["value"]);      
$db->where('sid',$_POST["pk"]);
$last_id=$db->update('estimated_expenses', $data);
 if($last_id)
{
    
    	echo $_SESSION['success'] ="Successfully Updated ".$_POST["name"];
       
}
}

  
   }
?>