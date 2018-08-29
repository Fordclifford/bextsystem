<?php
require_once './config.php';
if (isset($_POST["sub"])) {
    require_once "phpmailer/class.phpmailer.php";

    $name = trim($_POST["uname"]);
    $pass = trim($_POST["pass1"]);
    $email = trim($_POST["uemail"]);
    $mobile = trim($_POST["mobile"]);
    $union = trim($_POST["union_mission"]);
    $conf = trim($_POST["conference"]);

    $token = sha1(uniqid($email, true));

    $sql = "SELECT COUNT(*) AS count from church where email = :email_id";
    try {
        $stmt = $DB->prepare($sql);
        $stmt->bindValue(":email_id", $email);
        $stmt->execute();
        $result = $stmt->fetchAll();

        if ($result[0]["count"] > 0) {
            $msg = "Email already exist";
            $msgType = "warning";
        } else {
            $query = $DB->prepare("INSERT INTO pending_users (username, token, tstamp) VALUES (?, ?, ?)");
            $query->execute(
                    array(
                        $email,
                        $token,
                        $_SERVER["REQUEST_TIME"]
                    )
            );
            $sql = "INSERT INTO `church` (`name`, `pass`, `email`,`conference`,`mobile`,`union_mission`) VALUES " . "( :name, :pass, :email, :conf, :mobile, :union)";
            $stmt = $DB->prepare($sql);
            $stmt->bindValue(":name", $name);
            $stmt->bindValue(":pass", md5($pass));
            $stmt->bindValue(":email", $email);
            $stmt->bindValue(":mobile", $mobile);
            $stmt->bindValue(":conf", $conf);
            $stmt->bindValue(":union", $union);

            $stmt->execute();

            $result = $stmt->rowCount();


            if ($result > 0) {

                $message = '<html><head>
                <title>Email Verification</title>
                </head>
                <body>';
                $message .= '<h1>Hi ' . $name . '!</h1>';
                $message .= '<p>Thank you for signing up at our site.  Please go to <a href="' . SITE_URL . 'activate.php?token=' . $token . '">this link </a> to activate your account.<br><br></p>Regards,<br> Admin.';
                $message .= "</body></html>";


                // php mailer code starts
                $mail = new PHPMailer(true);
                $mail->IsSMTP(); // telling the class to use SMTP
                $mail->SMTPOptions = array(
                    'ssl' => array(
                        'verify_peer' => false,
                        'verify_peer_name' => false,
                        'allow_self_signed' => true
                    )
                );

                $mail->SMTPDebug = 0;                     // enables SMTP debug information (for testing)
                $mail->SMTPAuth = true;                  // enable SMTP authentication
                $mail->SMTPSecure = "ssl";                 // sets the prefix to the servier
                $mail->Host = "host22.safaricombusiness.co.ke";      // sets GMAIL as the SMTP server
                $mail->Port = 465;                   // set the SMTP port for the GMAIL server

                $mail->Username = 'admin@c-websolutions.com';
                $mail->Password = 'Clifordmasi07';

                $mail->SetFrom('admin@c-websolutions.com', 'Admin');
                $mail->AddAddress($email);

                $mail->Subject = trim("Email Verifcation - Budget and Expense Tracker");
                $mail->MsgHTML($message);

                try {
                    $mail->send();
                    $msg = "An email has been sent for verfication.";
                    $msgType = "success";
                    unset($name);
                    unset($email);
                    unset($pass);
                    unset($conf);
                    unset($mobile);
                    unset($union);
                    header("refresh:5;../index.php");
                } catch (Exception $ex) {
                    $msg = $ex->getMessage();
                    $msgType = "danger";
                }
            } else {
                $msg = "Failed to create User";
                $msgType = "warning";
            }
        }
    } catch (Exception $ex) {
        echo $ex->getMessage();
    }
}

