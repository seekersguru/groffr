<?php include_once('header.php'); ?>
<!-- <a href="my_connection.php">My Connections</a> -->
<!DOCTYPE HTML>
<html>
<head>
<title>Add Project</title>
<meta http-equiv="content-type" content="text/html;charset=UTF-8">
<link rel="stylesheet" href="assets/css/style.css">
</head>
<body>

<div class="content">
	<h1>
		Other projects
	</h1>

<?php
	$query = "Select * from projects where owner_id !=".$_SESSION['user_id'];
	// echo $query."<br>";
	$result = mysql_query($query) or die(mysql_error() );
	// exit;
	// header('Location:myaccount.php');
	while($data = mysql_fetch_object($result)){
		?>
		<form method='post'>

		<table style='text-align:left;border:1px solid #000;margin-bottom:20px'>
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
		<?php
			echo "<td>".$data->details."</td>";
		?>
			</tr>
			<tr>

		<td>
			type
		</td>
		<td>
			<?php
				echo "<td>".$data->type."</td>";
			?>
		</td>
			</tr>
			<tr>

		<td>
			Box Price
		</td>
		<td>
			<?php
			echo "<td>".$data->box_price."</td>";
			?>
		</td>
			</tr>
			<tr>

		<td>
			Location
		</td>
		<td>
			<?php
			echo "<td>".$data->location."</td>";
			?>
		</td>
			</tr>
			<tr>

		<td>
			Ratio
		</td>
		<td>
			<?php
			echo "<td>".$data->ratio."</td>";
			?>
		</td>
			</tr>
			<tr>

		<td>
			Payment plan
		</td>
		<td>
			<?php
			echo "<td>".$data->payment_plan."</td>";
			?>
		</td>
			</tr>
			<tr>

		<td>
			Number of Agent connection
		</td>
		<td>
			<?php
			echo "<td>".$data->agent_connection_count."</td>";
			?>
		</td>
			</tr>
			<tr>

		<td>
			Number of Buyer/Seller connection
		</th>
		<td>
		<?php
			echo "<td>".$data->buyer_seller_connection_count."</td>";
		?>
		</td>
			</tr>
			<tr>
				<td>
					<input type="hidden" name='project_id' value='<?php echo $data->id ?>'>
					<?php
						$q = "select id from connection where `projects_id` = '".$data->id."' and register_id = '".$_SESSION['user_id']."'";
						$conn_result = mysql_query($q) or die(mysql_error());
						// echo $conn_result;
						if( mysql_num_rows($conn_result) > 0 ){
							echo "<b>Connected</b>";
						}
						else{

							echo "<input type='submit' name='connect' value='connect'>";
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
