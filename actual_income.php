<?php session_start();
require_once 'includes/auth_validate.php';
include_once'includes/header.php';
$db = getDbInstance();
?>

<?php if (isset($_SESSION['user_logged_in']) && $_SESSION['user_logged_in'] == true) : ?>
        <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="">Income & Expense Tracker</a>
            </div>
            <!-- /.navbar-header -->

            <ul class="nav navbar-top-links navbar-right">
                <!-- /.dropdown -->

                <!-- /.dropdown -->
      <li>  <a name="button" id="notification-icon" name="button" onclick="myFunction()" class="notification">
  <span class="fa fa-envelope fa-fw"></span ><?php if($count>0) { ?>
  <span class="badge" id="notification-count" ><?php  echo $count; } ?></span>
</a> <div id="notification-latest"></div>
                </li>
                 <li>  <a name="button" id="notification-icon" name="button" onclick="myFunction()" class="notification">
  <span class="fa fa-exclamation-triangle fa-fw"></span ><?php if($count>0) { ?>
  <span class="badge" id="notification-count" ><?php  echo $count; } ?></span>
</a> <div id="notification-latest"></div>
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

            <div class="navbar-default sidebar" role="navigation">
                <div class="sidebar-nav navbar-collapse">
                    <ul class="nav" id="side-menu">
                        <li>
                            <a href="index.php"><i class="fa fa-dashboard fa-fw"></i> Dashboard</a>
                        </li>

                        <li>
                            <a href="bills.php"><i class="glyphicon glyphicon-registration-mark fa-fw"></i> Bills<span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
                                <li>
                                    <a href="bills.php"><i class="fa fa-list fa-fw"></i>List all</a>
                                </li>
                                <li>
                                    <a href="addbill.php"><i class="fa fa-plus fa-fw"></i>Add New</a>
                                </li>
                            </ul>
                        </li>

                        <li >
                            <a href="budget.php"><i class="glyphicon glyphicon-briefcase fa-fw"></i> Budget<span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
                                <li>
                                    <a href="estimated_income.php"><i class="fa fa-list fa-fw"></i>Estimated Income</a>
                                </li>
                                <li>
                                    <a href="estimated_expenses.php"><i class="fa fa-list fa-fw"></i>Estimated Expenses</a>
                                    
                                </li>
                            </ul>
                        </li>

                        <li>
                            <a href="actual_income.php"> <i class="glyphicon glyphicon-usd"></i>Actual Income</a>
                        </li>
                        <li>
                            <a href="balance.php"> <i class="glyphicon glyphicon-btc"></i> Balance</a>

                        </li>
                    </ul>
                </div>
                <!-- /.sidebar-collapse -->
            </div>
            <!-- /.navbar-static-side -->
        </nav>
    <?php endif; ?>
<div id="page-wrapper">
    <div class="row">

        <div class="col-lg-6">
            <h1 class="page-header">Actual Income</h1>
        </div>
        <div class="col-lg-6" style="">
            <div class="page-action-links text-right">
	            <a href="add_church.php?operation=create">
	            	<button class="btn btn-success"><span class="glyphicon glyphicon-plus"></span> Add new </button>
	            </a>
            </div>
        </div>
    </div>
    <?php require_once 'includes/flash_messages.php'; ?>
    
    
    
    
    
    
    
    
    
    
</div>

<?php include_once('includes/footer.php'); ?>