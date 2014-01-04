<?php
include('app_inc/main-config.php');

if( !isset($_SESSION['user_id'] )){
	
  header("location:login.php");
}

if( !isset($_GET['type'] )){
  
$_SESSION['type']=$_GET['type'];
}

if( isset($_POST['connect'] )){
	$project_id= mysql_real_escape_string( $_POST['project_id'] );
	$query = "insert into connection(`id`,`projects_id`,`register_id`) values(null,'".$project_id."',
		".$_SESSION['user_id'].")";
	// echo $query."<br>";
	$mysql = mysql_query($query) or die(mysql_error() );
	// exit;
	// header('Location:myaccount.php');
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
    <title>Add Project</title>

    <!-- Bootstrap core CSS -->
    <link href="assets/css/bootstrap.css" rel="stylesheet">
    
    <!-- Just for debugging purposes. Don't actually copy this line! -->
    <!--[if lt IE 9]><script src="../../docs-assets/js/ie8-responsive-file-warning.js"></script><![endif]-->

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
    <![endif]-->
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