<?php
	ob_start();
	@session_start();
		 error_reporting(0);
/************************************** IP Addres For local demo and live Define Here *************************************/
$Company_Email_ID =  "info@maddyzone.com";

	$local_IP 	= 	array("localhost","127.0.0.1");
	$this_host 	= 	$_SERVER['HTTP_HOST'];			

	if (in_array ($this_host, $local_IP)) {
		define("CONFIG_MODE", "LOCAL");
	}
	else {
		define("CONFIG_MODE", "LIVE");
	}
	
/************************************** End IP Addres For local demo and live Define Here *************************************/
	
	
/************************************** Constants Define Here *************************************/
	switch (CONFIG_MODE) {
	
	
/**************************************For local system Constants Define Here *************************************/
			
			
		case "LOCAL":
			define("SERVER", "localhost");
			define("DBASE", "loginsystem");
			define("USER", "root");
			define("PASS", "");
			define("WEBSITE_URL", "http://" . $_SERVER['HTTP_HOST'] . '/Groffr/');
			define("WEBSITE_IMG_URL", "http://" . $_SERVER['HTTP_HOST'] . '/Groffr/');
			define("WEBSITE_ROOT_URL", $_SERVER['DOCUMENT_ROOT'] . '/Groffr/');
			$makeNew_dir 		=	$_SERVER['DOCUMENT_ROOT'].'/Groffr/'; // For Make a new Directory for client Panel 
			$upload_logo 		=	$_SERVER['DOCUMENT_ROOT'].'/Groffr/upload_logo/'; // For Upload logo Path 
			define("LOGO_PATH" ,"upload_logo/"); // For upload logo image Retrive Path 
			define("DIR_PATH","http://".$_SERVER['HTTP_HOST']."/Groffr/");
	
			
			break;
/***************************************For Demo server Constants Define Here *************************************/
			
/****************************************For Live server Constants Define Here ***************************************/
			
			
		case "LIVE":
			define("SERVER", "");
			define("DBASE", "");
			define("USER", "");
			define("PASS", "");
			define("WEBSITE_URL", "http://" . $_SERVER['HTTP_HOST'] . '/');
			define("WEBSITE_AFFILIATE_URL", "http://" . $_SERVER['HTTP_HOST'] . '/');
			define("WEBSITE_ROOT_URL", $_SERVER['DOCUMENT_ROOT'] . '/');
			$makeNew_dir 		=	$_SERVER['DOCUMENT_ROOT'].'/'; // For Make a new Directory for client Panel 
			$makeNewClient_dir 	=	$_SERVER['DOCUMENT_ROOT'].'docs/';	// For admin add new company
			$upload_logo 		=	$_SERVER['DOCUMENT_ROOT'].'upload_logo/'; // For Upload logo Path 
			define("LOGO_PATH" ,"upload_logo/"); // For upload logo image Retrive Path 
			define("DIR_PATH","http://".$_SERVER['HTTP_HOST']."/");
			
			
			break;
			/******************************************************************************************/
			
			}
			
/**************************************End Constants Define Here *************************************/


/************************************** All Global Constants will Define Here *************************************/

	define("CLASS_FOLDER", "classes/");
	define("FUNCTION_FOLDER", "function/");
	define("WEBSITE_TITLE", "Groffr");
	define('DIRSEP', DIRECTORY_SEPARATOR);
	
	define("ADMIN_MAIL", "riturajratan@gmail.com");
	/************************************** Paging contant for admin panel ****************************************************/
	
	define('RECORD_ON_PAGE', 4);
	define('ARTICLE_ON_PAGE', 4);
	define('PAGING_SCROLLING', 5);
	define('MinPasswordLength',7);
	
	/******************************************************************************************/
	
	
	define("SECRET_KEY", "secretkey");
	
	
	/************************************** End All Global Constants will Define Here *************************************/
	

/**************************************  All site path will Define Here *************************************/
	
	$site_path 			=	realpath(dirname (__FILE__) . DIRSEP) . DIRSEP;
	$root_site_path		= 	str_replace("include/", "", $site_path);
	$image_path			= 	str_replace("include", "uploads", $site_path);
	
/************************************** ALl Site Pages will pLaces Here*****************************************/
	
// html extension are given for security purpose basicaaly these files are made in php

   
	$SITE_Add_Redirect			= 'go';
	
	

/************************************** All Site Message  will palce here ********************************************/
	$LoginFailed  =  "Login Failed..!!";
	$LogoutSuccess =  "Logout Successfully..!!"; 
 	$User_Create_Sucess  = "User create Successfully..!!!";
	$User_Edit_Sucess  = "User Edit Successfully..!!!";
	$Name_Already_Exist_Error  =  "This User Name Already Exist...!!!";
	
	$CaptchaFailed  =  "The CAPTCHA Text wasn't entered correctly.";
	$QuerySucess  =  "Thanks for your Query We Will contact you very soon";
	$FilledError  =  "Please Fill All The Items...!!!";
	$EmailError  =  "Please Fill Correct Email ID...!!!";
	$AccountError =  "There is some problem in account creation. Please after some time...!!!";
	$AccountSuccess =  "Your Account is made Successfully. Please Check your mail ...!!!";
	$Email_Account_Exist = "By This email account already exist..!!!"; 
	
	$EmptyOldPassword = "please write old password..!!!<br>"; 
	$ErrorOldPassword ="Old password is not correct..!!!<br>";
	$EmptyNewPassword= "please write new password..!!!<br>"; 
	$EmptyConfPassword= "please write confirm password..!!!<br>"; 
	$PasswordNotMatchError = "new and confirm password is not matched..!!!<br>"; 
	$PasswordLengthError = "Password length should be minimum ".MinPasswordLength." character length!!!<br>";
	$passwordSend  =  "your password is send in your mail Please check your mail...!!!";
	$passwordChange = "your password is Change Successfully...!!!";
	
	$Page_Edit_Sucess = "Page Edit Successfully.....!!!";
	$Page_Edit_Fail = "Some Problem in Page Edit .....!!!";
	
	

/************************************** All classes will palce here ********************************************/

	include_once("db-tables.php");
	include_once($site_path.CLASS_FOLDER . "db.class.php");
	include_once($site_path.CLASS_FOLDER . "session_class.php");
	include_once($site_path.CLASS_FOLDER . "login_class.php");
	include_once($site_path.CLASS_FOLDER . "class.phpmailer.php");
	include_once($site_path.CLASS_FOLDER . "formvalidator.php");
		

/************************************** End All classes will palce here ********************************************/

/************************************** object creation will palce here ********************************************/
		
	$mySession		=	new Session();
	$db				=	new DB(DBASE, SERVER, USER, PASS);
	$objLogin		=	new Login();

/**************************************End object creation will palce here ********************************************/

/**************************************All Functions will palce here ********************************************/

	include_once($site_path.FUNCTION_FOLDER . "functions.php");
	include_once($site_path.FUNCTION_FOLDER . "site_function.php");
/***************************** all security function are written in this file ****/    
	include_once("sec.php");	
?>