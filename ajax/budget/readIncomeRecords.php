<?php
ob_start();
session_start();
// include Database connection file
include("dbconnect.php");
$church_id=$_SESSION['church']; 
$error =false;
$q1 = "SELECT id FROM income_sources WHERE church_id = $church_id";
$income = mysql_query($q1);

 if (mysql_num_rows($income) ==0) {
    $error = TRUE;
    $errTyp = "warning";
    $errMSG = "You have not added income for your church";
}
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
     <h3 style="margin: 0px 20px">Income Sources:</h3>
    <table class="table table-bordered table-striped">
						<tr>
							<th>No.</th>
							<th>Source</th>
							<th>Amount</th>
                                                        <th>Date Added</th>
							<th>Delete</th>
						</tr>';
if (isset($_POST['year'])) {
    $year = $_POST['year'];
$query = "SELECT * FROM income_sources WHERE church_id = $church_id AND financial_year= $year ORDER BY date DESC";


if (!$result = mysql_query($query)) {
    exit(mysql_error());
}


// if query results contains rows then featch those rows
if (mysql_num_rows($result) > 0) {
    $number = 1;
    while ($row = mysql_fetch_assoc($result)) {
        $data .= '<tr>
				<td>' . $number . '</td>
				<td>' . $row['source_name'] . '</td>
				<td>' . $row['amount'] . '</td>
                                    <td>' . $row['date'] . '</td>
				<td>
					<button onclick="DeleteIncome(' . $row['id'] . ')" class="btn btn-danger"><span class="glyphicon glyphicon-remove-circle"></span> Delete</a>
				</td>
    		</tr>';

        $number++;
    }
    $data .= '<tr><td colspan="5"></td></tr>';


    $sql = "SELECT SUM(amount) FROM income_sources where financial_year ='$year' AND church_id = '$church_id'";
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
    $data .= '<tr><td colspan="6">No Income Records found!</td></tr>';
}

$data .= '</table></div>';

echo $data;
$sq = "SELECT * FROM income_sources WHERE church_id = '$church_id' AND financial_year=$year";
$income = mysql_query($sq);
if (mysql_num_rows($income) == 0) {
    $error = TRUE;
    $errTyp = "warning";
    $errorMSG = "No income records found for the selected year";
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
