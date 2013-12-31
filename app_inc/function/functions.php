<?php
//********this function for check Format of date that is correct or not********//
function checkDateFormat($mydate) { 
       
    list($dd,$mm,$yy)=explode("-",$mydate); 
    if (is_numeric($yy) && is_numeric($mm) && is_numeric($dd)) 
    { 
        return checkdate($mm,$dd,$yy); 
    } 
    return false;            
} 
//********this function for get value from get and post that should not be an array********//
function getVal($key = "", $secured = 0)	
{
	$outVal="";
	if($key == "")
		return;
	
	if($_SERVER['REQUEST_METHOD'] == "GET")//1
	 {
		if(array_key_exists($key,$_GET))
		{
			if(strlen(trim($_GET[$key]))>0)//2
			{	
				if($secured == 1)//3
				{
					if (get_magic_quotes_gpc()==1)//4
						$outVal = $_GET[$key];
					else
						$outVal = addslashes($_GET[$key]);
				}//3
				else
				{
				$outVal = $_GET[$key];
				}
			}//2
			else
			{
				$outVal = "";
			}
		 }	
	 }
	else
	{
		if(array_key_exists($key,$_POST))
		{
			if(strlen(trim($_POST[$key]))>0)//2
			{	
				if($secured == 1)//3
				{
					if (get_magic_quotes_gpc()==1)//4
						$outVal = $_POST[$key];
					else
						$outVal = addslashes($_POST[$key]);
				}//3
				else
				{
				$outVal = $_POST[$key];
				}
			}//2
			else
			{
				$outVal = "";
			}
		}
	}
	return $outVal;
}

function getDirectorySize($path)
{
  $totalsize = 0;
  $totalcount = 0;
  $dircount = 0;
  if ($handle = opendir ($path))
  {
    while (false !== ($file = readdir($handle)))
    {
      $nextpath = $path . '/' . $file;
      if ($file != '.' && $file != '..' && !is_link ($nextpath))
      {
        if (is_dir ($nextpath))
        {
          $dircount++;
          $result = getDirectorySize($nextpath);
          $totalsize += $result['size'];
          $totalcount += $result['count'];
          $dircount += $result['dircount'];
        }
        elseif (is_file ($nextpath))
        {
          $totalsize += filesize ($nextpath);
          $totalcount++;
        }
      }
    }
  }
  closedir ($handle);
  $total['size'] = $totalsize;
  $total['count'] = $totalcount;
  $total['dircount'] = $dircount;
  return $total;
}

function sizeFormat($size)
{
	
    if($size<1024)
    {
        return $size." bytes";
    }
    else if($size<(1024*1024))
    {
        $size=round($size/1024,1);
        return $size." KB";
    }
    else if($size<(1024*1024*1024))
    {
        $size=round($size/(1024*1024),1);
        return $size." MB";
    }
    else
    {
        $size=round($size/(1024*1024*1024),1);
        return $size." GB";
    }

} 

#############################################



/*************************** getVal Function End *******************************/	

/*======================================================*/
function getPage()
{	
	global	$db;
	global	$mySession;
	global	$page1;
	
	if(isset($_REQUEST['url'])&&($_REQUEST['url']!="")){
		$page=$_REQUEST['url'];
	}elseif(isset($_REQUEST['go'])&&($_REQUEST['go']!="")){
	$page=$_REQUEST['go'];
	}
	
	if(isset($page))
	{
	 
	 $pageToCall = $page.".php";
	if (file_exists($pageToCall)) {
    
     } else {
    $pageToCall = "error.php";
     }
	}
	else
	$pageToCall = "error.php";
	
	$success = include_once($pageToCall);
	
	return $success;
}

function getPage1($go="")
{	
	global	$db;
	global	$fo;
	global	$mySession;
	global  $pageID;
	
	$page=$go;
	
	
	
	if(isset($page))
	{
	 
	$pageToCall = $page.".php";
	if (file_exists($pageToCall)) {
    
     } else {
    $pageToCall = "error.php";
     }
	}
	else
	$pageToCall = "error.php";
	
	$success = include_once($pageToCall);
	
	return $success;
}
/*======================================================*/

	###########################//Encryption #Start ###################################################
