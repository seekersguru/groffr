<?php
class Login {

function Login ()
{
	// Dummy constructor
}

function auth ($tbl = "", $userNameField = "", $passwordField = "", $userNameValue = "", $passwordValue = "", $rememberLogin = 0)
{

	if($tbl == "" || $userNameField == "" || $passwordField == "" || $userNameValue == "" || $passwordValue == "")
	return false;


	$sql   = "select * from $tbl where $userNameField = '$userNameValue' and isActive=1";

	$result  = mysql_query($sql) or die("error");
	$row     = mysql_fetch_array($result);
	if(mysql_num_rows($result) > 0)
		{
			if($passwordValue == $row["$passwordField"])
			{
		   		if ($rememberLogin == 1)
				{     
					   $expire = time() + 30 * 86400; 
					   setcookie('userName', $userNameValue, $expire, "/");
					   setcookie('userPass', $passwordValue, $expire,  "/");
				}
				else
				{	
						$expire = time() - 30 * 86400; 
						setcookie('userName', $userNameValue, $expire, "/");
						setcookie('userPass', $passwordValue, $expire,  "/");
			    }
				
				return 1;
			}
			else
			{
				return 2;
			}

		}
		else
		{
			$sql1   = "select * from $tbl where $userNameField = '$userNameValue'";
			$result1  = mysql_query($sql1) or die("error");
			$row1     = mysql_fetch_array($result1);
			if(mysql_num_rows($result1) > 0)
			{
				if($passwordValue == $row1["$passwordField"])
				{
					return 4;
				}else
				{
					return 2;
				}
			}else
			{
				return 3;
			}
		}

}


}//End of class
?>
