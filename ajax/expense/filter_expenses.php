<?php

ob_start();
session_start();
// include Database connection file 
include("dbconnect.php");
$church_id=$_SESSION['user']; 
$error =false;

if (isset($_POST['year'])) {    
    $year = $_POST['year'];
   
// Design initial table header 
$data = '<div style="overflow-x:auto;padding-right: 20px; padding-left:20px">
   <hr />
     <h3  style="margin: 20px; margin-bottom: 0px"  >' . $year . ' Estimated Expenses:</h3>
    <table  class="table table-responsive table-bordered table-striped" >
						<tr>
							<th>No.</th>
							<th>Expense</th>
							<th>Amount</th>	
                                                        <th>Date</th>	
							<th>Update</th>
							<th>Delete</th>
						</tr>';
$id_q = "SELECT id AS id FROM financial_year WHERE year= '$year' AND church_id='$church_id'";
    $q_result = mysql_query($id_q);
    $r_count = mysql_fetch_array($q_result);
    $id = $r_count['id'];

$query = "SELECT * FROM budget_expenses WHERE church_id = $church_id AND financial_year='$id' ORDER BY date DESC";

if (!$result = mysql_query($query)) {
    exit(mysql_error());
}

// if query results contains rows then featch those rows 
if (mysql_num_rows($result) > 0) {
    $number = 1;
    while ($row = mysql_fetch_assoc($result)) {
        $data .= '<tr>
				<td>' . $number . '</td>
				<td>' . $row['expense_name'] . '</td>
				<td>' . $row['amount'] . '</td>	
                                    <td>' . $row['date'] . '</td>
				<td>
					<button onclick="GetExpenseDetails(' . $row['sid'] . ')" class="btn btn-warning"><span class="glyphicon glyphicon-edit"></span> Update</button>
				</td>
				<td>
					<button onclick="DeleteExpense(' . $row['sid'] . ')" class="btn btn-danger"><span class="glyphicon glyphicon-remove-circle"></span> Delete</button>
				</td>
    		</tr>';
        $number++;
    }
    $data .= '<tr><td colspan="5"></td></tr>';
    $sql = "SELECT SUM(amount) FROM budget_expenses WHERE financial_year ='$id' AND church_id = '$church_id'";
    if (!$sum = mysql_query($sql)) {
        exit(mysql_error());
    }  
    if (mysql_num_rows($sum) > 0) {
        $label = 'Total';
        while ($row = mysql_fetch_assoc($sum)) {
            $data .= '<tr>
        <td colspan="1"></td>
             <th class="warning" colspan="1" > ' . $label . '</th>       
            <th class="warning" colspan="3"> ' . $row['SUM(amount)'] . '</th>            
            
            </tr>';
        }
    }
} else {
    // records now found 
    $data .= '<tr><td colspan="6">No Expenses found!</td></tr>';
}

$data .= '</table></div>';
echo $data;
$sq = "SELECT * FROM budget_expenses WHERE church_id = '$church_id' AND financial_year=$id";
$expense = mysql_query($sq);
if (mysql_num_rows($expense) == 0) {
    $error = TRUE;
    $errTyp = "warning";
    $errMSG = "No expenses found for $year,";
} 
// Design initial table header 
if (isset($errMSG)) {
    ?>
    <div style="background-color: #ff9900" class="alert">
        <span class="closebtn" onclick="this.parentElement.style.display = 'none';">&times;</span>
        <?php echo $errMSG; ?>
    </div> 
    <?php
}
}
?>
<?php ob_end_flush(); ?>