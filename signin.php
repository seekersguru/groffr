<?php
include('connection.php');
$social = 0;
$loginwith = 'Main';
/** fb set **/ $client_id = '240625999437259';
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
  if( isset($_POST['signin']) ){
    $email    = mysql_real_escape_string($_POST['email']);
    $password = md5( mysql_real_escape_string($_POST['password'] ));
    $login_result = mysql_query("select id,fname,lname from register where email ='".$email."' and password = '".$password);
    if( mysql_num_rows($login_result) > 0){
      $user_data = mysql_fetch_object( $login_result )  ;
        $_SESSION['fname'] = $user_data->fname;
        $_SESSION['lname'] = $user_data->lname;
        $_SESSION['user_id'] = $user_data->id;
        header('Location:myaccount.php');
      }
      else{
        echo "Email or password does not match";
      }
  }

  /* Login With Linked in */
  include("linkedin/linkedin_function.php");

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
  </head>

  <body>

    <div class="container">
      <div style=' margin-top:120px' class='col-sm-4'>

      <span class='border-right:1px solid #000;'>
        <a href="https://graph.facebook.com/oauth/authorize?client_id=240625999437259&redirect_uri=<?php echo urlencode('http://localhost/Groffr/myaccount.php'); ?>">
          <img src='assets/images/fb_connect.png'>
        </a>
      </span>
      <span>
        <img src='assets/images/ln_connect.jpg'>
      </span>
      </div>
      <div class=''>

      <form class="form-signin">
        <h2 class="form-signin-heading">Please sign in</h2>
        <input type="text" class="form-control" placeholder="Email address" autofocus name='email'>
        <input type="password" class="form-control" placeholder="Password" name='password'>
        <label class="checkbox">
          <input type="checkbox" value="remember-me"> Remember me
        </label>
        <button class="btn btn-lg btn-primary btn-block" type="submit">Sign in</button>
      </form>
      </div>

    </div> <!-- /container -->


    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
  </body>
</html>
