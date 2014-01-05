<?php
include('connection.php');
include('linkedin/linkedin_function.php');
$social = 0;
$loginwith = 'Main';
/** fb set **/
$client_id = '240625999437259';
$secret_key = '060a9cddefeffd951a24a8ff95e0b4ca';

if(isset($_GET['code'])) {
 $code = $_GET['code'];
  $client_id = '240625999437259';
  $secret_key = '060a9cddefeffd951a24a8ff95e0b4ca';
  parse_str(sc_curl_get_contents("https://graph.facebook.com/oauth/access_token?" .
    'client_id=' . $client_id . '&redirect_uri=' . urlencode('http://groffr.in/login.php') .
    '&client_secret=' .  $secret_key .
    '&code=' . urlencode($code)));
  $fb_json = json_decode( sc_curl_get_contents("https://graph.facebook.com/me?access_token=" . $access_token) );
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
    $newQuery="select userid,firstname,lastname from register where email ='". $_SESSION['email']."'";
    $login_result = mysql_query($newQuery);
      if( mysql_num_rows($login_result) > 0 ){
       $user_data = mysql_fetch_object( $login_result )  ;
       $_SESSION['userid'] = $user_data->userid;
       $_SESSION['user_id']= $user_data->userid;
       }
      else
      {
         $query = "insert into register(`firstname`,`lastname`,`email`,`password`,`status`,`loginwith`)
           values('".$_SESSION['fname']."',
                  '".$_SESSION['lname']."',
                  '".$_SESSION['email']."',
                  '". $_SESSION['passcode']."',
                  'active',
        '".$loginwith."' )";
         $mysql = mysql_query($query) or die(mysql_error() );
         $_SESSION['userid'] = mysql_insert_id();
           $_SESSION['user_id'] =$_SESSION['userid'];
       }
    
    header("Location: selecttype.php");

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
  if( isset($_POST['signin']) ){
    $email    = mysql_real_escape_string($_POST['email']);
    $password = mysql_real_escape_string($_POST['password']);
   $login_result = mysql_query("select * from register where email ='".$email."' and password = '".$password."'");
    if( mysql_num_rows($login_result) > 0){
      $user_data = mysql_fetch_object( $login_result )  ;
        $_SESSION['fname'] = $user_data->firstname;
        $_SESSION['lname'] = $user_data->lastname;
        $_SESSION['user_id'] = $user_data->userid;
        header('location:selecttype.php');
      }
      else{
        $error=1;
        $msg="Email or password does not match";
              }
  }


  if( $_GET['login']=='linkedin'){
          $social = 1;

        $_SESSION['oauth']['linkedin']['authorized'] = (isset($_SESSION['oauth']['linkedin']['authorized'])) ? $_SESSION['oauth']['linkedin']['authorized'] : FALSE;
                if($_SESSION['oauth']['linkedin']['authorized'] === TRUE) {
                  $OBJ_linkedin = new LinkedIn($API_CONFIG);
                    $OBJ_linkedin->setTokenAccess($_SESSION['oauth']['linkedin']['access']);
                  $OBJ_linkedin->setResponseFormat(LINKEDIN::_RESPONSE_XML);
                }


          $response         = $OBJ_linkedin->profile('~:(id,first-name,last-name,picture-url,email-address)');
          $result             = new SimpleXMLElement($response['linkedin']);
                $_SESSION = array();
              //  $_SESSION['passcode']   = $result->id;
                $_SESSION['passcode'] ="linkedian@1234";
                $_SESSION['fname']    = $result->{'first-name'};
                $_SESSION['lname']    = $result->{'last-name'};
                $_SESSION['email'] =    $result->{'email-address'};
                $result->email-address;

                $loginwith = 'LinkedIn';

      $login_result = mysql_query("select * from register where email ='". $_SESSION['email']."'");
      if( mysql_num_rows($login_result) > 0 ){
         $user_data = mysql_fetch_object( $login_result )  ;
          $_SESSION['userid'] = $user_data->userid;
          $_SESSION['user_id']= $user_data->userid;
           $_SESSION['fname']  =$user_data->firstname;
           $_SESSION['lname']  =$user_data->lastname;
           $_SESSION['email']  =$user_data->email;
           
       
       }
      else
      {
         $query = "insert into register(`firstname`,`lastname`,`email`,`password`,`status`,`loginwith`)
           values('".$_SESSION['fname']."',
                  '".$_SESSION['lname']."',
                  '".$_SESSION['email']."',
                  '". $_SESSION['passcode']."',
                  'active',
        '".$loginwith."' )";
         $mysql = mysql_query($query) or die(mysql_error() );
         $_SESSION['userid'] = mysql_insert_id();
         $_SESSION['user_id'] =$_SESSION['userid'];
       }
    

   @header("location:selecttype.php");
 
   }
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="shortcut icon" href="../../assets/ico/favicon.png">

    <title>Signin Template for Bootstrap</title>

    <!-- Bootstrap core CSS -->
    <link href="assets/css/bootstrap.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="signin.css" rel="stylesheet">

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="assets/js/html5shiv.js"></script>
      <script src="assets/js/respond.min.js"></script>
    <![endif]-->
    <style>
    #linkedin_connect_form #linksubmit {
  background: url("/assets/images/ln_connect.jpg") no-repeat scroll 0 0 transparent;
 color: #000000;
 cursor: pointer;
font-weight: bold;
height: 23px;
padding-bottom: 12px;
width: 155px;
}
    </style>
  </head>

  <body>
