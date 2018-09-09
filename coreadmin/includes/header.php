<?php
require_once './config/config.php';
?>
<!DOCTYPE html>
<html lang="en">

    <head>

        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="">
        <meta name="author" content="">

        <title>Church Income & Expense Tracking System Administrator</title>

        <!-- Bootstrap Core CSS -->
        <link  href="assets/bootstrap/css/bootstrap.css" rel="stylesheet">
        <!-- <link href="assets/bootstrap/css/bootstrap.min.css" rel="stylesheet"> -->
               <link href="assets/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
        <link  rel="stylesheet" href="css/bootstrap.min.css" type="text/css"/>

        
<script src="assets/jquery/jquery-1.9.1.min.js" type="text/javascript"></script>

        <link href="css/style.css" rel="stylesheet" type="text/css"/>

        <!-- MetisMenu CSS -->
        <link href="js/metisMenu/metisMenu.min.css" rel="stylesheet">

        <!-- Custom CSS -->
        <link href="css/sb-admin-2.css" rel="stylesheet">
        <!-- Custom Fonts -->
        <link href="fonts/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">



    </head>

    <body onload='loadUnions()'>

        <div id="wrapper">

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
                        <a class="navbar-brand" href="">Church Income & Expense Tracking System Administrator</a>
                    </div>
                    <!-- /.navbar-header -->

                    <ul class="nav navbar-top-links navbar-right">
                        <!-- /.dropdown -->

                        <!-- /.dropdown -->
                        <li> <a id="notification-icon" name="button" onclick="myFunction()" class="dropbtn"><span id="notification-count">
                          <?php
                                    include_once 'count.php';
                                    if ($count > 0) {
                                        echo $count;
                                    }
                                    ?></span><i class="fa fa-comment fa-fw"></i></a>
                            <div id="notification-latest"></div>
                        </li>


                        <li class="dropdown">
                            <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                                <i class="fa fa-user fa-fw"></i> <i class="fa fa-caret-down"></i>
                            </a>
                            <ul class="dropdown-menu dropdown-user">
                                <li><a href="#"><i class="fa fa-user fa-fw"></i> User Profile</a>
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

                                <li <?php echo (CURRENT_PAGE == "churches.php" || CURRENT_PAGE == "add_church.php") ? 'class="active"' : ''; ?>>
                                    <a href="#"><i class="fa fa-globe fa-fw"></i> churches<span class="fa arrow"></span></a>
                                    <ul class="nav nav-second-level">
                                        <li>
                                            <a href="churches.php"><i class="fa fa-list fa-fw"></i>List all</a>
                                        </li>
                                        <li>
                                            <a href="add_church.php"><i class="fa fa-plus fa-fw"></i>Add New</a>
                                        </li>
                                    </ul>
                                </li>
                                <li <?php echo (CURRENT_PAGE == "admin_users.php" || CURRENT_PAGE == "add_admin.php") ? 'class="active"' : ''; ?>>
                                    <a href="#"><i class="fa fa-user-circle fa-fw"></i> users<span class="fa arrow"></span></a>
                                    <ul class="nav nav-second-level">
                                        <li>
                                            <a href="admin_users.php"><i class="fa fa-list fa-fw"></i>List all</a>
                                        </li>
                                        <li>
                                            <a href="add_admin.php"><i class="fa fa-plus fa-fw"></i>Add New</a>
                                        </li>
                                    </ul>
                                </li>
                                <li <?php echo (CURRENT_PAGE == "unions.php" || CURRENT_PAGE == "add_union.php") ? 'class="active"' : ''; ?>>
                                    <a href="#"><i class="fa fa-flag fa-fw"></i> unions<span class="fa arrow"></span></a>
                                    <ul class="nav nav-second-level">
                                        <li>
                                            <a href="unions.php"><i class="fa fa-list fa-fw"></i>List all</a>
                                        </li>
                                        <li>
                                            <a href="add_union.php"><i class="fa fa-plus fa-fw"></i>Add New</a>
                                        </li>
                                    </ul>
                                </li>
                                <li <?php echo (CURRENT_PAGE == "conferences.php" || CURRENT_PAGE == "add_conference.php") ? 'class="active"' : ''; ?>>
                                    <a href="#"><i class="fa fa-asterik fa-fw"></i> conferences<span class="fa arrow"></span></a>
                                    <ul class="nav nav-second-level">
                                        <li>
                                            <a href="conferences.php"><i class="fa fa-list fa-fw"></i>List all</a>
                                        </li>
                                        <li>
                                            <a href="add_conference.php"><i class="fa fa-plus fa-fw"></i>Add New</a>
                                        </li>
                                    </ul>
                                </li>

                            </ul>
                        </div>
                        <!-- /.sidebar-collapse -->
                    </div>
                    <!-- /.navbar-static-side -->
                </nav>
            <?php endif;
            ?>



            <!-- The End of the Header -->
