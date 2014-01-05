<?php 
include('header.php');
//$page				=	new page();
$query = "Select * from projects" ;
$listSql 			=	$db->query($query);
// $total_records      =   $db->numRows($listSql);
// $record_per_page    =   5;
// $scroll=5;
// if(isset($_REQUEST['limit']))
// {
//  $limit = getVal('limit', '1');
// }
// else
// {
//  $limit = '15';
// }

// if(isset($_REQUEST['page']))
// {
// 	$pageno			=	getVal('page', 1);
// }
// else
// {
// 	$pageno=0;
// }

// $page->set_page_data(WEBSITE_PROJECT_URL,$total_records, $record_per_page, $scroll, true, true, true);
// //$page->set_qry_string("limit=$limit");
// $page->set_link_parameter("class='paging'");
//$listSql=$db->query($page->get_limit_query($query));

 ?>
<div class="content">
	<h1>
		 projects
	</h1>

<?php

// if ($total_records == 0)
// 		{  ?>
        
<!-- 		<h1>	NO Project FOUND </h1> -->
 <?php //}
// else { 
while($data	=	$db->fetchNextObject($listSql))
  {
?>  
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
						$listaSql = "select id from connection where `projects_id` = '".$data->id."' and register_id = '".$_SESSION['user_id']."' ";
						$listaQuery 			=	$db->query($listaSql);
                 		if( $db->numRows($listaQuery)> 0 ){
                            $projectdata=$db->fetchNextObject($listaQuery );
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
		<?php
	}
// }
//echo $page->get_page_nav();
?>

</div>
</body>
</html>
