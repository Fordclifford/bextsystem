

<?php
ob_start();
session_start();
// include Database connection file 
include("dbconnect.php");
$church_id = $_SESSION['user'];

if (isset($_POST['month'])) {
      $month = $_POST['month'];
  
  
// Design initial table header 
$data = '<div style="overflow-x:auto;padding-right: 10px; padding-left:10px">
    <table class="table table-bordered table-striped">
						<tr>
							<th>No.</th>
							<th>Category</th>
							<th>Amount</th>	
                                                        <th>Date</th>	
                                                        <th>Image</th>                                                       
                                                        <th>Description</th>	
							<th>Update</th>
							<th>Delete</th>
						</tr>';

$query = "SELECT * FROM bill WHERE church_id = $church_id AND financial_year='$id' ORDER BY date DESC";


if (!$result = mysql_query($query)) {
    exit(mysql_error());
}

// if query results contains rows then featch those rows 
if (mysql_num_rows($result) > 0) {
    $number = 1;
    while ($row = mysql_fetch_assoc($result)) {
        $sids = $row['source'];
            $que = mysql_query("SELECT expense_name FROM budget_expenses WHERE church_id = $church_id AND sid = $sids");
            while ($rows = mysql_fetch_assoc($que)) {
        $data .= '<tr>
           
    
				<td>' . $number . '</td>
				<td>' . $rows['expense_name'] . '</td>
				<td>' . $row['amount'] . '</td>
                                    <td>' . $row['date'] . '</td>
                                          <td>
                                          <a href="uploads/' . $row['image'] . '"class="img-rounded" width="250px" height="250px"><span class="glyphicon glyphicon-eye-open"></span> View Image</a>
                                          </td>
                                           <td>' . $row['description'] . '</td>
                        
				<td>
		<a class="btn btn-warning" href="editbill.php?edit_id=' . $row['id'] . '" title="click for edit" onclick="return confirm(\'Sure to edit?\')"><span class="glyphicon glyphicon-edit"></span> Edit</a> 
    
				</td>
				<td>
					<a onclick="return confirm(\'Sure to Delete?\')" class="btn btn-danger" href="?delete_id=' . $row['id'] . '" title="click for delete"  ><span class="glyphicon glyphicon-remove-circle"></span> Delete</a> 
    	</td>
    		</tr>';
        $number++;
    }
    }
    $data .= '<tr><td colspan="8"></td></tr>';
    $sql = "SELECT SUM(amount) FROM bill WHERE church_id = '$church_id' AND financial_year ='$id'";
    if (!$sum = mysql_query($sql)) {
        exit(mysql_error());
    }
    if (mysql_num_rows($sum) > 0) {
        $label = 'Total';
        while ($row = mysql_fetch_assoc($sum)) {
            $data .= '<tr>
        <td colspan="1"></td>
             <th colspan="1" > ' . $label . '</th>       
            <th colspan="6"> ' . $row['SUM(amount)'] . '</th>            
            
            </tr>';
        }
    }
} else {
    // records now found 
    $data .= '<tr><td colspan="6">Records not found! Please add bills </td></tr>';
}

$data .= '</table></div>';

echo $data;

}

?>