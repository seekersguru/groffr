<?php
 include_once('header.php');

if(!isset($_SESSION['user_id']))
{
header("location:login.php");
}
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
	echo "<div class='info'>New Projected created</div>";
}
?>
<!DOCTYPE HTML>
<html>
<head>
<title>Add Project</title>
<meta http-equiv="content-type" content="text/html;charset=UTF-8">
<link rel="stylesheet" href="assets/css/style.css">
</head>
<body>

<div class="content">

	<h1>Add Project</h1>
	<form method="POST">
	<div  >
		<table>
			<tr>
				<td>
					<label>Please provide a summary of what you want to do</label></td></tr><tr><td> <span class="txtbox"><textarea cols='20' rows='5' name='project_summary'> </textarea> </span>
				</td>
			</tr>
			<tr>
				<td>
					<label>Details</label> </td></tr><tr><td><span class="txtbox"><textarea rows='5' cols='20' name='details'></textarea></span>
				</td>
			</tr>
			<tr>
				<td>

					<label>Type</label></td></tr><tr><td>
					<span class="txtbox">
						<select name='type'>
							<option value='apartment'>Apartment</option>
							<option value='Villa'>Villa</option>
							<option value='builder_flats'>Builder Flats</option>
							<option value='shared_acco'>Shared Acco</option>
							<option value='land'>Land</option>
						</select>
					</span>
				</td>
			</tr>
		<tr>
			<td>
				<label>Box Price</label></td><tr><td>
				<span class="txtbox">
					<select name='box_price'>
						<option value="">1000 </option>
					</select>

				</span>
			</td>
		</tr>
		<tr>
			<td>
				<label>City</label>
			</td>
		</tr><tr>
			<td>
				<span class="txtbox">
					<select name='city'>
						<option value='jaipur'>Jaipur </option>
						<option value='jaipur'>Bikaner</option>
						<option value='jaipur'>Delhi</option>
						<option value='jaipur'>Bangalore </option>


					</select>

				</span>
			</td>
		</tr>
		<tr>
			<td>
		<label> Ratio</label>
	</td></tr><tr>
	<td>
		<input type="text" name='ratio'>%
	</td></tr>
	<tr>
		<td>
		<label>Payment Plan</label>
</td></tr><tr><td>
		<select name='payment_plan'>
			<option value="construction_linked"> Construction Linked</option>
			<option value="flexi">Flexi</option>
			<option value="upfront">Upfront</option>

		</select>
	</td></tr>
	<tr>
		<td>
		<label>How many Agents can connect with you?</label>

		</td>
	</tr><td>
		<select name="agent_connection_count" id='agent_count'>
			<option value="fcfs">FCFS</option>
			<option value="accredited">Accredited</option>
		</select>
	</td></tr>
	<tr class='agent_acc' style='display:none'>
 		<td>
			<input type='text' name='acc_agent'>
		</td>
	</tr>
	<tr>
	<td>
		<label>How many Buyers/Sellers can connect with you?</label>
	</td></tr><tr><td>
		<select name='buyer_seller_connection_count' id='buyer_seller_count'>
			<option value="fcfs">FCFS</option>
			<option value="accredited">Accredited</option>
		</select>
	</td></tr>
		<tr class='buyer_seller_acc' style='display:none'>
	 		<td>
				<input type='text' name='buyer_seller_acc'>
			</td>
		</tr>
		</table>
		<div class="submit_box"><input type="submit" value="Save" name="add_project"> </div>
	</form>
</div>
</div>
<script src="assets/js/jquery.js"></script>

<script >
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