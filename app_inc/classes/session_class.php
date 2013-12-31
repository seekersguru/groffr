<?php
class Session {

function Session ()
{
	//Dummy Constructor
}

function setSession ($name = "", $val = "")
{
	if($name == "")
	return false;
	
	$_SESSION["$name"] = $val;
	
	/*
	checking if the session has been
	successfully "created"
	*/
	
	if(isset($_SESSION["$name"]))
		return true;
	else
		return false;

}

function getSession ($name = "")
{
	if($name == "")
	return false;
		
	/*
	checking if the session has been
	successfully "retrieved"
	*/
	
	if(isset($_SESSION["$name"]))
		return $_SESSION["$name"];
	else
		return false;

}

function removeSession ($name = "")
{
	if($name == "")
	return false;
	
	/*
	checking if the session has been
	successfully "removed"
	*/
	
	if(isset($_SESSION["$name"]))
	{
		unset($_SESSION["$name"]);
	}
	else
	{
		$_SESSION["$name"] = "";
		unset($_SESSION["$name"]);
	}
}

function printSession ()
{
	echo "<pre>";
	print_r($_SESSION);
	echo "</pre>";
}

function cleanSession ()
{
	// Unset all of the session variables.
	$_SESSION = array();
	
	// Finally, destroy the session.
//	session_destroy();
}


}
