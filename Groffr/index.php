<?php 
include('connection.php');

if($_SESSION)
{
header("location:myaccount.php");
}else{
header("location:login.php");	
}

?>