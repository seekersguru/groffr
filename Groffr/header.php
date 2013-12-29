<?php
include('connection.php');
if( !isset($_SESSION['user_id'] )){
	header("location:login.php");
}
echo 'Welcome ' .$_SESSION['fname'] ." " .$_SESSION['lname'] ."<br>";
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
<a href="myaccount.php">My Account</a>
<a href="add_project.php">Add Project</a>
<a href="my_project.php">My Project</a>
<a href="logout.php" style='float:right;margin-right:20px'>Logout</a>