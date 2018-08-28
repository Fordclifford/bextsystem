<?php
if(!class_exists('PHPMailer')) {
    require('phpmailer/class.phpmailer.php');
	require('phpmailer/class.smtp.php');
}

require_once("mail_configuration.php");


$emailBody = "<div>" . $user["name"] . ",<br><br><p>Click this link to recover your password<br><a href='" . PROJECT_HOME . "reset_password.php?token=" . $token . "'>" . PROJECT_HOME . "reset_password.php?name=" . $token. "</a><br><br></p>Regards,<br> Admin.</div>";
 $mail = new PHPMailer(true);
                $mail->IsSMTP(); // telling the class to use SMTP
                $mail->SMTPOptions = array(
                    'ssl' => array(
                        'verify_peer' => false,
                        'verify_peer_name' => false,
                        'allow_self_signed' => true
                    )
                );
$mail->IsSMTP();
$mail->SMTPDebug = 0;
$mail->SMTPAuth = TRUE;
$mail->SMTPSecure = "ssl";
$mail->Port     = PORT;  
$mail->Username = MAIL_USERNAME;
$mail->Password = MAIL_PASSWORD;
$mail->Host     = MAIL_HOST;


$mail->SetFrom(SENDER_EMAIL, SENDER_NAME);
$mail->AddReplyTo(SENDER_EMAIL, SENDER_NAME);
$mail->ReturnPath=SENDER_EMAIL;	
$mail->AddAddress($user["email"]);
$mail->Subject = "Forgot Password Recovery";		
$mail->MsgHTML($emailBody);
$mail->IsHTML(true);

if(!$mail->Send()) {
	$error_message = 'Problem in Sending Password Recovery Email';
} else {
	$success_message = 'Please check your email to reset password!';
}

?>
