<?php 
/*
PHP does not support multithreading natively (which you need to do this beautifully). 
You can do it though by saving the emails in a database and then process them 
later using another script (e.g. using a cron job). In this way you don't have to wait for 
the underlying email framework
 */
require_once('PHPMailer_v5.1/class.phpmailer.php');

//send_mail($body = "MESSAGE1" ,$address = "nishu.saxena@gmail.com" , $name="Nshant Saxena",$subject="Subject1 ");
function send_mail( $body,$address, $name,$subject){
	$mail             = new PHPMailer(); // defaults to using php "mail()"
	$mail->Port       =  25;                    // set the SMTP server port
	$mail->IsSMTP();
	$mail->SMTPAuth   = true;
	$mail->Host       = "smtp.seekersguru.com"; // SMTP server
	$mail->Username   = "info@seekersguru.com";     // SMTP server username
	$mail->Password   = "XvkPgcSkJ8"; 
	
	//$body             = eregi_replace("[\]",'',$body);
	
	//$mail->AddReplyTo("info@seekersguru.com","First Last");
	
	$mail->SetFrom('info@seekersguru.com', 'Groffr Admin');
	
	//$mail->AddReplyTo("info@seekersguru.com","First Last");
	
	
	$mail->AddAddress($address, $name);
	
	$mail->Subject    = $subject;
	
	//$mail->AltBody    = "To view the message, please use an HTML compatible email viewer!"; // optional, comment out and test
	
	$mail->MsgHTML($body);
	
	//$mail->AddAttachment("images/phpmailer.gif");      // attachment
	//$mail->AddAttachment("images/phpmailer_mini.gif"); // attachment
	
	if(!$mail->Send()) {
	  echo "Mailer Error: " . $mail->ErrorInfo;
	} else {
	  echo "Message sent!";
	}

}


//send_mail($body = "MESSAGE1" ,$address = "nishu.saxena@gmail.com" , $name="Nshant Saxena",$subject="Subject1 ");
?>