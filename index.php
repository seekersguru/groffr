<?php 
include("app_inc/main-config.php");
if($_SESSION)
{
header("location:myaccount.php");
}
else{
header("location:login.php");	
}

?>