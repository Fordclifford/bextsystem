<?php

session_start();
include("config.php");

// if session is not set this will redirect to login page

require_once '../../includes/auth_validate.php';

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
        $pdf->SetLeftMargin(20);
        $pdf->Ln();
        
         $pdf->Cell(10, 20, 'Bills Posted in between ' . $datefrom->format('d-m-Y').' and '.$dateto->format('d-m-Y') .'');
        $pdf->Ln();
       

      

        $query = "SELECT * FROM bill bb WHERE church_id='$church_id' AND date  BETWEEN '$from' AND '$to'";
        $result = mysql_query($query);

        if (mysql_num_rows($result) == 0) {
            $error = true;
            
          echo $_SESSION['failure'] ='No Bills found between ' .$from. ' and '. $to.' !';
         
   	header('location: ../../bills.php');
         exit;
        } 
if(!$error){
        $bills = "SELECT source, amount,date,mode_of_payment, description from bill WHERE church_id='$church_id' AND date  BETWEEN '$from' AND '$to' ORDER BY date DESC";
        $totalBills = " SELECT SUM(amount) AS totalBill from bill WHERE church_id='$church_id' AND date  BETWEEN '$from' AND '$to' ";
         $income = "SELECT source_name from actual_income WHERE church_id='$church_id' AND date_added  BETWEEN '$from' AND '$to' ORDER BY date_added DESC";
       

        if (!$resu = mysql_query($bills)) {
            exit(mysql_error());
        }
        if (!$resu = mysql_query($income)) {
            exit(mysql_error());
        }
        if (!$total = mysql_query($totalBills)) {
            exit(mysql_error());
        }
       
        $width_cell = array(50, 25, 25, 25, 50);
        $pdf->SetFillColor(193, 229, 252); // Background color of header
// Header starts ///
        $pdf->Cell($width_cell[0], 10, 'SOURCE ', 1, 0, 'C', true); // First header column
        $pdf->Cell($width_cell[1], 10, 'AMOUNT', 1, 0, 'C', true); // Second header column
        $pdf->Cell($width_cell[2], 10, 'DATE', 1, 0, 'C', true); // Second header column
        $pdf->Cell($width_cell[3], 10, 'MODE', 1, 0, 'C', true); // Second header column
        $pdf->Cell($width_cell[4], 10, 'DESCRIPTION', 1, 0, 'C', true); // Second header column
        
        $pdf->Ln();
         

//// header ends ///////

        $pdf->SetFont('Arial', '', 10);
        $pdf->SetFillColor(235, 236, 236); // Background color of header
        $fill = false; // to give alternate background fill color to rows
/// each record is one row  ///
        foreach ($dbo->query($bills) as $row) {
              
           
                $pdf->Cell($width_cell[0], 10, $irow['source_name'], 1, 0, 'C', $fill);
                $pdf->Cell($width_cell[1], 10, $row['amount'], 1, 0, 'L', $fill);
                $pdf->Cell($width_cell[2], 10, $row['date'], 1, 0, 'L', $fill);
                $pdf->Cell($width_cell[3], 10, $row['mode_of_payment'], 1, 0, 'L', $fill);
                 $pdf->Cell($width_cell[4], 10, $row['description'], 1, 0, 'L', $fill);
               
                $pdf->Ln();
                $fill = !$fill; // to give alternate background fill  color to rows
            
        
        }




        $pdf->SetFont('Arial', 'B', 16);
        $width_cells = array(80, 50);
        $label = "TOTAL BILLS";
        foreach ($dbo->query($totalBills) as $row) {
            $pdf->Ln();
            $pdf->SetFillColor(0, 240, 180);
            $pdf->Cell($width_cells[0], 10, $label, 0, 0, 'C', $fill);
            $pdf->Cell($width_cells[1], 10, $row['totalBills'], 0, 0, 'C', $fill);
            $pdf->Ln();
           

            // to give alternate background fill  color to rows
        }
       
     
 $pdf->Output('billsPdf.pdf','D');
}
}
}

?>      
            


