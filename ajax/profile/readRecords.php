<?php

ob_start();
session_start();
// include Database connection file 
include("dbconnect.php");
$church_id = $_SESSION['user'];
// Design initial table header 
$data = '
    ';

$query = "SELECT * FROM church WHERE id = $church_id";


if (!$result = mysql_query($query)) {
    exit(mysql_error());
}


// if query results contains rows then featch those rows 
if (mysql_num_rows($result) > 0) {
    $number = 1;
    while ($row = mysql_fetch_assoc($result)) {
        $data .= '<div style="overflow-x:auto;padding-right: 20px; padding-left:20px">
    <table class="table table-bordered table-responsive table-hover">
    
<tr>
<td><label class="control-label">Name:</label></td>
 <td><input style="height:40px" class="form-control" type="text" name="name" value="' . $row['name'] . '"  readonly="true" /></td>
 <td>
 <button onclick="GetNameDetails(' . $row['id'] . ')" class="btn btn-warning"><span class="glyphicon glyphicon-edit"></span> Update</button>
</td>
</tr>

<tr>
<td><label class="control-label">Union:</label></td>
 <td><input style="height:40px" class="form-control" type="text" name="name" value="' . $row['union_mission'] . '"  readonly="true" /></td>
 <td>
 <button onclick="GetUnionDetails(' . $row['id'] . ')" class="btn btn-warning"><span class="glyphicon glyphicon-edit"></span> Update</button>
</td>
</tr>

<tr>
<td><label class="control-label">Conference:</label></td>
 <td><input style="height:40px" class="form-control" type="text" name="conference" value="' . $row['conference'] . '"  readonly="true" /></td>
 <td>
 <button onclick="GetUnionDetails(' . $row['id'] . ')" class="btn btn-warning"><span class="glyphicon glyphicon-edit"></span> Update</button>
</td>
</tr>

<tr>
<td><label class="control-label">Mobile:</label></td>
 <td><input style="height:40px" class="form-control" type="text" name="mobile" value="' . $row['mobile'] . '"  readonly="true" /></td>
 <td>
 <button onclick="GetMobileDetails(' . $row['id'] . ')" class="btn btn-warning"><span class="glyphicon glyphicon-edit"></span> Update</button>
</td>
</tr>


<tr>
<td><label class="control-label">Email:</label></td>
 <td><input style="height:45px" class="form-control" type="text" name="email" value="' . $row['email'] . '"  readonly="true" /></td>
 <td>
 <button data-toggle="collapse" data-target="#email"  class="btn btn-warning"><span class="glyphicon glyphicon-edit"></span> Update</button>
</td>
</tr>
<td><label class="control-label">Password:</label></td>
 <td><input style="height:45px" class="form-control" type="password" name="email" value="' . $row['pass'] . '" placeholder="Update Password"  readonly="true" /></td>
 <td>
 <button data-toggle="collapse" data-target="#pwd"  class="btn btn-warning"><span class="glyphicon glyphicon-edit"></span> Update</button>
</td>
</tr>';
       
    }   

} else {
    // records now found 
    $data .= '<tr><td colspan="6">Records not found!</td></tr>';
}

$data .= '</table> </div>';

echo $data;
?>
 