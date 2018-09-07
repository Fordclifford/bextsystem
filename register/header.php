<?php
require_once '../coreadmin/config/config.php';

$count=0;

$db = getDbInstance();
$select = array('id', 'subject','comment','date');
//echo $db->count($row);exit;
?>
<!DOCTYPE html>
<html lang="en">

    <head>

        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="">
        <meta name="author" content="">

        <title>B&E System</title>

        <link rel="shortcut icon" href="../assets/image/favicon.png" type="image/x-icon" />
         <link rel="stylesheet" href="../assets/css/w3.css" type="text/css"/>


        <!-- Bootstrap Core CSS -->
        <link  rel="stylesheet" href="../assets/css/bootstrap.min.css"/>
		<script src="https://code.jquery.com/jquery-2.1.1.min.js" type="text/javascript"></script>

        <!-- MetisMenu CSS -->
        <link href="../includes/js/metisMenu/metisMenu.min.css" rel="stylesheet" type="text/css"/>
        <!-- Custom CSS -->

        <link href="../includes/css/sb-admin.css" rel="stylesheet">
        <!-- Custom Fonts -->
        <link href="../includes/fonts/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
            <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
            <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
        <![endif]-->
        <script src="../includes/js/jquery.min.js" type="text/javascript"></script>
		<style>
	#notification-latest {
	position: absolute;
	right: 0px;
	background:white;
	box-shadow: 0px 1px 5px rgba(0, 0, 0, 0.20);
	max-width: 250px;
	text-align: left;
}
.notification-item {
	padding:10px;
	border-bottom:0.5px solid;
	cursor:pointer;
}
.notification-subject {
  white-space: nowrap;
  overflow: hidden;
  font-weight:bold;
  text-overflow: ellipsis;
}
.view-all {
  font-weight:bold;
  text-overflow: ellipsis;
  text-align: center;
}
.notification-comment {
  white-space: nowrap;
  overflow: hidden;
  text-overflow: ellipsis;
  font-style:italic;
}
#notification-count{
	position: absolute;
	left: 8px;
	top: 15px;
	font-size: 0.9em;
	color: #de5050;
	font-weight:bold;
}
		</style>

    </head>
