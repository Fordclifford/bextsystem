<?php
ob_start();
session_start();
require_once 'config.php';

require_once './includes/auth_validate.php';

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
    }  if (strlen($year) != 4 ) {
        $error = true;
        $errTyp = "danger";
        $errMSG = "Error, Check and Try again!";
        $yearError = "Year must have only four digits.";
    }  if ($year <= 0) {
        $error = true;
        $errTyp = "danger";
        $errMSG = "Error, Check and Try again!";
        $yearError = "Year be more than zero.";
    }  if ($year > 2999) {
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
                $errMSG = "Successfully added..";
               
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
     $bal_q =mysql_query("INSERT INTO actual_income(source_name,amount,financial_year_id,church_id) VALUES ('$source','$bal','$id','$church_id')");
     $bal_q =mysql_query("Update actual_income set balance =$bal WHERE source_name ='$source' AND church_id='$church_id' ");
     
     if (!$bal_q){
         exit(mysql_error());
      }
      $update_query = mysql_query("UPDATE financial_year F
    SET total_actual_income =
    (SELECT SUM(amount) FROM actual_income
    WHERE church_id = '$church_id' AND financial_year_id = $id)
    WHERE id = $id");
    if (!$update_query) {
        die( exit(mysql_error($conn)));
        $errMSG = "Sorry Data Could Not Updated !";
        exit(mysql_error($conn));
    }

    $sumincome_query = mysql_query("SELECT total_actual_income AS Income from financial_year  WHERE  id =$id ");
    $sumbills_query = mysql_query("SELECT total_bills AS Bills from financial_year  WHERE church_id = $church_id AND id =$id ");
    $incomerow = mysql_fetch_assoc($sumincome_query);
    $sum_income = $incomerow['Income'];

    $expenserow = mysql_fetch_assoc($sumbills_query);
    $sum_bill = $expenserow['Bills'];
    $balance = $sum_income - $sum_bill;

    $bal_query = mysql_query("UPDATE financial_year
    SET balance = '$balance' WHERE id = $id");

    if (!$bal_query) {
        die("error3!");
        exit(mysql_error($conn));
    }
    
   $_SESSION['info']="New Year \n Balance will be carried forward!";
     
    }

 if ($max > $year) {
     AddYear();
    }
}
include_once('includes/header.php');
?>
<body>

        <div id="wrapper">

            <!-- Navigation -->
         <?php if (isset($_SESSION['user_logged_in']) && $_SESSION['user_logged_in'] == true) :
     include_once './sidenav.php';
    ?>

<?php endif; ?>

           <div id="page-wrapper">
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">New Financial Year</h1>
        </div>
    </div>
                <?php require_once 'includes/flash_messages.php'; ?>




                <div  >
                    <form class="well form-horizontal" method="post" class="animate" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" autocomplete="off">


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
                                <input style="height:40px" type="number" title="type year" name="year" class="form-control w3-round-large" placeholder="Enter Year" value="<?php echo $year; ?>" maxlength="40" />
                            </div>
                            <span class="text-danger"><?php echo $yearError; ?></span>
                        </div>
                        <div >
                            <button type="submit" class="btn btn-block btn-primary" title="click to save" data-toggle="tooltip" name="btn-year"><span class="glyphicon glyphicon-save"> </span> Save</button>
                        </div>
                    </form>

                </div>
        </div>

<?php include_once('includes/footer.php'); ?>
