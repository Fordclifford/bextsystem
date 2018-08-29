<?php
require_once './dbconfig.php';
if (!empty($_POST["forgot-password"])) {
    $condition = "";
       if (!empty($_POST["user-login-name"])) {
        $condition = " name = '" . $_POST["user-login-name"] . "'";
    }
    if (!empty($_POST["user-email"])) {
        if (!empty($condition)) {
            $condition = " and ";
        }
        $condition = " email = '" . $_POST["user-email"] . "'";
    }

    if (!empty($condition)) {
        $condition = " where " . $condition;
    }
$error=false;
 $conn = mysqli_connect("localhost", "cwebsolu_cliff", "Clifordmasi07", "cwebsolu_bext_system");
   $sql = "Select * from church " . $condition;
    $result = mysqli_query($conn, $sql);
    $user = mysqli_fetch_array($result);

   $token = sha1(uniqid($user['email'], true));
   
   $email= $user['email'];
      $query = $DB->prepare(
           "INSERT INTO reset (username, token, tstamp) VALUES (?, ?, ?)"
    );
    $query->execute(
            array(
                $user['email'],
                $token,
                $_SERVER["REQUEST_TIME"]
            )
    );
     
    if (!empty($user)) {
        require_once("forgot-password-recovery-mail.php");
    } else {
        $error_message = 'No User Found';
    }
}
include_once './header.php';
?>
<link href="demo-style.css" rel="stylesheet" type="text/css">
      
<div class="login_form_div">
    <form name="frmForgot" id="frmForgot" method="post" onSubmit="return validate_forgot();">
        <h1>Forgot Password?</h1>
        <?php if (!empty($success_message)) { ?>
            <div class="success_message alert alert-success"><?php echo $success_message; ?></div>
        <?php } ?>

        <div id="validation-message">
            <?php if (!empty($error_message)) { ?>
                <?php echo $error_message; ?>
            <?php } ?>
        </div>

        <div class="field-group">
            <div><label for="username">Username</label></div>
            <div><input type="text" name="user-login-name" id="user-login-name" class="input-field"> Or</div>
        </div>

        <div class="field-group">
            <div><label for="email">Email</label></div>
            <div><input type="text" name="user-email" id="user-email" class="input-field"></div>
        </div>

        <div class="field-group">
            <div><input type="submit" name="forgot-password" id="forgot-password" value="Submit" class="form-submit-button"></div>
        </div>
            <div style="margin: 5px">
                                <a  style="color: #0000CC;" href="../index.php" data-toggle="tooltip" title="click to login"><span class="glyphicon glyphicon-user"></span> Sign In</a>
                                <div align='right' >  <span>Sign <a title="click to reset password" data-toggle="tooltip" style="color: #0000CC" href="../register/"> Up?</a></span></div>
                            </div>  
    </form>
</div>


<?php require_once './footer.php' ?>