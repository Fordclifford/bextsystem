<?php
ob_start();
session_start();
require_once 'config.php';

// it will never let you open index(login) page if session is set
if (isset($_SESSION['user'])) {
    unset($_SESSION['user']);    
    session_destroy();
}


$error = false;

if (isset($_POST['btn-login'])) {

    // prevent sql injections/ clear user invalid inputs
    $email = trim($_POST['email']);
    $email = strip_tags($email);
    $email = htmlspecialchars($email);

    $pass = trim($_POST['password']);
    $pass = strip_tags($pass);
    $pass = htmlspecialchars($pass);
    // prevent sql injections / clear user invalid inputs

    if (empty($email)) {
        $error = true;
        $errMSG = "Error! Empty mail/password!";
        $emailError = "Please enter your email";
    } else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = true;
        $errMSG = "Input Error! Invalid Email";
        $emailError = "Please enter valid email";
    }

    if (empty($pass)) {
        $error = true;
        $errMSG = "Input Error! Empty mail/password";
        $passError = "Please enter your password.";
    }
	
	 $res = mysql_query("SELECT id, status, name, pass FROM church WHERE email='$email'");
              
        $row = mysql_fetch_array($res);
       $status="pending";
	   if($row['status']== $status){
		   $error = true;
        $errMSG = "Your account has not been activated! please check your email";
	   }		  

    // if there's no error, continue to login
    if (!$error) {
        $password = hash('md5', $pass); // password hashing using SHA256
         $count = mysql_num_rows($res); // if uname/pass correct it returns must be 1 row
               
           if ($count == 1 &&  $row['pass'] == $password) {
            $_SESSION['user'] = $row['id'];
             $_SESSION['name'] = $row['name'];
            header("Location: home.php");
        } else {
            $errMSG = "Incorrect Credentials, Try again..";
        }
    }
}

if (isset($_POST['auditor-login'])) {

    // prevent sql injections/ clear user invalid inputs
    $auemail = trim($_POST['auemail']);
    $auemail = strip_tags($auemail);
    $auemail = htmlspecialchars($auemail);

    $aupass = trim($_POST['aupassword']);
    $aupass = strip_tags($aupass);
    $aupass = htmlspecialchars($aupass);
    // prevent sql injections / clear user invalid inputs

    if (empty($auemail)) {
        $error = true;
         ?>
    <script>
        alert('Input Error! Empty mail/password');
        window.location.href = 'index.php';
    </script>
    <?php 
        $auemailError = "Please enter your email";
    } else if (!filter_var($auemail, FILTER_VALIDATE_EMAIL)) {
        $auerror = true;
         ?>
    <script>
        alert('Input Error! Invalid Email');
        window.location.href = 'index.php';
    </script>
    <?php 
        $auemailError = "Please enter valid email";
    }

    if (empty($aupass)) {
        $auerror = true;
      ?>
    <script>
        alert('Input Error! Empty mail/password');
        window.location.href = 'index.php';
    </script>
    <?php       
        $aupassError = "Please enter your password.";
    }

    // if there's no error, continue to login
    if (!$auerror) {

        $aupassword = hash('sha256', $pass); // password hashing using SHA256

        $aures = mysql_query("SELECT id, email, password FROM conference WHERE email='$auemail'");
        $aurow = mysql_fetch_array($aures);
        $aucount = mysql_num_rows($aures); // if uname/pass correct it returns must be 1 row

        if ($aucount == 1 && $row['password'] == $aupassword) {
            $_SESSION['user'] = $aurow['id'];
             header("Location: home.php");
        } else {
             ?>
    <script>
        alert('Incorrect Credentials, Try again..');
       
    </script>
    <?php
            
        }
    }
}
?>

