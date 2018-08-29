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
$res = mysql_query("SELECT * FROM church WHERE id=" . $_SESSION['user']);


$userRow = mysql_fetch_array($res);

if (isset($_POST['update_password'])) {
    $church_id = $_SESSION['user'];
    // clean user inputs to prevent sql injections
    $pass = trim($_POST['password']);
    $pass = strip_tags($pass);
    $pass = htmlspecialchars($pass);

    if (empty($pass)) {
        $error = true;
         $errTyp = "danger";
        $passError = "Password Cannot be Empty!.";
        $errMSG = "An Error Occured!, Please check and try again later...";
    } else if (strlen($pass) < 6) {
        $error = true;
         $errTyp = "danger";
        $passError = "Password must have atleast 6 characters.";
        $errMSG = "An Error Occured!, Please check and try again later...";
    }
    if (!$error) {
        $password = hash('md5', $pass);
        $query = "UPDATE church SET pass = '$password' WHERE id = '$church_id'";
        if (!$result = mysql_query($query)) {
            exit(mysql_error());
        }    
    if ($query) {
        $errTyp = "success";
        $errMSG = "Successfully changed password";
        header("refresh:5;profile.php");
        unset($pass);
    } else {
        $errTyp = "danger";
        $errMSG = "Something went wrong, try again later...";
    }
    }
}
?>

<?php

