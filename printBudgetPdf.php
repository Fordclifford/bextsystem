<?Php
ob_start();
session_start();
require_once 'config.php';
if (!isset($_SESSION['user'])) {
    header("Location: index.php");
    exit;
}
// select loggedin users detail
$res = mysql_query("SELECT * FROM church WHERE id=" . $_SESSION['user']);

$userRow = mysql_fetch_array($res);

$church_id = $_SESSION['user'];
$error = false;

if (isset($_POST['submit'])) {
    $year = $_POST['year'];
    $comment = $_POST['comment'];

       $q1 = "SELECT * FROM income_sources WHERE church_id = '$church_id' AND financial_year =$year";
    $q11 = "SELECT * FROM budget_expenses WHERE church_id = '$church_id' AND financial_year =$year";
    $result = mysql_query($q1);
    $result1 = mysql_query($q11);
    if (mysql_num_rows($result1) == 0) {
        $error= true;
        ?>
        <script>
            alert('You Need to add income and Expenses first \n You will be redirected to expenses page ...');
            window.location.href = 'expenses.php';
        </script>
        <?php
    }
    if (mysql_num_rows($result) == 0) {
        $error=true;
        ?>
        <script>
            alert('You Need to add income and Expenses first \n You will be redirected to income page ...');
            window.location.href = 'income.php';
        </script>
        <?php
    }
    
    if (empty($year)) {
        $errMSG = "Sorry an Error Occured! Check and Try Again!";
        $error = true;
        $yrError = "Please Select Date.";
        $errTyp = "danger";
    }
    if (!file_exists('fpdf.php')) {
        echo " Place fpdf.php file in this directory before using this page. ";
        exit;
    }

    if (!file_exists('font')) {
        echo " Place font directory in this directory before using this page. ";
        exit;
    }
    require "dbconfig.php";
    // connection to database 
    require('fpdf.php');

    class PDF extends FPDF {

// Page header
 function Header()
{
    // Logo
    $this->Image('logo.png',10,6,30);
    // Arial bold 15
    $this->SetFont('Arial','B',15);
    // Move to the right
    $this->Cell(80);
    // Title
    $this->Cell(30,10,'Title',1,0,'C');
    // Line break
    $this->Ln(20);
}

// Page footer
function Footer()
{
    // Position at 1.5 cm from bottom
    $this->SetY(-15);
    // Arial italic 8
    $this->SetFont('Arial','I',8);
    // Page number
    $this->Cell(0,10,'Page '.$this->PageNo().'/{nb}',0,0,'C');
}

    }

    $pdf = new FPDF();
    $pdf->AliasNbPages();
    $pdf->AddPage();

if(!$error){

    $count = "select source_name,amount from income_sources WHERE church_id = $church_id AND financial_year =$year";
    $totalincome = " select SUM(amount) AS totalIncome from income_sources WHERE church_id = $church_id AND financial_year =$year";
    $expense = "select expense_name, amount from budget_expenses WHERE church_id = $church_id AND financial_year =$year";
    $totalexpense = " select SUM(amount) AS totalExpense from budget_expenses WHERE church_id = $church_id AND financial_year =$year";
    $church = "select name AS name from church WHERE id = $church_id";
    $fyr = mysql_query("Select year AS Fyear from financial_year where church_id =$church_id AND id=$year");
    $y_row = mysql_fetch_assoc($fyr);


// SQL to get  records 
//check if recordes exist
 


    $pdf->Image('assets/image/logo-2x.png', 100, 5, 30, 0, '', '../bextsystem');
    $pdf->Cell(10, 5);
    $pdf->SetFont('Arial', 'B', 8);
    foreach ($dbo->query($church) as $row) {
        $pdf->Ln();
        $pdf->SetLeftMargin(100);
        $pdf->Cell(20, 0, $row['name']);
        $pdf->SetLeftMargin(30);
        $pdf->Ln();
    }

    $pdf->SetFont('Arial', 'B', 20);
    $pdf->SetLeftMargin(30);
    $pdf->Cell(0, 20, '' . $y_row['Fyear'] . ' Church Proposed Operating Budget');
    $pdf->Ln();

    $pdf->SetFont('Arial', 'B', 15);
    $pdf->Cell(0, 10, 'INCOME SOURCES');
    $pdf->Ln();

    $width_cell = array(100, 50, 40, 30);
    $pdf->SetFont('Arial', 'B', 15);
    $pdf->SetFillColor(193, 229, 252); // Background color of header 
// Header starts /// 

    $pdf->Cell($width_cell[0], 10, 'SOURCE NAME', 1, 0, 'C', true); // First header column 
    $pdf->Cell($width_cell[1], 10, 'AMOUNT', 1, 0, 'C', true); // Second header column
    $pdf->Ln();

//// header ends ///////

    $pdf->SetFont('Arial', '', 14);
    $pdf->SetFillColor(235, 236, 236); // Background color of header 
    $fill = false; // to give alternate background fill color to rows 
/// each record is one row  ///
    foreach ($dbo->query($count) as $row) {
        $pdf->Cell($width_cell[0], 10, $row['source_name'], 1, 0, 'C', $fill);
        $pdf->Cell($width_cell[1], 10, $row['amount'], 1, 0, 'L', $fill);

        $pdf->Ln();
        $fill = !$fill; // to give alternate background fill  color to rows
    }
    $pdf->Ln();

    $pdf->SetFont('Arial', 'B', 16);
//$pdf->SetFillColor(0, 240, 180);
    $label = "TOTAL INCOME";
    foreach ($dbo->query($totalincome) as $row) {

        $pdf->Cell($width_cell[0], 10, $label, 0, 0, 'C', $fill);
        $pdf->Cell($width_cell[1], 10, $row['totalIncome'], 0, 0, 'C', $fill);
        global $inc;
        $inc = $row['totalIncome'];

        // to give alternate background fill  color to rows
    }
    $pdf->Ln();
    $pdf->Ln();
    $pdf->Ln();


    $pdf->SetFont('Arial', 'B', 15);
    $pdf->Cell(0, 10, 'EXPENSES ');
    $pdf->Ln();

/// Expenses///
    $pdf->SetFillColor(193, 229, 252); // Background color of header 
    $pdf->SetFont('Arial', 'B', 15);
// Header starts /// 
    $pdf->Cell($width_cell[0], 10, 'EXPENSE NAME', 1, 0, 'C', true); // First header column 
    $pdf->Cell($width_cell[1], 10, 'AMOUNT', 1, 0, 'C', true); // Second header column
    $pdf->Ln();

    $pdf->SetFont('Arial', '', 14);
    $pdf->SetFillColor(235, 236, 236); // Background color of header 
    $fill = false; // to give alternate background fill color to rows 
/// each record is one row  ///
    foreach ($dbo->query($expense) as $row) {
        $pdf->Cell($width_cell[0], 10, $row['expense_name'], 1, 0, 'C', $fill);
        $pdf->Cell($width_cell[1], 10, $row['amount'], 1, 0, 'L', $fill);

        $pdf->Ln();
        $fill = !$fill; // to give alternate background fill  color to rows
    }
    $pdf->Ln();

    $pdf->SetFont('Arial', 'B', 16);
    $label = "TOTAL PROPOSED EXPENSES";
    foreach ($dbo->query($totalexpense) as $row) {

        $pdf->Cell($width_cell[0], 10, $label, 0, 0, 'C', $fill);
        $pdf->Cell($width_cell[1], 10, $row['totalExpense'], 0, 0, 'C', $fill);

        global $exp;
        $exp = $row['totalExpense'];
        // to give alternate background fill  color to rows
    }
    $pdf->Ln();
    $pdf->Ln();
    $pdf->Ln();
    $pdf->SetFillColor(0, 240, 180);
    $lbl = "BALANCE";
    $balance = $inc - $exp;
    $pdf->Cell($width_cell[0], 10, $lbl, 0, 0, 'C', $fill);
    $pdf->Cell($width_cell[1], 10, $balance, 0, 0, 'C', $fill);
    $pdf->Ln();
    $pdf->Ln();

    $pdf->SetFont('Arial', 'B', 20);
    $pdf->Cell(0, 10, '' . $y_row['Fyear'] . ' Budget Comments');
    $pdf->SetFont('Arial', '', 10);
    $pdf->Ln();
    $pdf->Write(5, '' . $comment . '');
    

/// end of records /// 

    $pdf->Output();
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
            <h1 class="page-header">Print to Pdf</h1>
        </div>
    </div>
             
                
                               <div  id="register_form_div">
                    <form  method="post" >

                        <div  class="form-group"> 
                            <label for="fyear"> Select Year: </label>
                            <?php
                            $c_id = $_SESSION['user'];
                            $f_query = mysql_query("Select id, year from financial_year WHERE church_id = $c_id order by year DESC");

                            echo "<select title=\" Choose Financial Year\" style=\" data-toggle=\"tooltip\" height: 30px;\" class=\" w3-round-large\" name=\"year\" id=\"fyear\" value='<?php echo $year; ?>'>";

                            while ($row = mysql_fetch_array($f_query)) {
                                echo "<option value='" . $row['id'] . "'>" . $row['year'] . "</option>";
                            } echo "</select>";
                            ?>       
                        </div> 
                        <span class="text-danger"> <?php echo $yrError; ?></span>
                        <div class="form-group">
                            <label for="comment">Comments:</label>
                            <textarea class="form-control" title="enter comments"  data-toggle="tooltip" rows="5" name="comment" id="comment"></textarea>
                        </div> 

                        <div class="modal-footer">
                            <button title="Click to Print" data-toggle="tooltip" type="submit" name="submit" class="btn btn-primary" ><span class="glyphicon glyphicon-print"></span> &nbsp; Print
                            </button>
                        </div>
                    </form>
                </div>
        <
         <script type="text/javascript" src="assets/js/dateTimePicker.js"></script>  
        <script type="text/javascript" >


                        function DateCheck()
                        {
                            if (document.editform.date_from.value > document.editform.date_to.value)
                            {
                                alert("error in date.please check and continue");
                                return false;
                            } else
                            {
                                return true;
                            }
                        }

<?php include_once('includes/footer.php'); ?>