<!DOCTYPE html>
<html>
    <head>

        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>B&E Tracker</title>
        <link rel="shortcut icon" href="assets/image/favicon.png" type="image/x-icon" />
        <link rel="stylesheet" href="assets/css/bootstrap.min.css" type="text/css"  />
        <link rel="stylesheet" href="assets/css/style.css" type="text/css"/>
        <link rel="stylesheet" href="assets/css/style2.css" type="text/css"/>
        <link rel="stylesheet" href="assets/css/w3.css" type="text/css"/>
        <link rel="stylesheet" href="assets/css/font-awesome.min.css" type="text/css"/>
    </head>
    <body>
        <div id="wrap">

            <section  id="top">

            </section>
            <section id="page">
                <header id="pageheader" class="w3-round-xlarge homeheader">

                </header>
                <div style="padding: 3px"></div>
                <div class="topnav w3-round-xlarge" id="myTopnav" >
                    <a href="index.php"><i class="glyphicon glyphicon-home"></i> Home</a>
                    <a style="margin-left: 25%" href="index.php"><i class="glyphicon glyphicon-log-in"></i> Login</a>
                    <a class="navbar-right" href="register/"><i class="glyphicon glyphicon-registration-mark"></i> Register</a>
                    <a href="javascript:void(0);" class="icon" onClick="myFunction()">&#9776;</a>

                </div>             

                <div class="login_form_div w3-round-large" >
                    <div style="background-color: tomato">
                        <div class="form-group w3-round-large" style="padding: 20px">


                            <input value="2" type="radio" checked="true" name="formselector" title="select to login as a treasurer" onClick="displayForm(this)"></input><label> Local Church Treasurer Login</label>
                         <br />
                        <input value="1" type="radio" name="formselector" title=" select to login as a conference auditor" onClick="displayForm(this)"></input><label> Conference Treasurer/Auditor Login</label>

                    </div>
                    </div>

                    <div style="position:relative;" id="trformContainer">

                        <form id="trform" method="post" class="animate" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" autocomplete="off">

                            <div class="form-group">
                                <h2 style="font-size: 20px; margin-top: 0px;"><span class="glyphicon glyphicon-user"></span> Treasurer Sign In.</h2>
                            </div>

                            <div class="form-group">
                                <hr />
                            </div>
                            <?php
                            if (isset($errMSG)) {
                                ?>
                                <div class="form-group">
                                    <div class="alert alert-danger">
                                        <span class="glyphicon glyphicon-info-sign"></span> <?php echo $errMSG; ?>
                                    </div>
                                </div>
                                <?php
                            }
                            ?>
                            <div class="form-group">
                                <div class="input-group">
                                    <span class="input-group-addon"><span class="glyphicon glyphicon-envelope"></span></span>
                                    <input style="height:40px" type="email" name="email" class="form-control w3-round-large" title="Enter Login Email" data-toggle="tooltip" placeholder="Your Email" value="<?php echo $email; ?>" maxlength="40" />
                                </div>
                                <span class="text-danger"><?php echo $emailError; ?></span>
                            </div>

                            <div class="form-group">
                                <div class="input-group">
                                    <span class="input-group-addon"><span class=" glyphicon glyphicon-lock "></span></span>
                                    <input style="height:40px; margin-top: 0px" type="password" name="password" title="enter password" data-toggle="tooltip" class="form-control w3-round-large" placeholder="Enter Password"  />
                                </div>
                                <span class="text-danger"><?php echo $passError; ?></span>
                            </div>



                            <div >
                                <button type="submit" title="click to sign in" data-toggle="tooltip" class="btn btn-block btn-primary" name="btn-login"><span class="glyphicon glyphicon-log-in"> </span> Sign In</button>
                            </div>                         



                            <div style="margin: 5px">
                                <a  style="color: #0000CC;" href="register.php" data-toggle="tooltip" title="click to register"><span class="glyphicon glyphicon-registration-mark"></span> Sign Up</a>
                                <div align='right' >  <span>Forgot <a title="click to reset password" data-toggle="tooltip" style="color: #0000CC" href="reset/"> password?</a></span></div>
                            </div>                 

                        </form>
                    </div>
                    <div style="visibility:hidden;position:inherit; margin-top:-300px;"  id="auformContainer">
                        <form id="auform" method="post" class="animate" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" autocomplete="off">
                            <div class="form-group">
                                <h2 style="font-size: 20px; margin-top: 0px;"><span class="glyphicon glyphicon-user"></span> Auditor Sign In.</h2>
                            </div>

                            <div class="form-group">
                                <hr />
                            </div>
                             <?php
                            if (isset($auerrMSG)) {
                                ?>
                                <div class="form-group">
                                    <div class="alert alert-danger">
                                        <span class="glyphicon glyphicon-info-sign"></span> <?php echo $auerrMSG; ?>
                                    </div>
                                </div>
                                <?php
                            }
                            ?>

                            <div class="form-group">
                                <div class="input-group">
                                    <span class="input-group-addon"><span class="glyphicon glyphicon-envelope"></span></span>
                                    <input style="height:40px" type="email" name="auemail" class="form-control w3-round-large" title="Enter Login Email" data-toggle="tooltip" placeholder="Your Email" value="<?php echo $auemail; ?>" maxlength="40" required="true" />
                                </div>
                                <span class="text-danger"><?php echo $auemailError; ?></span>
                            </div>

                            <div class="form-group">
                                <div class="input-group">
                                    <span class="input-group-addon"><span class=" glyphicon glyphicon-lock "></span></span>
                                    <input style="height:40px; margin-top: 0px" type="password" name="aupassword" title="enter password" data-toggle="tooltip" class="form-control w3-round-large" placeholder="Your Password" required="true" />
                                </div>
                                <span class="text-danger"><?php echo $aupassError; ?></span>
                            </div>

                            <div>
                                <button type="submit" title="click to sign in" data-toggle="tooltip" class="btn btn-block btn-primary" name="auditor-login"><span class="glyphicon glyphicon-log-in"> </span> Sign In</button>
                            </div> 

                            <div style="margin: 5px">
                                <a  style="color: #0000CC;" href="register.php" data-toggle="tooltip" title="click to register"><span class="glyphicon glyphicon-registration-mark"></span> Sign Up</a>
                                <div align='right' >  <span>Forgot <a title="click to reset password" data-toggle="tooltip" style="color: #0000CC" href="#"> password?</a></span></div>
                            </div>                 

                        </form>
                    </div>

                </div>

                <!-- Modal - Add New Record/User -->
                
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
        <script>
            $(document).ready(function () {
                $('[data-toggle="tooltip"]').tooltip();
            });
        </script>
        <script src="assets/js/navigation.js"></script>   
        <script type="text/javascript">
            function displayForm(c) {
                if (c.value == "1") {

                    document.getElementById("auformContainer").style.visibility = 'visible';
                    document.getElementById("trformContainer").style.visibility = 'hidden';
                } else if (c.value == "2") {
                    document.getElementById("auformContainer").style.visibility = 'hidden';

                    document.getElementById("trformContainer").style.visibility = 'visible';
                } else {
                }
            }

        </script>
        <script type="text/javascript" src="assets/jquery-1.11.3-jquery.min.js"></script>
        <script type="text/javascript">
        </body>
        
        </html>
            <?php ob_end_flush(); ?>