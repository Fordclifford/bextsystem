
<?php include_once './includes/header.php';
session_start();
require_once 'includes/auth_validate.php';
?>


<?php if (isset($_SESSION['user_logged_in']) && $_SESSION['user_logged_in'] == true) :
     include_once './sidenav.php';
    ?>

<?php endif; ?>
<div id="page-wrapper">
    <div class="row">

        <div class="col-lg-6">
            <h1 class="page-header">Actual Income</h1>
        </div>
       
    </div>
    <?php require_once 'includes/flash_messages.php'; ?>
    <div id="alert_message"></div>
   
<div >
        <div >

            <form onsubmit="return DateCheck();" action="ajax/income/actualIncomeExcel.php" id="excel_form" name="excel_form" method="post" class="well form-horizontal ">
                <div class="modal-header">
                       <h4 class="modal-title" id="myModalLabel">Exporting Actual Income to Excel </h4>
                </div>
                <div class="modal-body"  >
                    <fieldset>
                        <div class="form-group">
                        <div class="row">
                             <div class="col-md-1"></div>
                            <div class="col-md-3">
                                  <label >From Date</label>
                                       <input type="date" style="height:40px"  name="from_date"  id="from_date" placeholder="From Date " class="form-control w3-round-large"  autocomplete="off">
 
                            </div>
                            <div class="col-md-3">
                                <label >To Date</label>
                              <input type="date" style="height:40px" name="to_date"  id="to_date" placeholder="TO Date " class="form-control w3-round-large"  autocomplete="off">

                                </div>
                           <div class="col-md-1"></div>
                            <div class="col-md-2">
                               
                                <button type="submit" name="submit" style="margin-top: 25px"  title="Go" data-toggle="tooltip"  class="btn btn-primary" ><span class=" glyphicon glyphicon-export"></span> Go</button>
                
                            </div> 
                            
                        </div>
                        </div>
                        
                        <div class="form-group"></div>
                        <div class="form-group"></div>
                        
                    </fieldset>
                </div>
                
            </form>

        </div>
    </div>
</div>

<?php include_once('includes/footer.php'); ?>
<script src="includes/js/notif.js" type="text/javascript"></script>
 <script type="text/javascript" >


                        function DateCheck()
                        {
                           
                            if (document.excel_form.from_date.value > document.excel_form.to_date.value)
                            {
                                alert("error in date.please check and continue");
                                return false;
                            } else
                            {
                                return true;
                            }
                        }
                        </script>
                        


