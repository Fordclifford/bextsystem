<?php
require_once './config.php';
if (isset($_POST['username_check'])) {
  	$uname = $_POST['username'];
           $sql = "SELECT COUNT(*) AS count from users where user_name = :uname";
    try {
        $stmt = $DB->prepare($sql);
        $stmt->bindValue(":uname", $uname);
        $stmt->execute();
        $result = $stmt->fetchAll();

        if ($result[0]["count"] > 0) {
             echo "taken";	
        }else{
  	  echo 'not_taken';
  	}
        exit();
  }
  catch (Exception $ex) {
        echo $ex->getMessage();
    }
}
  if (isset($_POST['email_check'])) { 
$email = $_POST['email'];
        $sql = "SELECT COUNT(*) AS count from users where email=:email";
       try{
        $stmt = $DB->prepare($sql);
        $stmt->bindValue(":email", $email);
        $stmt->execute();
        $result = $stmt->fetchAll();
if ($result[0]["count"] > 0) {
             echo "taken";	
        }else{
  	  echo 'not_taken';
  	}
        exit();
       }
       catch (Exception $ex) {
        echo $ex->getMessage();
    }
  }   
        
  if (isset($_POST['name_check'])) { 

$name = $_POST['name'];
       $sql = "SELECT COUNT(*) AS count from church where name=:name";
       try{
        $stmt = $DB->prepare($sql);
        $stmt->bindValue(":name", $name);
        $stmt->execute();
        $result = $stmt->fetchAll();
if ($result[0]["count"] > 0) {
             echo "taken";	
        }else{
  	  echo 'not_taken';
  	}
        exit();
       }
       catch (Exception $ex) {
        echo $ex->getMessage();
    }
  } 
  
  if (isset($_POST["save"])) {
   require_once "phpmailer/class.phpmailer.php";

    $name = trim($_POST["name"]);
    $uname = trim($_POST["username"]);
    $password = trim($_POST["password"]);
    $email = trim($_POST["email"]);
    $mobile = trim($_POST["mobile"]);
    $union = trim($_POST["union"]);
    $conf = trim($_POST["conference"]);
    $pass = md5($password);
    $type = "treasurer";
    $error = false;

    $token = sha1(uniqid($uname, true));
      
    $sql = "SELECT COUNT(*) AS count from users where email=:email";
      
        $stmt = $DB->prepare($sql);
        $stmt->bindValue(":email", $email);
        $stmt->execute();
        $result = $stmt->fetchAll();
if ($result[0]["count"] > 0) {
             echo "exists";
            exit();
        }else{
        
       
            $query = $DB->prepare("INSERT INTO pending_users (username, token, tstamp) VALUES (?, ?, ?)");
            $query->execute(
                    array(
                        $uname,
                        $token,
                        $_SERVER["REQUEST_TIME"]
                    )
            );
            $sql = "INSERT INTO `users` (`user_name`, `passwd`,`user_type`,`email`) VALUES " . "( :user_name, :passwd, :user_type, :email)";
            $stmt = $DB->prepare($sql);
            $stmt->bindValue(":user_name", $uname);
            $stmt->bindValue(":passwd", $pass);
            $stmt->bindValue(":user_type", $type);
            $stmt->bindValue(":email", $email);

            $stmt->execute();

            $sql = "SELECT id from users where email=:email";
            $stmt = $DB->prepare($sql);
            $stmt->bindValue(":email", $email);
            $stmt->execute();
            $result = $stmt->fetchAll();

            $sql = "INSERT INTO `church` (`name`, `conference_id`,`mobile`,`union_id`,`user_id`) VALUES " . "( :name, :conf, :mobile, :union, :user_id)";
            $stmt = $DB->prepare($sql);
            $stmt->bindValue(":name", $name);
            $stmt->bindValue(":mobile", $mobile);
            $stmt->bindValue(":conf", $conf);
            $stmt->bindValue(":union", $union);
            $stmt->bindValue(":user_id", $result[0]["id"]);

            $stmt->execute();

            $result = $stmt->rowCount();


            if ($result > 0) {

                $message = '<html><head>
                <title>Email Verification</title>
                </head>
                <body>';
                $message .= '<h1>Hi ' . $uname . '!</h1>';
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
                $mail->Host = "smtp.gmail.com";      // sets GMAIL as the SMTP server
                $mail->Port = 465;                   // set the SMTP port for the GMAIL server

                $mail->Username = 'cliffordmasi07@gmail.com';
                $mail->Password = 'cliffkaka07';

                $mail->SetFrom('cliffordmasi07@gmail.com', 'Admin');
                $mail->AddAddress($email);

                $mail->Subject = trim("Email Verifcation - Budget and Expense Tracker");
                $mail->MsgHTML($message);

                try {
                    $mail->send();
                    echo $msg = "An email has been sent for verfication.";
                    $msgType = "success";
                    unset($name);
                    unset($uname);
                    unset($email);
                    unset($pass);
                    unset($conf);
                    unset($mobile);
                    unset($union);
                    header("refresh:5;../index.php");
                } catch (Exception $ex) {
                   echo $msg = "Failed to send verification email! ".$ex->getMessage()." Contact your system admin";
                    $msgType = "danger";
                }
            } else {
               echo $msg = "Failed to create User";
                $msgType = "warning";
            }

        }
  }


  
        
