<?Php
ob_start();
session_start();
require_once 'config.php';
if (!isset($_SESSION['user_logged_in'])) {
    header("Location: index.php");
    exit;
}
// select loggedin users detail


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
            <h1 class="page-header">Print to Pdf</h1>
        </div>
    </div>


               <div>          
                   <form action="ajax/budget/printBudgetPdf.php" method="post" >

                        <div  class="form-group">
                            <label for="fyear"> Select Year: </label>
                            <?php
                            $c_id = $_SESSION['church'];
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
           </div>
        </div>
    
    
<?php include_once('includes/footer.php'); ?>
    <script src="includes/js/est_expense.js" type="text/javascript"></script>