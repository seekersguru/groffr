<?php
include('header.php');
$msg="";
if(isset($_GET['approve']) && is_numeric($_GET['approve']) )
{


			$sqlStatus = "UPDATE " .CONNECTION_TBL. " SET status = '1' WHERE id=".$_GET['approve'];
    		$db->execute($sqlStatus);
    		$msg = "Status successfully updated";

}
?>

<br>
<br>
<br>


<?php
if($msg)
{
	echo '<div class="alert alert-success">' .$msg. '</div>';
}
	 $query = "Select * from projects where owner_id = ".$_SESSION['user_id'];
	$listabQuery 			=	$db->query($query);
    while($datatb = $db->fetchNextObject($listabQuery)){
   		?>
		<table class= "table table-bordered table-hover">
			<tr>

		<td>
Post As		</td>
		<td>
		<?php
			echo $datatb->post_as;
		?>
	</td>
			</tr>

			<tr>

		<td>
			request for this project by user 
		</td>
		<td>
		<?php
			echo $datatb->summary;
		?>
	</td>
			</tr>
			<tr>

		<td>
			Details
		</td>
		<td>
		<?php
			echo $datatb->details;
		?>
			
			</td></tr>
			<tr>

		<td>
			type
		</td>
		<td>
			<?php
				echo $datatb->type;
			?>
		</td>
			</tr>
			<tr>

		<td>
			Box Price
		</td>
		<td>
			<?php
			echo $datatb->box_price;
			?>
		</td>
			</tr>
			<tr>

		<td>
			Location
		</td>
		<td>
			<?php
			echo $datatb->location;
			?>
		</td>
			</tr>
			<tr>

		<td>
			Ratio
		</td>
		<td>
			<?php
			echo $datatb->ratio;
			?>
		</td>
			</tr>
			<tr>

		<td>
			Payment plan
		</td>
		<td>
			<?php
			echo $datatb->payment_plan;
			?>
		</td>
			</tr>
			<tr>

		<td>
			Number of Agent connection
		</td>
		<td>
			<?php
			echo $datatb->agent_connection_count;
			?>
		</td>
			</tr>
			<tr>

		<td>
			Number of Buyer/Seller connection
		</th>
		<td>
		<?php
			echo $datatb->buyer_seller_connection_count;
		?>
		</td>
		</tr>

<?php
    $queryi = "Select * from connection where projects_id =".$datatb->id;
      $listabQueryi 			=	$db->query($queryi);
       if( $db->numRows($listabQueryi) > 0)
       {
      while($data = $db->fetchNextObject($listabQueryi)){
   
                $queryu 		= "Select * from register where userid =".$data->register_id;
      			$listabQueryu   = $db->query($queryu);
      			$datau 		    = $db->fetchNextObject($listabQueryu);

   ?>
		<tr>
				<?php if($data->status == 0)
             {
      			
             	?>
				<td >
             <?php 
           echo  '<span class="label label-info">'.$datau->firstname.'</span> Want to connect with you' ;

             ?>			
			</td>
           <td>
           <a href="my_notification.php?approve=<?php echo $data->id ?>"  type="button" class="btn btn-primary"> Approve</a>
            </td>
<?php }else {

  echo  '<td colspan="2"><span class="label label-success">'.$datau->firstname.' </span> Already  Connected </td>' ;

} ?>

			</tr>
	<?php }
	 }
	 else{
?>
<tr>
				<td >
					<span class="label label-success">There is no request now for this project </span>
					</td></tr>

<?php 	} ?>		 

		</table>
		<?php
	}

?>
</div>
</body>
</html>