function encrypt($sData, $sKey)
{
	$sResult = '';
	
	for($i = 0; $i < strlen($sData); $i ++)
	{
		$sChar    = substr($sData, $i, 1);
		$sKeyChar = substr($sKey, ($i % strlen($sKey)) - 1, 1);
		$sChar    = chr(ord($sChar) + ord($sKeyChar));
		$sResult .= $sChar;
	}
	
	return encode_base64($sResult);
}
###########################//Encryption #End ###################################################

###########################//Decrypt #Start ######################################################
function decrypt($sData, $sKey)
{
	$sResult = '';
	$sData   = decode_base64($sData);
	
	for($i = 0; $i < strlen($sData); $i ++)
	{
		$sChar    = substr($sData, $i, 1);
		$sKeyChar = substr($sKey, ($i % strlen($sKey)) - 1, 1);
		$sChar    = chr(ord($sChar) - ord($sKeyChar));
		$sResult .= $sChar;
	}
	
	return $sResult;
}
###########################//Decrypt #End ######################################################

###########################//Encode Decode #Start ##############################################
function encode_base64($sData)
{
	$sBase64 = base64_encode($sData);
	return strtr($sBase64, '+/', '-_');
}
		####################################################################################
function decode_base64($sData)
{
	$sBase64 = strtr($sData, '-_', '+/');
	return base64_decode($sBase64);
}
###########################//Encode Decode #End ################################################

/*************************** Email Address Validation Function Start *******************************/
function check_email_address($email) {
	// First, we check that there's one @ symbol, and that the lengths are right
	if (!ereg("^[^@]{1,64}@[^@]{1,255}$", $email)) {
		// Email invalid because wrong number of characters in one section, or wrong number of @ symbols.
		return false;
	}
	// Split it into sections to make life easier
	$email_array = explode("@", $email);
	$local_array = explode(".", $email_array[0]);
	for ($i = 0; $i < sizeof($local_array); $i++) {
		 if (!ereg("^(([A-Za-z0-9!#$%&'*+/=?^_`{|}~-][A-Za-z0-9!#$%&'*+/=?^_`{|}~\.-]{0,63})|(\"[^(\\|\")]{0,62}\"))$", $local_array[$i])) {
			return false;
		}
	}    
	if (!ereg("^\[?[0-9\.]+\]?$", $email_array[1])) { // Check if domain is IP. If not, it should be valid domain name
		$domain_array = explode(".", $email_array[1]);
		if (sizeof($domain_array) < 2) {
				return false; // Not enough parts to domain
		}
		for ($i = 0; $i < sizeof($domain_array); $i++) {
			if (!ereg("^(([A-Za-z0-9][A-Za-z0-9-]{0,61}[A-Za-z0-9])|([A-Za-z0-9]+))$", $domain_array[$i])) {
				return false;
			}
		}
	}
	return true;
}
/*************************** Email Address Validation Function End   *******************************/

/*************************** Check Session For Admin Function Start ******************************************/
function check_session(){
	if(isset($_SESSION["loginUserId"]))
	{
		$loginUserId	=	$_SESSION["loginUserId"];
		if($loginUserId=='')
		{
			header("location:".WEBSITE_URL."vrd_admin/login.php");
			exit;
		}
	}else{
		header("location:".WEBSITE_URL."vrd_admin/login.php");		
		exit;
	}
}
/*************************** Check Session For Admin Function End   ******************************************/

/*************************** Check Session For Front Function Start ******************************************/
function askLogin()
{
	$requestUrl	=	str_replace('/alisoncms/','',$_SERVER['REQUEST_URI']);
	$sessionErrorFlag	=	0;
	if(!isset($_SESSION["id"]))
	{
		$sessionErrorFlag	=	1;
	}else
	{
		if($_SESSION["id"]=='' || $_SESSION["id"]==NULL)
		{
			$sessionErrorFlag	=	1;		
		}
	}
	if($sessionErrorFlag	==	1)
	{
		echo "<script> window.location.href='".WEBSITE_URL."theme.php?go=signin&requestUrl=".$requestUrl."'</script>";
		exit;
	}
	
}
/*************************** Check Session For Front Function End   ******************************************/

