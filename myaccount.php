<?php include_once('header.php'); ?>
<!DOCTYPE HTML>
<html>
<head>
<title>Add Project</title>
<meta http-equiv="content-type" content="text/html;charset=UTF-8">
 <link href="assets/css/bootstrap.css" rel="stylesheet">
<link rel="stylesheet" href="assets/css/style.css">
</head>
<body>

<div class="content">
	<h1>
		Other projects
	</h1>

<?php


	// $query = "Select * from projects where owner_id !=".$_SESSION['user_id'];
	$query = "Select * from projects where owner_id !=".$_SESSION['user_id'];
    $listabQuery 			=	$db->query($query);
    while($data	=	$db->fetchNextObject($listabQuery))
   {
		?>
		<form method='post'>

		<table class= "table table-bordered table-hover"  >
			<tr>

		<td>
			Project Summary
		</td>
		<?php
			echo "<td>".$data->summary."</td>"
		?>
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
			<tr>

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
			<tr>

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
			<tr>

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
			<tr>

		<td>
			Number of Buyer/Seller connection
		</th>
		<td>
		<?php
			echo $data->buyer_seller_connection_count;
		?>
		</td>
			</tr>
			<tr>
				<td colspan="2">
					<input type="hidden" name='project_id' value='<?php echo $data->id ?>'>
				<?php
						$listaSql = "select * from connection where `projects_id` = '".$data->id."' and register_id = '".$_SESSION['user_id']."' ";
						$listaQuery 			=	$db->query($listaSql);
                 		if( $db->numRows($listaQuery)> 0 ){
                         $projectdata = $db->fetchNextObject($listaQuery );
                 	    	if($projectdata->status==1)
                 			{
							echo "<span class='label label-success'>Connected</span>";
						}
						else{
						echo "<span class='label label-danger'> request pending for approval !!!</span>";	
						}
						}
						else{

							echo "<a type='button' class='btn btn-lg btn-primary' href='".WEBSITE_PROJECT_URL.'?project='.$data->id."'>Connect</a>";
						}
				?>
				</td>

			</tr>
		</table>
		</form>
		<?php
	}
?>
</div>
</body>
</html>
