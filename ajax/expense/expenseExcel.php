<?php
session_start();
require_once 'config.php';

// if session is not set this will redirect to login page
if (!isset($_SESSION['user_logged_in'])) {
    header("Location: ../../login.php");
    exit;
}

// select loggedin users detail
if ($_SESSION['user_type'] == 'treasurer') {
   
 if (isset($_POST['submit'])) {
$error = false;
    $from= $_POST['from_date'];
    $to= $_POST['to_date'];
$datefrom = new DateTime($from);
$dateto = new DateTime($to);
  $to=$dateto->format('Y-m-d H:i:s');
  $from=$datefrom->format('Y-m-d H:i:s');
  $church_id = $_SESSION['church'];

       $q3 = "SELECT * FROM estimated_expenses WHERE church_id=$church_id AND date  BETWEEN '$from' AND '$to'";
        $result = mysql_query($q3);

        if (mysql_num_rows($result) == 0) {
            $error = true;
            
          echo $_SESSION['failure'] ='No Expenses found between ' .$from. ' and '. $to.' !';
    
   	header('location: ../../estimatedExpensesExcel.php');
    	exit;
        }
if(!$error){
        $setSql = "SELECT expense_name, amount, date from estimated_expenses WHERE church_id='$church_id' AND date  BETWEEN '$from' AND '$to' ORDER BY date DESC";
        $sumQuery = " SELECT SUM(amount) AS totalExpenses from estimated_expenses WHERE church_id='$church_id' AND date  BETWEEN '$from' AND '$to' ";
         $setRec = mysql_query($setSql);
       echo  $setSum = mysql_query($sumQuery);

        if (!$resu = mysql_query($setSql)) {
            exit(mysql_error());
        }
        if (!$total = mysql_query($sumQuery)) {
            exit(mysql_error());
        }
      
   

        $columnHeader = '';
        $columnHeader = "Sr NO" . "\t" . "Name" . "\t" . "Amount" . "\t"."Date"  . "\t";

        $setData = '';
        $number = 1;
        $space = ' ';
        while ($rec = mysql_fetch_assoc($setRec)) {

            $rowData = '';
            $num = '"' . $number . '"' . "\t";
            $rowData .= $num;
            foreach ($rec as $value) {
                $value = '"' . $value . '"' . "\t";
                $rowData .= $value;
            }

            $setData .= trim($rowData) . "\n";
            $number++;
        }

        $label = 'Total';
        $blank = '  ';
        while ($rec = mysql_fetch_assoc($setSum)) {

            $rowData = '';
            $blk = "\t" . '"' . $blank . '"' . "\t";
            $rowData .= $blk;
            $lbl = '"' . $label . '"' . "\t";
            $rowData .= $lbl;
            foreach ($rec as $value) {
                $value = '"' . $value . '"' . "\t";
                $rowData .= $value;
            }

            $setData .= "\n" . trim($rowData) . "\n";
        }





        header("Content-type: application/octet-stream");
        header("Content-Disposition: attachment; filename=Expeses_Report.xls");
        header("Pragma: no-cache");
        header("Expires: 0");

        echo ucwords($columnHeader) . "\n" . $setData . "\n";
    }
   
}
}
?>
<?php ob_end_flush(); ?>