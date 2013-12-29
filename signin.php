<?php
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
