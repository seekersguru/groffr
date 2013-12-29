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
	// echo $query."<br>";
	$result = mysql_query($query) or die(mysql_error() );
	// exit;
	// header('Location:myaccount.php');
	while($data = mysql_fetch_object($result)){
		?>
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
		</table>
		<b>Connections with this projects</b> -
		<?php
			$pro_conn_results = mysql_query("select * from connection conn,register reg where conn.projects_id = '".$data->id."' and reg.id=conn.register_id ") or die(mysql_error());
			// print_r($pro_conn_results);
			while( $pro_conn_data = mysql_fetch_object($pro_conn_results) ){
				echo $pro_conn_data->fname "<br>";

			}
	}
?>
</div>
</body>
</html>
