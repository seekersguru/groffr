<?php
include($_SERVER['DOCUMENT_ROOT'].'/Groffr/app_inc/main-config.php');
	$_SESSION = array();
	@session_destroy();
	header('location:index.php')
?>