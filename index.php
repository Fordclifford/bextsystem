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
    $status = "pending";
    if ($row['status'] == $status) {
        $error = true;
        $errMSG = "Your account has not been activated! please check your email";
    }

    // if there's no error, continue to login
    if (!$error) {
        $password = hash('md5', $pass); // password hashing using SHA256
        $count = mysql_num_rows($res); // if uname/pass correct it returns must be 1 row

        if ($count == 1 && $row['pass'] == $password) {
            $_SESSION['user'] = $row['id'];
            $_SESSION['name'] = $row['name'];
            header("Location: home.php");
        } else {
            $errMSG = "Incorrect Credentials, Try again..";
        }
    }
}
include_once"includes/header.php";
?>



                <div class="login_form_div w3-round-large" >

                    <div style="position:relative;" id="trformContainer">

                        <form id="trform" method="post" class="animate" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" autocomplete="off">

                            <div class="form-group">
                                <h2 style="font-size: 15px; margin-top: 0px;"><span class="glyphicon glyphicon-user"></span> Please Sign In</h2>
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
                                <a  style="color: #0000CC;" href="register" data-toggle="tooltip" title="click to register"><span class="glyphicon glyphicon-registration-mark"></span> Sign Up</a>
                                <div align='right' >  <span>Forgot <a title="click to reset password" data-toggle="tooltip" style="color: #0000CC" href="reset/"> password?</a></span></div>
                            </div>                 

                        </form>
                    </div>
                    
                </div>


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
        
           <?php include_once './includes/footer.php';