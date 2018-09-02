<?php
session_start();
require_once './config.php';

// if session is not set this will redirect to login page
if (!isset($_SESSION['user'])) {
    header("Location: index.php");
    exit;
}
// select loggedin users detail
if ($_SESSION['user_type'] == 'treasurer') {

$f_year = mysql_query("SELECT year,church_id FROM financial_year WHERE church_id=" . $_SESSION['church']);
if (mysql_num_rows($f_year) == 0) {
    $church_id = $_SESSION['church'];
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
$budget = mysql_query("SELECT expense_name,church_id FROM budget_expenses WHERE church_id=" . $_SESSION['church']);
if (mysql_num_rows($budget) == 0) {
    ?>
    <script>
        alert('Hello!\n You need to add expenses for your church\n You will be redirected to expenses page ...');
        window.location.href = 'expenses.php';
    </script>
    <?php
}
$income = mysql_query("SELECT source_name,church_id FROM income_sources WHERE church_id=" . $_SESSION['church']);
if (mysql_num_rows($income) == 0) {
    ?>
    <script>
        alert('Hello!\n You need to add income for your church\n You will be redirected to income page ...');
        window.location.href = 'income.php';
    </script>
    <?php
}
}
include_once('includes/header.php');
?>
<body>

        <div id="wrapper">

            <!-- Navigation -->
            <?php if (isset($_SESSION['user']) && $_SESSION['user'] == true ) : ?>
                <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
                    <div class="navbar-header">
                        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                            <span class="sr-only">Toggle navigation</span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                        </button>
                        <a class="navbar-brand" href="">B&E Tracker</a>
                    </div>
                    <!-- /.navbar-header -->

                    <ul class="nav navbar-top-links navbar-right">
                        <!-- /.dropdown -->

                        <!-- /.dropdown -->
						<li> <a id="notification-icon" name="button" onclick="myFunction()" class="dropbtn"><span id="notification-count"><?php if($count>0) { echo $count; } ?></span><i class="fa fa-envelope fa-fw"></i></a>
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

                    <div class="navbar-default sidebar" role="navigation">
                        <div class="sidebar-nav navbar-collapse">
                            <ul class="nav" id="side-menu">
                                <li>
                                    <a href="home.php"><i class="fa fa-dashboard fa-fw"></i> Dashboard</a>
                                </li>

                                <li <?php echo (CURRENT_PAGE =="balance.php" || CURRENT_PAGE=="balance.php") ? 'class="active"' : '' ; ?>>
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
                                <li>
                                   <a href="expenses.php"> <i class="glyphicon glyphicon-apple"></i> Expenses</a>
                                </li>
                                 <li>
                                   <a href="budget.php"> <i class="glyphicon glyphicon-usd"></i> Budget</a>
                                </li>

                                <li>
                                       <a href="income.php"> <i class="glyphicon glyphicon-usd"></i> Income</a>

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
        <div class="col-lg-12">
            <h1 class="page-header">Budget</h1>
        </div>
    </div>

                      <div class="col-lg-4">
                    <div  class=" animate "><a onclick="return confirm('Sure to Add?')" style="margin: 20px" data-toggle="tooltip" title="click to add new financial year" href="new_year.php" class="btn btn-success w3-round-large"  ><span class="glyphicon glyphicon-plus-sign"></span> New Year</a></div>

                    <div  class=" animate "><a onclick="return confirm('Sure to Print?')" style="margin-left: 20px" data-toggle="tooltip" title="click to print budget to pdf" href="printBudgetPdf.php" class="btn btn-success w3-round-large"  ><span class="glyphicon glyphicon-print"></span> Print Budget</a></div>
                </div>
                <div class=" search">
                    <form class="frm">

                        <div  class="sidebyside">
                            <label> Year: </label>
                            <?php
                            $c_id = $_SESSION['church'];
                            $f_query = mysql_query("Select id, year from financial_year WHERE church_id = $c_id order by year DESC");

                            echo "<select title=\" Choose Financial Year\" data-toggle=\"tooltip\" style=\" height: 30px;\" class=\" w3-round-large\" name=\"year\" id=\"fyear\" value\"echo $fyear\">";
                            echo "<option value=''>Select</option>";
                            while ($row = mysql_fetch_array($f_query)) {
                                echo "<option value='" . $row['id'] . "'>" . $row['year'] . "</option>";
                            } echo "</select>";
                            ?>
                        </div>

                        <div style="padding-top: 20px;"class="sidebyside ">
                            <button  type="button" style="height: 40px;"  name="filter" id="filter" data-toggle="tooltip" title="Click to Search" class="btn btn-info  glyphicon glyphicon-eye-open w3-round-xxlarge"> View </button>
                        </div>
                    </form>
                </div>


                <hr />

                <div class=" animate row">
                    <div class="col-md-12">


                        <div class="record_content"></div>

                        <div class="records_content"></div>
                    </div>
                </div>
           </div>

    <script src="assets/js/modal3.js"></script>
    <script src="assets/js/budget_expenses_ajax.js"></script>
    <script src="assets/js/budget_income_ajax.js"></script>
     <script type="text/javascript" src="js/script.js"></script>
<?php include_once('includes/footer.php'); ?>
