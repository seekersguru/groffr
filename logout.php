<?php
include('app_inc/main-config.php');
	$_SESSION = array();
	@session_destroy();
	header('location:index.php')
?>