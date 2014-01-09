<?php 
if(!isset($_GET['project']))
{
header("Location:".WEBSITE_ALL_PROJECT_URL);
}
include('header.php');
//$page				=	new page();
$query = "Select * from projects WHERE id=".$_GET['project'] ;
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
		<form method='post'>

		<table class= "table table-bordered table-hover"  >
			<thead>
				<tr class="success">
					<th colspan="2">
						Post As <?php  echo $data->post_as;?>
					</th>
				</tr>
			</thead>
<tbody>
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
						
                	if($_SESSION['user_id'] == $data->owner_id)
						{
                           echo "<span class='label label-warning'>You are the Creator of this Project So no need to connect !!! </span>";
						
?>
<br>
			  		<br>

			         <textarea  name='comment' class="form-control" required >  </textarea>
			       	<input type='submit'  class='btn btn-info' name='connect' value='Submit'>

			       	<?php 

                       $listcSql = "select * from project_comment where `project_id` = '".$data->id."' ";
						$listcQuery 			=	$db->query($listcSql);
                 		if( $db->numRows($listcQuery)> 0 ){

                        while($dbc	=	$db->fetchNextObject($listcQuery))
                        { 
                     
                       
                $queryu 		= "Select * from register where userid =".$dbc->userid;
      			$listabQueryu   = $db->query($queryu);
      			$datau 		    = $db->fetchNextObject($listabQueryu);

                   $uname=$datau->firstname;
                   if($_SESSION['user_id']==$datau->userid){

                   	$uname="ME";
                    }
                    echo '<div class="alert">'. $dbc->comment .' by  <b>'. $uname.'</b> </div>';
                    
                       }

                       }
                       ?>

 <?php

						}else{

						$listaSql = "select * from connection where `projects_id` = '".$data->id."' and register_id = '".$_SESSION['user_id']."' ";
						$listaQuery 			=	$db->query($listaSql);
                 		if( $db->numRows($listaQuery)> 0 ){
                            $projectdata=$db->fetchNextObject($listaQuery );
                 			if($projectdata->status==1)
                 			{
							echo "<span class='label label-success'>you are Connected connected now give your comment</span>";
						
?>
				 
			  		<br>
			  		<br>

			         <textarea  name='comment' class="form-control" required >  </textarea>
			       	<input type='submit'  class='btn btn-info' name='connect' value='Submit'>

			       	<?php 

                       $listcSql = "select * from project_comment where `project_id` = '".$data->id."' ";
						$listcQuery 			=	$db->query($listcSql);
                 		if( $db->numRows($listcQuery)> 0 ){

                        while($dbc	=	$db->fetchNextObject($listcQuery))
                        { 
                     
                       
                $queryu 		= "Select * from register where userid =".$dbc->userid;
      			$listabQueryu   = $db->query($queryu);
      			$datau 		    = $db->fetchNextObject($listabQueryu);

                   $uname=$datau->firstname;
                   if($_SESSION['user_id']==$datau->userid){

                   	$uname="ME";
                    }
                    echo '<div class="alert">'. $dbc->comment .' by  <b>'. $uname.'</b> </div>';
                    
                       }

                       }


			       	?>

<?php
						}
						else{
						echo "<span class='label label-danger'> request pending for approval !!!</span>";	
						}
						}
						else{

                      $typearr=array('Buyer','Agent','Seller');

				   	 if(($key = array_search($data->post_as, $typearr)) !== false) {
					     unset($typearr[$key]);
					 }

					 ?>
					 <div class="form-group">
         <label for="connet_as">Connect as</label>
         <?php
					 foreach ($typearr as $key => $value) {
   echo '<div class="radio-inline">
  <label>
    <input type="radio" name="connet_as"  value="'.$value.'" >
  '.$value.'
  </label>
</div>';	

 
}

?>
       
 </div>


		<div class="form-group hide_temp">
         <label for="help_message" >How can you help?</label>
         <textarea  name='help_message' class="form-control" required > </textarea>
       </div>

 <div class="form-group hide_temp">
         <label for="link_page">Add Link to a particular page </label>
         <textarea  name='link_page' class="form-control"> </textarea>
       </div>

<div class="form-group hide_temp">
         <label for="attachment">Upload Files</label>
         <textarea  name='attachment' class="form-control"> </textarea>
 </div>

							<input type='submit'  class='btn btn-info' name='connect' value='connect'>

<?php						}

						}

					?>
				</td>

			</tr>
		</tbody>
		</table>
		</form>
		<?php
	}
// }
//echo $page->get_page_nav();
?>

</div>
<script type="text/javascript">
jQuery(document).ready(function($) {
$("input[type=radio]").change(function(){
$(".hide_temp").show();
});
	
});

</script>
</body>
</html>
