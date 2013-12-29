<?php
include('connection.php');
$social = 0;
$loginwith = 'Main';
/** fb set **/
?>


<a href="https://graph.facebook.com/oauth/authorize?client_id=240625999437259&redirect_uri=<?php echo urlencode('http://localhost/Groffr/login.php');?>&scope=email,read_insights">Login with facebook</a>
<?php $client_id = '240625999437259';
$secret_key = '060a9cddefeffd951a24a8ff95e0b4ca';

if(isset($_GET['code'])) {
 $code = $_GET['code'];
  $client_id = '240625999437259';
  $secret_key = '060a9cddefeffd951a24a8ff95e0b4ca';
  parse_str(sc_curl_get_contents("https://graph.facebook.com/oauth/access_token?" .
    'client_id=' . $client_id . '&redirect_uri=' . urlencode('http://localhost/Groffr/login.php') .
    '&client_secret=' .  $secret_key .
    '&code=' . urlencode($code)));
	$fb_json = json_decode( sc_curl_get_contents("https://graph.facebook.com/me?access_token=" . $access_token) );
	//print_r($fb_json);
	    $sc_provider_identity = $fb_json->id;
		$sc_email = $fb_json->email;
		$sc_first_name = $fb_json->first_name;
		$sc_last_name = $fb_json->last_name;
		$sc_profile_url = $fb_json->link;
		$sc_birth = $fb_json->birthday;
		$sc_gender = $fb_json->gender;
		$sc_city = $fb_json->hometown->name;
		$sc_city = $fb_json->location->name;
		$sc_city = $fb_json->work[0]->employer->name;

		$_SESSION['fname'] =$sc_first_name;
		$_SESSION['lname']= $sc_last_name;
		$_SESSION['email'] = $sc_email;
		$_SESSION['passcode']= "xcxcx465461365";
		$social = 1;
		$loginwith = 'Facebook';

}
function sc_curl_get_contents( $url ) {
	$curl = curl_init();
	curl_setopt( $curl, CURLOPT_RETURNTRANSFER, 1 );
	curl_setopt( $curl, CURLOPT_URL, $url );
	curl_setopt( $curl, CURLOPT_SSL_VERIFYPEER, false );
    $html = curl_exec( $curl );
    curl_close( $curl );
    return $html;
}

/** end fb set*/

function oauth_session_exists() {
  if((is_array($_SESSION)) && (array_key_exists('oauth', $_SESSION))) {
    return TRUE;
  } else {
    return FALSE;
  }
}

if( isset($_POST['register']) ){

	$fname 	= mysql_real_escape_string($_POST['fname']);
	$lname 	= mysql_real_escape_string($_POST['lname']);
	$email 		= mysql_real_escape_string($_POST['email']);
	$passcode	= mysql_real_escape_string($_POST['passcode']);
	$loginwith	= mysql_real_escape_string($_POST['loginwith']);
	$status 	= 'active';
	$check_result = mysql_query("select id from register where email = '".$email ."'") or die(mysql_error());
	if( mysql_num_rows($check_result) == 0 ){

		$mysql = mysql_query("insert into register set fname	= '".$fname."',
								lname	=	'".$lname."',
								email		=	'".$email."',
								passcode	=	'".$passcode."',
								loginwith	=	'".$loginwith."',
								status		= 	'".$status."'");
		$_SESSION['fname'] = $fname;
		$_SESSION['lname'] = $lname;
		$_SESSION['user_id'] = mysql_insert_id();
		header('Location:myaccount.php');
	}
	else{
		echo "<br>A user with email address <b>". $email ."</b> already registered";
	}

}

/* Login With Linked in */

include("linkedin/linkedin_function.php");


?>

<!DOCTYPE HTML>
<html>
<head>
<title>Login System</title>
<meta http-equiv="content-type" content="text/html;charset=UTF-8">
<link rel="stylesheet" href="assets/css/style.css">
</head>
<body>

<div class="content">
	<div class="login_left">
		<span class="linkedin">
			<?php
				if( $_GET['login']=='linkedin'){
					$social = 1;

				$_SESSION['oauth']['linkedin']['authorized'] = (isset($_SESSION['oauth']['linkedin']['authorized'])) ? $_SESSION['oauth']['linkedin']['authorized'] : FALSE;
			         	if($_SESSION['oauth']['linkedin']['authorized'] === TRUE) {
			         		$OBJ_linkedin = new LinkedIn($API_CONFIG);
			           		$OBJ_linkedin->setTokenAccess($_SESSION['oauth']['linkedin']['access']);
			         		$OBJ_linkedin->setResponseFormat(LINKEDIN::_RESPONSE_XML);
			         	}


					$response 				= $OBJ_linkedin->profile('~:(id,first-name,last-name,picture-url,email-address)');
					$result         		= new SimpleXMLElement($response['linkedin']);
          	        $_SESSION['passcode'] 	= $result->id;
          			$_SESSION['fname'] 		= $result->{'first-name'};
          			$_SESSION['lname'] 		= $result->{'last-name'};
          			$_SESSION['email'] =    $result->{'email-address'};

          			$loginwith = 'LinkedIn';
				}
            ?>
        <form id="linkedin_connect_form" action="<?php echo $_SERVER['PHP_SELF'];?>" method="get">
        <input type="hidden" name="<?php echo LINKEDIN::_GET_TYPE;?>" id="<?php echo LINKEDIN::_GET_TYPE;?>" value="initiate" />
        <input type="submit" value="Connect to LinkedIn" name="linkedin" />
        </form>
	</span> <br/>
	</div>

	<form method="POST" action="?register=true">
	<div class="login_right">
		<label>First Name</label> <span class="txtbox"> <input type="text" name="fname" class="input_box" placeholder="Enter First Name" autocomplete="off" required value="<?php print $_SESSION['fname']?>"> </span>
		<label>Last Name</label> <span class="txtbox"> <input type="text" name="lname" class="input_box" placeholder="Enter Last Name" autocomplete="off" required value="<?php print $_SESSION['lname']?>"> </span>
		<label>Email</label>     <span class="txtbox"> <input type="email" name="email" class="input_box" placeholder="Enter Email Address" autocomplete="off" required value="<?php print $_SESSION['email']?>"></span>
		<?php if(!$social){ ?>
		<label>Password</label>  <span class="txtbox"> <input type="password" name="password" class="input_box" placeholder="Enter Password" required></span>
		<?php } ?>
		<input type="hidden" name="passcode" value="<?php print $_SESSION['passcode']?>"></span>
		<input type="hidden" name="loginwith" value="<?php print $loginwith?>"></span>

		<div class="submit_box"><input type="submit" value="Submit" name="register"> </div>
	<div>
	</form>
</div>

</body>
</html>