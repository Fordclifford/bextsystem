<?php
ob_start();
session_start();
require_once 'config.php';

// if session is not set this will redirect to login page
if (!isset($_SESSION['user'])) {
    header("Location: index.php");
    exit;
}
$error =false;
// select loggedin users detail
$res = mysql_query("SELECT * FROM church WHERE id=" . $_SESSION['user']);


$userRow = mysql_fetch_array($res);
if (isset($_POST['submit'])) {
    $comment = $_POST['comment'];
    $yr = $_POST['year'];

    $church_id = $_SESSION['user'];
    if (!file_exists('fpdf.php')) {
        echo " Place fpdf.php file in this directory before using this page. ";
        exit;
    }

    if (!file_exists('font')) {
        echo " Place font directory in this directory before using this page. ";
        exit;
    }

    require "dbconfig.php"; // connection to database 
    require('fpdf.php');

    class PDF extends FPDF {

// Page header
        function Header() {
            global $title;

            // Arial bold 15
            $this->SetFont('Arial', 'B', 15);
            // Calculate width of title and position
            $w = $this->GetStringWidth($title) + 6;
            $this->SetX((210 - $w) / 2);
            // Colors of frame, background and text
            $this->SetDrawColor(0, 80, 180);
            $this->SetFillColor(230, 230, 0);
            $this->SetTextColor(220, 50, 50);
            // Thickness of frame (1 mm)
            $this->SetLineWidth(1);
            // Title
            $this->Cell($w, 9, $title, 1, 1, 'C', true);
            // Line break
            $this->Ln(10);
        }

        function Footer() {
            // Position at 1.5 cm from bottom
            $this->SetY(-15);
            // Arial italic 8
            $this->SetFont('Arial', 'I', 8);
            // Text color in gray
            $this->SetTextColor(128);
            // Page number
            $this->Cell(0, 10, 'Page ' . $this->PageNo(), 0, 0, 'C');
        }

    }

    $id_q = "SELECT year AS year FROM financial_year WHERE id= '$yr' AND church_id='$church_id'";
    $q_result = mysql_query($id_q);
    $r_count = mysql_fetch_array($q_result);
    $year = $r_count['year'];

  
        $pdf = new FPDF();
        $pdf->AliasNbPages();
        $pdf->AddPage();
        $pdf->SetFont('Arial', 'B', 14);

        $pdf->Image('assets/image/logo-2x.png', 100, 5, 30, 0, '', '../bextsystem');
        $pdf->SetLeftMargin(30);
        $pdf->Ln();

        $pdf->Cell(10, 20, 'Bills Posted in ' . $year . '');
        $pdf->Ln();

        $q1 = "SELECT * FROM bill WHERE financial_year='$yr' AND church_id = '$church_id'";
        $result = mysql_query($q1);

        if (mysql_num_rows($result) == 0) {
            $error = true;
            ?>
            <script>
                alert('No Bills found for that year!\n You Need to add bills first \n You will be redirected to bills page ...');
                window.location.href = 'bills.php';
            </script>
            <?php
        }
if(!$error){
        $count = "SELECT source, amount, date, description,mode_of_payment from bill WHERE financial_year='$yr' AND church_id = '$church_id' ORDER BY date DESC";
        $totalbills = " SELECT SUM(amount) AS totalBill from bill WHERE financial_year='$yr' AND church_id = '$church_id' ";


        if (!$resu = mysql_query($count)) {
            exit(mysql_error());
        }
        if (!$total = mysql_query($totalbills)) {
            exit(mysql_error());
        }

        $width_cell = array(50, 25, 25, 40,30);
        $pdf->SetFillColor(193, 229, 252); // Background color of header 
// Header starts /// 
        $pdf->Cell($width_cell[0], 10, 'SOURCE ', 1, 0, 'C', true); // First header column 
        $pdf->Cell($width_cell[1], 10, 'AMOUNT', 1, 0, 'C', true); // Second header column
        $pdf->Cell($width_cell[2], 10, 'DATE', 1, 0, 'C', true); // Second header column
        $pdf->Cell($width_cell[3], 10, 'DESCRIPTION', 1, 0, 'C', true); // Second header column
        $pdf->Cell($width_cell[4], 10, 'MODE', 1, 0, 'C', true); // Second header column
        $pdf->Ln();

//// header ends ///////

        $pdf->SetFont('Arial', '', 10);
        $pdf->SetFillColor(235, 236, 236); // Background color of header 
        $fill = false; // to give alternate background fill color to rows 
/// each record is one row  ///
        foreach ($dbo->query($count) as $row) {
            $sids = $row['source'];
            $que = mysql_query("SELECT expense_name FROM budget_expenses WHERE church_id = $church_id AND sid = $sids");
            while ($rows = mysql_fetch_assoc($que)) {

                $pdf->Cell($width_cell[0], 10, $rows['expense_name'], 1, 0, 'C', $fill);
                $pdf->Cell($width_cell[1], 10, $row['amount'], 1, 0, 'L', $fill);
                $pdf->Cell($width_cell[2], 10, $row['date'], 1, 0, 'L', $fill);
                $pdf->Cell($width_cell[3], 10, $row['description'], 1, 0, 'L', $fill);
                 $pdf->Cell($width_cell[4], 10, $row['mode_of_payment'], 1, 0, 'L', $fill);

                $pdf->Ln();
                $fill = !$fill; // to give alternate background fill  color to rows
            }
        }




        $pdf->SetFont('Arial', 'B', 16);
        $width_cells = array(50, 50);
        $label = "TOTAL BILLS";
        foreach ($dbo->query($totalbills) as $row) {
            $pdf->Ln();
            $pdf->SetFillColor(0, 240, 180);
            $pdf->Cell($width_cells[0], 10, $label, 0, 0, 'C', $fill);
            $pdf->Cell($width_cells[1], 10, $row['totalBill'], 0, 0, 'C', $fill);
            $pdf->Ln();
            $pdf->Ln();

            // to give alternate background fill  color to rows
        }

        $pdf->SetFont('Arial', 'B', 20);
        $pdf->Cell(0, 10, 'Report Comments/Reccomendations');
        $pdf->SetFont('Arial', '', 10);
        $pdf->Ln();
        $pdf->Write(5, '' . $comment . '');



        $pdf->Output();
   
}
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
                <header id="pageheader" class="w3-round-large homeheader">

                </header>  
                <div class="topnav w3-round-xlarge" id="myTopnav">
                    <a href="home.php"> <i class="glyphicon glyphicon-home"></i> Home</a>
                    <a href="budget.php"> <i class="glyphicon glyphicon-usd"></i> Budget</a>
                    <a href="expenses.php"> <i class="glyphicon glyphicon-apple"></i> Expenses</a>
                    <a href="bills.php"> <i class="glyphicon glyphicon-registration-mark"></i> Bills</a>
                    <a href="income.php"> <i class="glyphicon glyphicon-usd"></i> Income</a>                    

                    <a href="javascript:void(0);" class="icon" onClick="myFunction()">&#9776;</a>

                </div>
                <div style="margin-top: 10px" class ="btn-group w3-round-large buttoncontainer">
                    <div class="sidebyside"><a href="bills.php" class="btn btn-success w3-round-large " >&laquo; Back  </a></div>
                </div>

                <div  id="register_form_div">


                    <form  method="post" name="editform" onsubmit="return DateCheck()">

                        <?php
                        if (isset($errMSG)) {
                            ?>
                            <div class="form-group">
                                <div class="alert alert-<?php echo ($errTyp == "success") ? "success" : $errTyp; ?>">
                                    <span class="glyphicon glyphicon-info-sign"></span> <?php echo $errMSG; ?>
                                </div>
                            </div>  
<?php } ?>
                        <div  class="form-group"> 
                            <label for="fyear"> Select Financial Year: </label>
                            <?php
                            $c_id = $_SESSION['user'];
                            $f_query = mysql_query("Select id, year from financial_year WHERE church_id = $c_id order by year DESC");

                            echo "<select title=\" Choose Financial Year\" style=\" data-toggle=\"tooltip\" height: 30px;\" class=\" w3-round-large\" name=\"year\" id=\"fyear\" value='<?php echo $year; ?>'>";

                            while ($row = mysql_fetch_array($f_query)) {
                                echo "<option value='" . $row['id'] . "'>" . $row['year'] . "</option>";
                            } echo "</select>";
                            ?>       
                        </div> 
                        <div class="form-group">
                            <label for="comment">Comments/Reccomendations:</label>
                            <textarea class="form-control" title="Enter comments or recommedations for the report" data-toggle="tooltip" rows="5" name="comment" id="comment"></textarea>
                        </div> 



                        <div class="modal-footer">
                            <button title="Click to Clear Input" type="reset" value="reset" class="btn btn-default" ><span class="glyphicon glyphicon-erase"></span> Clear</button>
                            <button title="Click to Print " type="submit" name="submit" class="btn btn-primary" ><span class="glyphicon glyphicon-print"></span> &nbsp; Print
                            </button>
                        </div>
                    </form>
                </div>
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

        </script>
        <script>
            $(document).ready(function () {
                $('[data-toggle="tooltip"]').tooltip();
            });
        </script>


    </body>

</html>
<?php ob_end_flush(); ?>