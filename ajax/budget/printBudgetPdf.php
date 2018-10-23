<?Php

session_start();

require_once 'config.php';
if (!isset($_SESSION['user_logged_in'])) {
    header("Location: index.php");
    exit;
}
// select loggedin users detail

 $church_id = $_SESSION['church'];
$error = false;

if (isset($_POST['submit'])) {
   
   
    $year = $_POST['year'];
    $comment = $_POST['comment'];

       $q1 = "SELECT * FROM estimated_income WHERE church_id = '$church_id' AND financial_year =$year";
    $q11 = "SELECT * FROM estimated_expenses WHERE church_id = '$church_id' AND financial_year =$year";
    $result = mysql_query($q1);
    $result1 = mysql_query($q11);
    if (mysql_num_rows($result1) == 0) {
        $error= true;
        ?>
        <script>
            alert('You Need to add income and Expenses first \n You will be redirected to expenses page ...');
            window.location.href = '../../estimated_expenses.php';
        </script>
        <?php
    }
    if (mysql_num_rows($result) == 0) {
        $error=true;
        ?>
        <script>
            alert('You Need to add income and Expenses first \n You will be redirected to income page ...');
            window.location.href = '../../estimated_income.php';
        </script>
        <?php
    }

 
    if (!file_exists('../../fpdf.php')) {
        echo " Place fpdf.php file in this directory before using this page. ";
        exit;
    }

    if (!file_exists('../../font')) {
        echo " Place font directory in this directory before using this page. ";
        exit;
    }
    require "dbconfig.php";
    // connection to database
    require('../../fpdf.php');

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

    $count = "select source_name,amount from estimated_income WHERE church_id = $church_id AND financial_year =$year";
    $totalincome = " select SUM(amount) AS totalIncome from estimated_income WHERE church_id = $church_id AND financial_year =$year";
    $expense = "select expense_name, amount from estimated_expenses WHERE church_id = $church_id AND financial_year =$year";
    $totalexpense = " select SUM(amount) AS totalExpense from estimated_expenses WHERE church_id = $church_id AND financial_year =$year";
    $church = "select name AS name from church WHERE id = $church_id";
    $fyr = mysql_query("Select year AS Fyear from financial_year where AND id=$year");
    $y_row = mysql_fetch_assoc($fyr);


// SQL to get  records
//check if recordes exist



    $pdf->Image('../../assets/image/logo-2x.png', 100, 5, 30, 0, '', '../../index.php');
    $pdf->Cell(10, 5);
    $pdf->SetFont('Arial', 'B', 8);
    foreach ($dbo->query($church) as $row) {
        echo 'yes'.$row['name'];
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