require_once('header.php');
?>
<body>

    <div id="wrapper">

        <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-8">
                    <h1 style="font-size: 22px;"><i class="glyphicon glyphicon-registration-mark"></i> Register Church</h1>
                </div>
            </div>

            <div class="register_form_div w3-round-large">


                <form style=" width: 100%" class="animate w3-round-large" method="post" name="f" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" autocomplete="off" onsubmit="return validateForm();">

                    <fieldset>
                        <div class="form-group">
                            <hr />
                        </div>
                        <?php if ($msg <> "") { ?>
                            <div class="alert alert-dismissable alert-<?php echo $msgType; ?>">
                                <button data-dismiss="alert" class="close" onclick="this.parentElement.style.display = 'none';" type="button">x</button>
                                <p><?php echo $msg; ?></p>
                            </div>
                        <?php } ?>

                        <div class="form-group">
                            <label for="union" >Select Union/Mission</label>
                            <div class="input-group">
                                <span class="input-group-addon"><span class="glyphicon glyphicon-globe"></span></span>
                                <select title="union" data-toggle="tooltip" style="height:40px;margin-top: 0px" class="w3-round-large form-control"  value="<?php echo $union ?>" onchange="print_conf('conference', this.selectedIndex);" id="union_mission" name ="union_mission"></select>
                            </div>

                        </div>

                        <div class="form-group">
                            <label for="conference" >Select Conference</label>
                            <div class="input-group">
                                <span class="input-group-addon"><span class="glyphicon glyphicon-globe"></span></span>
                                <select title="Conference" data-toggle="tooltip" style="height:40px;margin-top: 0px" class="w3-round-large form-control"  value="<?php echo $conf ?>" id="conference" name ="conference"></select>
                            </div>

                        </div>


                        <div class="form-group">
                            <label for="conference" >Church Name</label>
                            <div class="input-group">
                                <span class="input-group-addon"><span class="glyphicon glyphicon-btc"></span></span>
                                <input type="text" placeholder="Church Name" id="uname" style="height:40px;margin-top: 0px" class="form-control" value="<?php echo $name ?>" name="uname">
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="input-group">
                                <span class="input-group-addon"><span class="glyphicon glyphicon-phone"></span></span>
                                <input title="Enter Mobile Number" data-toggle="tooltip" style="height:40px;margin-top: 0px" type="text" placeholder="Contact Number e.g. 0712345678" name="mobile" id="mobile" class="form-control w3-round-large"  value="<?php echo $mobile ?>" maxlength="40" />
                            </div>

                        </div>

                        <div class="form-group">
                            <label for="conference" > Email</label>
                            <div class="input-group">
                                <span class="input-group-addon"><span class="glyphicon glyphicon-envelope"></span></span>
                                <input type="text" placeholder="Your Email" value="<?php echo $email ?>" id="uemail" style="height:40px;margin-top: 0px" class="form-control" name="uemail">

                            </div>

                            <div class="form-group">
                                <label for="pass1" > Password</label>
                                <div class="input-group">
                                    <span class="input-group-addon"><span class="glyphicon glyphicon-lock"></span></span>
                                    <input type="password" placeholder="Password" value="<?php echo $pass ?>" style="height:40px;margin-top: 0px" id="pass1" class="form-control" name="pass1">
                                </div>

                                <div class="form-group">
                                    <label for="conference" > Confirm</label>
                                    <div class="input-group">
                                        <span class="input-group-addon"><span class="glyphicon glyphicon-lock"></span></span>
                                        <input type="password" placeholder="Password" value="<?php echo $pass ?>" style="height:40px;margin-top: 0px" id="pass2" class="form-control" name="pass2">

                                    </div>

                                    <div style="height: 10px;clear: both"></div>

                                    <div class="form-group">
                                        <div class="col-lg-4">
                                            <button title="Click to Clear Input" type="reset" value="reset" data-toggle="tooltip"  class="btn btn-default" ><span class="glyphicon glyphicon-erase"></span> Clear</button>

                                        </div>
                                        <div class="col-lg-4">

                                            <button class="btn btn-primary" type="submit" name="sub">Submit</button>
                                        </div>
                                    </div>
                                    </fieldset>
                                    <hr />
                                    <div>
                                        <span >Sign in </span><a href="../index.php" style="color: #0000FF">Here</a>
                                    </div>
                                    </form>



                                </div>
                            </div>
                        </div>


                        <?php include 'footer.php'; ?>
