<?php

ob_start();
session_start();
// include Database connection file
include("dbconnect.php");
$church_id=$_SESSION['church']; 
$error = false;

$sq = "SELECT * FROM budget_expenses WHERE church_id = '$church_id'";
$expense = mysql_query($sq);
if (mysql_num_rows($expense) == 0) {
    $error = TRUE;
    $errTyp = "warning";
    $errMSG = "You have not added expenses for your church";
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


// Design initial table header
$data = '<div style="overflow-x:auto;padding-right: 20px; padding-left:20px">
    <h3  style="margin: 20px; margin-bottom: 0px"  >Estimated Expenses:</h3>

    <table class="table table-responsive table-bordered table-striped" >
						<tr>
							<th>No.</th>
							<th>Expense</th>
							<th>Amount</th>
                                                        <th>Date Added</th>

							<th>Delete</th>
						</tr>';
if (isset($_POST['year'])) {
    $year = $_POST['year'];
$query = "SELECT * FROM budget_expenses WHERE church_id = $church_id AND financial_year= $year ORDER BY date DESC";

if (!$result = mysql_query($query)) {
    exit(mysql_error());
}

// if query results contains rows then fetch those rows
if (mysql_num_rows($result) > 0) {
    $number = 1;
    while ($row = mysql_fetch_assoc($result)) {
        $data .= '<tr>
				<td>' . $number . '</td>
				<td>' . $row['expense_name'] . '</td>
				<td>' . $row['amount'] . '</td>
                                 <td>' . $row['date'] . '</td>
				<td>
					<button onclick="DeleteExpense(' . $row['sid'] . ')" class="btn btn-danger"><span class="glyphicon glyphicon-remove-circle"></span> Delete</a>
				</td>
    		</tr>';
        $number++;
    }
    $data .= '<tr><td colspan="5"></td></tr>';
    $sql = "SELECT SUM(amount) FROM budget_expenses WHERE financial_year='$year' AND church_id = $church_id";
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
      $data .= '<tr><td colspan="5"> </td></tr>';


} else {
     $data .= '<tr><td colspan="6">No Expense Records found!</td></tr>';
     $data .= '</table> </div>';

    // records now found

}

$inc_quer = "SELECT total_income,total_expenses FROM financial_year WHERE  id = $year";


if (!$results = mysql_query($inc_quer)) {
    exit(mysql_error());
}


 while ($row = mysql_fetch_assoc($results)) {
     $label = "Balance";
     $balance= $row['total_income'] -  $row['total_expenses'];
     $data .= '<div style="overflow-x:auto;padding-right: 20px; padding-left:20px">
       <table class="table table-responsive table-bordered table-striped" >
         <tr>

             <th  style="background-color: #2196F3;  text-align: center;" colspan="2" > ' . $label . '</th>
            <th  style="background-color: #2196F3; text-align: center;" colspan="2"> ' . $balance . '</th>

            </tr></table> </div>';
 }




echo $data;
$sq = "SELECT * FROM budget_expenses WHERE church_id = '$church_id' AND financial_year=$year";
$expense = mysql_query($sq);
if (mysql_num_rows($expense) == 0) {
    $error = TRUE;
    $errTyp = "warning";
    $errorMSG = "No expenses found for the selected year";
}
// Design initial table header
if (isset($errorMSG)) {
    ?>
    <div style="background-color: #ff9900" class="alert">
        <span class="closebtn" onclick="this.parentElement.style.display = 'none';">&times;</span>
        <?php echo $errorMSG; ?>
    </div>
    <?php
}
}
ob_end_flush();
?>
