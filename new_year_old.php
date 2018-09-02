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
$error = false;

if (isset($_POST['btn-year'])) {

    // prevent sql injections/ clear user invalid inputs

    $year = trim($_POST['year']);
    $year = strip_tags($year);
    $year = htmlspecialchars($year);
    $church_id = $_SESSION['church'];



    if (empty($year)) {
        $error = true;
        $errTyp = "danger";
        $errMSG = "Error, Check and Try again!";
        $yearError = "Cannot be empty.";
    } else if (strlen($year) != 4) {
        $error = true;
        $errTyp = "danger";
        $errMSG = "Error, Check and Try again!";
        $yearError = "Year must have only four digits.";
    } else if (($year) <= 0) {
        $error = true;
        $errTyp = "danger";
        $errMSG = "Error, Check and Try again!";
        $yearError = "Year be more than zero.";
    } else if (($year) > 2999) {
        $error = true;
        $errTyp = "danger";
        $errMSG = "Error, Check and Try again!";
        $yearError = "Not a valid year.";
    }


    function AddYear() {
        global $year, $error, $errTyp, $church_id,$errMSG;
        if (!$error) {
            $query_insert = mysql_query("INSERT INTO financial_year(year,church_id) VALUES ('$year','$church_id')");
            if ($query_insert) {
                $errTyp = "success";
                $errMSG = "Successfully added..redirecting....";
                header("refresh:5; budget.php");
            } else {
                exit(mysql_error());
                $errMSG = "Unknown Error Occured!, Try again later...";
            }
        }
    }


    $max_query = "SELECT MAX(year) AS max FROM financial_year WHERE church_id='$church_id'";
    $q_result = mysql_query($max_query);
    $r_count = mysql_fetch_array($q_result);
    $max = $r_count['max'];

    $b_query = "SELECT balance FROM financial_year WHERE year='$max' AND church_id='$church_id'";
    $bq_result = mysql_query($b_query);
    $br_count = mysql_fetch_array($bq_result);
    $bal = $br_count['balance'];

    if ($max < $year) {
        AddYear();
      $id_q =  "SELECT id AS id FROM financial_year WHERE year= '$year' AND church_id='$church_id'";
    $q_result = mysql_query($id_q);
    $r_count = mysql_fetch_array($q_result);
     $id = $r_count['id'];
     $source ="".$max." Balance Carried Forward";
     $bal_q =mysql_query("INSERT INTO income_sources(source_name,amount,financial_year,church_id) VALUES ('$source','$bal','$id','$church_id')");
      if (!$bal_q){
         exit(mysql_error());
      }
      $update_query = mysql_query("UPDATE financial_year F
    SET total_income =
    (SELECT SUM(amount) FROM income_sources
    WHERE church_id = '$church_id' AND financial_year = $id)
    WHERE church_id = '$church_id' AND id = $id");
    if (!$update_query) {
        die("error1!");
        $errMSG = "Sorry Data Could Not Updated !";
        exit(mysql_error($conn));
    }

    $sumincome_query = mysql_query("SELECT total_income AS Income from financial_year  WHERE church_id = $church_id AND id =$id ");
    $sumbills_query = mysql_query("SELECT total_bills AS Bills from financial_year  WHERE church_id = $church_id AND id =$id ");
    $incomerow = mysql_fetch_assoc($sumincome_query);
    $sum_income = $incomerow['Income'];

    $expenserow = mysql_fetch_assoc($sumbills_query);
    $sum_bill = $expenserow['Bills'];
    $balance = $sum_income - $sum_bill;

    $bal_query = mysql_query("UPDATE financial_year
    SET balance = '$balance' WHERE church_id = $church_id AND id = $id");

    if (!$bal_query) {
        die("error3!");
        exit(mysql_error($conn));
    }

     ?>
      <script>
       alert("New Year \n Balance will be carried forward!")
        </script>
        <?php
    }
 if ($max > $year) {
     AddYear();
    }
}
?>
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>B&E Tracker</title>
        <link rel="shortcut icon" href="assets/image/favicon.png" type="image/x-icon" />
        <link rel="stylesheet" href="assets/css/bootstrap.min.css" type="text/css"  />
        <link rel="stylesheet" href="assets/css/style.css" type="text/css"/>
        <link rel="stylesheet" href="assets/css/style2.css" type="text/css"/>
        <link rel="stylesheet" href="assets/css/w3.css" type="text/css"/>
        <link rel="stylesheet" href="assets/css/font-awesome.min.css" type="text/css"/>
    </head>
    <body>
        <div id="wrap">

            <section  id="top">

            </section>
            <section id="page">
                <header id="pageheader" class="w3-round-xlarge homeheader">

                </header>
                <div style="padding: 3px"></div>
                <div class="topnav w3-round-xlarge" id="myTopnav">
                    <a href="home.php"> <i class="glyphicon glyphicon-home"></i> Home</a>
                    <a href="budget.php"> <i class="glyphicon glyphicon-usd"></i> Budget</a>
                    <a href="expenses.php"> <i class="glyphicon glyphicon-apple"></i> Expenses</a>
                    <a href="bills.php"> <i class="glyphicon glyphicon-registration-mark"></i> Bills</a>
                    <a href="income.php"> <i class="glyphicon glyphicon-usd"></i> Income</a>

                    <a href="javascript:void(0);" class="icon" onClick="myFunction()">&#9776;</a>

                </div>
                <div style="margin-top: 20px" class ="row">
                    <div class="col-lg-3"><a href="budget.php" class="btn btn-success w3-round-large " >&laquo; Back  </a></div>
                </div>

                <div class="login_form_div w3-round-large" >
                    <form method="post" class="animate" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" autocomplete="off">


                        <?php
                        if (isset($errMSG)) {
                            ?>
                            <div class="form-group">
                                <div class="alert alert-<?php echo ($errTyp == "success") ? "success" : $errTyp; ?>">
                                    <span class="glyphicon glyphicon-info-sign"></span> <?php echo $errMSG; ?>
                                </div>
                            </div>
<?php } ?>


                        <div class="form-group">
                            <div class="input-group">
                                <span class="input-group-addon"><span class="glyphicon glyphicon-yen"></span></span>
                                <input style="height:40px" type="number" title="type year" data-toggle="tooltip" name="year" class="form-control w3-round-large" placeholder="Enter Year" value="<?php echo $year; ?>" maxlength="40" />
                            </div>
                            <span class="text-danger"><?php echo $yearError; ?></span>
                        </div>
                        <div >
                            <button type="submit" class="btn btn-block btn-primary" title="click to save" data-toggle="tooltip" name="btn-year"><span class="glyphicon glyphicon-save"> </span> Save</button>
                        </div>
                    </form>

                </div>

                <!-- Modal - Add New Record/User -->





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

        <script src="assets/js/navigation.js"></script>
        <script>
                        $(document).ready(function () {
                            $('[data-toggle="tooltip"]').tooltip();
                        });
        </script>
    </body>

</html>
<?php ob_end_flush(); ?>