/*******************************  Function to send mail Start *******************************/
function PHP_MAILLER( $TO, $CC, $FROM, $FROM_NAME, $REPLY_TO, $SUBJECT, $BODY, $ATTATCHMENT, $IS_HTML, $ALTERNET_BODY) 
{	
	require_once("../classes/class.phpmailer.php");
	$mail = new PHPMailer();
	$mail->IsMail();                                    
	
	$mail->From 	= $FROM;
	$mail->FromName = $FROM_NAME;
	$mail->AddAddress($TO);
	if( trim($CC) != "" ) 
	$mail->AddAddress($CC);
	$mail->AddReplyTo($REPLY_TO);
	
	if(trim($ATTATCHMENT) != "")
	for( $ii=0; $ii<count($ATTATCHMENT); $ii++)
	$mail->AddAttachment($ATTATCHMENT['rootPath'][$ii], $ATTATCHMENT['displayName'][$ii]);
	
	$mail->IsHTML($IS_HTML);                        // HTML [ TRUE/FALSE]
	$mail->Subject = $SUBJECT;
	$mail->Body    = $BODY;
	$mail->AltBody = $ALTERNET_BODY;
	
	if($mail->Send())
	return true; else
	return false;
}
		########################################################################

function sendMail($from, $to, $subject, $body, $cc="", $bcc="") {

		$header  = "MIME-Version: 1.0\r\n";//MIME VERSION
		$header .= "Content-type: text/html; charset=iso-8859-1\r\n";//MAIL TYPE
		#$header .= "To: $to\r\n";//RECIVER's EMAIL ADDRESS
		$header .= "From: $from\r\n";//SENDER's EMAIL ADDRESS
		if (!empty($cc)) {
			$header .= "Cc: $cc\r\n";//SEND MAIL COPY TO OTHER's
		}
		if (!empty($bcc)) {
			$header .= "Bcc: $bcc\r\n";//SEND MAIL COPY TO OTHER's
		}
		
		if(mail($to, $subject, $body, $header))
			return true;
		else
			return false;
}

/*******************************  Function to send mail End *******************************/

############################# //For Get the image extension # Start ############################################

function getExtension($str) {
	$i = strrpos($str,".");
	if (!$i) { return ""; }
	$l = strlen($str) - $i;
	$ext = substr($str,$i+1,$l);
	return $ext;
}

############################# //For Get the image extension # End ############################################

############################# //For Get the Data # Start ##########################################

function getData($tableName='', $fieldName='', $conditionField='', $conditionValue='')
{
	global $db;
	if($tableName=='' || $fieldName=='' || $conditionField=='' || $conditionValue=='')
	{
		//$msg	=	'Please provide the complete information';
		$msg	=	FALSE;
		return $msg;
	}else{
		 $sql	=	"SELECT ".$fieldName." FROM ".$tableName." WHERE ".$conditionField."=".$conditionValue;
		$que	=	$db->query($sql);
		$res	=	$db->fetchNextObject($que);
		$rows	=	$db->numRows();
		if($rows>0)
		{
			return $res->$fieldName;
		}else{
			//$msg	=	'Record Not Found';
			$msg	=	FALSE;
			return $msg;
		}
	}
}

############################# //For Get the Data # End ############################################

############################//convert time # Start//###############################################################

function period($date, $format="F d, Y")
{
	$period	=	date($format,$date);
	return $period;
}

############################//convert time # End//###############################################################

############################//convert time # Start//###############################################################

function periodWithTime($date){
	$period	=	date("g:i A d/m/Y",$date);
	return $period;
}
function MonthWithTime($date){
	$period	=	date("M",$date);
	return $period;
}


############################//convert time # End//###############################################################

