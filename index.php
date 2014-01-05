<?php 
include("app_inc/main-config.php");
// if($_SESSION)
// {
// header("location:myaccount.php");
// }
// else{
// header("location:login.php");	
// }

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
    <style>
   .parentlist{
    width: 100%;
   }
   .childlist{
   width:25%;
   margin: 3px;
   color: black;
   border: 1px solid #d0e9c6;
   
   }
   .childlist a,.childlist table a{
   	color: black;
   }
.pull-left {
  float: left !important;
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
<?php if($_SESSION['userid']){ ?>
  	        <li class="active"><a href="myaccount.php">My Account</a></li>
  	        <li><a href="add_project.php">Add Project</a></li>
  	        <li><a href="my_project.php">My Project</a></li>
            <li><a href="my_connection.php">My Connection</a></li>
  	        <li><a href="#"> <?php echo 'Welcome ' .$_SESSION['fname'] ." " .$_SESSION['lname']; ?></a></li>
          <li><a href="logout.php">LogOut</a></li>
  	 <?php } else { ?>
  	        <li ><a href="register.php">Register</a></li>
  	        <li><a class="active" href="login.php">Login</a></li>
  	   
  <?php }	 ?>     </ul>
  	    </div><!--/.nav-collapse -->
  	  </div>
  	</div>
    <!-- Fixed navbar -->
    <br>
    <br>
    <br>
    <br>
  <div class="container">  
  	<hr>
  	<h2>Trending Buyer</h2>
  	<hr>
   <div id="buyer" class="parentlist pull-left" >

<?php
	$query = "Select * from projects where post_as = 'Buyer' ORDER BY rand()  LIMIT 3";
    $listabQuery 			=	$db->query($query);
    while($data	=	$db->fetchNextObject($listabQuery))
   {
		?>
	<a href="<?php echo WEBSITE_PROJECT_URL.'?project='.$data->id; ?>" >	
	<div class="childlist pull-left">
		<table class= "table table-striped table-hover" >
<thead>
<tr>
<th colspan="2">
<?php  
$queryuser = "Select * from register where userid = ".$data->owner_id;
    $userQuery 			=	$db->query($queryuser);
    $userdata= $db->fetchNextObject($userQuery);
    echo $userdata->firstname."  " ;
?>

</th>
</tr>
</thead>
		<tbody>
			<tr class="success">
          <td>
          Title
          </td>
          <td>
		<?php
			echo $data->summary;
		?>
	</td>
			</tr>
			<tr>

		<td>
			Details
		</td>
		<td>
		<?php
			echo $data->details;
		?>
		</td>
			</tr>
			<tr class="success">

		<td>
			type
		</td>
		<td>
			<?php
				echo $data->type;
			?>
		</td>
			</tr>
			<tr>

		<td>
			Box Price
		</td>
		<td>
			<?php
			echo $data->box_price;
			?>
		</td>
			</tr>
			<tr class="success">

		<td>
			Location
		</td>
		<td>
			<?php
			echo $data->location;
			?>
		</td>
			</tr>
			<tr>

		<td>
			Ratio
		</td>
		<td>
			<?php
			echo $data->ratio;
			?>
		</td>
			</tr>
			<tr class="success">

		<td>
			Payment plan
		</td>
		<td>
			<?php
			echo $data->payment_plan;
			?>
		</td>
			</tr>
			<tr>

		<td>
			Number of Agent connection
		</td>
		<td>
			<?php
			echo $data->agent_connection_count;
			?>
		</td>
			</tr>
			<tr class="success">

		<td>
			Number of Buyer/Seller connection
		</th>
		<td>
		<?php
			echo $data->buyer_seller_connection_count;
		?>
		</td>
			</tr>
		
		</table>
	</div></a>
		<?php
	}
?>
<div class="childlist pull-left" style="width:22%">

<h2>
<a href="add_project.php">This Could be You !<br> <br>
	 What do you wish for? <br><br>
	 Enter now<br>

</a>
	<h2>

</div>


	</div>

		<hr>
  <h2>	Trending Agent </h2>
  	<hr>
   <div id="agent" class="parentlist pull-left" >

<?php
	$query = "Select * from projects where post_as = 'Agent' ORDER BY rand()  LIMIT 3";
    $listabQuery 			=	$db->query($query);
    while($data	=	$db->fetchNextObject($listabQuery))
   {
		?>
	<a href="<?php echo WEBSITE_PROJECT_URL.'?project='.$data->id; ?>" >	
		<div class="childlist pull-left">
		<table class= "table table-striped table-hover" >
<thead>
<tr>
<th colspan="2">
<?php  
$queryuser = "Select * from register where userid = ".$data->owner_id;
    $userQuery 			=	$db->query($queryuser);
    $userdata= $db->fetchNextObject($userQuery);
    echo $userdata->firstname."  " ;
?>

</th>
</tr>
</thead>
		<tbody>
			<tr class="success">
          <td>
          Title
          </td>
          <td>
		<?php
			echo $data->summary;
		?>
	</td>
			</tr>
			<tr>

		<td>
			Details
		</td>
		<td>
		<?php
			echo $data->details;
		?>
		</td>
			</tr>
			<tr class="success">

		<td>
			type
		</td>
		<td>
			<?php
				echo $data->type;
			?>
		</td>
			</tr>
			<tr>

		<td>
			Box Price
		</td>
		<td>
			<?php
			echo $data->box_price;
			?>
		</td>
			</tr>
			<tr class="success">

		<td>
			Location
		</td>
		<td>
			<?php
			echo $data->location;
			?>
		</td>
			</tr>
			<tr>

		<td>
			Ratio
		</td>
		<td>
			<?php
			echo $data->ratio;
			?>
		</td>
			</tr>
			<tr class="success">

		<td>
			Payment plan
		</td>
		<td>
			<?php
			echo $data->payment_plan;
			?>
		</td>
			</tr>
			<tr>

		<td>
			Number of Agent connection
		</td>
		<td>
			<?php
			echo $data->agent_connection_count;
			?>
		</td>
			</tr>
			<tr class="success">

		<td>
			Number of Buyer/Seller connection
		</th>
		<td>
		<?php
			echo $data->buyer_seller_connection_count;
		?>
		</td>
			</tr>
		
		</table>
	</div>
</a>
		<?php
	}
?>
<div class="childlist pull-left" style="width:22%">

<h2>
<a href="add_project.php">This Could be You !<br> <br>
	 What do you wish for? <br><br>
	 Enter now<br>

</a>
	<h2>

</div>


	</div>


		<hr>
  <h2>	Trending Seller </h2>
  	<hr>
   <div id="seller" class="parentlist pull-left" >

<?php
	$query = "Select * from projects where post_as = 'Seller' ORDER BY rand()  LIMIT 3";
    $listabQuery 			=	$db->query($query);
    while($data	=	$db->fetchNextObject($listabQuery))
   {
		?>
		<a href="<?php echo WEBSITE_PROJECT_URL.'?project='.$data->id; ?>" >
		<div class="childlist pull-left">
		<table class= "table table-striped table-hover" >
<thead>
<tr>
<th colspan="2">
<?php  
$queryuser = "Select * from register where userid = ".$data->owner_id;
    $userQuery 			=	$db->query($queryuser);
    $userdata= $db->fetchNextObject($userQuery);
    echo $userdata->firstname."  " ;
?>

</th>
</tr>
</thead>
		<tbody>
			<tr class="success">
          <td>
          Title
          </td>
          <td>
		<?php
			echo $data->summary;
		?>
	</td>
			</tr>
			<tr>

		<td>
			Details
		</td>
		<td>
		<?php
			echo $data->details;
		?>
		</td>
			</tr>
			<tr class="success">

		<td>
			type
		</td>
		<td>
			<?php
				echo $data->type;
			?>
		</td>
			</tr>
			<tr>

		<td>
			Box Price
		</td>
		<td>
			<?php
			echo $data->box_price;
			?>
		</td>
			</tr>
			<tr class="success">

		<td>
			Location
		</td>
		<td>
			<?php
			echo $data->location;
			?>
		</td>
			</tr>
			<tr>

		<td>
			Ratio
		</td>
		<td>
			<?php
			echo $data->ratio;
			?>
		</td>
			</tr>
			<tr class="success">

		<td>
			Payment plan
		</td>
		<td>
			<?php
			echo $data->payment_plan;
			?>
		</td>
			</tr>
			<tr>

		<td>
			Number of Agent connection
		</td>
		<td>
			<?php
			echo $data->agent_connection_count;
			?>
		</td>
			</tr>
			<tr class="success">

		<td>
			Number of Buyer/Seller connection
		</th>
		<td>
		<?php
			echo $data->buyer_seller_connection_count;
		?>
		</td>
			</tr>
		
		</table>
	</div>
</a>
		<?php
	}
?>
<div class="childlist pull-left" style="width:22%">

<h2>
<a href="add_project.php">This Could be You !<br> <br>
	 What do you wish for? <br><br>
	 Enter now<br>

</a>
	<h2>

</div>


	</div>

</div>
