<?php
session_start();
require_once './coreadmin/config/config.php';
require_once 'includes/auth_validate.php';
require_once 'config.php';
$church_id = $_SESSION['church'];
?>
<?php
if (isset($_POST["submit"])) {

    // include Database connection file
    // get values
    $category = $_POST['category'];
    $amount = $_POST['amount'];
    $date = $_POST['date'];
    $desc = $_POST['desc'];
    $church_id = $_SESSION['church'];
    $yr = $_POST['year'];
    $bill = $_POST['bill'];


    $imgFile = $_FILES['image']['name'];
    $tmp_dir = $_FILES['image']['tmp_name'];

    $date1 = date("Y-m-d h:i:sa");

    $d = (strtotime($date));
    $date2 = (strtotime($date1));

    $diff = ($d - $date2);

    if ($diff > 0) {
        $error = true;
        $dateError = "Cannot be Future Date.";
        $errTyp = "danger";
        $errMSG = "Sorry an Error Occured! Check and Try Again!";
    }if ($amount <= 0) {
        $error = true;
        $amtError = "Amount Must be more than Zero.";
        $errTyp = "danger";
        $errMSG = "Sorry an Error Occured! Check and Try Again!";
    }
    if ($category != '') {

        $check = mysql_query("SELECT balance AS amount FROM actual_income WHERE id=$category");
        $res_row = mysql_fetch_assoc($check);
        $amt = $res_row['amount'];
        if ($amt < $amount) {
            $errMSG = "An error occured! Check your input and try again";
            $error = true;
            $amtError = "The amount you entered exceeds limit, the remaining balance is " . $amt . " ";
            $errTyp = "danger";
        }
    }
    if (!isset($error)) {
        if ($imgFile) {

            $upload_dir = 'uploads/'; // upload directory

            $imgExt = strtolower(pathinfo($imgFile, PATHINFO_EXTENSION)); // get image extension
            // valid image extensions
            $valid_extensions = array('jpeg', 'jpg', 'png', 'gif'); // valid extensions
            // rename uploading image
            $userpic = rand(1000, 1000000) . "." . $imgExt;

            // allow valid image file formats
            if (in_array($imgExt, $valid_extensions)) {
                // Check file size '5MB'
                if ($imgSize < 5000000) {
                    move_uploaded_file($tmp_dir, $upload_dir . $userpic);
                } else {
                    $error = TRUE;
                    $errTyp = "danger";
                    $errMSG = "Sorry, your file is too large.";
                }
            } else {
                $error = TRUE;
                $errTyp = "danger";
                $errMSG = "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
            }
        } else {
            $userpic = "no-image.png";
        }
    }
    //take care of duplicates


    if (!isset($error)) {
        $dateto = new DateTime($date);
        $to = $dateto->format('Y-m-d H:i:s');
        $insert_query = mysql_query("INSERT INTO bill (source,amount,date,image,description,church_id,financial_year,mode_of_payment)VALUES('$category', '$amount', '$to', '$userpic','$desc',$church_id,$yr,'$bill')");
        if (!$insert_query) {

            exit(mysql_error($conn));
        }

        $update_query = mysql_query("UPDATE financial_year F
    SET total_bills =
    (SELECT SUM(amount) FROM bill
    WHERE church_id = $church_id AND financial_year = $yr)
    WHERE church_id = $church_id AND id = $yr");
        if (!$update_query) {
            die("error2!");
            exit(mysql_error($conn));
        }

        $sumincome_query = mysql_query("SELECT total_actual_income AS Income from financial_year WHERE church_id = $church_id and id =$yr");
        $sumbills_query = mysql_query("SELECT total_bills AS Bills from financial_year WHERE church_id = $church_id and id =$yr");
        $incomerow = mysql_fetch_assoc($sumincome_query);
        $sum_income = $incomerow['Income'];

        $expenserow = mysql_fetch_assoc($sumbills_query);
        $sum_bill = $expenserow['Bills'];
        $balance = $sum_income - $sum_bill;

        $bal_query = mysql_query("UPDATE financial_year F
    SET balance = '$balance' WHERE church_id = $church_id AND id = $yr");

        if (!$bal_query) {
            die("error3!");
            exit(mysql_error($conn));
        }
        $sum_amt = mysql_query("SELECT SUM(amount) AS sum FROM bill WHERE source=$category AND church_id=$church_id AND financial_year=$yr");
        $sum_row = mysql_fetch_assoc($sum_amt);
        $sum = $sum_row['sum'];

        $bala = mysql_query("SELECT amount AS amount FROM actual_income WHERE id=$category ");
        $bal_row = mysql_fetch_assoc($bala);
        $amt_val = $bal_row['amount'];

        $bal_val = $amt_val - $sum;
        $upd_query = mysql_query("UPDATE actual_income SET balance='$bal_val' WHERE id=$category");

        if (!$upd_query) {
            die("error4!");
            exit(mysql_error($conn));
        }
        if ($insert_query && $update_query && $bal_query && $upd_query) {
            $errTyp = "success";
            $_SESSION['success'] ="The bill was added successfully";
          $errMSG = "new record succesfully inserted redirecting...";
            header("refresh:5;bills.php"); // redirects image view page after 5 seconds.
        } else {
            $error = TRUE;
            $errTyp = "danger";
            $errMSG = "error while inserting....";
        }
    }
}

$sql1 = "SELECT * FROM actual_income WHERE church_id=" . $_SESSION['church'];
$result1 = mysql_query($sql1, $conn);



if (mysql_num_rows($result1) <= 0) {
    
}

include_once './includes/header.php';
?>
<?php
if (isset($_SESSION['user_logged_in']) && $_SESSION['user_logged_in'] == true) :
    include_once './sidenav.php';
    ?>

<?php endif; ?>

<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">Add Bill</h1>
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <div style="margin: 0 auto">
        <form  class="animate well form-horizontal" method="post" name="f1" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" onsubmit="DateCheck()" enctype="multipart/form-data" autocomplete="off">
            <fieldset>
                <?php
                if (isset($errMSG)) {
                    ?>
                    <div class="form-group">
                        <div class="alert alert-<?php echo ($errTyp == "success") ? "success" : $errTyp; ?>">
                            <span class="glyphicon glyphicon-info-sign"></span> <?php echo $errMSG; ?>
                        </div>
                    </div>
<?php } ?>

                <hr />

                <div class="form-group">
                    <label class="col-md-6 control-label">Select Financial Year: </label>
                    <div class="col-md-4 inputGroupContainer">
                        <div class="input-group">

                            <span class="input-group-addon"><span class="glyphicon glyphicon-flag "></span></span>

                            <select title=" Choose Financial Year"  style=" height: 40px" class="form-control w3-round-large" name="year" id="year"
                                    value="<?php echo $yr; ?>">
                                <option value=''>------- Select Year --------</option>
                                <?php
                                $sql = "SELECT * FROM financial_year WHERE church_id=" . $_SESSION['church'];
                                $resu = mysql_query($sql);
                                if (mysql_num_rows($resu) > 0) {
                                    while ($row = mysql_fetch_object($resu)) {
                                        echo "<option value='" . $row->id . "'>" . $row->year . "</option>";
                                    }
                                }
                                ?>
                            </select>
                        </div>
                    </div> <span class="text-danger"> <?php echo $yrError; ?></span> </div>
                <div class="form-group">
                    <label class="col-md-6 control-label">Select Income Source: </label>

                    <div class="col-md-4 inputGroupContainer">
                        <div class="input-group">

                            <span class="input-group-addon"><span class="glyphicon glyphicon-apple "></span></span>

                            <select title=" Click to Choose Category" style=" height: 40px" class="form-control w3-round-large" name="category" id="category" value="<?php echo $category; ?>">
                                <option value=''  >----Select Category----</option>
                            </select>

                        </div>
                        <span class="text-danger"> <?php echo $catError; ?></span>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-md-6 control-label" >What Bill: </label>
                    <div class="col-md-4 inputGroupContainer">
                        <div class="input-group">
                            <span class="input-group-addon"><span class="glyphicon glyphicon-bitcoin "></span></span>

                            <select style=" height: 40px" class="w3-round-large form-control" id="desc" name="desc"
                                    onchange="if (this.options[this.selectedIndex].value === 'customOption') {
                                        toggleField(this, this.nextSibling);
                                        this.selectedIndex = '0';
                                    }">
                                <option value="">------Select-------</option>
                                <option value="Repairs and Painting Church Building">Repairs and Painting Church Building</option>
                                <option value="Fuel">Fuel</option>
                                <option value="Janitor and Supplies">Janitor and Supplies</option>
                                <option value="Insurance on Building and Furnishings">Insurance on Building and Furnishings</option>
                                <option value="Sabbath School Supplies">Sabbath School Supplies</option>
                                <option value="Church Fund for the Needy">Church Fund for the Needy</option>
                                <option value="Emergency Expense">Emergency Expense</option>
                                <option value="Light">Light</option>
                                <option value="Water">Water</option>
                                <option value="Gas">Gas</option>
                                <option value="Stationery and Supplies">Stationery and Supplies</option>
                                <option value="Laundry">Laundry</option>
                                <option value="Church School Subsidy">Church School Subsidy</option>
                                <option value="Welfare Expense">Welfare Expense</option>
                                <option value="Evangelism and Church Planting">Evangelism and Church Planting</option>
                                <option value="customOption">[Other]</option>
                               
                            </select><input style="display:none;height: 40px" class="w3-round-large form-control" name="desc" id="desc" disabled="disabled"
                                            onblur="if (this.value === '') {
                                                toggleField(this, this.previousSibling);
                                            }">
                        </div>
                        <span class="text-danger"><?php echo $billError; ?></span>
                    </div>
                </div>


                <div class="form-group">
                    <label class="col-md-6 control-label">Date: </label>
                    <div class="col-md-4 inputGroupContainer">
                        <div class="input-group">
                            <span style="height: 40px" class="input-group-addon"><a title="Click to Select Date" ><span class="glyphicon glyphicon-calendar "></span></a></span>
                            <input  title="Select Date " type="date" style="height:40px;  margin:0px 0px 0px 0px;" type="text" id="date" name="date" class="form-control w3-round-large" placeholder="Click to Select Date"  value="<?php echo $date; ?>"/>
                        </div>
                        <span class="text-danger"><?php echo $dateError; ?></span>
                    </div>
                </div>


                <div class="form-group">
                    <label class="col-md-6 control-label" >Payment Mode: </label>
                    <div class="col-md-4 inputGroupContainer">
                        <div class="input-group">
                            <span class="input-group-addon"><span class="glyphicon glyphicon-bitcoin "></span></span>

                            <select style=" height: 40px" class="w3-round-large form-control" id="source" name="bill"
                                    onchange="if (this.options[this.selectedIndex].value === 'customOption') {
                                        toggleField(this, this.nextSibling);
                                        this.selectedIndex = '0';
                                    }">
                                <option value="">------Select-------</option>
                                <option value="customOption">[type a custom value]</option>
                                <option value="cash">Cash</option>
                                <option value="cheque">Cheque </option>
                                <option value="card">Card</option>
                                <option value="mpesa">M-Pesa</option>
                            </select><input style="display:none;height: 40px" class="w3-round-large form-control" name="bill" id="sources" disabled="disabled"
                                            onblur="if (this.value === '') {
                                                toggleField(this, this.previousSibling);
                                            }">
                        </div>
                        <span class="text-danger"><?php echo $billError; ?></span>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-md-6 control-label" >Amount: </label>

                    <div class="col-md-4 inputGroupContainer">
                        <div class="input-group">
                            <span class="input-group-addon"><span class="glyphicon glyphicon-usd "></span></span>
                            <input style=" height: 40px ;margin: 0px" type="number" name="amount" title="Enter Amount"  id="amount" placeholder="Enter Amount" class="form-control w3-round-large" value="<?php echo $amount; ?>"/>
                        </div>
                        <span class="text-danger"><?php echo $amtError; ?></span>
                    </div>
                </div>



                <div class="form-group">
                    <label class="col-md-6 control-label">Select Bill Image(optional): </label>
                    <div class="col-md-4 inputGroupContainer">
                        <div class="input-group">
                            <span class="input-group-addon"><span class="glyphicon glyphicon-file "></span></span>
                            <input title="Click to Choose Image File"  style="height:40px; margin:0px" class="form-control" type="file" name="image" id="image" accept="image/*" value="<?php echo $userpic; ?>" />
                        </div>
                        <span class="text-danger"><?php echo $imgError; ?></span>
                    </div>
                </div>




                <div class="modal-footer">
                    <div class="col-md-4 inputGroupContainer">
                        <button title="Click to Clear Input" data-toggle="tooltip" type="reset" value="reset" class="btn btn-default" ><span class="glyphicon glyphicon-erase"></span> Clear</button>
                        <button title="Click to Save Record" data-toggle="tooltip" type="submit" name="submit" class="btn btn-primary" ><span class="glyphicon glyphicon-save"></span> &nbsp; save
                        </button>
                    </div>
                </div>
            </fieldset>
        </form>
    </div>


    <script src ="./assets/js/dateTimePicker.js"></script>
    <script type="text/javascript" src="assets/js/changeIncome.js"></script>
    <script src="assets/js/js.js" ></script>
    <script src="assets/jquery-1.11.3-jquery.min.js"></script>
    <script type="text/javascript">
                                        $(document).ready(function () {
                                            $("#bill_form").validate({
                                                rules: {
                                                    category: {
                                                        required: true
                                                    },
                                                    bill: {
                                                        required: true
                                                    },
                                                    date: {
                                                        required: true

                                                    },
                                                    desc: {
                                                        required: true,
                                                        minlength: 3
                                                    },
                                                    year: {
                                                        required: true,

                                                    },
                                                    amount: {
                                                        required: true,
                                                        minlength: 3
                                                    }
                                                }
                                            });
                                        });
    </script>
<?php include_once('includes/footer.php'); ?>
    <script src="includes/js/notif.js" type="text/javascript"></script>