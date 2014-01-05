<?php
include('app_inc/main-config.php');
$already =0;
if( isset($_POST['register']) ){
	
	$fname 	= mysql_real_escape_string($_POST['fname']);
	$lname 	= mysql_real_escape_string($_POST['lname']);
	$email 		= mysql_real_escape_string($_POST['email']);
	$passcode	= mysql_real_escape_string($_POST['passcode']);
	$status 	= 'active';
	$loginwith = mysql_real_escape_string($_POST['loginwith']);

	$check_result = mysql_query("select userid from register where email = '".$email ."'") or die(mysql_error());
	if( mysql_num_rows($check_result) == 0 ){
	 $query = "insert into register(`firstname`,`lastname`,`email`,`password`,`status`,`loginwith`)
           values('".$fname."',
		'".$lname."',
		'".$email."',
		'".$passcode."',
		'".$status."',
		'Main' )";
	$mysql = mysql_query($query) or die(mysql_error() );
     	$_SESSION['fname'] = $fname;
	 	$_SESSION['lname'] = $lname;
		$_SESSION['userid'] = mysql_insert_id();
		$_SESSION['user_id'] =$_SESSION['userid'];

   SEC_AccountConfirmEmail($email, $_SESSION['userid'], "info@groffr.com", "http://groffr.in");
	header("location:myaccount.php");
	}
	else{
		$already =1;
				
	}
}
?>
<!DOCTYPE HTML>
<html>
<head>
<title>Register</title>
<meta http-equiv="content-type" content="text/html;charset=UTF-8">
<link rel="stylesheet" href="assets/css/style.css">
<link rel="stylesheet" href="assets/css/bootstrap.css">
<link rel="stylesheet" href="assets/css/signin.css">

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
  	        <li class="active"><a href="register.php">Register</a></li>
  	        <li><a href="login.php">Login</a></li>
  	       
  	      </ul>
  	    </div><!--/.nav-collapse -->
  	  </div>
  	</div>
    <!-- Fixed navbar -->
<br>


      <div style=' margin-top:120px' class='jumbotron'>
	<form role="form" method="POST" action="?register=true">
	<?php if($already){echo '<div class="alert alert-danger">A user with email address <b>'. $email .'</b> already registered please <a href="login.php">Login</a> </div>';}
 ?>
		<div class="form-group">
		<label>First Name</label> 
		<input type="text" name="fname" class="form-control" placeholder="Enter First Name" autocomplete="off" required value=""> 
	   </div>
	   <div class="form-group">
		<label>Last Name</label>  
		<input type="text" name="lname" class="form-control" placeholder="Enter Last Name" autocomplete="off" required value="">
		</div>
	   <div class="form-group">
		<label>Email</label>     <input type="email" name="email" class="form-control" placeholder="Enter Email Address" autocomplete="off" required value="">
		</div>
	 
		<div class="form-group">
		<label>Password</label>     <input type="password" name="passcode" class="form-control" placeholder="Password" autocomplete="off" required value="">
		</div>
			<input type="hidden" name="loginwith" value="Main"></span>
		
		
		<button type="submit" name="register" class="btn btn-default">Register</button>
	
	</form>
  </div>

    </div> <!-- /container -->
</body>
</html>