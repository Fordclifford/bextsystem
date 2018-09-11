
<?php
session_start();
require_once 'includes/auth_validate.php';

/* ACTION REQUIRED: Enter your database information below */

/* The host name in which the database is available */
$host = "localhost";

/* The database port number */
$port = 3306;
/* The username to connect to the database */
$usernm = "root";
/* The password associated with the username */
$passwd = "";
/* The database to which to connect */
$dbname = "bext_system";
/*
  The query to use. This query selects the `date` and `24h_average` columns
  from the `t_baverage` table and orders the results by date in an ascending order
 */
$church = $_SESSION['church'];
$query = "SELECT date, amount,source_name from estimated_income where church_id=$church ORDER BY date ASC";
$bill = "SELECT date, amount from bill where church_id=$church ORDER BY date ASC";

/* ---------------- */
$date = []; // Array to hold our date values
$series = [];

$b_series =[];
$b_date =[];
// Array to hold our series values
/* Connect to the database */
$mysqli = new mysqli($host, $usernm, $passwd, $dbname, $port);
if ($mysqli->connect_error) {
    die('Connect Error (' . $mysqli->connect_errno . ')' . $mysqli->connect_error);
}
/* Run the query */
if ($bills = $mysqli->query($bill)) {
    /* Fetch the result row as a numeric array */
    while ($row = $bills->fetch_array(MYSQLI_NUM)) {
        /* Push the values from each row into the $date and $series arrays */
       array_push($date, $row[0]);
        array_push($b_series, $row[1]);
        
    }
    /* Convert each date value to a Unix timestamp, multiply by 1000 for milliseconds */
    foreach ($b_date as &$value) {
        $value = strtotime($value) * 1000;
    }
    /* Free the result set */
    $bills->close();
}

if ($result = $mysqli->query($query)) {
    /* Fetch the result row as a numeric array */
    while ($row = $result->fetch_array(MYSQLI_NUM)) {
        /* Push the values from each row into the $date and $series arrays */
       array_push($date, $row[0]);
       array_push($series, $row[1]);
      
    }
    /* Convert each date value to a Unix timestamp, multiply by 1000 for milliseconds */
    foreach ($date as &$value) {
        $value = strtotime($value) * 1000;
    }
    /* Free the result set */
    $result->close();
    
}
include_once'includes/header.php'
?>


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
                <a class="navbar-brand" href="">Income & Expense Tracker</a>
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
                            <a href="budget.php"><i class="glyphicon glyphicon-registration-mark fa-fw"></i> Budget<span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
                                <li>
                                    <a href="income.php"><i class="fa fa-list fa-fw"></i>Estimated Income</a>
                                </li>
                                <li>
                                    <a href="expenses.php"><i class="fa fa-plus fa-fw"></i>Estimated Expenses</a>
                                    <ul class="nav nav-second-level">

                                    </ul>
                                </li>
                            </ul>
                        </li>

                        <li>
                            <a href="actual_income.php"> <i class="glyphicon glyphicon-usd"></i>Actual Income</a>

                        </li>
                        <li>
                            <a href="balance.php"> <i class="glyphicon glyphicon-usd"></i> Balance</a>

                        </li>
                    </ul>
                </div>
                <!-- /.sidebar-collapse -->
            </div>
            <!-- /.navbar-static-side -->
        </nav>
<?php endif; ?>

    <div id="page-wrapper">

<?php require_once 'includes/flash_messages.php'; ?>

        <script>

            /* Join the values in each array to create JavaScript arrays */
            var dateValues = [<?php echo join($date, ',') ?>];
            var seriesValues = [<?php echo join($series, ',') ?>];            
            var bseriesValues = [<?php echo join($b_series, ',') ?>];
            var minDate =<?php echo min($date) ?>;

<?php
/* Close database connection */
$mysqli->close();
?>
        </script>
        <script>
            var myTheme = {
                palette: {
                    line: [
                        ['#FBFCFE', '#00BAF2', '#00BAF2', '#00a7d9'], /* light blue */
                        ['#FBFCFE', '#E80C60', '#E80C60', '#d00a56'], /* light pink */
                        ['#FBFCFE', '#9B26AF', '#9B26AF', '#8b229d'], /* light purple */
                        ['#FBFCFE', '#E2D51A', '#E2D51A', '#E2D51A'], /* med yellow */
                        ['#FBFCFE', '#FB301E', '#FB301E', '#e12b1b'], /* med red */
                        ['#FBFCFE', '#00AE4D', '#00AE4D', '#00AE4D'], /* med green */
                    ]
                },
                graph: {

                }
            };</script>
        <script>
            window.onload = function () {
                zingchart.render({
                    id: "myChart",
                    width: "100%",
                    height: 500,
                    defaults: myTheme,
                    data: {
                        "type": "line",
                        "title": {
                            "text": "Estimated Income",

                        },
                        "scale-x": {
                            
                            label: {
                                text: "Date",
                                "font-size": 15,
                                "font-family": "Tahoma",
                                "font-color": "blue",
                                "border-width": 1,
                                "border-color": "blue",
                                "background-color": "#ffe6e6",
                                "width": "40%"
                            },
                            "values": dateValues,
                            
                            "transform": {
                                "type": "date",
                                
                                "item": {
                                    "visible": false
                                }
                            }
                        },
                        "scale-y": {

                            "thousands-separator": ",",

                            "label": {
                                "text": "Amount (ksh.)",
                                "font-size": 15,
                                "font-family": "Tahoma",
                                "font-color": "blue",
                                "border-width": 1,
                                "border-color": "blue",
                                "background-color": "#ffe6e6",
                                "width": "40%"
                            },
                            "item": {
                                "font-size": 10
                            },
                           
                        },
                        "plot": {
                            "line-width": 1
                        },
                        "plotarea": {
                            "margin-left": "dynamic",
                            "margin-bottom": "dynamic"
                        },

                        "series": [
                            {
                                "values": seriesValues
                            }
                            
                        ]
                    }
                });
               
            };
        </script>
        
        <!--    <h1>Estimated Income</h1>-->
        <div id="myChart"></div>
        <hr />
        <div id="billsChart"></div>
    </div>
</div>
 
<?php include_once'includes/footer.php' ?>
<script src="assets/zingchart/zingchart.min.js" type="text/javascript"></script>