function date_convert($date, $type){
  $date_year=substr($date,0,4);
  $date_month=substr($date,5,2);
  $date_day=substr($date,8,2);
  if($type == 1):
  	// Returns the year Ex: 2003
  	$date=date("Y", mktime(0,0,0,$date_month,$date_day,$date_year));
  elseif($type == 2):
  	// Returns the month Ex: January
  	$date=date("F", mktime(0,0,0,$date_month,$date_day,$date_year));
  elseif($type == 3):
  	// Returns the short form of month Ex: Jan
  	$date=date("M", mktime(0,0,0,$date_month,$date_day,$date_year));
  elseif($type == 4):
  	// Returns numerical representation of month with leading zero Ex: Jan = 01, Feb = 02
  	$date=date("m", mktime(0,0,0,$date_month,$date_day,$date_year));
  elseif($type == 5):
  	// Returns numerical representation of month without leading zero Ex: Jan = 1, Feb = 2
  	$date=date("n", mktime(0,0,0,$date_month,$date_day,$date_year));
  elseif($type == 6):
  	// Returns the day of the week Ex: Monday
  	$date=date("l", mktime(0,0,0,$date_month,$date_day,$date_year));
  elseif($type == 7):
  	// Returns the day of the week in short form Ex: Mon, Tue
  	$date=date("D", mktime(0,0,0,$date_month,$date_day,$date_year));
  elseif($type == 8):
  	// Returns dd-mm-yyyy
  	$date = date('d/m/Y', strtotime($date));
  elseif($type == 9):
  	// Returns a combo Ex: November 12th,2003
  	$date=date("F jS, Y", mktime(0,0,0,$date_month,$date_day,$date_year));
  elseif($type == 10):
  	// Returns a combo Ex: Nov 12th,2003
  	$date = date('M d, Y', strtotime($date));
  elseif($type == 11):
  	// Returns a combo ExL Wed,Nov 12th,2003
  	$date=date("D, M jS, Y", mktime(0,0,0,$date_month,$date_day,$date_year));
  elseif($type == 12):
  	// Returns mm-dd-yyyy
  	$date = date('m-d-Y', strtotime($date));
  elseif($type == 13):
  	// Returns yyyy-mm-dd
  	$date = date('Y/m/d', strtotime($date));
  elseif($type == 14):
  	// Returns Date and Time combo Ex: Nov 12th,2003 10:22:25
  	$date = date('M d, Y H:i:s', strtotime($date));
  elseif($type == 15):
  	// Returns Date and Time combo Ex: Nov 12th,2003 10:22:25
  	$date = date('F jS, Y', $date);
  elseif($type == 16):
  	// Returns Date and Time combo Ex: Nov 12th,2003 10:22:25
  	$date = date('l, F jS, Y', $date);
 elseif($type == 17):
  	// Returns Date 12
  	$date = date('j', $date);	
  endif;
  return $date;
}

############################################################################

function GET_CURRENT_FILE(){
	$filename	=	$_SERVER['REQUEST_URI'];
	$fname	=	split("/",$filename);
return $fname[count($fname)-1];
}

############################################################################

function getAlphaSearch($page, $tableName, $fieldname, $condition="", $keyword=""){

	global $db;
 	$listSql 			=	"SELECT $fieldname FROM ".$tableName." WHERE 1".$condition;
	$listQuery 			=	$db->query($listSql);
	$findArray			=	array();
	$ext                =  str_replace(" AND ","&",$condition);

    $alphaArray			=array("A","B","C","D","E","F","G","H","I","J","K","L","M","N","O","P","Q","R","S","T","U","V","W","X","Y","Z");
	while($customerList	=	$db->fetchNextObject($listQuery)){
		
		if(preg_replace('/([A-Z])/', '\\1', $customerList->$fieldname)) 
		{ 
			$findArray[]= ucwords(substr($customerList->$fieldname,0,1)); 
		} 
	}
	
	if($keyword!=""){
	$searchstring="<a class=\"action\" href=\"#\" onclick=\"return searchKeyword('$page','ALL','".$ext."')\" title=\"Search with ALL\">ALL</a>&nbsp;&nbsp;";}else{
	$searchstring="";
	
	}
	foreach($alphaArray as $value){
		if(in_array($value,$findArray)){
		if($value==$keyword){
		$searchstring.="<font color=\"#ff6600\" size=\"+1\">$value</font>&nbsp;&nbsp;";
		}else{
		$searchstring.="<a href=\"#\" onclick=\"return searchKeyword('$page','$value','".$ext."')\" title=\"Search with $value\">$value</a>&nbsp;&nbsp;";
		}
		}else{
		$searchstring.="<font color=\"#999999\" size=\"-4\">$value</font>&nbsp;&nbsp;";
		}
	
	}

return $searchstring;

}
############################################################################

