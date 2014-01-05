<?php include('app_inc/main-config.php');
if( !isset($_SESSION['user_id'] )){
	
  header("location:login.php");
}

if( $_GET['type'] !== ""  ){
  
if($_SESSION['type'] == "")
{
$_SESSION['type']=$_GET['type'];
}

}


if( isset($_POST['connect'] )){
	$project_id= mysql_real_escape_string( $_POST['project_id'] );
	$query = "insert into connection(`id`,`projects_id`,`register_id`,`help_message`,`link_page`,`attachment`,`connet_as`) values(null,'".$project_id."',
		".$_SESSION['user_id'].",'".$_POST['help_message']."','".$_POST['link_page']."','".$_POST['attachment']."','".$_POST['connet_as']."')";
	// echo $query."<br>";
	$mysql = mysql_query($query) or die(mysql_error() );

    $From="info@Groffr.com";
    $subject = "Your request to connect as ". $_POST['connet_as'] ." pendng";
    $headers = "From: ".$From." \r\nReply-To: ".$From;
    $message = "This email was sent in response to show your interest on project .\r\n";
    $message .= "If this was not you, then please report this to Groffr at the email address shown below.\r\n\r\n";
    $message .= "Otherwise,  please enter the address you see below into your web browser.\r\n\r\n";
    $message .= 'http://groffe.com/project.php?project='.$_POST['project_id'];
    $message .= "\rto see status\r\n\r\n";
    $message .= "Best regards,\r\n\r\nThe Groffr team\n";
    $message .= "$From";
     mail($_SESSION['email'], $subject, $message, $headers);
  echo "<div class='info'>Projected added to your connection</div>";
}
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>Groffr</title>

    <!-- Bootstrap core CSS -->
    <link href="assets/css/bootstrap.css" rel="stylesheet">
    
    <!-- Just for debugging purposes. Don't actually copy this line! -->
    <!--[if lt IE 9]><script src="../../docs-assets/js/ie8-responsive-file-warning.js"></script><![endif]-->

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
    <![endif]-->
    <script src="http://code.jquery.com/jquery-1.10.2.min.js"></script>
    <style>
    .hide_temp{
      display: none;
    }

    </style>
  

  </head>

  <body>
  	<!-- Fixed navbar -->
  	<div class="navbar navbar-inverse navbar-fixed-top" role="navigation">
  	  <div class="container">
  	    <div class="navbar-header">
  	      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
  	        <span class="sr-only">Toggle navigation</span>
  	        <span class="icon-bar"></span>
  	        <span class="icon-bar"></span>
  	        <span class="icon-bar"></span>
  	      </button>
  	      <a class="navbar-brand" href="<?php echo WEBSITE_URL;?>">Groffr</a>
  	    </div>
  	    <div class="navbar-collapse collapse">
  	      <ul class="nav navbar-nav">
  	        <li class="active"><a href="myaccount.php">My Account</a></li>
  	        <li><a href="add_project.php">Add Project</a></li>
  	        <li><a href="my_project.php">My Project</a></li>
            <li><a href="my_connection.php">My Connection</a></li>
             <li><a href="my_notification.php">My Notification</a></li>
            
  	        <li><a href="#"> <?php echo 'Welcome ' .$_SESSION['fname'] ." " .$_SESSION['lname']; ?></a></li>

  	          <li><a href="logout.php">LogOut</a></li>
  	       <!--  <li class="dropdown">
  	          <a href="#" class="dropdown-toggle" data-toggle="dropdown"> <?php echo 'Welcome ' .$_SESSION['fname'] ." " .$_SESSION['lname']; ?><b class="caret"></b></a>
  	          <ul class="dropdown-menu">
  	            <li><a href="logout.php">LogOut</a></li>
  	          
  	          <!--   <li class="divider"></li>
  	            <li class="dropdown-header">Nav header</li>
  	            <li><a href="#">Separated link</a></li>
  	            <li><a href="#">One more separated link</a></li>
 -->  	        <!--  </ul>
  	        </li> -->
  	      </ul>
  	    </div><!--/.nav-collapse -->
  	  </div>
  	</div>
    <!-- Fixed navbar -->
    <br>
    <br>