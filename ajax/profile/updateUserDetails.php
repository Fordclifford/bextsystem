<?php

ob_start();
session_start();
// include Database connection file
include("dbconnect.php");

// check request
if (isset($_POST['name'])) {
    // get values
    $id = $_POST['id'];
    $name = $_POST['name'];

    // Updaste name details
    $query = "UPDATE church SET name = '$name' WHERE id = '$id'";
    if (!$result = mysql_query($query)) {
        exit(mysql_error());
    } else {
        header("refresh:5;index.php");
    }
}

if (isset($_POST['mobile'])) {
    // get values
    $id = $_POST['id'];
    $mobile = $_POST['mobile'];

  // Update mobile details
    $query = "UPDATE church SET mobile = '$mobile' WHERE id = '$id'";
    if (!$result = mysql_query($query)) {
        exit(mysql_error());
    } else {
        header("refresh:5;index.php");
    }
}
if (isset($_POST['union_mission'])&& isset($_POST['conference'])) {
    // get values
    $id = $_POST['id'];
    $union = $_POST['union_mission'];
        $conf = $_POST['conference'];
    // Updaste mobile details
    $query = "UPDATE church SET union_mission = '$union',conference = '$conf' WHERE id = '$id'";
    if (!$result = mysql_query($query)) {
        exit(mysql_error());
    } else {
        header("refresh:5;index.php");
    }
}
