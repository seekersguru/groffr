<?php 
include($_SERVER['DOCUMENT_ROOT'].'/Groffr/app_inc/main-config.php');
if($_SESSION)
{
header("location:myaccount.php");
}
else{
header("location:login.php");	
}

?>