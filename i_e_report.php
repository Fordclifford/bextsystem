<?php
require_once 'chartdb.php';
ob_start();
session_start();
// include Database connection file
if (!isset($_SESSION['user'])) {
    header("Location: index.php");
    exit;
}

?>

<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title><?php echo $userRow['name']; ?></title>
        <link rel="shortcut icon" href="assets/image/favicon.png" type="image/x-icon" />
        <link rel="stylesheet" href="assets/css/bootstrap.min.css" type="text/css"  />
        <link rel="stylesheet" href="assets/css/style.css" type="text/css"/>
        <link rel="stylesheet" href="assets/css/style2.css" type="text/css"/>
        <link rel="stylesheet" href="assets/css/w3.css" type="text/css"/>
         <link href="assets/font-awesome/css/font-awesome.css" rel="stylesheet" type="text/css">
       <link rel="stylesheet" href="assets/css/font-awesome.min.css" type="text/css"/>
         <script src="assets/zingchart/zingchart.min.js"></script>
        <script>
            zingchart.MODULESDIR = "assets/zingchart/modules/";
            ZC.LICENSE = ["569d52cefae586f634c54f86dc99e6a9", "ee6b7db5b51705a13dc2339db3edaf6d"];
        </script>
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
            <section id="page">
                <header id="pageheader" class="w3-round-xlarge homeheader">

                </header>
                <div class="topnav w3-round-xlarge" id="myTopnav">
                    <a href="home.php"> <i class="glyphicon glyphicon-home"></i> Home</a>
                    <a href="budget.php"> <i class="glyphicon glyphicon-usd"></i> Budget</a>
                    <a href="expenses.php"> <i class="glyphicon glyphicon-apple"></i> Expenses</a>
                    <a href="bills.php"> <i class="glyphicon glyphicon-registration-mark"></i> Bills</a>
                    <a href="income.php"> <i class="glyphicon glyphicon-usd"></i> Income</a>

                    <a href="javascript:void(0);" class="icon" onClick="myFunction()">&#9776;</a>

                </div>
                 <div style="margin: 0 auto" >
                    <h3 align='center' class="page-header">View  Income-Expense Curve</h3>
                </div>


       <div class="row">
           <div class="col-lg-12">
       <div id='myChart'></div>
           </div>
       </div>
 <script>
<?php
$data = mysqli_query($mysqli, "SELECT MONTHNAME(date),amount FROM bill WHERE church_id=$church_id");
$data1 = mysqli_query($mysqli, "SELECT MONTHNAME(date),amount FROM bill");
?>

            var myData = [<?php
while ($info = mysqli_fetch_array($data))
    echo $info['amount'] . ','; /* We use the concatenation operator '.' to add comma delimiters after each data value. */
?>];
            var myLabels = [<?php
while ($info = mysqli_fetch_array($data))
    echo '"' . $info['MONTHNAME(date)'] . '",'; /* The concatenation operator '.' is used here to create string values from our database names. */
?>];
        </script>

        <script>

        var myConfig = {
            type: "bar",
            plotarea: {
                adjustLayout: true
            },
            scaleX: {
                label: {
                    text: "Here is a category scale"
                },
                labels: ["Jan", "Feb", "March", "April", "May", "June", "July", "Aug"]
            },
            series: [
                 {
                    values: myData
                },
                {
                    values: [20, 40, 25, 50, 15, 45, 33, 34]
                },
                {
                    values: [5, 30, 21, 18, 59, 50, 28, 33]
                }
            ]
        };

        zingchart.render({
            id: 'myChart',
            data: myConfig,
            height: "100%",
            width: "100%"
        });

</script>
                <div class="clearfix"></div>



            </section>
        </div>
        <footer id="pagefooter">
            <div id="f-content">

                <div id="foot_notes">
                    <p style="margin: 0px" align='center'>&copy;<?php echo date("Y"); ?> - Church Budget and Expense Tracker  </p>

                </div>
                <img src="assets/image/bamboo.png" alt="bamboo" id="footerimg" width="96px" height="125px">
            </div>
        </footer>

        <script src="assets/jquery-1.11.3-jquery.min.js"></script>
        <script src="assets/js/bootstrap.min.js"></script>
        <script src="assets/js/navigation.js"></script>
        <script>
                        $(document).ready(function () {
                            $('[data-toggle="tooltip"]').tooltip();
                        });
    </script>
    <script src="assets/js/report.js"></script>



    </body>

</html>
<?php ob_end_flush(); ?>
