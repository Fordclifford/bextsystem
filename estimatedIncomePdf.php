
<?php include_once './includes/header.php';
session_start();
require_once 'includes/auth_validate.php';
?>


<?php if (isset($_SESSION['user_logged_in']) && $_SESSION['user_logged_in'] == true) : ?>
   <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="">Income & Expense Tracker</a>
        </div>
        <!-- /.navbar-header -->

        <ul class="nav navbar-top-links navbar-right">
            <!-- /.dropdown -->

            <!-- /.dropdown -->
            <li>  <a name="button" id="notification-icon" name="button" onclick="myFunction()" class="notification">
                    <i class="fa fa-envelope fa-fw"></i><?php if ($count > 0) { ?>
                        <span class="badge" id="notification-count" ><?php
                            echo $count;
                        }
                        ?></span>
                </a> <div id="notification-latest"></div>
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
                        <a href="index.php"><i class="fa fa-dashboard fa-fw"></i> Dashboard</a>
                    </li>
                    <li>           
                        <a href="actual_income.php"> <i class="glyphicon glyphicon-usd"></i>Actual Income</a>
                        <ul class="nav nav-second-level">
                             <li>
                                <a href="actual_income.php"><i class="fa fa-list fa-fw"></i>List all</a>
                            </li>
                            <li>
                                <a href="actualIncomePdf.php" ><i class="fa fa-file-pdf-o fa-fw"></i>Export pdf</a>
                            </li>
                            <li>
                                <a href="actualIncomeExcel.php" ><i class="fa fa-file-excel-o fa-fw"></i>Export Excel</a>
                            </li>
                        </ul>
                    </li>


                    <li>
                        <a href="bills.php"><i class="glyphicon glyphicon-registration-mark fa-fw"></i> Bills<span class="fa arrow"></span></a>
                        <ul class="nav nav-second-level">
                            <li>
                                <a href="bills.php"><i class="fa fa-list fa-fw"></i>List all</a>
                            </li>
                            <li>
                                <a href="addbill.php"><i class="fa fa-plus fa-fw"></i>Add New</a>
                            </li>
                            <li>
                                <a href="exportBillsPdf.php" ><i class="fa fa-file-pdf-o fa-fw"></i>Export pdf</a>
                            </li>
                            <li>
                                <a href="exportBillsExcel.php" ><i class="fa fa-file-excel-o fa-fw"></i>Export Excel</a>
                            </li>
                        </ul>
                    </li>

                    <li >
                        <a href="budget.php"><i class="glyphicon glyphicon-briefcase fa-fw"></i> Budget<span class="fa arrow"></span></a>
                        <ul class="nav nav-second-level">
                             <li <?php echo (CURRENT_PAGE == "estimated_income.php" || CURRENT_PAGE == "estimated_income.php") ? 'class="active"' : ''; ?>>
                              
                                <a href="estimated_income.php"><i class="fa fa-dollar fa-fw"></i>Estimated Income</a>
                           <ul class="nav nav-third-level">
                            <li>
                                <a href="estimated_income.php"><i class="fa fa-list fa-fw"></i>List all</a>
                            </li>
                          
                            <li>
                                <a href="estimatedIncomePdf.php" ><i class="fa fa-file-pdf-o fa-fw"></i>Export pdf</a>
                            </li>
                            <li>
                                <a href="estimatedIncomeExcel.php" ><i class="fa fa-file-excel-o fa-fw"></i>Export Excel</a>
                            </li>
                        </ul>
                            </li>
                            <li>
                                <a href="estimated_expenses.php"><i class="fa fa-list fa-fw"></i>Estimated Expenses</a>

                            </li>
                        </ul>
                    </li>
                    <li>
                        <a href="balance.php"> <i class="glyphicon glyphicon-btc"></i> Balance</a>

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

        <div class="col-lg-6">
            <h1 class="page-header">Estimated Income</h1>
        </div>
        
    </div>
    <?php require_once 'includes/flash_messages.php'; ?>
    <div id="alert_message"></div>
   
<div >
        <div >

            <form onsubmit="return DateCheck()" action="ajax/income/estimatedIncomePdf.php" id="excel_form" name="excel_form" method="post" class="well form-horizontal ">
                <div class="modal-header">
                       <h4 class="modal-title" id="myModalLabel">Exporting Estimated Income to Pdf </h4>
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
                        


