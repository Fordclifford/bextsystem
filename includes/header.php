<?php
require_once './coreadmin/config/config.php';

if (isset($_SESSION['user_logged_in'])) {

    include_once 'count.php';

}
?>
<!DOCTYPE html>
<html lang="en">

    <head>

        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="">
        <meta name="author" content="">

        <title>I&E Tracking System</title>

        <link rel="shortcut icon" href="assets/image/favicon.png" type="image/x-icon" />
         <link rel="stylesheet" href="assets/css/w3.css" type="text/css"/>
         <link rel="stylesheet" href="coreadmin/css/style.css" type="text/css"/>


        <!-- Bootstrap Core CSS -->
       <link  href="coreadmin/assets/bootstrap/css/bootstrap.css" rel="stylesheet">
       
        <link  rel="stylesheet" href="coreadmin/css/bootstrap.min.css" type="text/css"/>


        <!-- MetisMenu CSS -->
        <link href="includes/js/metisMenu/metisMenu.min.css" rel="stylesheet" type="text/css"/>
        <!-- Custom CSS -->

        <link href="includes/css/sb-admin.css" rel="stylesheet">
        <!-- Custom Fonts -->
        <link href="includes/fonts/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
<!--        angular assets-->
       <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
            <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
            <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
        <![endif]-->
        <script src="coreadmin/assets/jquery/jquery-1.9.1.min.js" type="text/javascript"></script>
        <link href="includes/css/angular-growl.min.css" rel="stylesheet" media="screen"/> 
       
    </head>
    <body ng-app="notifyApp" ng-controller="notifyCtrl">
        <div  id="wrapper"><div growl></div>

