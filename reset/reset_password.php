<?php
require_once './dbconfig.php';
if (isset($_POST["reset-password"])) {
   $error =false;
if (isset($_GET["token"]) && preg_match('/^[0-9A-F]{40}$/i', $_GET["token"])) {
    $token = $_GET["token"];
} else {
    $error =true;
    $error_message = "Invalid Link.";
       throw new Exception("Valid token not provided.");
}

// verify token

$query = $DB->prepare("SELECT username, tstamp FROM reset WHERE token = ?");
$query->execute(array($token));
 $row = $query->fetch(PDO::FETCH_ASSOC);
$query->closeCursor();

if ($row) {
    extract($row);
} else {
       $error =true;
     $error_message = "Invalid Link.";
       throw new Exception("Valid token not provided.");
}


$delta = 60000;

// Check to see if link has expired
if ($_SERVER["REQUEST_TIME"] - $tstamp > $delta) {
    $error =true;
    $error_message = "Link Expired.";
    throw new Exception("Token has expired.");
}
// do one-time action here, like activating a user account
// ...

if (!$error){
 $uname =$row['username'];
 $conn = mysqli_connect("localhost", "root", "", "bext_system");
 $sql = "UPDATE `users` SET `passwd` = '" . md5($_POST["member_password"]) . "' WHERE `users`.`user_name` = '" . $uname . "'";
    $result = mysqli_query($conn, $sql);
    $success_message = "Password is reset successfully.";

    // delete token so it can't be used again
$q = $DB->prepare(
"DELETE FROM reset WHERE username = ? AND token = ? ");
$q->execute(
        array(
            $uname,
            $token
        )
);
header("refresh:5;../index.php");

}
}
?>
<link href="demo-style.css" rel="stylesheet" type="text/css">
<?php require_once './header.php'; ?>
<body>
    <div class="container-fluid">
   <div class="row">
       <img height="200px" width="1500px" src="../assets/image/header3.png"  border="0" alt="Main Banner">
   </div>
</div>
       
<div id="wrapper">
<div  >
    <form name="frmReset" class="well form-horizontal" method="post" onSubmit="return validate_password_reset();">
       <?php include_once 'forms/forgot_form.php';?>
    </form>
</div>
</div>
</body>
<?php require_once 'footer.php' ?>
