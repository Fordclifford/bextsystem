<?php

session_start();
include("config.php");

// if session is not set this will redirect to login page
if (!isset($_SESSION['user_logged_in'])) {
    header("Location: index.php");
    exit;
}

$error =false;
// select loggedin users detail
if ($_SESSION['user_type'] == 'treasurer') { 
 if (isset($_POST['submit'])) {
    $from= $_POST['from_date'];
    $to= $_POST['to_date'];
$datefrom = new DateTime($from);
$dateto = new DateTime($to);
  $to=$dateto->format('Y-m-d H:i:s');
  $from=$datefrom->format('Y-m-d H:i:s');

    $church_id = $_SESSION['church'];
    if (!file_exists('../../fpdf.php')) {
        echo " Place fpdf.php file in this directory before using this page. ";
        exit;
    }

    if (!file_exists('../../font')) {
        echo " Place font directory in this directory before using this page. ";
        exit;
    }

    require "dbconfig.php"; // connection to database
    require('../../fpdf.php');

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


        $pdf = new FPDF();
        $pdf->AliasNbPages();
        $pdf->AddPage();
        $pdf->SetFont('Arial', 'B', 14);

        $pdf->Image('../../assets/image/logo-2x.png', 100, 5, 30, 0, '', '../bextsystem');
        $pdf->SetLeftMargin(30);
        $pdf->Ln();
        
         $pdf->Cell(10, 20, 'Income Posted in between ' . $datefrom->format('d-m-Y').' and '.$dateto->format('d-m-Y') .'');
        $pdf->Ln();
       

      

        $q1 = "SELECT * FROM actual_income WHERE church_id=$church_id AND date_added  BETWEEN '$from' AND '$to' ";
        $result = mysql_query($q1);

        if (mysql_num_rows($result) == 0) {
            $error = true;
            
          echo $_SESSION['failure'] ='No Income found between ' .$from. ' and '. $to.' !';
         
   	header('location: ../../actualIncomePdf.php');
         exit;
        } 
if(!$error){
        $count = "SELECT source_name, amount, date_added,balance from actual_income WHERE church_id='$church_id' AND date_added  BETWEEN '$from' AND '$to' ORDER BY date_added DESC";
        $totalIncome = " SELECT SUM(amount) AS totalIncome from actual_income WHERE church_id='$church_id' AND date_added  BETWEEN '$from' AND '$to' ";


        if (!$resu = mysql_query($count)) {
            exit(mysql_error());
        }
        if (!$total = mysql_query($totalIncome)) {
            exit(mysql_error());
        }
       
        $width_cell = array(50, 25, 50, 25);
        $pdf->SetFillColor(193, 229, 252); // Background color of header
// Header starts ///
        $pdf->Cell($width_cell[0], 10, 'SOURCE ', 1, 0, 'C', true); // First header column
        $pdf->Cell($width_cell[1], 10, 'AMOUNT', 1, 0, 'C', true); // Second header column
        $pdf->Cell($width_cell[2], 10, 'DATE', 1, 0, 'C', true); // Second header column
        $pdf->Cell($width_cell[3], 10, 'BALANCE', 1, 0, 'C', true); // Second header column
        $pdf->Ln();

//// header ends ///////

        $pdf->SetFont('Arial', '', 10);
        $pdf->SetFillColor(235, 236, 236); // Background color of header
        $fill = false; // to give alternate background fill color to rows
/// each record is one row  ///
        foreach ($dbo->query($count) as $row) {
           
                $pdf->Cell($width_cell[0], 10, $row['source_name'], 1, 0, 'C', $fill);
                $pdf->Cell($width_cell[1], 10, $row['amount'], 1, 0, 'L', $fill);
                $pdf->Cell($width_cell[2], 10, $row['date_added'], 1, 0, 'L', $fill);
                $pdf->Cell($width_cell[3], 10, $row['balance'], 1, 0, 'L', $fill);
                
                $pdf->Ln();
                $fill = !$fill; // to give alternate background fill  color to rows
            
        }




        $pdf->SetFont('Arial', 'B', 16);
        $width_cells = array(80, 50);
        $label = "TOTAL ACTUAL INCOME";
        foreach ($dbo->query($totalIncome) as $row) {
            $pdf->Ln();
            $pdf->SetFillColor(0, 240, 180);
            $pdf->Cell($width_cells[0], 10, $label, 0, 0, 'C', $fill);
            $pdf->Cell($width_cells[1], 10, $row['totalIncome'], 0, 0, 'C', $fill);
            $pdf->Ln();
           

            // to give alternate background fill  color to rows
        }
       
       $pdf->Output('actualIncomePdf.pdf','D');

}
}
}

?>      
            


