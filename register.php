<?php
include('app_inc/main-config.php');

if($mySession->getSession('msg'))
{
	$msg			= 	$mySession->getSession('msg');
	$fname			=	$mySession->getSession('fname');
	$lname	    	=   $mySession->getSession('lname');
	$email			=   $mySession->getSession('email');
	$passcode		= 	$mySession->getSession('passscode');
	$fnameErr		=	$mySession->getSession('fname err');
	$lnameErr		=	$mySession->getSession('lname err');
	$emailErr		=	$mySession->getSession('email err');
	$passcodeErr	=	$mySession->getSession('passcode err');
	
	
	$mySession->removeSession('fname');
	$mySession->removeSession('lname');
	$mySession->removeSession('email');
	$mySession->removeSession('passcode');
	$mySession->removeSession('msg');
	
	
    $mySession->removeSession('fname err');
	$mySession->removeSession('lname err');
	$mySession->removeSession('email err');
	$mySession->removeSession('passcode err');
	
}
else
{
	$fname						=	'';
	$lname						=	'';
	$email					    =   '' ;
	$passcode					=   '' ;
	
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
<style>
.error{
color:"red";

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
  	        <li class="active"><a href="register.php">Register</a></li>
  	        <li><a href="login.php">Login</a></li>
  	       
  	      </ul>
  	    </div><!--/.nav-collapse -->
  	  </div>
  	</div>
    <!-- Fixed navbar -->
<br>


      <div style=' margin-top:120px' class='jumbotron'>
	<form role="form" method="POST" action="<?php echo WEBSITE_URL; ?>action.php">
	<?php if($msg =="alreadyexist"){echo '<div class="alert alert-danger">A user with email address <b>'. $email .'</b> already registered please <a href="login.php">Login</a> </div>';}
 ?>
		<div class="form-group">
		<label>First Name</label> 
		<input type="text" name="fname" class="form-control" placeholder="Enter First Name" autocomplete="off" required value="<?php echo $fname; ?>"> 
	    <span class="error"><?php echo $fnameErr; ?></span>
	   </div>
	   <div class="form-group">
		<label>Last Name</label>  
		<input type="text" name="lname" class="form-control" placeholder="Enter Last Name" autocomplete="off" required value="<?php echo $lname; ?>">
		<span class="error"><?php echo $lnameErr; ?></span>
		</div>
	   <div class="form-group">
		<label>Email</label>     <input type="email" name="email" class="form-control" placeholder="Enter Email Address" autocomplete="off" required value="<?php echo $email; ?>">
		<span class="alert error"><?php echo $emailErr; ?></span>
		</div>
	 
		<div class="form-group">
		<label>Password</label>     <input type="password" name="passcode" class="form-control" placeholder="Password" autocomplete="off" required value="<?php echo $passcode; ?>">
		<span class="error"><?php echo $passcodeErr; ?></span>
		</div>
			<input type="hidden" name="loginwith" value="Main" />
			<input type="hidden" name="action" value="register" /> 

		  <button type="submit" name="register" class="btn btn-default">Register</button>
	
	</form>
  </div>

    </div> <!-- /container -->
</body>
</html>