<div class="container">
		<div class="navbar navbar-inverse navbar-fixed-top" role="navigation">
  	  <div class="container">
  	    <div class="navbar-header">
  	      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
  	        <span class="sr-only">Toggle navigation</span>
  	        <span class="icon-bar"></span>
  	        <span class="icon-bar"></span>
  	        <span class="icon-bar"></span>
  	      </button>
  	      <a class="navbar-brand" href="http://groffr.in">Groffr</a>
  	    </div>
  	    <div class="navbar-collapse collapse">
  	      <ul class="nav navbar-nav">
  	        <li ><a href="register.php">Register</a></li>
  	        <li><a class="active" href="login.php">Login</a></li>
  	       
  	      </ul>
  	    </div><!--/.nav-collapse -->
  	  </div>
  	</div>
    <!-- Fixed navbar -->
    <div class="container">
      <div style=' margin-top:120px' class='col-sm-4'>

      <span class='border-right:1px solid #000;'>
        <a href="https://graph.facebook.com/oauth/authorize?client_id=240625999437259&redirect_uri=<?php echo urlencode('http://groffr.in/login.php'); ?>">
          <img src='assets/images/fb_connect.png'>
        </a>
      </span>
      <form id="linkedin_connect_form" action="<?php echo $_SERVER['PHP_SELF'];?>" method="get">
        <input type="hidden" name="<?php echo LINKEDIN::_GET_TYPE;?>" id="<?php echo LINKEDIN::_GET_TYPE;?>" value="initiate" />
        <input type="submit"  id="linksubmit" value="" name="linkedin" />
        </form> 
      </div>
      <div class=''>

      <form class="form-signin" method="POST">
        <?php if($error){ echo '<div class="alert alert-danger">'.$msg.'</div>';} ?>
        <h2 class="form-signin-heading">Please sign in</h2>
        <input type="text" class="form-control" placeholder="Email address" autofocus name='email'>
        <input type="password" class="form-control" placeholder="Password" name='password'>
        <!-- <label class="checkbox">
          <input type="checkbox" value="remember-me"> Remember me
        </label> -->
        <input type="hidden" value="signin" name="signin" /> 
        <button class="btn btn-lg btn-primary btn-block" type="submit">Sign in</button>
       <br>
       
       <a href="register.php" type="button" class="btn btn-success">Register</a>
      </form>

      </div>

    </div> <!-- /container -->


    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
  </body>
</html>