function Display_Limited_Character($string, $str_len) {
	
	if ( strlen($string) > $str_len ){
	  $short_string = substr(strip_tags($string), 0, $str_len)."..";
	}
	else{
	  $short_string = $string;      
	}
		
	return $short_string;
	
}




############################################################################

function htmlTruncate($s, $l, $e = '...', $isHTML = false){
		$i = 0;
		$tags = array();
		if($isHTML)
		{
			preg_match_all('/<[^>]+>([^<]*)/', $s, $m, PREG_OFFSET_CAPTURE | PREG_SET_ORDER);
			foreach($m as $o)
			{
				if($o[0][1] - $i >= $l)
					break;
				$t = substr(strtok($o[0][0], " \t\n\r\0\x0B>"), 1);
				if($t[0] != '/')
					$tags[] = $t;
				elseif(end($tags) == substr($t, 1))
					array_pop($tags);
				$i += $o[1][1] - $o[0][1];
			}
		}
		return substr($s, 0, $l = min(strlen($s),  $l + $i)) . (count($tags = array_reverse($tags)) ? '</' . implode('></', $tags) . '>' : '') . (strlen($s) > $l ? $e : '');
}


############################################################################
		
function user_exists($user){
	$userCheck1	=	mysql_query("SELECT * FROM ".REGISTRATION." WHERE username='".$user."' ");
	  $userNumRows1	=	mysql_num_rows($userCheck1);

if($userNumRows1>0){
		return TRUE;
	}else{
		return FALSE;
	}
}

############################################################################

function email_exists_registration($email_reg){
	
	$emailCheck1	=	mysql_query("SELECT * FROM ".REGISTRATION." WHERE email='".$email_reg."' ");
	$emailNumRows1	=	mysql_num_rows($emailCheck1);
	if($emailNumRows1>0)
	{
	return TRUE;
	}
	else
	{
	return FALSE;
	}
}

############################################################################

function inEdit_email_exists($email, $id){
		
		$emailCheck1	=	mysql_query("SELECT * FROM ".REGISTRATION." WHERE email='".$email."' AND id<>$id ");
		$emailNumRows1	=	mysql_num_rows($emailCheck1);
	
	if($emailNumRows1>0){
		return TRUE;
	}else{
		return FALSE;
	}
}

############################################################################

function inEdit_user_exists($user, $id){

		$userCheck1	    =	mysql_query("SELECT * FROM ".REGISTRATION." WHERE username='".$user."' AND id<>$id ");
		$userNumRows1	=	mysql_num_rows($userCheck1);
	if($userNumRows1>0)
	{
		return TRUE;
	}
	else
	{
		return FALSE;
	}
}

############################################################################
function checkModule($go, $moduleHeader)
{
	global $db;
	
	$newGoArraay	=	explode('/',$go);

	
	$sql		=	"SELECT * FROM ".MODULES." WHERE modulePath LIKE '%".$newGoArraay[1]."%'";// AND isDeleted='0' AND isActive='1'";

	$query		=	$db->query($sql);
	$fetchValue	=	$db->fetchNextObject($query);
	
	$id	=	$fetchValue->id;
	if (in_array($id, $moduleHeader))
		return true;
	else
		return false;
}
################################################################################

//function for news article
function getCategoryName($catId)
{
$sqlcat   = mysql_query("select CategoryName from categories where CategoryID='$catId'");
if($catres =  mysql_fetch_array($sqlcat))
 {
  $catname  =  $catres['CategoryName'];
 }
return $catname;

}

function totalrecrd_Incat($catId)
{
$total =  0;
$sqlcat   = mysql_query("select count(*) as total from categories where CategoryID='$catId'");
if($catres =  mysql_fetch_array($sqlcat))
 {
  $total  =  $catres['total'];
 }
return $total;
}

function total_archive($dt)
{
$arc_total = 0;
$arc_sql   =  mysql_query("select count(*) as total from feeddata where Date like  '$dt%'");
if($res    =  mysql_fetch_array($arc_sql));
  {
   $arc_total = $res['total'];
  }
return $arc_total;
}



