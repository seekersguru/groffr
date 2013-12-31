<?php
include('header.php');
?>


<br>

<br>
<br>

<?php
	$query = "Select * from connection where register_id =".$_SESSION['user_id'];
	// echo $query."<br>";
	$listabQuery 			=	$db->query($query);

	// exit;
	// header('Location:myaccount.php');
   while($datatb = $db->fetchNextObject($listabQuery)){
      $queryi = "Select * from ".PROJECTS_TBL." where id =".$datatb->projects_id;
      $listabQueryi 			=	$db->query($queryi);

	
   while($data = $db->fetchNextObject($listabQueryi)){
   		?>
		<table class= "table table-bordered table-hover">
			<tr>

		<td>
			Project Summary connect Request
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
		<?php
	}
}
?>
</div>
</body>
</html>
