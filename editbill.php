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

if ($_SESSION['user_type'] == 'treasurer') {
if (isset($_GET['edit_id']) && !empty($_GET['edit_id'])) {
    $id = $_GET['edit_id'];
    $query_edit = "SELECT church_id, source, amount, date, image, description FROM bill WHERE id =$id";
    $results = mysql_query($query_edit);

    $edit_row = mysql_fetch_assoc($results);
} else {
    header("Location: bills.php");
}

if (isset($_POST['update'])) {

    $id;
    $category = $_POST['category']; // //category
    $amount = $_POST['amount']; // amount
    $d = strtotime($_POST['date']);
    $date = date("Y-m-d", $d);  // //date
    $yr = $_POST['year'];
    $bill = $_POST['bill'];
    $church_id = $_SESSION['church'];

    $desc = $_POST['desc']; // //description
    $imgFile = $_FILES['image']['name'];
    $tmp_dir = $_FILES['image']['tmp_name'];
    $imgSize = $_FILES['image']['size'];


    $date1 = date("Y-m-d");
    $d = (strtotime($date));
    $date2 = (strtotime($date1));
    $diff = ($date2 - $d);
    if ($diff < 0) {
        $error = true;
        $dateError = "Cannot be Future Date.";
        $errTyp = "danger";
        $errMSG = "Sorry Data Could Not Updated Check and Try Again !";
    }if ($amount <= 0) {
        $error = true;
        $amtError = "Amount Must be more than Zero.";
        $errTyp = "danger";
        $errMSG = "Sorry Data Could Not Updated Check and Try Again!";
    }
    if (empty($bill)) {
        $error = true;
        $billError = "Please select mode of payment.";
        $errTyp = "danger";
        $errMSG = "Sorry an Error Occured! Check and Try Again!";
    }
    if (empty($yr)) {
        $error = true;
        $yrError = "Please select year.";
        $errTyp = "danger";
        $errMSG = "Sorry an Error Occured! Check and Try Again!";
    }
    if (empty($category)) {
        $error = true;
        $catError = "Please select category.";
        $errTyp = "danger";
        $errMSG = "Sorry an Error Occured! Check and Try Again!";
    }

    if (isset($category) && $category != '') {
        $check = mysql_query("SELECT balance AS amount FROM budget_expenses WHERE sid=$category");
        $res_row = mysql_fetch_assoc($check);
        $amt = $res_row['amount'];
        if ($amt < $amount) {
            $errMSG = "An error occured! Check your input and try again";
            $error = true;
            $amtError = "The amount you entered exceeds limit, the remaining balance is " . $amt . " ";
            $errTyp = "danger";
        }
    }


    if ($imgFile) {
        $upload_dir = 'uploads/'; // upload directory
        $imgExt = strtolower(pathinfo($imgFile, PATHINFO_EXTENSION)); // get image extension
        $valid_extensions = array('jpeg', 'jpg', 'png', 'gif'); // valid extensions
        $userpic = rand(1000, 1000000) . "." . $imgExt;
        if (in_array($imgExt, $valid_extensions)) {
            if ($imgSize < 5000000) {
                unlink($upload_dir . $edit_row['image']);
                move_uploaded_file($tmp_dir, $upload_dir . $userpic);
            } else {
                $error = true;
                $errMSG = "Sorry, your file is too large it should be less then 5MB";
            }
        } else {
            $error = true;
            $errMSG = "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
        }
    } else {
// if no image selected the old image remain as it is.
        $userpic = $edit_row['image']; // old image from database
    }


// if no error occured, continue ....
    if (!isset($error)) {

        $insert_query = mysql_query("UPDATE bill SET source='$category',date = '$date', image='$userpic', description='$desc', amount='$amount',mode_of_payment='$bill' WHERE id='$id'");

        if (!$insert_query) {
            $error = true;
            $errMSG = "Sorry Data Could Not Updated !";
            exit(mysql_error());
        }

        $update_query = mysql_query("UPDATE financial_year F
    SET total_bills =
    (SELECT SUM(amount) FROM bill
    WHERE church_id = '$church_id' AND financial_year = '$yr')
    WHERE church_id = '$church_id' AND id = '$yr'");
        if (!$update_query) {
            $errMSG = "Sorry Data Could Not Updated !";
            exit(mysql_error($conn));
            die("error1!");
        }
        $sumincome_query = mysql_query("SELECT total_income AS Income from financial_year WHERE church_id = $church_id and id =$yr");
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

        $bala = mysql_query("SELECT amount AS amount FROM budget_expenses WHERE sid=$category ");
        $bal_row = mysql_fetch_assoc($bala);
        $amt_val = $bal_row['amount'];

        $bal_val = $amt_val - $sum;
        $upd_query = mysql_query("UPDATE budget_expenses SET balance='$bal_val' WHERE sid=$category");
        if ($insert_query && $update_query && $bal_query && $upd_query) {
            ?>
            <script>
                alert('Successfully Updated ...');
                window.location.href = 'bills.php';
            </script>
            <?php
        }
    }
}
}
include_once('includes/header.php');
?>


<body>

    <div id="wrapper">

        <!-- Navigation -->
        <?php if (isset($_SESSION['user']) && $_SESSION['user'] == true) : ?>
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
                            <li><a href="#"><i class="fa fa-user fa-fw"></i> User Profile</a>
                            </li>
                            <li><a href="#"><i class="fa fa-gear fa-fw"></i> Settings</a>
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

                            <li <?php echo (CURRENT_PAGE == "balance.php" || CURRENT_PAGE == "balance.php") ? 'class="active"' : ''; ?>>
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
                            <li>
                                <a href="balances.php"> <i class="glyphicon glyphicon-usd"></i> Balance</a>

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
                    <h1 class="page-header">Edit Bill</h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <div class ="btn-group w3-round-large buttoncontainer">
                <div class="sidebyside"><a href="bills.php" class="btn btn-success w3-round-large " >&laquo; Back                             </a></div>
            </div>

            <form  method="post" onsubmit="DateCheck()" enctype="multipart/form-data" autocomplete="off">
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
                    <label>Select Financial Year: </label>
                    <div class="input-group">

                        <span class="input-group-addon"><span class="glyphicon glyphicon-flag "></span></span>

                        <select title=" Choose Financial Year" data-toggle="tooltip" style=" height: 40px" class="form-control w3-round-large" name="year" id="year" value="<?php echo $edit_row['financial_year']; ?>"
                                value="<?php echo $yr; ?>">
                            <option value=''>------- Select Year --------</option>
                            <?php
                            //echo $church_id= $_SESSION['user'];exit;
                            $sql = "select * from `financial_year` where church_id=" . $_SESSION['church'];
                            $resu = mysql_query($sql);
                            if (mysql_num_rows($resu) > 0) {
                                while ($row = mysql_fetch_object($resu)) {
                                    echo "<option value='" . $row->id . "'>" . $row->year . "</option>";
                                }
                            }
                            ?>
                        </select>

                    </div> <span class="text-danger"> <?php echo $yrError; ?></span> </div>
                <div class="form-group">
                    <label>Select Bill Category: </label>
                    <div class="input-group">

                        <span class="input-group-addon"><span class="glyphicon glyphicon-apple "></span></span>

                        <select title=" Click to Choose Category" data-toggle="tooltip" style=" height: 40px" class="form-control w3-round-large" name="category" id="category" value="<?php echo $edit_row['source']; ?>">
                            <option value=''  >----Select Category----</option>
                        </select>

                    </div>
                    <span class="text-danger"> <?php echo $catError; ?></span>

                </div>

                <div class="form-group">

                    <div class="input-group">
                        <span style="height: 40px" class="input-group-addon"><a title="Click to Select Date" data-toggle="tooltip" href="javascript:NewCal('date','ddmmyyyy')"><span class="glyphicon glyphicon-calendar "></span></a></span>
                        <input onclick="javascript:NewCal('date', 'ddmmyyyy')" title="Select Date " data-toggle="tooltip" style="height:40px;  margin:0px 0px 0px 0px;" type="text" id="date" name="date" class="form-control w3-round-large" placeholder="Select Date" readonly="true" value="<?php echo $edit_row['date']; ?>"/>
                    </div>
                    <span class="text-danger"><?php echo $dateError; ?></span>
                </div>



                <div class="form-group">
                    <div class="input-group">
                        <span class="input-group-addon"><span class="glyphicon glyphicon-usd "></span></span>
                        <input style=" height: 40px ;margin: 0px" type="number" name="amount" id="amount" placeholder="Enter Amount" class="form-control w3-round-large" value="<?php echo $edit_row['amount']; ?>"/>
                    </div> <span class="text-danger"><?php echo $amtError; ?></span>
                </div>

                <div class="form-group">
                    <label for="source">Payment Mode: </label>
                    <div class="input-group">
                        <span class="input-group-addon"><span class="glyphicon glyphicon-bitcoin "></span></span>

                        <select style=" height: 40px" class="w3-round-large form-control" id="source" name="bill" value="<?php echo $edit_row['mode_of_payment']; ?>"
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
                        </select><input style="display:none;height: 40px" class="w3-round-large form-control" name="bill" id="sources" disabled="disabled" value="<?php echo $edit_row['mode_of_payment']; ?>"
                                        onblur="if (this.value === '') {
                                                                        toggleField(this, this.previousSibling);
                                                                    }">
                    </div>
                    <span class="text-danger"><?php echo $billError; ?></span>

                </div>



                <div class="form-group">
                    <label>Select Bill Image(optional): </label>

                    <div class="input-group">
                        <span class="input-group-addon"><span class="glyphicon glyphicon-file "></span></span>
                        <input title="Click to Choose Image File" data-toggle="tooltip" style="height:40px; margin:0px" class="form-control" type="file" name="image" id="image" accept="image/*" value="<?php echo $edit_row['image']; ?>" /> </div>
                    <span class="text-danger"><?php echo $imgError; ?></span>

                </div>


                <div class="form-group">
                    <label>Enter brief description of the bill: </label>
                    <div class="input-group">
                        <span class="input-group-addon"><span class="glyphicon glyphicon-book "></span></span>
                        <input title="Brief Description of the Bill" data-toggle="tooltip" style="  height: 40px; margin-top: 0px" type="text" name="desc" id="desc" placeholder="Description " class="form-control w3-round-large" value="<?php echo $edit_row['description']; ?>"/>
                    </div>
                    <span class="text-danger"><?php echo $descError; ?></span>
                </div>

                <div class="modal-footer">
                    <button title="Click to Clear Input" data-toggle="tooltip" type="reset" value="reset" class="btn btn-default" ><span class="glyphicon glyphicon-erase"></span> Clear</button>
                    <button title="Click to Save Record" data-toggle="tooltip" type="submit" name="update" class="btn btn-primary" ><span class="glyphicon glyphicon-save"></span> &nbsp; save</button>
                </div>
            </form>

        <script src ="assets/js/dateTimePicker.js"></script>
        <script type="text/javascript" src="assets/js/changeIncome.js"></script>
        <script src="assets/js/js.js"></script>
<?php include_once('includes/footer.php'); ?>