if (isset($_POST['update_email'])) {
    $church_id = $_SESSION['user'];
    // clean user inputs to prevent sql injections
    $mail = trim($_POST['email']);
    $mail = strip_tags($mail);
    $mail = htmlspecialchars($mail);

     if (!filter_var($mail, FILTER_VALIDATE_EMAIL)) {
        $error = true;
        $emailError = "Please enter valid email address.";
         $errTyp = "danger";
        $errMSG = "Please Provide a New Email Address";
    } else {
        // check email exist or not
        $q1 = "SELECT email FROM church WHERE email ='$mail'";
        $results = mysql_query($q1);
        $count = mysql_num_rows($results);
        if ($count != 0) {
            $error = true;
            $errMSG = "Please Provide a Different Email";
            $errTyp = "danger";
            $emailError = "Provided Email is already in use.";
        }
    }
    
    if (!$error) {        
        $q2 = "UPDATE church SET email = '$mail' WHERE id = '$church_id'";
        if (!$resul = mysql_query($q2)) {
            exit(mysql_error());
        }
    
    if ($q2) {
        $errTyp = "success";
        $errMSG = "Successfully changed Email";
        unset($mail);
        header("refresh:5;profile.php");
    } else {
        $errTyp = "danger";
        $errMSG = "Something went wrong, try again later...";
    }
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
           <h1 align='center' class="h2"><?php echo $userRow['name']; ?> Profile. </h1>
        </div>
    </div>
                
                    <div class="modal fade animate" id="update_name_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content" style="width: 80%; margin: 0 auto">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                <h4 class="modal-title" >Update Name</h4>
                            </div>
                            <div class="modal-body" style="margin-left: 40px">
                                      <div class="form-group">
                                    <div class="input-group">
                                        <span class="input-group-addon"><span class="glyphicon glyphicon-user "></span></span>
                                        <input title="Edit Name" data-toggle="tooltip" style=" width: 80%; height: 40px;margin-top: 0px" type="text" id="update_name" placeholder="Name" class="form-control w3-round-large"/>
                                    </div>

                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" title="close" data-toggle="tooltip"  class="btn btn-default" data-dismiss="modal">Cancel</button>
                                <button type="button" title="save" data-toggle="tooltip"  class="btn btn-primary" onclick="UpdateNameDetails()" >Save Changes</button>
                                <input type="hidden" id="hidden_user_id">
                            </div>
                        </div>
                    </div>
                </div>
                
                
                
                <div class="modal fade animate" id="update_union_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content" style="width: 80%; margin: 0 auto">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                <h4 class="modal-title" >Update Country/State</h4>
                            </div>
                            <div class="modal-body" style="margin-left: 40px">
                              <div class="form-group">
                             <label for="union" >Select Union/Mission</label>
                            <div class="input-group">
                                <span class="input-group-addon"><span class="glyphicon glyphicon-globe"></span></span>
                              <select  title="union" data-toggle="tooltip" style="height:40px;margin-top: 0px" class="w3-round-large form-control"  value="<?php echo $union_mission ?>" onchange="print_conf('conference',this.selectedIndex);" id="union_mission" name ="union_mission"></select>
		               </div>
                            </div>
                        
                          <div class="form-group">
                             <label for="conference" >Select Conference</label>
                            <div class="input-group">
                                <span class="input-group-addon"><span class="glyphicon glyphicon-globe"></span></span>
                              <select title="Conference" data-toggle="tooltip" style="height:40px;margin-top: 0px" class="w3-round-large form-control"  value="<?php echo $conference ?>" id="conference" name ="conference"></select>
		             </div>
                           </div>                    
                                
                            </div>
                            <div class="modal-footer">
                                <button type="button" title="close" data-toggle="tooltip"  class="btn btn-default" data-dismiss="modal">Cancel</button>
                                <button type="button" title="save" data-toggle="tooltip"  class="btn btn-primary" onclick="UpdateUnionDetails()" >Save Changes</button>
                                <input type="hidden" id="hidden_user_id">
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="modal fade animate" id="update_mobile_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content" style="width: 80%; margin: 0 auto">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                <h4 class="modal-title" id="myModalLabel">Update Mobile</h4>
                            </div>
                            <div class="modal-body" style="margin-left: 40px">
                                      <div class="form-group">
                                    <div class="input-group">
                                        <span class="input-group-addon"><span class="glyphicon glyphicon-phone "></span></span>
                                        <input title="Edit Mobile" data-toggle="tooltip" style=" width: 80%; height: 40px;margin-top: 0px" type="text" id="update_mobile" placeholder="Mobile" class="form-control w3-round-large"/>
                                    </div>

                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" title="close" data-toggle="tooltip"  class="btn btn-default" data-dismiss="modal">Cancel</button>
                                <button type="button" title="save" data-toggle="tooltip"  class="btn btn-primary" onclick="UpdateMobileDetails()" >Save Changes</button>
                                <input type="hidden" id="hidden_user_id">
                            </div>
                        </div>
                    </div>
                </div>
                
                    
               
               
                <div class="clearfix">

                </div>
                <div> 
                     <?php
                        if (isset($errMSG)) {
                            ?>
                            <div class="form-group">
                                <div class="alert alert-<?php echo ($errTyp == "success") ? "success" : $errTyp; ?>">
                                    <span class="glyphicon glyphicon-info-sign"></span> <?php echo $errMSG; ?>
                                </div>
                            </div>  
                        <?php } ?>
                </div>
                <div id="email" class="collapse">
                     <div class=" page-header"><h3 > Change Email</h3></div>
                <form style="margin-bottom: 0px" class='frm'  method="post" autocomplete="off">
                    <div style="padding-right: 50px" class="form-group side">
                        <div class="input-group">
                            <label> New Email</label>
                            <input type="email" style="max-width: 200px;height: 35px;" data-toggle="tooltip" name="email" title="Enter Your New Email" class="form-control"  value="<?php echo $mail; ?>" maxlength="40"/>
                        </div>
                        <span class="text-danger"><?php echo $emailError; ?></span>
                    </div>                   

                    <div style="padding: 25px; margin-bottom: 0px" class=" ">                    
                        <button type="submit" title="Save Email" data-toggle="tooltip"  name="update_email" class=" btn btn-info" ><span class="glyphicon glyphicon-save"></span> Save</button>
                    </div>

                </form>
                    </div>
                
                  
                <div class="clearfix">

                </div>
                  <div class="collapse" id="pwd">
                      <div class=" page-header"><h3 > Change Password</h3></div>
                  <form style="margin-bottom: 0px"class='frm animate'  name="profile" method="post" autocomplete="off">
                    <div style="padding-right: 50px" class="form-group sideside">
                        <div class="form-group">
                            <label> New Password</label>
                            <input type="password" style="max-width: 200px;height: 35px;padding-right: 20px" name="password" data-toggle="tooltip" data-toggle="tooltip" data-toggle="tooltip" data-toggle="tooltip" data-toggle="tooltip" data-toggle="tooltip"  title="Enter Your New Password" class="form-control"  value="<?php echo $pass; ?>" maxlength="40"/>
                        </div>
                        <span class="text-danger"><?php echo $passError; ?></span>
                    </div>

                    <div class="form-group sideside">
                        <label> Confirm Password</label>
                        <input type="password" style="max-width: 200px;height: 35px" title="Confirm Your New Password"  data-toggle="tooltip" name="confirm" class="form-control" maxlength="40" />
                    </div>

                    <div style="padding-top: 25px" class="form-group ">                    
                        <button type="submit" title="Save Password" data-toggle="tooltip"  name="update_password" class=" btn btn-info" onclick="return validatePassword()" ><span class="glyphicon glyphicon-save"></span> Save</button>
                    </div>

                </form>
                  </div>
                
                 <div class="row">
                    <div class="col-md-12">


                        <div  class="animate records_content"></div>
                    </div>

                </div>
           </div>
                    <script src="assets/js/profile.js"></script> 
        <script type= "text/javascript" src = "assets/js/conferences.js"></script>
        <script language="javascript">print_union("union_mission");</script> 
       <script type="text/javascript">

                        function validatePassword()
                        {
                            if (document.profile.password.value !== document.profile.confirm.value) {
                                alert("Your passwords did not match!. Please check and try again");


                                return false;
                            } else {
                                return true;
                            }
                        }
      </script>
<?php include_once('includes/footer.php'); ?>
