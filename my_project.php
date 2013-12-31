<?php
include('header.php');
?>
<!DOCTYPE HTML>
<html>
<head>
<title>My Project</title>
<meta http-equiv="content-type" content="text/html;charset=UTF-8">
<link rel="stylesheet" href="assets/css/style.css">
</head>
<body>

<div class="content">
	<h1>
		My projects
	</h1>

<?php
	$query = "Select * from projects where owner_id =".$_SESSION['user_id'];
    $listabQuery 			=	$db->query($query);
	// exit;
	// header('Location:myaccount.php');
	while($data = $db->fetchNextObject($listabQuery)){
		?>
		<table class= "table table-bordered table-hover">
			<tr>

		<td>
			Project Summary
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
			
			</td></tr>
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
		</table>
		<b>Connections with this projects</b> -
		<?php
			$pro_conn_results = mysql_query("select * from connection conn,register reg where conn.projects_id = '".$data->id."' and reg.userid=conn.register_id ") or die(mysql_error());
			// print_r($pro_conn_results);
			while( $pro_conn_data = @mysql_fetch_object($pro_conn_results) ){
				echo $pro_conn_data->firstname."<br>";

			}
	}
?>
</div>
</body>
</html>
