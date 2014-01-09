<?php
include('app_inc/main-config.php');
 
     $action 				=	stripslashes(getVal('action',1));
	 $fname					=	getVal('fname',1);
	 $lname					=	getVal('lname',1);
	 $email					=	getVal('email',1);
	 $passcode				=	getVal('passcode',1);
	 $loginwith             =   getVAl('loginwith');
	 $status				=	getVal('status',1);
     $modifiedDate			=	time();
     $ip                    =  $_SERVER["REMOTE_ADDR"];

$already =0;
$msg= "NULL";

/*
set code at the time of user registration
 */

if( $action == 'register'){

	    $validator = new FormValidator();
		$validator->addValidation("fname","req","*Please fill Your First Name.");
		$validator->addValidation("lname","req","*Please fill Your Last Name.");
		$validator->addValidation("email","req","*Please fill Your valid Email ID .");
		$validator->addValidation("email","email","*The input for Email should be a valid email value.");
		$validator->addValidation("passcode","minlen=5","*The input for Password  should be a 5 character length.");

		if (!$validator->ValidateForm())
		{
			$error_hash = $validator->GetErrors();
            foreach($error_hash as $inpname => $inp_err)
			{
				$mySession->setSession("$inpname err", "$inp_err");
			}
            
        
            $mySession->setSession("fname", $fname);
			$mySession->setSession("lname", $lname);
			$mySession->setSession("email", $email);
			$mySession->setSession("passcode", $passcode);
			    

            $msg = "go for valid";
            $mySession->setSession("msg", $msg);
    		PQR_ValidationFailed($Fill_Valid_Feild, WEBSITE_REGISTER_URL);

 
		}else{

			$status 	= 'active';
			$check_result = mysql_query("select userid from register where email = '".$email ."'") or die(mysql_error());
			if( mysql_num_rows($check_result) == 0 ){
			 $query = "insert into register(`firstname`,`lastname`,`email`,`password`,`status`,`loginwith`,`time`,`ip`)
		           values
		        ('".$fname."',
				'".$lname."',
				'".$email."',
				'".$passcode."',
				'".$status."',
				'Main',
				'".$modifiedDate."',
				'".$ip."' )";

    	$db->execute($query);
        $lastid= $db->lastInsertedId();

        $mySession->setSession('fname',$fname);
        $mySession->setSession('lname',$lname);
        $mySession->setSession('userid',$lastid);
        $mySession->setSession('user_id',$lastid);

     SEC_AccountConfirmEmail($email, $mySession->getSession("userid"), ADMIN_MAIL, WEBSITE_URL);
	 PQR_ValidationPassed ($User_Create_Sucess,WEBSITE_MYACCOUNT_URL );
	}
	else{

    		$mySession->setSession("fname", $fname);
			$mySession->setSession("lname", $lname);
			$mySession->setSession("email", $email);
			$mySession->setSession("passcode", $passcode);
		
            $msg = "alreadyexist";
			$mySession->setSession("msg", $msg);
    		$mySession->setSession("email err", $Email_Account_Exist);
	    	PQR_ValidationFailed($Email_Account_Exist, WEBSITE_REGISTER_URL);

	}
  }
}


?>