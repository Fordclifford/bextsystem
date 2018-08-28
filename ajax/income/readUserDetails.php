<?php
// include Database connection file
include("dbconnect.php");

// check request
if(isset($_POST['id']) && isset($_POST['id']) != "")
{
    // get income ID
    $income_id = $_POST['id'];

    // Get income Details
    $query = "SELECT * FROM income_sources WHERE id = '$income_id'";
    if (!$result = mysql_query($query)) {
        exit(mysql_error());
    }
    $response = array();
    if(mysql_num_rows($result) > 0) {
        while ($row = mysql_fetch_assoc($result)) {
            $response = $row;
        }
    }
    else
    {
        $response['status'] = 200;
        $response['message'] = "Data not found!";
    }
    // display JSON data
    echo json_encode($response);
}
else
{
    $response['status'] = 200;
    $response['message'] = "Invalid Request!";
}