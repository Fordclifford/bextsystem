<?php
require_once './dbconfig.php';
if (!empty($_POST["forgot-password"])) {

 $email=$_POST['user-email'];
 $q = $DB->prepare("SELECT * from users where email = ?");
 
 
 try{
    $q->execute(array($email));
}catch (Exception $ex) {
                    $error_message = $ex->getMessage();
                    $msgType = "danger";
}
 
 $row = $q->fetch(PDO::FETCH_ASSOC);


if ($row) {
    extract($row);
    $uname= $row['user_name'];
       $token = sha1(uniqid($uname, true));
    $query = $DB->prepare(
           "INSERT INTO reset (username, token, tstamp) VALUES (?, ?, ?)"
    );
try{
    $query->execute(
            array(
                $uname,
                $token,
                $_SERVER["REQUEST_TIME"]
            )
    );
}catch (Exception $ex) {
                    $error_message = $ex->getMessage();
                    $msgType = "danger";
}

        require_once("forgot-password-recovery-mail.php");
   
}
else {
      $error_message = "No user found!";
   

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
