<?php
	function SEC_UserLogin($con, $Email, $Password) {
	        $newPass=SEC_EncryptStringArray($Password);
			$query="SELECT * from ".USER_TABLE." WHERE EmailID = '$Email' AND  Password = '$newPass'" ;
            $result = mysqli_query($con,$query);
			if(mysqli_num_rows($result)==0)
			{
			return 0;
			}
			else{
			while($row = mysqli_fetch_array($result))
            {
			$_SESSION['userID']=$row['ID'];
			$_SESSION['Email']=$row['EmailID'];
			$_SESSION['Password']=$row['Password'];
			 
			$_SESSION['role']="user";
			if($row['Status']==0)
			{
			return -1;
			}
			else{
			return $row['ID'];
			}
		  }
 	}
}


function SEC_EncryptStringArray($stringArray, $key = 'fJ8$snO67Gl5GT') { 
		$s = strtr(base64_encode(mcrypt_encrypt(MCRYPT_RIJNDAEL_256, md5($key), serialize($stringArray), MCRYPT_MODE_CBC, md5(md5($key)))), '+/=', '-_,'); 
		return $s; 
	} 
	 
	function SEC_DecryptStringArray($stringArray, $key = 'fJ8$snO67G;)5GT') { 
		$s = unserialize(rtrim(mcrypt_decrypt(MCRYPT_RIJNDAEL_256, md5($key), base64_decode(strtr($stringArray, '-_,', '+/=')), MCRYPT_MODE_CBC, md5(md5($key))), "\0"));
		return $s; 
	}
	//BLL Functions
	function PQR_ValidationFailed($Message, $Redir) {
		$_SESSION["error_message"] = $Message;
		@header("Location: ".$Redir);
		 exit;
	}
	
		function PQR_ValidationPassed ($Message, $Redir) {
		$_SESSION["pass_success"] = $Message;
		@header("Location: ".$Redir);
	   exit;
	}
	
	
	function PQR_ValidEmailAddress ($Email) {
		if(preg_match('/^.+@.+\..{2,3}$/',$Email) > 0) return true;
		return false;
	}
	
	function SEC_AccountConfirmEmail($Email, $uuid, $From, $AccountConfURL) {
		//var_dump($Email.",". $uuid.",".$From.",".$AccountConfURL);
		$subject = "Confirm your new Groffr account registration.";
		$headers = "From: ".$From." \r\nReply-To: ".$From;
		$message = "This email was sent in response to a new account registration using your email address.\r\n";
		$message .= "If this was not you, then please report this to Groffr at the email address shown below.\r\n\r\n";
		$message .= "Otherwise, to activate your new account, please enter the address you see below into your web browser.\r\n\r\n";
		$message .= $AccountConfURL."?cnf=".$uuid."\r\n\r\n";
		$message .= "Best regards,\r\n\r\nThe Groffr team\n";
		$message .= "$From";
		return mail($Email, $subject, $message, $headers);
	}


function SEC_AccountConfirmEmailFB($Email, $uuid, $From, $AccountConfURL) {
//var_dump($Email.",". $uuid.",".$From.",". $AccountConfURL.",".$_SESSION['fb']['password']);
		//var_dump($Email.",". $uuid.",".$From.",".$AccountConfURL);
		$subject = "Confirm your new Groffr account registration.";
		$headers = "From: ".$From." \r\nReply-To: ".$From;
		$message = "This email was sent in response to a new account registration using your email address.\r\n";
		$message .= "If this was not you, then please report this to Groffr at the email address shown below.\r\n\r\n";
		$message .= "Otherwise, to activate your new account, please enter the address you see below into your web browser.\r\n\r\n";
		$message .= "Your Email:".$Email.".\r\n";
		$message .= "Your Password:".$_SESSION['fb']['password'].".\r\n" ;
		$message .= $AccountConfURL."?cnf=".$uuid."\r\n\r\n";
		$message .= "Best regards,\r\n\r\nThe Groffr team\n";
		$message .= "$From";
		return  mail($Email, $subject, $message, $headers);
	}
 

function SEC_SendPassword($Email,$From,$password,$AccountConfURL) {
//var_dump($Email.",". $uuid.",".$From.",". $AccountConfURL.",".$_SESSION['fb']['password']);
		//var_dump($Email.",". $uuid.",".$From.",".$AccountConfURL);
		$subject = "Password Changed Groffr.";
		$headers = "From: ".$From." \r\nReply-To: ".$From;
		$message = "This email was sent in response to change password using your email address.\r\n";
		$message .= "If this was not you, then please report this to Groffr at the email address shown below.\r\n\r\n";
		$message .= "Otherwise,  please enter the address you see below into your web browser.\r\n\r\n";
		$message .= "Your Email:".$Email.".\r\n";
		$message .= "Your Password:".$password.".\r\n" ;
		$message .= $AccountConfURL."\r\n\r\n";
		$message .= "Best regards,\r\n\r\nThe Groffr team\n";
		$message .= "$From";
		return  mail($Email, $subject, $message, $headers);
	}



?>