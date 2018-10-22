<?php
ob_start();
session_start();
require_once 'config.php';

// if session is not set this will redirect to login page
if (!isset($_SESSION['user_logged_in'])) {
    header("Location: index.php");
    exit;
}
// select loggedin users detail

if (isset($_POST['update_password'])) {
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
        $query = "UPDATE users SET passwd = '$password' WHERE id =".$_SESSION['user'];
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
        $q1 = "SELECT email FROM users WHERE email ='$mail'";
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
        $q2 = "UPDATE users SET email = '$mail' WHERE id =".$_SESSION['user'];
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
 include_once './includes/header.php';
 ?>

<?php if (isset($_SESSION['user_logged_in']) && $_SESSION['user_logged_in'] == true) :
     include_once './sidenav.php';
    ?>

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
