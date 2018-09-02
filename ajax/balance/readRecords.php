<?php
ob_start();
session_start();
// include Database connection file
if (!isset($_SESSION['user'])) {
    header("Location: index.php");
    exit;
}
include("dbconnect.php");
$church_id = $_SESSION['church'];

// Design initial table header
if (isset($_POST['year'])) {
    $year = $_POST['year'];

    $query = "SELECT * FROM financial_year WHERE id = $year";


    if (!$result = mysql_query($query)) {
        exit(mysql_error());
    }


// if query results contains rows then featch those rows
    if (mysql_num_rows($result) > 0) {
        $number = 1;
        while ($row = mysql_fetch_assoc($result)) {
            $data .= '<div style="overflow-x:auto;padding-right: 20px; padding-left:20px">
    <table class="table table-bordered table-responsive table-hover">
  <tr >
<td ><label class="control-label">Year:</label></td>
 <td><input data-toggle="tooltip" title =" financial year" style="height:40px" class="form-control" type="text" name="name" value="' . $row['year'] . '"  readonly="true" /></td>
 </tr>

<tr>
<td><label class="control-label">Total Income:</label></td>
 <td><input style="height:40px" data-toggle="tooltip" title ="total income for ' . $row['year'] . '" class="form-control" type="text" name="name" value="' . $row['total_income'] . '"  readonly="true" /></td>
 </tr>


<tr>
<td><label class="control-label">Total Bills:</label></td>
 <td><input style="height:40px" data-toggle="tooltip" title ="total expenses for ' . $row['year'] . '" class="form-control" type="text" name="conference" value="' . $row['total_bills'] . '"  readonly="true" /></td>
 </tr>

<tr>
<td><label class="control-label">Total Expenses:</label></td>
 <td><input style="height:40px" data-toggle="tooltip" title ="total bills for ' . $row['year'] . '" class="form-control" type="text" name="conference" value="' . $row['total_expenses'] . '"  readonly="true" /></td>
 </tr>

<tr>
<td><label class="control-label">Balance:</label></td>
 <td><input style="height:45px" class="form-control" type="text" data-toggle="tooltip" title ="balance(difference between income and bills) for ' . $row['year'] . '" value="' . $row['balance'] . '"  readonly="true" /></td>
</tr>';
        }
    } else {
        // records not found
        $data .= '<tr><td data-toggle="tooltip" title ="No records has been entered so far you need to add" colspan="6">Records not found!</td></tr>';
    }

    $data .= '</table> </div>';
echo $data;

    $data = '<div style="overflow-x:auto;padding-right: 20px; padding-left:20px">
   <hr />
     <h3  style="margin: 20px; margin-bottom: 0px"  > Balance Per Expense:</h3>
    <table  class="table table-responsive table-bordered table-striped" >
						<tr>
							<th>No.</th>
							<th>Expense</th>
							<th>Total Amount Allocated</th>
                                                         <th>Amount Used</th>
                                                        <th>Remaining Balance</th>

						</tr>';


$b_query = "SELECT * FROM budget_expenses WHERE church_id = $church_id AND financial_year='$year' ORDER BY date DESC";

if (!$result = mysql_query($b_query)) {
    exit(mysql_error());
}

// if query results contains rows then featch those rows
if (mysql_num_rows($result) > 0) {
    $number = 1;
    while ($row = mysql_fetch_assoc($result)) {
        $used_amount =$row['amount']-$row['balance'];
        $data .= '<tr>
				<td>' . $number . '</td>
				<td>' . $row['expense_name'] . '</td>
				<td>' . $row['amount'] . '</td>
                                 <td>' . $used_amount . '</td>
                                <td>' . $row['balance'] . '</td>

    		</tr>';
        $number++;
    }

} else {
    // records now found
    $data .= '<tr><td colspan="6">No Expenses found!</td></tr>';
}

$data .= '</table></div>';

echo $data;
}
?>
<script>
    $(document).ready(function () {
        $('[data-toggle="tooltip"]').tooltip();
    });
</script>
