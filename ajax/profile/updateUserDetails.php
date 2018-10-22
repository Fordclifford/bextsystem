<?php

ob_start();
session_start();
// include Database connection file
include("dbconnect.php");

// check request
if (isset($_POST['user_name'])) {
    // get values
    $id = $_POST['id'];
    $name = $_POST['user_name'];

    // Updaste name details
    $query = "UPDATE users SET user_name = '$name' WHERE id = '$id'";
    if (!$result = mysql_query($query)) {
        exit(mysql_error());
    } else {
        header("refresh:5;index.php");
    }
}
