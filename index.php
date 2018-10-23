<?php
session_start();
require_once './config.php';

// if session is not set this will redirect to login page
require_once './includes/auth_validate.php';
// select loggedin users detail


?>
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
        <link href="includes/css/index_angular.css" rel="stylesheet" media="screen"/> 
       
    </head>
    <body ng-app="notifyApp" ng-controller="notifyCtrl">
        <div  id="wrapper"><div growl></div>


<!-- Navigation -->
<?php if (isset($_SESSION['user_logged_in']) && $_SESSION['user_logged_in'] == true) : ?>
    <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="">Income & Expenses Tracking System</a>
        </div>
        <!-- /.navbar-header -->

        <ul class="nav navbar-top-links navbar-right">
            <!-- /.dropdown -->

            <!-- /.dropdown -->
            <li> <a id="notification-icon" name="button" onclick="myFunction()" class="dropbtn"><span id="notification-count"><?php if ($count > 0) {
        echo $count;
    } ?></span><i class="fa fa-envelope fa-fw"></i></a>
                <div id="notification-latest"></div>
            </li>


            <li class="dropdown">
                <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                    <i class="fa fa-user fa-fw"></i> <i class="fa fa-caret-down"></i>
                </a>
                <ul class="dropdown-menu dropdown-user">
                    <li><a href="profile.php"><i class="fa fa-user fa-fw"></i> User Profile</a>
                    </li>

                    <li class="divider"></li>
                    <li><a href="logout.php"><i class="fa fa-sign-out fa-fw"></i> Logout</a>
                    </li>
                </ul>
                <!-- /.dropdown-user -->
            </li>
            <!-- /.dropdown -->
        </ul>
        <!-- /.navbar-top-links -->


        <!-- /.navbar-static-side -->
    </nav>
<?php endif; ?>
<div id="page-wrapper">
    
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">Dashboard</h1>
        </div>
        <!-- /.col-lg-12 -->
    </div>

        

            <div class="row">
                 <div data-toggle="tooltip" title="Click the link to go to income page" class="col-md-3 col-lg-4">
                    <div class="panel panel-darkBlue">
                        <div class="panel-heading">
                            <div class="row">

                                <div class="col-xs-3">
                                    <i class="glyphicon glyphicon-usd fa-5x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                    <div class="huge"> Income</div>
                                </div>

                            </div>
                        </div>
                        <a href="actual_income.php">
                            <div class="panel-footer">
                                <span class="pull-left">Go to Income&nbsp;&nbsp;</span>
                                <span class="pull-right"><i class="glyphicon glyphicon-circle-arrow-right"></i></span>

                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div>
                <div data-toggle="tooltip" title="Click the link to go to bills page" class="col-md-3 col-lg-4">
                    <div class="panel panel-yellow">
                        <div class="panel-heading">
                            <div class="row">

                                <div class="col-xs-3">
                                    <i class="glyphicon glyphicon-bitcoin fa-5x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                    <div class="huge"> Bills</div>
                                </div>
                                </a>
                            </div>
                        </div>
                        <a href="bills.php">
                            <div class="panel-footer">
                                <span class="pull-left">Go to Bills&nbsp;</span>
                                <span class="pull-right"><i class="glyphicon glyphicon-circle-arrow-right"></i></span>

                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div>

               
                   <div data-toggle="tooltip" title="Click the link to go to income-expense report page" class="col-md-3 col-lg-4">
                    <div class="panel panel-purple">
                        <div class="panel-heading">
                            <div class="row">

                                <div class=" col-xs-3"><i class="glyphicon glyphicon-calendar fa-5x"></i>  </div>

                                <div class="col-xs-9 text-right">
                                    <div class="huge"> I vs E</div>
                                </div>

                            </div>
                        </div>
                        <a href="income_expense_curve.php">
                            <div class="panel-footer">
                                <span class="pull-left">View Report &nbsp;</span>
                                <span class="pull-right"><i class="glyphicon glyphicon-circle-arrow-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div>
                
                
            </div>
            <div class="row">
                <div data-toggle="tooltip" title="Click the link to go to budget page" class="col-md-3 col-lg-4">
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="glyphicon glyphicon-briefcase fa-4x"></i>
                                </div>

                                <div class="col-xs-9 text-right">
                                    <div class="huge"> Estimated Income</div>
                                </div>

                            </div>
                        </div>
                        <a href="estimated_income.php">
                            <div class="panel-footer">
                                <span class="pull-left">Go to Estimated Income &nbsp;</span>
                                <span class="pull-right"><i class="glyphicon glyphicon-circle-arrow-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div>
                
                <div data-toggle="tooltip" title="Click the link to go to budget page" class="col-md-3 col-lg-4">
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="glyphicon glyphicon-briefcase fa-4x"></i>
                                </div>

                                <div class="col-xs-9 text-right">
                                    <div class="huge"> Estimated Expenses</div>
                                </div>

                            </div>
                        </div>
                        <a href="estimated_expenses.php">
                            <div class="panel-footer">
                                <span class="pull-left">Go to Estimated Expenses&nbsp;</span>
                                <span class="pull-right"><i class="glyphicon glyphicon-circle-arrow-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div>

                <div data-toggle="tooltip" title="Click the link to go to profile page" class="col-md-3 col-lg-4">
                    <div class="panel panel-bloodRed">
                        <div class="panel-heading">
                            <div class="row">

                                <div class="col-xs-3">
                                    <i class="glyphicon glyphicon-user fa-5x"></i>
                                </div>

                                <div class="col-xs-9 text-right">
                                    <div class="huge"> Profile</div>
                                </div>

                            </div>
                        </div>
                        <a href="profile.php">
                            <div class="panel-footer">
                                <span class="pull-left"> Manage Profile </span>
                                <span class="pull-right"><i class="glyphicon glyphicon-circle-arrow-right"></i></span>

                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div>



            </div>

      

    </div>
</div>


<?php include_once('includes/footer.php'); ?>
<script src="includes/js/summary.js" type="text/javascript"></script>
