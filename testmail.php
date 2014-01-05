<?php 
require_once('PHPMailer_v5.1/class.phpmailer.php');
// 02230797979
$mail             = new PHPMailer(); // defaults to using php "mail()"
$mail->Port       =  25;                    // set the SMTP server port
$mail->Host       = "smtp.seekersguru.com"; // SMTP server
$mail->Username   = "info@seekersguru.com";     // SMTP server username
$mail->Password   = "XvkPgcSkJ8"; 
$mail->IsSMTP();
$body             = "NSHU";
//$body             = eregi_replace("[\]",'',$body);

$mail->AddReplyTo("nishu.saxena@gmail.com","First Last");

$mail->SetFrom('info@seekersguru.com', 'First Last');

$mail->AddReplyTo("info@seekersguru.com","First Last");

$address = "info@seekersguru.com";
$mail->AddAddress($address, "John Doe");

$mail->Subject    = "PHPMailer Test Subject via mail(), basic";

$mail->AltBody    = "To view the message, please use an HTML compatible email viewer!"; // optional, comment out and test

$mail->MsgHTML($body);

//$mail->AddAttachment("images/phpmailer.gif");      // attachment
//$mail->AddAttachment("images/phpmailer_mini.gif"); // attachment

if(!$mail->Send()) {
  echo "Mailer Error: " . $mail->ErrorInfo;
} else {
  echo "Message sent!";
}
    
?>