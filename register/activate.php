<?php
require_once './config.php';

// retrieve token
if (isset($_GET["token"]) && preg_match('/^[0-9A-F]{40}$/i', $_GET["token"])) {
    $token = $_GET["token"];
}
else { 
    $msg = "No account found";
      $msgType = "warning";
    throw new Exception("Valid token not provided.");
}

// verify token
$q = $DB->prepare("SELECT username, tstamp FROM pending_users WHERE token = ?");
$q->execute(array($token));
$row = $q->fetch(PDO::FETCH_ASSOC);
$q->closeCursor();

if ($row) {
    extract($row);
}
else {
      $msg = "Invalid Link.";
    throw new Exception("Valid token not provided.");
        
}
     
$delta = 8640;

// Check to see if link has expired
if ($_SERVER["REQUEST_TIME"] - $tstamp > $delta) {
     $msg = "Link has expired Link.";
    throw new Exception("Token has expired.");
    
}
//
// do one-time action here, like activating a user account
// ...
$email=$row['username'];
$sql = "UPDATE `church` SET  `status` =  'approved' WHERE `email` = :email";
        $stmt = $DB->prepare($sql);
        $stmt->bindValue(":email", $email);
        $stmt->execute();
        $msg = "Your account has been activated you can now login.";
        $msgType = "success";
		header("refresh:5;../index.php");

// delete token so it can't be used again
$query = $DB->prepare(
    "DELETE FROM pending_users WHERE username = ? AND token = ? ");
$query->execute(
    array(
        $email,
        $token     
    )
);


include './header.php';
?>
<?php if ($msg <> "") { ?>
<div align="center" style="margin:10px" class="alert alert-dismissable alert-<?php echo $msgType; ?>">
    <button data-dismiss="alert" onclick="this.parentElement.style.display = 'none';" class="close" type="button">x</button>
    <p><?php echo $msg; ?></p>
  </div>
<?php } ?>
<div align="center" style="margin:10px" class="container">
  <div class="row">
    <div class="col-lg-9">
      <h1>Thank you for registering with us.</h1>
    </div>
  </div>
</div>
<div class="clearfix"></div>

<script type="text/javascript">
  function validateForm() {

    var your_name = $.trim($("#uname").val());
    var your_email = $.trim($("#uemail").val());
    var pass1 = $.trim($("#pass1").val());
    var pass2 = $.trim($("#pass2").val());


    // validate name
    if (your_name == "") {
      alert("Enter your name.");
      $("#uname").focus();
      return false;
    } else if (your_name.length < 3) {
      alert("Name must be atleast 3 character.");
      $("#uname").focus();
      return false;
    }

    // validate email
    if (!isValidEmail(your_email)) {
      alert("Enter valid email.");
      $("#uemail").focus();
      return false;
    }

    // validate subject
    if (pass1 == "") {
      alert("Enter password");
      $("#pass1").focus();
      return false;
    } else if (pass1.length < 6) {
      alert("Password must be atleast 6 character.");
      $("#pass1").focus();
      return false;
    }

    if (pass1 != pass2) {
      alert("Password does not matched.");
      $("#pass2").focus();
      return false;
    }

    return true;
  }

  function isValidEmail(email) {
    var regex = /^([a-zA-Z0-9_\.\-\+])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
    return regex.test(email);
  }


</script>

<?php
include './footer.php';
?>