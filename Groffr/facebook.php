<?php $appid = "466798966673063" ; 
$redirect= "http://localhost/loginwithlinkedin/facebook.php/";
$client_secret = "48c060280eb9fa890978f580b20a4fe3";
?>

<a href="https://graph.facebook.com/oauth/authorize?client_id=<?php echo $appid;?>&redirect_uri=<?php echo $redirect;?>&scope=email, user_birthday, user_hometown, user_location, user_work_history, user_website, publish_stream&display=page">Login with facebook</a>

<?php 
if (isset($_GET['code']) AND !empty($_GET['code'])) {
    $code = $_GET['code'];
    parse_str(facebookall_get_fb_contents("https://graph.facebook.com/oauth/access_token?" . 'client_id=' . $appid . '&redirect_uri=' . urlencode($redirect) .'&client_secret=' .  $apisecret . '&code=' . urlencode($code)));
	}
  if(!empty($access_token)) {
    $fbuser_info = json_decode(facebookall_get_fb_contents("https://graph.facebook.com/me?access_token=".$access_token));
    $fbdata = facebookall_get_fbuserprofile_data($fbuser_info);
	print_r($fbdata);
	}
	
function facebookall_get_fb_contents($url) {
    if  (in_array  ('curl', get_loaded_extensions())) {
      $curl = curl_init();
	  curl_setopt( $curl, CURLOPT_URL, $url );
	  curl_setopt( $curl, CURLOPT_RETURNTRANSFER, 1 );
	  curl_setopt( $curl, CURLOPT_SSL_VERIFYPEER, false );
      $response = curl_exec( $curl );
      curl_close( $curl );
      return $response;
    }
	else {
	   $response = @file_get_contents($url);
	   return $response;
	}
  }