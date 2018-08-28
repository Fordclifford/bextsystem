<?php
ob_start();
session_start();
require_once 'config.php';

// if session is not set this will redirect to login page
if (!isset($_SESSION['user'])) {
    header("Location: index.php");
    exit;
}
// select loggedin users detail
$res = mysql_query("SELECT * FROM church WHERE id=" . $_SESSION['user']);
$userRow = mysql_fetch_array($res);


$f_year = mysql_query("SELECT year,church_id FROM financial_year WHERE church_id=" . $_SESSION['user']);
if (mysql_num_rows($f_year) == 0) {
    $church_id = $_SESSION['user'];
    $year = date("Y");
    $query_insert = mysql_query("INSERT INTO financial_year(year,church_id) VALUES ('$year','$church_id')");
    if (!$query_insert) {
        //die("could not execute query 2");
        exit(mysql_error($conn));
    }
    ?>
    <script>
        alert('Hello!\n To begin a new financial year \n You will be redirected to income page to add income ...');
        window.location.href = 'income.php';
    </script>
    <?php
}
$budget = mysql_query("SELECT expense_name,church_id FROM budget_expenses WHERE church_id=" . $_SESSION['user']);
if (mysql_num_rows($budget) == 0) {
    ?>
    <script>
        alert('Hello!\n You need to add expenses for your church\n You will be redirected to expenses page ...');
        window.location.href = 'expenses.php';
    </script>
    <?php
}
$income = mysql_query("SELECT source_name,church_id FROM income_sources WHERE church_id=" . $_SESSION['user']);
if (mysql_num_rows($income) == 0) {
    ?>
    <script>
        alert('Hello!\n You need to add income for your church\n You will be redirected to income page ...');
        window.location.href = 'income.php';
    </script>
    <?php
}
?>
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title> Welcome- <?php echo $userRow['name']; ?></title>
        <link rel="shortcut icon" href="assets/image/favicon.png" type="image/x-icon" />
        <link rel="stylesheet" href="assets/css/bootstrap.min.css" type="text/css"  />
        <link rel="stylesheet" href="assets/css/style.css" type="text/css"/>
        <link rel="stylesheet" href="assets/css/style2.css" type="text/css"/>
        <link rel="stylesheet" href="assets/css/w3.css" type="text/css"/>
        <link href="assets/font-awesome/css/font-awesome.css" rel="stylesheet" type="text/css">
               <link rel="stylesheet" href="assets/css/font-awesome.min.css" type="text/css"/>
    </head>
    <body>
        <div id="wrap">

            <section  id="top">                
                <nav    class="navbar  navbar-inverse w3-round-xlarge">
                    <div class="container-fluid">
                        <div class="navbar-header " >
                            <a  class="w3-round-xxlarge navbar-brand" title="B&E Tracker Home" href="home.php"><img src="assets/image/log.png" style="height:48px; width:180px;" class="img-responsive w3-round-xxlarge" ></a>


                            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar"><span class="icon-bar"></span>
                                <span class="icon-bar"></span>
                                <span class="icon-bar"></span>                        
                            </button>
                        </div>
                            <ul class="nav navbar-nav navbar-right ">
                                <ul class="nav navbar-top-links navbar-right">
                            <li class="dropdown">
                                <a id="logged_in_user" class="dropdown-toggle logged-in-user" data-toggle="dropdown" href="profile.php">
                                    <i class="fa fa-user fa-fw"></i> <?php echo $_SESSION['name']; ?> <i class="fa fa-caret-down"></i>
                                </a>
                                <ul class="dropdown-menu dropdown-user">
                                    <li><a href="profile.php"><i class="fa fa-user fa-fw"></i> User Profile</a>
                                    </li>
                                   
                                    <li class="divider"></li>
                                    <li><a href="index.php"><i class="fa fa-sign-out fa-fw"></i> Logout</a>
                                    </li>
                                </ul>
                                <!-- /.drop down-user -->
                            </li>
                        </ul>
                    </ul>
                      
                    </div>
                </nav>

            </section>
            <section class="page">
                <header class="w3-round-xlarge"   id="homeheader">

                </header>


                <div  class=" animate row">
                    <div class="col-md-9 col-lg-9">

                        <div   class="col-lg-12">
                            <h3 class="">Dashboard</h3>
                            <hr style="margin-right: 30px"/>
                        </div>

                        <div class="row">
                            <div data-toggle="tooltip" title="Click the link to go to budget page" class="col-md-3 col-lg-3">               
                                <div class="panel panel-primary">
                                    <div class="panel-heading">
                                        <div class="row">
                                            <div class="col-xs-3">
                                                <i class="glyphicon glyphicon-briefcase fa-5x"></i>
                                            </div>

                                            <div class="col-xs-9 text-right">
                                                <div class="huge"> Budget</div>
                                            </div>

                                        </div>
                                    </div>
                                    <a href="budget.php">
                                        <div class="panel-footer">
                                            <span class="pull-left">Go to Budget&nbsp;</span>
                                            <span class="pull-right"><i class="glyphicon glyphicon-circle-arrow-right"></i></span>
                                            <div class="clearfix"></div>
                                        </div>
                                    </a>
                                </div>
                            </div>          
                            <div data-toggle="tooltip" title="Click the link to go to expenses page" class="col-md-3 col-lg-3">
                                <div class="panel panel-gold">
                                    <div class="panel-heading">
                                        <div class="row">
                                            <div class="col-xs-3">
                                                <i class="glyphicon glyphicon-apple fa-5x"></i>
                                            </div>

                                            <div class="col-xs-9 text-right">
                                                <div class="huge"> Expenses</div>
                                            </div>

                                        </div>
                                    </div>
                                    <a href="expenses.php">
                                        <div class="panel-footer">
                                            <span class="pull-left">Go to Expenses&nbsp;</span>
                                            <span class="pull-right"><i class="glyphicon glyphicon-circle-arrow-right"></i></span>
                                            <div class="clearfix"></div>
                                        </div>
                                    </a>
                                </div>
                            </div>
                            <div data-toggle="tooltip" title="Click the link to go to income page" class="col-md-3 col-lg-3">
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
                                    <a href="income.php">
                                        <div class="panel-footer">
                                            <span class="pull-left">Go to Income&nbsp;&nbsp;</span>
                                            <span class="pull-right"><i class="glyphicon glyphicon-circle-arrow-right"></i></span>

                                            <div class="clearfix"></div>
                                        </div>
                                    </a>
                                </div>
                            </div>
                            <div data-toggle="tooltip" title="Click the link to go to bills page" class="col-md-3 col-lg-3">
                                <div class="panel panel-paleGreen">
                                    <div class="panel-heading">
                                        <div class="row">
                                            <div class="col-xs-3">
                                                <i class="glyphicon glyphicon-registration-mark fa-5x"></i>
                                            </div>

                                            <div class="col-xs-9 text-right">
                                                <div class="huge"> Bills</div>
                                            </div>

                                        </div>
                                    </div>
                                    <a href="bills.php">
                                        <div class="panel-footer">
                                            <span class="pull-left">Manage Bills&nbsp; </span>
                                            <span class="pull-right"><i class="glyphicon glyphicon-circle-arrow-right"></i></span>
                                            <div class="clearfix"></div>
                                        </div>
                                    </a>
                                </div>
                            </div> 


                        </div>
                        <div class="row"> 
                            <div data-toggle="tooltip" title="Click the link to go to income-expense report page" class="col-md-3 col-lg-3">
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


                            <div data-toggle="tooltip" title="Click the link to go to balance page" class="col-md-3 col-lg-3">
                                <div class="panel panel-yellow">
                                    <div class="panel-heading">
                                        <div class="row">

                                            <div class="col-xs-3">
                                                <i class="glyphicon glyphicon-bitcoin fa-5x"></i>
                                            </div>                            
                                            <div class="col-xs-9 text-right">
                                                <div class="huge"> Balance</div>
                                            </div>
                                            </a>
                                        </div>
                                    </div>
                                    <a href="balance">
                                        <div class="panel-footer">
                                            <span class="pull-left">Go to Balance&nbsp;</span>
                                            <span class="pull-right"><i class="glyphicon glyphicon-circle-arrow-right"></i></span>

                                            <div class="clearfix"></div>
                                        </div>
                                    </a>
                                </div>
                            </div> 
                            <div data-toggle="tooltip" title="Click the link to go to profile page" class="col-md-3 col-lg-3">
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

            </section>
        </div>

        <footer id="pagefooter">
            <div id="f-content">

                <div align='center' style="margin: auto">
                    <p2 style="margin: 0px" align='center'>&copy;<?php echo date("Y"); ?> - Church Budget and Expense Tracker  </p2>

                </div>
                <img src="assets/image/bamboo.png" alt="bamboo" id="footerimg" width="96px" height="125px">
            </div>

        </footer>
    </body>
    <script src="assets/jquery-1.11.3-jquery.min.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>
    <script src="assets/js/navigation.js"></script>
    <script src="assets/js/tooltip.js" >
    
    </script>
</html>
<?php ob_end_flush(); ?>