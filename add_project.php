<?php
 include_once('header.php'); 
if( isset($_POST['add_project'] )){
	$project_summary = mysql_real_escape_string( $_POST['project_summary'] );
	$details= mysql_real_escape_string($_POST['details']);
	$type = mysql_real_escape_string($_POST['type']);
	$box_price= mysql_real_escape_string($_POST['box_price']);
	$city = mysql_real_escape_string($_POST['city']);
	$ratio = mysql_real_escape_string($_POST['ratio']);
	$payment_plan = mysql_real_escape_string($_POST['payment_plan']);
	$agent_connection_count= mysql_real_escape_string($_POST['agent_connection_count']);
	$buyer_seller_connection_count= mysql_real_escape_string($_POST['buyer_seller_connection_count']);
	$query = "insert into projects(`id`,`summary`,`details`,`type`,`box_price`,`location`,`ratio`,`payment_plan`,`agent_connection_count`,`buyer_seller_connection_count`,`owner_id`) values(null,'".$project_summary."',
		'".$details."',
		'".$type."',
		'".$box_price."',
		'".$city."',
		'".$ratio."',
		'".$payment_plan."',
		'".$agent_connection_count."',
		'".$buyer_seller_connection_count."',
		".$_SESSION['user_id'].")";
	// echo $query."<br>";
	$mysql = mysql_query($query) or die(mysql_error() );
	// exit;
	// header('Location:myaccount.php');
	$msg = 1;
}

?>


    <div class="container theme-showcase">
      <div class="page-header">
        <h1>Add Project</h1>
      </div>
     
      	<form role="form" method="POST">
	<?php if(isset($msg)) {echo '<div class="alert alert-success">New Projected created</div>';}?>
		<div class="form-group">
         <label for="project_summary">Please provide a summary of what you want to do</label>
         <textarea name='project_summary' class="form-control"> </textarea>
       </div>
		
		<div class="form-group">
         <label for="details">Details</label>
         <textarea  name='details' class="form-control"> </textarea>
       </div>
       
       <div class="form-group">
         <label for="type">Type</label>
         <select name='type' class="form-control">
							<option value='apartment'>Apartment</option>
							<option value='Villa'>Villa</option>
							<option value='builder_flats'>Builder Flats</option>
							<option value='shared_acco'>Shared Acco</option>
							<option value='land'>Land</option>
						</select>
       </div>
      <div class="form-group">
         <label for="box_price">Box Price</label>
         <select name='box_price' class="form-control">
						<option value="">1000 </option>
					</select>
       </div>
		 		
		 <div class="form-group">
         <label for="city">City</label>
        <select name='city' class="form-control">
						<option value='jaipur'>Jaipur </option>
						<option value='jaipur'>Bikaner</option>
						<option value='jaipur'>Delhi</option>
						<option value='jaipur'>Bangalore </option>


					</select>
       </div>	

       <div class="form-group input-group">
         <label for="ratio">Ratio</label>
         <span class="input-group-addon">%</span>
         <input type="text" name='ratio' class="form-control">
         
       </div>


       <div class="form-group">
         <label for="payment_plan">Payment Plan</label>
      <select name='payment_plan' class="form-control">
			<option value="construction_linked"> Construction Linked</option>
			<option value="flexi">Flexi</option>
			<option value="upfront">Upfront</option>

		</select>
       </div>

        <div class="form-group">
         <label for="payment_plan">How many Agents can connect with you?</label>
         <select name="agent_connection_count" id='agent_count' class="form-control">
			<option value="fcfs">FCFS</option>
			<option value="accredited">Accredited</option>
		</select>
       </div>





 <div class="form-group">
 	<input type='hidden' name='acc_agent'>
 	<input type='hidden' name='buyer_seller_acc'>
         <label for="payment_plan">How many Buyers/Sellers can connect with you?</label>
      <select name='buyer_seller_connection_count' id='buyer_seller_count' class="form-control">
			<option value="fcfs">FCFS</option>
			<option value="accredited">Accredited</option>
		</select>
       </div>
	
	

		<button type="submit" name="add_project" class="btn btn-default">Save</button>

	</form>
</div>
</div>
<script src="assets/js/jquery.js"></script>


      </div>


    </div> <!-- /container -->


    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://code.jquery.com/jquery-1.10.2.min.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>
    <!-- // <script src="assets/jsdocs-assets/js/holder.js"></script> -->

<script>
$(function(){

	$('#agent_count').change(function(){
		if(this.value == 'accredited'){
			$(".agent_acc").show();
		}
		else
			$(".agent_acc").hide();
	});

	$('#buyer_seller_count').change(function(){
		if(this.value == 'accredited'){
			$(".buyer_seller_acc").show();
		}
		else
			$(".buyer_seller_acc").hide();
	});
});
</script>

  </body>
</html>
