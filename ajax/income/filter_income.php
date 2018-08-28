<?php
ob_start();
session_start();
// include Database connection file 
include("dbconnect.php");
$church_id = $_SESSION['user'];
$error = false;
if (isset($_POST['year'])) {

    $year = $_POST['year'];

    $data = '<div style="overflow-x:auto;padding-right: 20px; padding-left:20px"> 
             <hr />        
 <h3  style="margin: 20px; margin-bottom: 0px"  >' . $year . ' Income Sources:</h3>
    <table class="table table-bordered table-striped">
						<tr>
							<th>No.</th>
							<th>Source</th>                                                        	
							<th>Amount</th>
                                                        <th>Date</th>
							<th>Update</th>
							<th>Delete</th>
						</tr>';
    $id_q = "SELECT id AS id FROM financial_year WHERE year= '$year' AND church_id='$church_id'";
    $q_result = mysql_query($id_q);
    $r_count = mysql_fetch_array($q_result);
    $id = $r_count['id'];

    $query = "SELECT * FROM income_sources WHERE church_id = $church_id AND financial_year='$id' ORDER BY date DESC";



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
					<button onclick="GetIncomeDetails(' . $row['id'] . ')" class="btn btn-warning"><span class="glyphicon glyphicon-edit"></span> Update</button>
				</td>
				<td>
					<button onclick="DeleteUser(' . $row['id'] . ')" class="btn btn-danger"><span class="glyphicon glyphicon-remove-circle"></span> Delete</button>
				</td>
    		</tr>';

            $number++;
        }
        $data .= '<tr><td colspan="6"></td></tr>';


        $sql = "SELECT SUM(amount) AS total FROM income_sources WHERE financial_year ='$id' AND church_id = $church_id";
        if (!$sum = mysql_query($sql)) {
            exit(mysql_error());
        }
        if (mysql_num_rows($sum) > 0) {
            $label = 'Total';
            while ($row = mysql_fetch_assoc($sum)) {

                $data .= '<tr>
        <td  colspan="1"></td>
             <th class = "warning" colspan="1" > ' . $label . '</th>       
            <th class = "warning" colspan="3"> ' . $row['total'] . '</th>            
            
            </tr>';
            }
        }
    } else {
        // records now found 
        $data .= '<tr><td colspan="6">Records not found!</td></tr>';
    }

    $data .= '</table> </div>';

    echo $data;
    $sq = "SELECT * FROM income_sources WHERE church_id = '$church_id' AND financial_year=$id";
$income = mysql_query($sq);
if (mysql_num_rows($income) == 0) {
    $error = TRUE;
    $errTyp = "warning";
    $errMSG = "No income records found for $year, if you have added refresh this page";
} 
 $sql = "SELECT balance FROM financial_year WHERE id=$id";
$balance = mysql_query($sql);

while ($row = mysql_fetch_assoc($balance)) {
    if($row['balance'] < 0 ){
    $error = TRUE;
    $errTyp = "warning";
    $errMSG = "Income for $year is less than expenses! Consider adding more income";
} 
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
 