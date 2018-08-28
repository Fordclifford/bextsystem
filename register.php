<?php
ob_start();
session_start();
if (isset($_SESSION['user']) != "") {
    header("Location: home.php");
}
include_once 'dbconnect.php';

$error = false;

if (isset($_POST['btn-signup'])) {

    // clean user inputs to prevent sql injections
    $name = trim($_POST['name']);
    $name = strip_tags($name);
    $name = htmlspecialchars($name);

    $email = trim($_POST['email']);
    $email = strip_tags($email);
    $email = htmlspecialchars($email);

    $pass = trim($_POST['password']);
    $pass = strip_tags($pass);
    $pass = htmlspecialchars($pass);


    $conference = trim($_POST['conference']);
    $conference = strip_tags($conference);
    $conference = htmlspecialchars($conference);

    $mobile = trim($_POST['mobile']);
    $mobile = strip_tags($mobile);
    $mobile = htmlspecialchars($mobile);

    //$union_mission= $_POST['union_mission'];
    $union_mission = trim($_POST['union_mission']);
    $union_mission = strip_tags($union_mission);
    $union_mission = htmlspecialchars($union_mission);
   

    // basic name validation
    if (empty($name)) {
        $error = true;
        $errTyp = "danger";
        $errMSG = "You have an error in your input, kindly check and try again!";
        $nameError = "Please enter your name.";
    } else if (!preg_match("/^[a-zA-Z ]+$/", $name)) {
        $error = true;
        $errMSG = "You have an error in your input, kindly check and try again!";
        $nameError = "Name must contain alphabets and space.";
    } else if (strlen($name) < 3) {
        $error = true;
        $errTyp = "danger";
        $errMSG = "You have an error in your input, kindly check and try again!";
        $nameError = "Name must have atleat 3 characters.";
    }



    //basic email validation
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = true;
        $errTyp = "danger";
        $errMSG = "You have an error in your input, kindly check and try again!";
        $emailError = "Please enter valid email address.";
    } else {
        // check email exist or not
        $query = "SELECT email FROM church WHERE email='$email'";
        $result = mysql_query($query);
        $count = mysql_num_rows($result);
        if ($count != 0) {
            $error = true;
            $errTyp = "danger";
            $errMSG = "You have an error in your input, kindly check and try again!";
            $emailError = "Provided Email is already in use.";
        }
    }

    //mobile number validation
    if (empty($mobile)) {
        $error = true;
        $errTyp = "danger";
        $errMSG = "You have an error in your input, kindly check and try again!";
        $mobileError = "Please enter your  mobile number.";
    } else if (!preg_match("/^[0-9]+$/", $mobile)) {
        $error = true;
        $errMSG = "You have an error in your input, kindly check and try again!";
        $mobileError = "Mobile number must contain numbers only.";
    } else if (strlen($mobile) < 10) {
        $error = true;
        $errTyp = "danger";
        $errMSG = "You have an error in your input, kindly check and try again!";
        $mobileError = "Mobile must have atleat 10 digits.";
    }

    // password validation
    if (empty($pass)) {
        $error = true;
        $errTyp = "danger";
        $errMSG = "You have an error in your input, kindly check and try again!";
        $passError = "Please enter password.";
    } else if (strlen($pass) < 6) {
        $error = true;
        $errTyp = "danger";
        $errMSG = "You have an error in your input, kindly check and try again!";
        $passError = "Password must have atleast 6 characters.";
    }

   
    if (empty($conference)) {
        $error = true;
        $errTyp = "danger";
        $errMSG = "You have an error in your input, kindly check and try again!";
        $confError = "Please Select your conference";
    }
     if (empty($union_mission)) {
        $error = true;
        $errTyp = "danger";
        $errMSG = "You have an error in your input, kindly check and try again!";
        $confError = "Please Select your Union";
    }



    // password encrypt using SHA256();
    $password = hash('sha256', $pass);
   // var_dump($union_mission);
   // var_dump($conference);
        // if there's no error, continue to signup
    if (!$error) {
        //$query = mysql_query("INSERT INTO church(union,name,email,conference,mobile,password)VALUES('$union','$name','$email','$conference','$mobile','$password')");
 $quer= mysql_query("INSERT INTO church (conference,name,email,mobile,union_mission,password)VALUES('$conference','$name','$email','$mobile','$union_mission','$password')");
        
        if (!$quer) {
            //die("could not execute query 1");
            exit(mysql_error($conn));
        }

        if ($quer) {
            $errTyp = "success";
            $errMSG = "Successfully registered, you may login now";
            unset($name);
            unset($email);
            unset($pass);
            unset($conference);
            unset($mobile);
            unset($union_mission);
            header("refresh:5;index.php");
        } else {
            $errTyp = "danger";
            $errMSG = "Something went wrong, try again later...";
        }
    }
}
?>
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
                <div style="padding: 2px"></div>
                <div class="topnav w3-round-xlarge" id="myTopnav" >
                    <a href="index.php"><i class="glyphicon glyphicon-home"></i> Home</a>
                    <a style="margin-left: 25%" href="index.php"><i class="glyphicon glyphicon-log-in"></i> Login</a>
                    <a class="navbar-right" href="register.php"><i class="glyphicon glyphicon-registration-mark"></i> Register</a>
                    <a href="javascript:void(0);" class="icon" onClick="myFunction()">&#9776;</a>

                </div>



                <div class="register_form_div w3-round-large">
                    <form style="padding: 30px; width: 100%" class="animate w3-round-large" method="post" name="login" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" autocomplete="off" onSubmit="return validatePassword()">



                        <div class="form-group">
                            <h style="font-size: 22px;"><i class="glyphicon glyphicon-registration-mark"></i> Register Church</h>
                        </div>

                        <div class="form-group">
                            <hr />
                        </div>
                        <?php
                        if (isset($errMSG)) {
                            ?>
                            <div class="form-group">
                                <div class="alert alert-<?php echo ($errTyp == "success") ? "success" : $errTyp; ?>">
                                    <span class="glyphicon glyphicon-info-sign"></span> <?php echo $errMSG; ?>
                                </div>
                            </div>  
                        <?php } ?>                       

                        <div class="form-group">
                             <label for="union" >Select Union/Mission</label>
                            <div class="input-group">
                                <span class="input-group-addon"><span class="glyphicon glyphicon-globe"></span></span>
                              <select title="union" data-toggle="tooltip" style="height:40px;margin-top: 0px" class="w3-round-large form-control"  value="<?php echo $union_mission ?>" onchange="print_conf('conference',this.selectedIndex);" id="union_mission" name ="union_mission"></select>
		               </div>
                            <span class="text-danger"><?php echo $uniError; ?></span>
                        </div>
                        
                          <div class="form-group">
                             <label for="conference" >Select Conference</label>
                            <div class="input-group">
                                <span class="input-group-addon"><span class="glyphicon glyphicon-globe"></span></span>
                              <select title="Conference" data-toggle="tooltip" style="height:40px;margin-top: 0px" class="w3-round-large form-control"  value="<?php echo $conference ?>" id="conference" name ="conference"></select>
		             </div>
                            <span class="text-danger"><?php echo $confError; ?></span>
                        </div>                    
                                        
		
                        
                        
                          <div class="form-group">
                            <div class="input-group">
                                <span class="input-group-addon"><span class="glyphicon glyphicon-cog"></span></span>
                                <input title="Enter Church Name" data-toggle="tooltip" style="height:40px;margin-top: 0px" type="text" name="name"  placeholder="Church Name e.g Nairobi Central SDA" class="form-control w3-round-large"  value="<?php echo $name ?>" maxlength="40" />
                            </div>
                            <span class="text-danger"><?php echo $nameError; ?></span>
                        </div>


                        <div class="form-group">
                            <div class="input-group">
                                <span class="input-group-addon"><span class="glyphicon glyphicon-phone"></span></span>
                                <input title="Enter Mobile Number" data-toggle="tooltip" style="height:40px;margin-top: 0px" type="text" placeholder="Contact Number e.g. 0712345678" name="mobile" class="form-control w3-round-large"  value="<?php echo $mobile ?>" maxlength="40" />
                            </div>
                            <span class="text-danger"><?php echo $mobileError; ?></span>
                        </div>


                        <div class="form-group">
                            <div class="input-group">
                                <span class="input-group-addon"><span class="glyphicon glyphicon-envelope"></span></span>
                                <input title="Enter Church Mail" data-toggle="tooltip" style="height:40px" type="email" id="email" name="email" class="form-control w3-round-large" placeholder="Your Church Email e.g email@example.com" value="<?php echo $email; ?>" maxlength="40" />
                            </div>
                            <span class="text-danger"><?php echo $emailError; ?></span>
                        </div>


                        <div class="form-group">
                            <div class="input-group">
                                <span class="input-group-addon"><span class="glyphicon glyphicon-lock"></span></span>
                                <input title="Enter Password" data-toggle="tooltip" style="height:40px;margin-top: 0px" type="password" id="password" name="password" class="form-control w3-round-large" placeholder="Your Password" value="<?php echo $pass; ?>" maxlength="40" />
                            </div>
                            <span class="text-danger"><?php echo $passError; ?></span>
                        </div>

                        <div class="form-group">
                            <div class="input-group">
                                <span class="input-group-addon"><span class="glyphicon glyphicon-lock"></span></span>
                                <input title="Re-enter Password" data-toggle="tooltip" style="height:40px;margin-bottom: 0px;margin-top: 0px" type="password"  name="confirm_password" class="form-control w3-round-large" placeholder="Confirm Password"  maxlength="40" />
                            </div>

                        </div>
                        <hr />


                        <div class="form-group">
                            <button title="Click to Clear Input" type="reset" value="reset" data-toggle="tooltip"  class="btn btn-default" ><span class="glyphicon glyphicon-erase"></span> Clear</button>
                            <button style="margin: auto" title="Click to Save Record" data-toggle="tooltip" type="submit" name="btn-signup" class="btn btn-primary navbar-right" ><span class="glyphicon glyphicon-log-in"></span> &nbsp; Sign Up
                            </button>

                        </div>
                        <hr />




                        <div>
                            <span >Sign in </span><a href="index.php" style="color: #0000FF">Here</a>
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
        <script type="text/javascript">

            function validatePassword()
            {
                if (document.login.password.value !== document.login.confirm_password.value) {
                    alert("Your passwords did not match!. Please check and register again");


                    return false;
                } else {
                    return true;
                }
            }

        </script>
        <script src="assets/js/navigation.js"></script>  
        <script>
            $(document).ready(function () {
                $('[data-toggle="tooltip"]').tooltip();
            });
        </script>
        <script type= "text/javascript" src = "assets/js/conferences.js"></script>
        <script language="javascript">print_union("union_mission");</script>
    </body>

</html>
<?php ob_end_flush(); ?>