###################### check training course exist##################
//  main training pages
function training_course_exits($id){
	$trainingCheck		=	mysql_query("SELECT * FROM ".TRAINING_LINK." WHERE id='".$id."' ");
	$trainingNumRows	=	mysql_num_rows($trainingCheck);
	if($trainingNumRows>0)
	{
		return FALSE;
	}
	else
	{
		@header("location:home");
		exit;
	//return TRUE;
	}
}



###################### check training course exist##################
// details traning Pages
function training_course_details_Exist($id)
{
	$trainingCouDetCheck		=	mysql_query("SELECT * FROM ".TRAINING_PAGES." WHERE id='".$id."' ");
	$trainingCouDetNumRows		=	mysql_num_rows($trainingCouDetCheck);
	if($trainingCouDetNumRows>0)
	{
		return FALSE;
	}
	else
	{
		@header("location:home");
		exit;
	//return TRUE;
	}
}

##################check elearning course exist#######################
// main elearning pagea
function elearning_course_exits($course_id)
{
	$elearningCheck		=	mysql_query("SELECT * FROM ".ELEARNING." WHERE id='".$course_id."' ");
	$elearningNumRows	=	mysql_num_rows($elearningCheck);
	if($elearningNumRows>0)
	{
		return FALSE;
	}
	else
	{
		@header("location:home");
		exit;
	//return TRUE;
	}
}

// detail traning page
function elearning_course_details_exits($course_id)
{
	$elearningCheck		=	mysql_query("SELECT * FROM ".ELEARNING." WHERE id='".$course_id."' ");
	$elearningNumRows	=	mysql_num_rows($elearningCheck);
	if($elearningNumRows>0)
	{
		return FALSE;
	}
	else
	{
		@header("location:home");
		exit;
	//return TRUE;
	}
}

#######################################################################
// add to cart
function add_to_cart($training_id){
	$addtocartCheck		=	mysql_query("SELECT * FROM ".TRAINING." WHERE `id`='".$training_id."' ");
	$addtocartNumRows	=	mysql_num_rows($addtocartCheck);
	if($addtocartNumRows>0)
	{
		return FALSE;
	}
	else
	{
		@header("location:home");
		exit;
	//return TRUE;
	}
}


//check news id
function news_id_exits($id)
{
	$newsCheck		=	mysql_query("SELECT * FROM ".TABLE_NEWS." WHERE id='".$id."' ");
	$newsNumRows	=	mysql_num_rows($newsCheck);
	
	if($newsNumRows>0)
	{
		return FALSE;
	}
	else
	{
		@header("location:home");
		exit;
	//return TRUE;
	}
}

//#################################################################
//check resource id
function resource_id_exits($id)
{
	$newsCheck		=	mysql_query("SELECT * FROM ".TBALE_RESOURCE_CENTER." WHERE id='".$id."' ");
	$newsNumRows	=	mysql_num_rows($newsCheck);
	
	if($newsNumRows>0)
	{
		return FALSE;
	}
	else
	{
		@header("location:home");
		exit;
	//return TRUE;
	}
}

//############################## front Login###################################
function check_front_login_session(){
	if(isset($_SESSION["loginFrontUserId"]))
	{
		$loginFrontUserId	=	$_SESSION["loginFrontUserId"];
		if($loginFrontUserId=='')
		{
			header("location:".WEBSITE_URL."theme?go=login");
			exit;
		}
	}else{
		header("location:".WEBSITE_URL."theme?go=login");		
		exit;
	}
}
############################## user registration check ##############################
function emailAlreadyExits($email){
	
	
	$emailCheck1	=	mysql_query("SELECT * FROM ".TABLE_USERS." WHERE emailid='".$email."' ");
	$emailNumRows1	=	mysql_num_rows($emailCheck1);
	if($emailNumRows1>0)
	{
	return TRUE;
	}
	else
	{
	return FALSE;
	}
}
#####################################################################################
function forgetPasswordEmailExits($emailId){
	
	
	$emailCheck1	=	mysql_query("SELECT * FROM ".TABLE_USERS." WHERE emailid='".$emailId."' ");
	$emailNumRows1	=	mysql_num_rows($emailCheck1);
	if($emailNumRows1>0)
	{
	return FALSE;
	}
	else
	{
	return TRUE;
	}
}

