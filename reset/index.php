<?php
require_once './dbconfig.php';
if (!empty($_POST["forgot-password"])) {
    $condition = "";

     if (!empty($_POST["user-login-name"])) {
        $condition = " user_name = '" . $_POST["user-login-name"] . "'";
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
 $conn = mysqli_connect("localhost", "root", "", "bext_system");
  echo $sql = "Select * from users " . $condition;
    $result = mysqli_query($conn, $sql);
    $user = mysqli_fetch_array($result);

   $token = sha1(uniqid($user['user_name'], true));

   $uname= $user['user_name'];
      $query = $DB->prepare(
           "INSERT INTO reset (username, token, tstamp) VALUES (?, ?, ?)"
    );
try{
    $query->execute(
            array(
                $user['user_name'],
                $token,
                $_SERVER["REQUEST_TIME"]
            )
    );
}catch (Exception $ex) {
                    $msg = $ex->getMessage();
                    $msgType = "danger";
}
    if (!empty($user)) {
        require_once("forgot-password-recovery-mail.php");
    } else {
        $error_message = 'No User Found';
    }
    
}
include_once './header.php';
?>

<body>
    <div class="container-fluid">
   <div class="row">
       <img height="200px" width="1500px" src="../assets/image/header3.png"  border="0" alt="Main Banner">
   </div>
</div>
       
 <div id="wrapper">
<div style="margin: 0 auto">
    <form class="well form-horizontal"  method="post" onSubmit="return validate_forgot();">
       <?php include_once 'forms/mail_username.php'; ?>
    </form>
</div>
 </div>
</body>
<?php require_once './footer.php' ?>
