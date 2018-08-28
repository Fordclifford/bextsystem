<?php

ob_start();
session_start();
include("config.php");
if (!isset($_SESSION['user'])) {
    header("Location: index.php");
    exit;
}
// select loggedin users detail
$res = mysql_query("SELECT * FROM church WHERE id=" . $_SESSION['user']);

$userRow = mysql_fetch_array($res);
$error = false;


if (isset($_POST['submit'])) {
    $yr = $_POST['year'];
    $church_id = $_SESSION['user'];
    $q1 = "SELECT * FROM budget_expenses WHERE financial_year ='$yr' AND church_id = '$church_id'";
    $result = mysql_query($q1);
    if (mysql_num_rows($result) == 0) {
        $error = true;
        ?>
        <script>
            alert('No expenses for the selected financial year\nYou Need to add expenses first \n You will be redirected to expeses page ...');
            window.location.href = 'expenses.php';
        </script>
        <?php

    }

    if (!$error) {
  
$setSql = "SELECT expense_name,amount FROM budget_expenses WHERE  financial_year ='$yr' AND  church_id = $church_id";
$setRec = mysql_query($setSql); 

$sumQuery="SELECT SUM(amount) FROM budget_expenses WHERE financial_year ='$yr' AND  church_id = $church_id";
$setSum = mysql_query($sumQuery); 
 
  
$columnHeader = '';  
$columnHeader = "Sr NO" . "\t" . "Estimated Expense" . "\t" . "Amount" . "\t";  
  
$setData = '';  
  $number=1;
  
while ($rec = mysql_fetch_assoc($setRec )) {
    
    $rowData = '';
    $num = '"'.$number.'"'."\t";
    $rowData .=$num;
    foreach ($rec as $value) {          
        $value = '"' . $value . '"' . "\t";  
        $rowData .= $value; 
       
    }  
    
    $setData .= trim($rowData) . "\n";
     $number++;
}
$label='Total';
$blank='  ';
while ($rec = mysql_fetch_assoc($setSum )) {
    
    $rowData = '';
      $blk = "\t".'"'.$blank.'"'."\t";
    $rowData .=$blk;
    $lbl = '"'.$label.'"'."\t";
    $rowData .=$lbl;
    foreach ($rec as $value) {          
        $value = '"' . $value . '"' . "\t";  
        $rowData .= $value; 
       
    }   
     
    $setData .= "\n".trim($rowData) . "\n";
   
     
}

  
header("Content-type: application/octet-stream");  
header("Content-Disposition: attachment; filename=Estimated_Expenses.xls");  
header("Pragma: no-cache");  
header("Expires: 0");  
  
echo ucwords($columnHeader) . "\n" . $setData . "\n";  
    }
}
?>