################################################################################
function toolnameAddExits($toolName){
	
	$toolnameCheck		=	mysql_query("SELECT * FROM " . TABLE_EDU_TOOLS . " WHERE name='".$toolName."' ");
	$toolNameNumRows	=	mysql_num_rows($toolnameCheck);
	
	
	if($toolNameNumRows>0)
	{
	return TRUE;
	}
	else
	{
	return FALSE;
	}
}

############################################################################

function toolNameEditExits($toolName, $id){
		
	$toolnameCheck	=	mysql_query("SELECT * FROM ".TABLE_EDU_TOOLS." WHERE name='".$toolName."' AND id<>$id ");
	$toolNameNumRows	=	mysql_num_rows($toolnameCheck);
	
	if($toolNameNumRows>0)
	{
		return TRUE;
	}
	else
	{
		return FALSE;
	}
}

################################################################################
function ablumAddExits($albumTitle){
	
	$ablumNameCheck		=	mysql_query("SELECT * FROM " . TABLE_ALBUMS . " WHERE album_name='".$albumTitle."' ");
	$ablumNameNumRows	=	mysql_num_rows($ablumNameCheck);
	
	
	if($ablumNameNumRows>0)
	{
	return TRUE;
	}
	else
	{
	return FALSE;
	}
}
############################################################################

function ablumEditExits($albumTitle, $id){
		
	$ablumNameCheck	=	mysql_query("SELECT * FROM ".TABLE_ALBUMS." WHERE album_name='".$albumTitle."' AND id<>$id ");
	$ablumNameNumRows	=	mysql_num_rows($ablumNameCheck);
	
	if($ablumNameNumRows>0)
	{
		return TRUE;
	}
	else
	{
		return FALSE;
	}
}

################## Shri mudbhagwad gita for category 5 ########################
function categoryGeetaExist($albumTitle){
	
	$ablumNameCheck		=	mysql_query("SELECT * FROM " . TABLE_SBG_ONE . " WHERE website_url='".$albumTitle."' ");
	$ablumNameNumRows	=	mysql_num_rows($ablumNameCheck);
	
	
	if($ablumNameNumRows>0)
	{
		return TRUE;
	}
	else
	{
		return FALSE;
	}
}

################## Ramcharitmanas for category 5 ########################
function categoryRamExist($albumTitle){
	
	$ablumNameCheck		=	mysql_query("SELECT * FROM " . TABLE_CAND_ONE . " WHERE website_url='".$albumTitle."' ");
	$ablumNameNumRows	=	mysql_num_rows($ablumNameCheck);
	
	
	if($ablumNameNumRows>0)
	{
		return TRUE;
	}
	else
	{
		return FALSE;
	}
}
################## Ved for category 5 ########################
function categoryVedExist($albumTitle){
	
	$ablumNameCheck		=	mysql_query("SELECT * FROM " . TABLE_VED_ONE . " WHERE website_url='".$albumTitle."' ");
	$ablumNameNumRows	=	mysql_num_rows($ablumNameCheck);
	
	
	if($ablumNameNumRows>0)
	{
		return TRUE;
	}
	else
	{
		return FALSE;
	}
}

################## Shri mudbhagwad gita sub for category 5 ########################
function categoryGeetaSubExist($albumTitle){
	
	$ablumNameCheck		=	mysql_query("SELECT * FROM " . TABLE_SBG_TWO . " WHERE website_url='".$albumTitle."' ");
	$ablumNameNumRows	=	mysql_num_rows($ablumNameCheck);
	
	
	if($ablumNameNumRows>0)
	{
		return TRUE;
	}
	else
	{
		return FALSE;
	}
}

################## Shri mudbhagwad gita sub for category 5 ########################
function categoryRamSubExist($albumTitle){
	
	$ablumNameCheck		=	mysql_query("SELECT * FROM " . TABLE_CAND_TWO . " WHERE website_url='".$albumTitle."' ");
	$ablumNameNumRows	=	mysql_num_rows($ablumNameCheck);
	
	
	if($ablumNameNumRows>0)
	{
		return TRUE;
	}
	else
	{
		return FALSE;
	}
}

?>