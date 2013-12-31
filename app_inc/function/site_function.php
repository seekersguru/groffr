<?php
/***@author      :  rituraj ratan
  **@work        :  handle all site function
  **@created date:  20-11-2012
*/
// my sqli connection
date_default_timezone_set('Asia/Calcutta');

function mysql_format_date($date){
	$temp=explode("-",$date);
$last=array();
	$last[0]=$temp[2];
	$last[1]=$temp[1];
	$last[2]=$temp[0];
	
    return implode("-",$last);
	
}

function frontend_format_date($date){
	$temp=explode("-",$date);
$last=array();
	$last[0]=$temp[2];
	$last[1]=$temp[1];
	$last[2]=$temp[0];
	
    return implode("-",$last);
	
}

function full_frontend_date($date)
{
	$datetime = new DateTime($date);
	return $datetime->format('d M Y');	
}

function full_frontend_dateTime($date)
{
	$datetime = new DateTime($date);
	return $datetime->format('d F Y H:i:s');	
}

function full_frontend_Month($date)
{
	$datetime = new DateTime($date);
	return $datetime->format('F');	
}
function get_only_day($date)
{
	$timestamp = strtotime($date);
    return  date("d", $timestamp);
}

function get_only_month_name($date)
{
	$timestamp = strtotime($date);
    return  date("M", $timestamp);
}


function all_SitePage($id)
{
if($id!='')
{
$query="SELECT * FROM ".SITEPAGES_TBL." WHERE ID='".$id."'";
}
else{
$query="SELECT * FROM ".SITEPAGES_TBL." ORDER BY ID";
}
$result = mysql_query($query);
$i=0;
$arr=array();
while($row = @mysql_fetch_array($result))
{
	$arr[$i]=$row;
   $i++;	
}
return ($arr);
}

//by this function we set the setting of site pages
function edit_sitepage($Pic,$Title,$MetaTag,$MetaDescription,$Description,$existId)
{
	
	if($Pic=='')
		{
		//at update time if user change not change the pic
	$query="UPDATE ".SITEPAGES_TBL. " SET Title ='".$Title."',
        MetaTag ='".$MetaTag."',
		MetaDescription ='".$MetaDescription."',
		Description ='".$Description."',
		LastModifiedDate='".date('Y-m-d H:i:s')."'
		WHERE ID ='$existId' ";

		}
		else{

//at update time if user change pic
		$newsList=all_SitePage($id);
		$newspic=$newsList[0]['Pic'];
		$filethumb= '../../../'.PAGES_UPLOAD_FOLDER.'full/feature_'.$newspic;
		@unlink($filethumb);
		
		 $query="UPDATE ".SITEPAGES_TBL. " SET Pic='$Pic',
		Title ='".$Title."',
        MetaTag ='".$MetaTag."',
		MetaDescription ='".$MetaDescription."',
		Description ='".$Description."',
		LastModifiedDate='".date('Y-m-d H:i:s')."'
		WHERE ID ='$existId' ";

		
		}

$result = mysql_query($query);
if($result)
{
	return 1;
	}
else
{
	return 0;
	}

	
}

//change password


function change_userpassword($id,$oldpass,$newpass)
{
	global $PQR_Login_Page,$Company_Email_ID;

 
$row=all_user($id);

$newrow=$row[0];

if(SEC_EncryptStringArray($oldpass)!=$newrow['Password'])
{

return 0;

}
else if( strlen($newpass) < PQR_MinPasswordLength)
{
return 2;
}
else
{
$query="UPDATE ".USER_TBL. " SET Password ='".SEC_EncryptStringArray($newpass)."' WHERE ID ='$id' ";
$_SESSION['password']=$newpass;

$result = mysql_query($query);

    $AccountfURL=WEBSITE_URL.$PQR_Login_Page;
 
    SEC_SendPassword($newrow['EmailID'],$Company_Email_ID,$newrow['Name'],$newpass,$AccountfURL); 
return 1;
}

}

//update password

function update_password($email,$password){

$query="SELECT * FROM ".USER_TBL." WHERE EmailID = '$email'";

$result = mysql_query($query);

if(mysql_num_rows($result)==0)
{
return 0;
}
else{

while($row = mysql_fetch_array($result))
{
$name=$row['Name'];
	 
}	

$query="UPDATE ".USER_TBL." SET  Password = '".SEC_EncryptStringArray($password)."', LastModifiedDate='".date("Y-m-d H:i:s")."' WHERE EmailID = '$email' ";

$result = mysql_query($query);
return $name;

}

}

function update_admin_password($email,$password){

$query="SELECT * FROM ".MASTER_ADMIN_TBL." WHERE EmailID = '$email'";

$result = mysql_query($query);

if(mysql_num_rows($result)==0)
{
return 0;
}
else{

while($row = mysql_fetch_array($result))
{
$name=$row['Name'];
	 
}	

$query="UPDATE ".MASTER_ADMIN_TBL." SET  Password = '".SEC_EncryptStringArray($password)."', LastModifiedDate='".date("Y-m-d H:i:s")."' WHERE EmailID = '$email' ";

$result = mysql_query($query);
return $name;

}

}

//user panel
function all_user($id){//return all the user list
if($id!='')
{
$query="SELECT * FROM ".USER_TBL." WHERE ID='$id'";
}
else{
$query="SELECT * FROM ".USER_TBL." ORDER BY ID";
}
$result = mysql_query($query);
$i=0;
$arr=array();
while($row = mysql_fetch_array($result))
{
	$arr[$i]=$row;
  $i++;	
}
return ($arr);
}

function all_admin($id)
{
	if($id!='')
{
$query="SELECT * FROM ".MASTER_ADMIN_TBL." WHERE ID='$id'";
}
else{
$query="SELECT * FROM ".MASTER_ADMIN_TBL." ORDER BY ID";
}
$result = mysql_query($query);
$i=0;
$arr=array();
while($row = mysql_fetch_array($result))
{
	$arr[$i]=$row;
  $i++;	
}
return ($arr);
}

function delete_user($deleteId){//delete user
$query="DELETE FROM ".USER_TBL." WHERE ID=$deleteId";
$result = mysql_query($query);
if($result)
{
return 1;
}
else{
return 0;
}

}
function delete_admin($deleteId){//delete user
$query="DELETE FROM ".MASTER_ADMIN_TBL." WHERE ID=$deleteId";
$result = mysql_query($query);
if($result)
{
return 1;
}
else{
return 0;
}

}


function addedit_user($FirstName,$LastName,$Name,$email,$Password,$MobileNo,$LandLineNo,$city,$state,$country,$ip,$existId)//add edit  user
{

$FirstName =  mysql_real_escape_string(trim($FirstName));
$LastName  =  mysql_real_escape_string(trim($LastName));
$Name      =  mysql_real_escape_string(trim($Name));
$email     =  mysql_real_escape_string(trim($email));
$Password  =  mysql_real_escape_string(trim($Password));
$MobileNo  =  mysql_real_escape_string(trim($MobileNo));
$LandLineNo= mysql_real_escape_string(trim($LandLineNo));

if($existId!='')
{
	$existId =  mysql_real_escape_string(trim($existId));
$userdetails=all_user($existId);
$oldname=$userdetails[0]['Name'];
if($oldname==$Name)
{
$query="UPDATE ".USER_TBL." SET FirstName='$FirstName', LastName='$LastName',Name='$Name', EmailID='$email', MobileNo='$MobileNo',LandLineNo='$LandLineNo',CityID = '$city',StateCode = '$state',CountryCode = '$country',EditIP='$ip',LastModifiedDate='".date("Y-m-d H:i:s")."'   WHERE ID ='$existId' ";


}
else{
$query="SELECT * FROM ".USER_TBL." WHERE Name = '$Name'";

$result = mysql_query($query);

if(mysql_num_rows($result)==0)
{

$query="UPDATE ".USER_TBL." SET FirstName='$FirstName', LastName='$LastName', Name='$Name', EmailID='$email',MobileNo='$MobileNo',LandLineNo='$LandLineNo',CityID = '$city',StateCode = '$state',CountryCode = '$country',EditIP='$ip',LastModifiedDate='".date("Y-m-d H:i:s")."'   WHERE ID ='$existId' ";
}
else{
$_SESSION['nameexist']=$Name;
return 0;
}

}
}
else{

$query="SELECT * FROM ".USER_TBL." WHERE Name = '$Name'";

$result = mysql_query($query);

if(mysql_num_rows($result)==0)
{

 $query="INSERT INTO ".USER_TBL." (FirstName,LastName,Name,EmailID,Password,MobileNo,LandLineNo,CityID,StateCode,CountryCode,CreateIP,CreatedDate,LastModifiedDate,OnlyDate)VALUES ('$FirstName','$LastName','$Name','$email','".SEC_EncryptStringArray($Password)."','$MobileNo','$LandLineNo','$city','$state','$country','$ip','".date("Y-m-d H:i:s")."','".date("Y-m-d H:i:s")."','".date("Y-m-d")."')";
}
else{
return 0;
}
}

$result = mysql_query($query);
return 1;

}

function addedit_admin($FirstName,$LastName,$Name,$email,$Password,$Status,$city,$state,$country,$ip,$permission,$existId)//add edit  user
{

$FirstName =  mysql_real_escape_string(trim($FirstName));
$LastName  =  mysql_real_escape_string(trim($LastName));
$Name      =  mysql_real_escape_string(trim($Name));
$email     =  mysql_real_escape_string(trim($email));
$Password  =  mysql_real_escape_string(trim($Password));
$MobileNo  =  mysql_real_escape_string(trim($MobileNo));
$LandLineNo= mysql_real_escape_string(trim($LandLineNo));

if($existId!='')
{
	$existId =  mysql_real_escape_string(trim($existId));
$userdetails=all_admin($existId);
$oldname=$userdetails[0]['Name'];
if($oldname==$Name)
{
$query="UPDATE ".MASTER_ADMIN_TBL." SET FirstName='$FirstName', LastName='$LastName',Name='$Name', EmailID='$email',Status='$Status',CityID = '$city',StateCode = '$state',CountryCode = '$country',moduleAccess='$permission', EditIP='$ip',LastModifiedDate='".date("Y-m-d H:i:s")."'   WHERE ID ='$existId' ";


}
else{
$query="SELECT * FROM ".MASTER_ADMIN_TBL." WHERE Name = '$Name'";

$result = mysql_query($query);

if(mysql_num_rows($result)==0)
{

$query="UPDATE ".MASTER_ADMIN_TBL." SET FirstName='$FirstName', LastName='$LastName', Name='$Name', EmailID='$email',Status='$Status',CityID = '$city',StateCode = '$state',CountryCode = '$country',moduleAccess='$permission',EditIP='$ip',LastModifiedDate='".date("Y-m-d H:i:s")."'   WHERE ID ='$existId' ";
}
else{
$_SESSION['nameexist']=$Name;
return 0;
}

}
}
else{

$query="SELECT * FROM ".MASTER_ADMIN_TBL." WHERE Name = '$Name'";

$result = mysql_query($query);

if(mysql_num_rows($result)==0)
{

 $query="INSERT INTO ".MASTER_ADMIN_TBL." (FirstName,LastName,Name,EmailID,Password,Status,CityID,StateCode,CountryCode,CreateIP,moduleAccess,CreatedDate,LastModifiedDate,OnlyDate)VALUES ('$FirstName','$LastName','$Name','$email','".SEC_EncryptStringArray($Password)."','$Status','$city','$state','$country','$ip','$permission','".date("Y-m-d H:i:s")."','".date("Y-m-d H:i:s")."','".date("Y-m-d")."')";
}
else{
return 0;
}
}

$result = mysql_query($query);
return 1;

}



function admin_login_status($name,$password)
{
global $mySession;
	$query="SELECT * FROM ".MASTER_ADMIN_TBL." WHERE Name  ='".mysql_real_escape_string($name)."' AND Password ='".mysql_real_escape_string($password)."' ";
   $result = mysql_query($query);
   if(@mysql_num_rows($result)!=0)
{

return 1;
}
else{
 return 0;
}
}
	
 function pagination($sql=STRATEGY_TBL, $per_page = 2,$page = 1,$type='',$subType='',$userID='', $url = '?'){ 
      //echo $sql." table   ". $per_page." perpage   ".$page." page  ".$userID." user id  ".$url. "url";
	   if(($type!='') && ($subType!=''))
	  { 
	 	if($type=='ath')
		{
			
	     $query="SELECT COUNT(ID) as `num` FROM ".$sql." WHERE type = '$subType' ORDER BY ID DESC ";
			
		}
		else if($type=='cat')
		{
			
		 $category=category_byname($subType);
		 $id=$category[0]['ID'];
		 $query="SELECT COUNT(ID) as `num` FROM ".$sql." WHERE find_in_set($id,Category) > 0 ORDER BY ID DESC ";
		
		}
		else if($type=='ach')
		{
			
		  $query="SELECT COUNT(ID) as `num` FROM ".$sql." WHERE MONTHNAME( CreatedDate ) LIKE '$subType' ORDER BY ID DESC ";
			
		}
		else{
			
			$query="SELECT COUNT(ID) as `num` FROM ".$sql." ORDER BY ID DESC ";
		}
	   
	  }
	  else
	   {
		   
		 $query = "SELECT COUNT(ID) as `num` FROM ".$sql." ORDER  BY  ID  DESC";		
    	
	   }
	   
    	$row = @mysql_fetch_array(mysql_query($query));
		$total = $row['num'];
        $adjacents = "2"; 

    	$page = ($page == 0 ? 1 : $page);  
    	$start = ($page - 1) * $per_page;								
		
    	$prev = $page - 1;							
    	$next = $page + 1;
        $lastpage = ceil($total/$per_page);
    	$lpm1 = $lastpage - 1;
    	
    	$pagination = "";
    	if($lastpage > 1)
    	{	
    		$pagination .= "<ul class='pagination'>";
                    $pagination .= "<li class='details'>Page $page of $lastpage</li>";
    		if ($lastpage < 7 + ($adjacents * 2))
    		{	
    			for ($counter = 1; $counter <= $lastpage; $counter++)
    			{
    				if ($counter == $page)
    					$pagination.= "<li><a class='current'>$counter</a></li>";
    				else
    					$pagination.= "<li><a href='{$url}page=$counter'>$counter</a></li>";					
    			}
    		}
    		elseif($lastpage > 5 + ($adjacents * 2))
    		{
    			if($page < 1 + ($adjacents * 2))		
    			{
    				for ($counter = 1; $counter < 4 + ($adjacents * 2); $counter++)
    				{
    					if ($counter == $page)
    						$pagination.= "<li><a class='current'>$counter</a></li>";
    					else
    						$pagination.= "<li><a href='{$url}page=$counter'>$counter</a></li>";					
    				}
    				$pagination.= "<li class='dot'>...</li>";
    				$pagination.= "<li><a href='{$url}page=$lpm1'>$lpm1</a></li>";
    				$pagination.= "<li><a href='{$url}page=$lastpage'>$lastpage</a></li>";		
    			}
    			elseif($lastpage - ($adjacents * 2) > $page && $page > ($adjacents * 2))
    			{
    				$pagination.= "<li><a href='{$url}page=1'>1</a></li>";
    				$pagination.= "<li><a href='{$url}page=2'>2</a></li>";
    				$pagination.= "<li class='dot'>...</li>";
    				for ($counter = $page - $adjacents; $counter <= $page + $adjacents; $counter++)
    				{
    					if ($counter == $page)
    						$pagination.= "<li><a class='current'>$counter</a></li>";
    					else
    						$pagination.= "<li><a href='{$url}page=$counter'>$counter</a></li>";					
    				}
    				$pagination.= "<li class='dot'>..</li>";
    				$pagination.= "<li><a href='{$url}page=$lpm1'>$lpm1</a></li>";
    				$pagination.= "<li><a href='{$url}page=$lastpage'>$lastpage</a></li>";		
    			}
    			else
    			{
    				$pagination.= "<li><a href='{$url}page=1'>1</a></li>";
    				$pagination.= "<li><a href='{$url}page=2'>2</a></li>";
    				$pagination.= "<li class='dot'>..</li>";
    				for ($counter = $lastpage - (2 + ($adjacents * 2)); $counter <= $lastpage; $counter++)
    				{
    					if ($counter == $page)
    						$pagination.= "<li><a class='current'>$counter</a></li>";
    					else
    						$pagination.= "<li><a href='{$url}page=$counter'>$counter</a></li>";					
    				}
    			}
    		}
    		
    		if ($page < $counter - 1){ 
    			$pagination.= "<li><a href='{$url}page=$next'>Next</a></li>";
                $pagination.= "<li><a href='{$url}page=$lastpage'>Last</a></li>";
    		}else{
    			$pagination.= "<li><a class='current'>Next</a></li>";
                $pagination.= "<li><a class='current'>Last</a></li>";
            }
    		$pagination.= "</ul>\n";		
    	}
    
    
        return $pagination;
    } 


//give all blog list
function all_blog($id)
{
	if($id!='')
{
$query="SELECT * FROM ".BLOG_TBL." WHERE ID='".$id."'";
}
else{
$query="SELECT * FROM ".BLOG_TBL." ORDER BY ID";
}
$result = mysql_query($query);
$i=0;
$arr=array();
while($row = @mysql_fetch_array($result))
{
	$arr[$i]=$row;
   $i++;	
}
return ($arr);
}

function blog_byTitle($title)
{
$query="SELECT * FROM ".BLOG_TBL." WHERE Title  LIKE '".$title."'";
$result = mysql_query($query);
$i=0;
 if(mysql_num_rows($result)!=0)
  {
$arr=array();
while($row = @mysql_fetch_array($result))
{
	$arr[$i]=$row;
   $i++;	
}
return ($arr);
  }
  else{
	  return 0;
  }
}


// blog by pagination
function content_byPaging($tbl,$start,$end,$type='',$subType='')
{
	if(($type=='') && ($subType==''))
	{
	$query="SELECT * FROM ".$tbl." ORDER BY ID DESC LIMIT $start,$end";
	}
	else{
		if($type=='ath')
		{
			
	     $query="SELECT * FROM ".$tbl." WHERE type = '$subType' ORDER BY ID DESC LIMIT $start,$end";
			
		}
		else if($type=='cat')
		{
			
		 $category=category_byname($subType);
		 $id=$category[0]['ID'];
		 $query="SELECT * FROM ".$tbl." WHERE find_in_set($id,Category) > 0 ORDER BY ID DESC LIMIT $start,$end";
		}
		else if($type=='ach')
		{
		  $query="SELECT * FROM ".$tbl." WHERE MONTHNAME( CreatedDate ) LIKE '$subType' ORDER BY ID DESC LIMIT $start,$end";
			
		}
		else{
			$query="SELECT * FROM ".$tbl." ORDER BY ID DESC LIMIT $start,$end";
		}
		
	}
	$result = mysql_query($query);
	$i=0;
	$arr=array();
	$total=@mysql_num_rows($result);
	if($total==0)
	{
     $query="SELECT * FROM ".$tbl." ORDER BY ID DESC LIMIT $start,$end";
	 $result = mysql_query($query);
	}
	while($row = @mysql_fetch_array($result))
	{
		$arr[$i]=$row;
	   $i++;	
	}
	return ($arr);
	}

//  blog count by category
function blog_bycategoryCount($id)
{
$query	="SELECT COUNT(ID) AS CNT FROM  ".BLOG_TBL." WHERE find_in_set($id,Category) > 0";
$result = mysql_query($query);
while($row = @mysql_fetch_array($result))
{
return $row['CNT'];;
}
	
	
}
// add edit blog 
function addedit_blog($Pic,$Title ,$Description ,$tag,$PostID ,$Type,$IP ,$Status,$category,$metatag,$metadescription,$existId)
{
		
$jobTitle	=	preg_replace('/[^a-zA-Z0-9 ]/s', '',$Title);
$website_url =  str_replace(" ","-",$jobTitle);

	
	$date=date("Y-m-d H:i:s");
	if($existId!='')
	  {
		  
		if($Pic=='')
		{
		//at update time if user change not change the pic
	
		$query="UPDATE ".BLOG_TBL." SET Title='$Title',
		Description='$Description',
		PostID='$PostID',
		Type='$Type',
		website_url='$website_url',
		Tag='$tag',
		EditIP 	='$IP',
		Status='$Status',
		Category='$category',
		meta_tag='".$metatag."',
        meta_description='".$metadescription."',
		ModifiedDate= '$date' 
		WHERE ID='$existId' ";

		}
		else{

//at update time if user change pic
		$blogList=all_blog($existId);
		$blogpic=$blogList[0]['Pic'];
		$filethumb= '../../../../'.BLOG_UPLOAD_FOLDER.'thumb/thumb_'.$blogpic;
		@unlink($filethumb);
		$filethumb= '../../../../'.BLOG_UPLOAD_FOLDER.'full/feature_'.$blogpic;
		@unlink($filethumb);
		
		echo $query="UPDATE ".BLOG_TBL." SET Pic='$Pic',
		Title='$Title',
		Description='$Description',
		PostID='$PostID',
		website_url='$website_url',
		Type='$Type',
		Tag='$tag',
		EditIP 	='$IP',
		Status='$Status',
		Category='$category',
    	meta_tag='".$metatag."',
        meta_description='".$metadescription."',
		ModifiedDate= '$date' 
		WHERE ID='$existId' ";
		}

  }
 else{
  $query="INSERT INTO ".BLOG_TBL." (Pic,Title,Description,meta_tag,meta_description,Tag,website_url,PostID,Type,CreateIP,Status,Category,CreatedDate,ModifiedDate ) 
  VALUES  
   ('$Pic','$Title','$Description','".$metatag."','".$metadescription."','$tag','$website_url','$PostID','$Type','$IP','$Status','$category','$date','$date')";
 }
$result = mysql_query($query);
if($result)
{
return 1;
}
else{
return 0;
}
	
}

// add edit blog 
function addedit_quote($Title,$author,$Status,$category,$existId)
{
		
$jobTitle	=	preg_replace('/[^a-zA-Z0-9 ]/s', '',$Title);
$website_url =  str_replace(" ","-",$jobTitle);
$date=time();
	if($existId!='')
	  {
		  
		$query="UPDATE ".QUOTE_TBL." SET quote='$Title',
		author_name='$author',
		website_url='$website_url',
		status='$Status',
		parent_id='$category',
		modified= '$date' 
		WHERE id='$existId' ";

		
  }
 else{
  $query="INSERT INTO ".QUOTE_TBL." (quote,author_name,website_url,status,parent_id,modified ) 
		VALUES   
		('$Title','$author','$website_url','$Status','$category','$date')";
 }
$result = mysql_query($query);
if($result)
{
return 1;
}
else{
return 0;
}
	
}

//delete blog
function delete_Blog($id)
{
delete_blogCommentbyBlog($id);	
$blogList=all_blog($id);
$blogpic=$blogList[0]['Pic'];
$filethumb= '../'.BLOG_UPLOAD_FOLDER.'thumb/thumb_'.$blogpic;
@unlink($filethumb);
$filethumb= '../'.BLOG_UPLOAD_FOLDER.'full/feature_'.$blogpic;
@unlink($filethumb);
$query="DELETE FROM ".BLOG_TBL." WHERE ID=$id";
$result = mysql_query($query);
if($result)
{
return 1;
}
else{
return 0;
}
	
}

// delete blog related comments
function delete_blogCommentbyBlog($id)
{
$query="DELETE FROM ".BLOG_COMMENT_TBL." WHERE BlogID=$id";
$result = mysql_query($query);
if($result)
{
return 1;
}
else{
return 0;
}

}

//blog comment 
function all_blog_comment($id)
{

if($id!='')
{
$query="SELECT * FROM ".BLOG_COMMENT_TBL." WHERE ID='".$id."'";
}
else{
$query="SELECT * FROM ".BLOG_COMMENT_TBL." ORDER BY ID";
}
$result = mysql_query($query);
$i=0;
$arr=array();
while($row = @mysql_fetch_array($result))
{
	$arr[$i]=$row;
   $i++;	
}
return ($arr);
	
}
//blog comment by blog id

function blog_comment_by_blogid($id)
{

$query="SELECT * FROM ".BLOG_COMMENT_TBL." WHERE BlogID='".$id."'";
$result = mysql_query($query);
$i=0;
$arr=array();
while($row = @mysql_fetch_array($result))
{
	$arr[$i]=$row;
   $i++;	
}
return ($arr);
	
}



//add edit blog comments
function addedit_blog_comment($Comment,$BlogID,$PostID ,$Type,$IP ,$Status,$existId)
{
	$date=date("Y-m-d H:i:s");
	if($existId!='')
	  {
		$query="UPDATE ".BLOG_COMMENT_TBL." SET Comment='$Comment',
		BlogID='$BlogID',
		PostID='$PostID',
		Type='$Type',
		IP 	='$IP',
		Status='$Status',
		ModifiedDate= '$date' 
		WHERE ID='$existId' ";

  }
 else{
  $query="INSERT INTO ".BLOG_COMMENT_TBL." (Comment,BlogID,PostID,Type,IP,Status,CreatedDate,ModifiedDate ) VALUES   ('$Comment','$BlogID','$PostID','$Type','$IP','$Status','$date','$date')";
 }
$result = mysql_query($query);
if($result)
{
return 1;
}
else{
return 0;
}
	
}


// delete blog related comments
function delete_blogComment($id)
{
$query="DELETE FROM ".BLOG_COMMENT_TBL." WHERE ID=$id";
$result = mysql_query($query);
if($result)
{
return 1;
}
else{
return 0;
}

}

//news related function 
//give all news list
function all_news($id)
{
	if($id!='')
{
$query="SELECT * FROM ".NEWS_TBL." WHERE ID='".$id."'";
}
else{
$query="SELECT * FROM ".NEWS_TBL." ORDER BY ID";
}
$result = mysql_query($query);
$i=0;
$arr=array();
while($row = @mysql_fetch_array($result))
{
	$arr[$i]=$row;
   $i++;	
}
return ($arr);
}

function news_byTitle($title)
{	
$query="SELECT * FROM ".NEWS_TBL." WHERE Title LIKE '".$title."'";

$result = mysql_query($query);
$i=0;
  if(mysql_num_rows($result)!=0)
  {
$arr=array();

while($row = @mysql_fetch_array($result))
{
	$arr[$i]=$row;
    $i++;	
}
return ($arr);
  }
  else{
return 0;
  }
}
//new between days and count
function news_bydateCount($count,$start,$end)
{
	global $PQR_NewsViewDetail;
	$query="SELECT * FROM ".NEWS_TBL."  WHERE  DATE(CreatedDate) <= '".$start."' AND  DATE(CreatedDate) >= '".$end."'  AND  Status	= 1 ORDER BY RAND() LIMIT  $count";
$currentProfitj = mysql_query($query);
$arrnewsList=array();
while( $row9=@mysql_fetch_array($currentProfitj))
{
	$arrnewsList[]=$row9;
	 
}
global $PQR_NewsViewDetail;

$str='';
foreach($arrnewsList as $news)
{
	$datetime = new DateTime($news['CreatedDate']);

$str.= '
<div>
 <div>
 <div class="float-left news-date-left-part">
 <div class="news-date-bg">'.get_only_day($news['CreatedDate']).'</div>
 <div class="news-month-bg">'.get_only_month_name($news['CreatedDate']).'</div>
 </div>
 
 <div class="float-left  news-titile-w">
 <div class="blue-link2 bold"> <a href="'.WEBSITE_NEWS_URL.$news['website_url'].'" title="'.$news['Title'].'">'.$news['Title'].'</a> </div>
 <div class="font-11">Post: '.$news['Type'].'</div>
 </div>
 <div class="clear"></div>
 </div>
 <div><img src="images/dot.gif" alt="" height="10px" width="1px" /></div>
 <div>
 <div class="float-left mar-right10">
 <a href="'.WEBSITE_NEWS_URL.$news['website_url'].'" title="'.$news['Title'].'">
 <img src="'.WEBSITE_NEWS_UPLOAD_IMG_URL."thumb/thumb_".$news['Pic'].'" alt="'.$news['Title'].'" />
 </a>
 </div>
'.Display_Limited_Character($news['Description'],250).'</div>
</div>

<div class="grayhr"><div class="clear"><img src="images/dot.gif" alt="" /></div></div>';
}

return $str;

}

// add edit blog 
function addedit_news($Pic,$Title ,$Description ,$PostID ,$Type,$IP ,$Status,$existId)
{
	
$jobTitle	=	preg_replace('/[^a-zA-Z0-9 ]/s', '',$Title);
$website_url =  str_replace(" ","-",$jobTitle);

	$date=date("Y-m-d H:i:s");
	if($existId!='')
	  {
		  
		if($Pic=='')
		{
		//at update time if user change not change the pic
	
		$query="UPDATE ".NEWS_TBL." SET Title='$Title',
		Description='$Description',
		website_url='$website_url',
		PostID='$PostID',
		Type='$Type',
		EditIP 	='$IP',
		Status='$Status',
		
		ModifiedDate= '$date' 
		WHERE ID='$existId' ";

		}
		else{

//at update time if user change pic
		$newsList=all_news($id);
		$newspic=$newsList[0]['Pic'];
		$filethumb= '../../../../'.NEWS_UPLOAD_FOLDER.'thumb/thumb_'.$newspic;
		@unlink($filethumb);
		$filethumb= '../../../../'.NEWS_UPLOAD_FOLDER.'full/feature_'.$newspic;
		@unlink($filethumb);
		
		$query="UPDATE ".NEWS_TBL." SET Pic='$Pic',
		Title='$Title',
		Description='$Description',
		website_url='$website_url',
		PostID='$PostID',
		Type='$Type',
		EditIP 	='$IP',
		Status='$Status',
		ModifiedDate= '$date' 
		WHERE ID='$existId' ";
		}

  }
 else{
  $query="INSERT INTO ".NEWS_TBL." (Pic,Title,Description,website_url,PostID,Type,CreateIP,Status,CreatedDate,ModifiedDate ) VALUES   ('$Pic','$Title','$Description','$website_url','$PostID','$Type','$IP','$Status','$date','$date')";
 }
$result = mysql_query($query);
if($result)
{
return 1;
}
else{
return 0;
}
	
}

//delete news
function delete_News($id)
{
delete_newsCommentbyNews($id);	
$newsList=all_news($id);
$newspic=$newsList[0]['Pic'];
$filethumb= '../'.NEWS_UPLOAD_FOLDER.'thumb/thumb_'.$newspic;
@unlink($filethumb);
$filethumb= '../'.NEWS_UPLOAD_FOLDER.'full/feature_'.$newspic;
@unlink($filethumb);
$query="DELETE FROM ".NEWS_TBL." WHERE ID=$id";
$result = mysql_query($query);
if($result)
{
return 1;
}
else{
return 0;
}
	
}

// delete news related comments
function delete_newsCommentbyNews($id)
{
$query="DELETE FROM ".NEWS_COMMENT_TBL." WHERE  NewsID=$id";
$result = mysql_query($query);
if($result)
{
return 1;
}
else{
return 0;
}

}

//news comment 
function all_news_comment($id)
{

if($id!='')
{
$query="SELECT * FROM ".NEWS_COMMENT_TBL." WHERE ID='".$id."'";
}
else{
$query="SELECT * FROM ".NEWS_COMMENT_TBL." ORDER BY ID";
}
$result = mysql_query($query);
$i=0;
$arr=array();
while($row = @mysql_fetch_array($result))
{
	$arr[$i]=$row;
   $i++;	
}
return ($arr);
	
}
//news comment by news id

function news_comment_by_newsid($id)
{

$query="SELECT * FROM ".NEWS_COMMENT_TBL." WHERE NewsID='".$id."'";
$result = mysql_query($query);
$i=0;
$arr=array();
while($row = @mysql_fetch_array($result))
{
	$arr[$i]=$row;
   $i++;	
}
return ($arr);
	
}

//add edit news comments
function addedit_news_comment($Comment,$NewsID,$PostID ,$Type,$IP ,$Status,$existId)
{
	$date=date("Y-m-d H:i:s");
	if($existId!='')
	  {
		$query="UPDATE ".NEWS_COMMENT_TBL." SET Comment='$Comment',
		NewsID='$NewsID',
		PostID='$PostID',
		Type='$Type',
		IP 	='$IP',
		Status='$Status',
		ModifiedDate= '$date' 
		WHERE ID='$existId' ";

  }
 else{
  $query="INSERT INTO ".NEWS_COMMENT_TBL." (Comment,NewsID,PostID,Type,IP,Status,CreatedDate,ModifiedDate ) VALUES   ('$Comment','$NewsID','$PostID','$Type','$IP','$Status','$date','$date')";
 }
$result = mysql_query($query);
if($result)
{
return 1;
}
else{
return 0;
}
	
}


// delete news related comments
function delete_newsComment($id)
{
$query="DELETE FROM ".NEWS_COMMENT_TBL." WHERE ID=$id";
$result = mysql_query($query);
if($result)
{
return 1;
}
else{
return 0;
}

}


//testimonial related function

//give all testimonial list
function all_testimonial($id)
{
	if($id!='')
{
$query="SELECT * FROM ".TESTIMONIAL_TBL." WHERE ID='".$id."'";
}
else{
$query="SELECT * FROM ".TESTIMONIAL_TBL." ORDER BY ID";
}
$result = mysql_query($query);
$i=0;
$arr=array();
while($row = @mysql_fetch_array($result))
{
	$arr[$i]=$row;
   $i++;	
}
return ($arr);
}
//give all testimonial list
function all_quoteauthor($id)
{
	if($id!='')
{
$query="SELECT * FROM ".QUOTE_AUTHOR_TBL." WHERE id='".$id."'";
}
else{
$query="SELECT * FROM ".QUOTE_AUTHOR_TBL." ORDER BY id";
}
$result = mysql_query($query);
$i=0;
$arr=array();
while($row = @mysql_fetch_array($result))
{
	$arr[$i]=$row;
   $i++;	
}
return ($arr);
}

//give all testimonial list
function all_quote($id)
{
	if($id!='')
{
$query="SELECT * FROM ".QUOTE_TBL." WHERE id='".$id."'";
}
else{
$query="SELECT * FROM ".QUOTE_TBL." ORDER BY id";
}
$result = mysql_query($query);
$i=0;
$arr=array();
while($row = @mysql_fetch_array($result))
{
	$arr[$i]=$row;
   $i++;	
}
return ($arr);
}

function testimonial_byCountRandom($count)
{
 $query="SELECT * FROM ".TESTIMONIAL_TBL."  ORDER BY RAND() LIMIT $count ";
$result = mysql_query($query);
$i=0;
$arr=array();
while($row = @mysql_fetch_array($result))
{
	$arr[$i]=$row;
   $i++;	
}
return ($arr);

}
// add edit blog 
function addedit_testimonial($Pic,$Title ,$Description ,$PostID ,$Type,$IP ,$Status,$existId)
{
	$date=date("Y-m-d H:i:s");
	if($existId!='')
	  {
		$query="UPDATE ".TESTIMONIAL_TBL." 
		SET		Status='$Status',
		        ModifiedDate ='$date'
	          	WHERE ID='$existId' ";
		
  }
 else{
  $query="INSERT INTO ".TESTIMONIAL_TBL." (Pic,Title,Description,PostID,Type,CreateIP,Status,CreatedDate,ModifiedDate ) VALUES   ('$Pic','$Title','$Description','$PostID','$Type','$IP','$Status','$date','$date')";
 }
$result = mysql_query($query);
if($result)
{
return 1;
}
else{
return 0;
}
	
}

//delete news
function delete_Testimonial($id)
{
$query="DELETE FROM ".TESTIMONIAL_TBL." WHERE ID=$id";
$result = mysql_query($query);
if($result)
{
return 1;
}
else{
return 0;
}
	
}

//Category related  function

//give all category list
function all_category($id)
{
	if($id!='')
{
 $query="SELECT * FROM ".CATEGORY_TBL." WHERE ID='".$id."' ";
}
else{
$query="SELECT * FROM ".CATEGORY_TBL." ORDER BY ID";
}
$result = mysql_query($query);
$i=0;
$arr=array();
while($row = @mysql_fetch_array($result))
{
	$arr[$i]=$row;
   $i++;	
}
return ($arr);
}

//give all category list
function all_quotecategory($id)
{
	if($id!='')
{
 $query="SELECT * FROM ".QUOTE_CATEGORY_TBL." WHERE ID='".$id."' ";
}
else{
$query="SELECT * FROM ".QUOTE_CATEGORY_TBL." ORDER BY ID";
}
$result = mysql_query($query);
$i=0;
$arr=array();
while($row = @mysql_fetch_array($result))
{
	$arr[$i]=$row;
   $i++;	
}
return ($arr);
}

//give all category list
function article_category($id)
{
 $query="SELECT * FROM ".ARTICLE_CATEGORY_TBL." WHERE id='".$id."' ";
$result = mysql_query($query);
while($row = @mysql_fetch_array($result))
{
	return $row;
	
}

}


//give all category list
function category_byname($name)
{

$query="SELECT * FROM ".CATEGORY_TBL." WHERE Name='".$name."'";
$result = mysql_query($query);
$i=0;
$arr=array();

while($row = @mysql_fetch_array($result))
{
	$arr[$i]=$row;
   $i++;	
}
return ($arr);
}

// add edit blog 
function addedit_category($Name,$existId)
{
	$date=date("Y-m-d H:i:s");
	
	if($Name!='')
	{
	if($existId!='')
	  {
		$query="UPDATE ".CATEGORY_TBL." 
		SET		Name        ='$Name',
		        ModifiedDate ='$date'
	          	WHERE ID='$existId' ";
		
  }
 else{
  $query="INSERT INTO ".CATEGORY_TBL." (Name,CreatedDate,ModifiedDate,OnlyDate ) VALUES ('$Name','$date','$date','".date('Y-m-d')."')";
 }
	
$result = mysql_query($query);
if($result)
{
return 1;
}
else{
return 0;
}
	
	}
	else{
		return 0;
	}
}


// add edit quote category
function addedit_quotecategory($Name,$existId)
{
	$date=date("Y-m-d H:i:s");
	
	if($Name!='')
	{
	if($existId!='')
	  {
		$query="UPDATE ".QUOTE_CATEGORY_TBL." 
		SET		Name        ='$Name',
		        ModifiedDate ='$date'
	          	WHERE ID='$existId' ";
		
  }
 else{
  $query="INSERT INTO ".QUOTE_CATEGORY_TBL." (Name,CreatedDate,ModifiedDate,OnlyDate ) VALUES ('$Name','$date','$date','".date('Y-m-d')."')";
 }
	
$result = mysql_query($query);
if($result)
{
return 1;
}
else{
return 0;
}
	
	}
	else{
		return 0;
	}
}

//delete category
function delete_Category($id)
{
$query="DELETE FROM ".CATEGORY_TBL." WHERE ID=$id";
$result = mysql_query($query);
if($result)
{
return 1;
}
else{
return 0;
}
	
}


//delete category
function delete_QuoteCategory($id)
{
$query="DELETE FROM ".QUOTE_CATEGORY_TBL." WHERE ID=$id";
$result = mysql_query($query);
if($result)
{
return 1;
}
else{
return 0;
}
	
}

function delete_Quote($id)
{
$query="DELETE FROM ".QUOTE_TBL." WHERE id=$id";
$result = mysql_query($query);
if($result)
{
return 1;
}
else{
return 0;
}
	
}
//all country

function all_country($id)
{
	if($id!='')
{
$query="SELECT * FROM ".COUNTRY_TBL." WHERE ID='".$id."'";
}
else{
$query="SELECT * FROM ".COUNTRY_TBL." ORDER BY CountryName ASC";
}
$result = mysql_query($query);
$i=0;
$arr=array();
while($row = @mysql_fetch_array($result))
{
	$arr[$i]=$row;
   $i++;	
}
return ($arr);
}



function find_statebycountry($countryId)
{
$query="SELECT * FROM ".STATE_TBL." WHERE CountryCode='$countryId' ORDER BY StateName ASC";

$result = mysql_query($query);

$i=0;

$arr=array();

while($row = mysql_fetch_array($result))
{

	$arr[$i]=$row;
$i++;	
}
return ($arr);

}


function find_citybystate($stateId,$countryID)
{
$query="SELECT * FROM ".CITY_TBL." WHERE  CountryCode='$countryID' AND StateCode=$stateId  ORDER BY CityName ASC";

$result = mysql_query($query);

$i=0;

$arr=array();

while($row = @mysql_fetch_array($result))
{

	$arr[$i]=$row;
$i++;	
}
return ($arr);

}


function find_citybycountry($countryID)
{
$query="SELECT * FROM ".CITY_TBL." WHERE CountryCode='$countryID' ORDER BY ID";

$result = mysql_query($query);

$i=0;

$arr=array();

while($row = mysql_fetch_array($result))
{

	$arr[$i]=$row;
$i++;	
}
return ($arr);

}

function add_subscribeuser($email)
{
	
	$query="SELECT * FROM ".SUBSCRIBE_TBL." WHERE EmailID ='".mysql_real_escape_string(trim($email))."'";
   $result = mysql_query($query);
   if(mysql_num_rows($result)==0)
{

$query="INSERT INTO ".SUBSCRIBE_TBL." (EmailID,CreatedDate,OnlyDate ) VALUES ('$email','".date('Y-m-d H:i:s')."','".date('Y-m-d')."')";
$result = mysql_query($query);
if($result)
{
return 1;
}
else{
return 0;
}

	
}
else{
	return 3;
}
}


function all_module($id)
{
if($id!='')
{
$query="SELECT * FROM ".MODULES." WHERE id ='".$id."' AND moduleStatus = 1";
}
else{
$query="SELECT * FROM ".MODULES." WHERE  moduleStatus = 1 ORDER BY moduleOrder ASC";
}
$result = mysql_query($query);
$i=0;
$arr=array();
while($row = @mysql_fetch_array($result))
{
	$arr[$i]=$row;
   $i++;	
}
return ($arr);

	
}
/**********************Adds Manager*****************************/
function all_adds($id)
{
if($id!='')
{
$query="SELECT * FROM ".ADDS_TBL." WHERE id ='".$id."'";
}
else{
$query="SELECT * FROM ".ADDS_TBL."  ORDER BY id DESC";
}
$result = mysql_query($query);
$i=0;
$arr=array();
while($row = @mysql_fetch_array($result))
{
	$arr[$i]=$row;
   $i++;	
}
return ($arr);
	
}

// add edit blog 
function addedit_adds($image,$title,$side,$url,$target_path,$status,$existId)
{
	//echo $image.",".$title.",".$side.",".$url.",".$target_path.",".$status.",".$existId;
	$date=time();
	if($existId!='')
	  {
		  
		if($image=='')
		{
		//at update time if user change not change the pic
	
	  $query="UPDATE ".ADDS_TBL." SET
		title='$title',
		side='$side',
		url='$url',
		target_path='$target_path',
		status='$status',
		modified_date= '$date' 
		WHERE id='$existId' ";

		}
		else{

//at update time if user change pic

		$newsList=all_adds($id);
		$newspic=$newsList[0]['image'];
		$filethumb= '../../../../'.ADDS_UPLOAD_FOLDER.'thumb/thumb_'.$newspic;
		@unlink($filethumb);
		$filethumb= '../../../../'.ADDS_UPLOAD_FOLDER.$newspic;
		@unlink($filethumb);
		
		$query="UPDATE ".ADDS_TBL." SET image='$image',
		title='$title',
		side='$side',
		url='$url',
		target_path='$target_path',
		status='$status',
		modified_date= '$date' 
		WHERE id='$existId' ";
		}

  }
 else{
	 
  $query="INSERT INTO ".ADDS_TBL." (image,title,side,url,target_path,status,modified_date ) VALUES   ('$image','$title','$side','$url','$target_path','$status','$date')";

 }
 
$result = mysql_query($query);
if($result)
{
return 1;
}
else{
return 0;
}
	
}



//delete adds
function delete_adds($id)
{
	
$addsList=all_adds($id);
$addspic=$addsList[0]['image'];
$filethumb= '../'.ADDS_UPLOAD_FOLDER.'thumb/thumb_'.$addspic;
@unlink($filethumb);
$filethumb= '../'.ADDS_UPLOAD_FOLDER.$addspic;
@unlink($filethumb);
	
$query="DELETE FROM ".ADDS_TBL." WHERE id=$id";
$result = mysql_query($query);
if($result)
{
return 1;
}
else{
return 0;
}
	
}


//delete adds
function delete_clickadds($id)
{
$query="DELETE FROM ".ADDS_CLICK_TBL." WHERE id=$id";
$result = mysql_query($query);
if($result)
{
return 1;
}
else{
return 0;
}
	
}
//delete adds
function delete_viewadds($id)
{
$query="DELETE FROM ".ADDS_VIEW_TBL." WHERE id=$id";
$result = mysql_query($query);
if($result)
{
return 1;
}
else{
return 0;
}
	
}


function add_byposition($position)
{
$query="SELECT * FROM ".ADDS_TBL." WHERE side ='".$position."'";
$result = mysql_query($query);
$i=0;
$arr=array();
while($row = @mysql_fetch_array($result))
{
	$arr[$i]=$row;
   $i++;	
}
return ($arr);

}

function add_by_page_position($page,$pos)
{
$query="SELECT * FROM ".ADDS_PAGES_TBL." WHERE page_name ='".$page."' AND side='".$pos."' ";
$result = mysql_query($query);
$i=0;
$arr=array();
while($row = @mysql_fetch_array($result))
{
	$arr[$i]=$row;
   $i++;	
}
return ($arr);
	
	
}


function add_by_page_position_random($page,$pos)
{
 $query="SELECT * FROM ".ADDS_PAGES_TBL." WHERE page_name ='".$page."' AND side='".$pos."' LIMIT 1 ";
$result = mysql_query($query);
$i=0;
while($row = @mysql_fetch_array($result))
{
$arr=	explode(",",$row['add_id']); 

//$arr[array_rand($arr)]);
return $arr[array_rand($arr)]; //in many add find a random value in add id array and show in a a page
}
	
	
}



function all_pageadds($id)
{
if($id!='')
{
$query="SELECT * FROM ".ADDS_PAGES_TBL." WHERE id ='".$id."'";
}
else{
$query="SELECT * FROM ".ADDS_PAGES_TBL."  ORDER BY id DESC";
}
$result = mysql_query($query);
$i=0;
$arr=array();
while($row = @mysql_fetch_array($result))
{
	$arr[$i]=$row;
   $i++;	
}
return ($arr);
	
}


function add_EventInCalender($currency,$date,$existId='')
{
	if($existId!='')
	  {
		$query="UPDATE ".MARKET_CALENDER." 
		SET		Currency 	        ='$Name',
		        Date ='$date'
	          	WHERE ID='$existId' ";
		
   }
 else{
 
  $query="SELECT * FROM ".MARKET_CALENDER." WHERE Currency ='".$currency."' AND Date='".$date."' ";
   $result = mysql_query($query);
   if(mysql_num_rows($result)==0)
 {	 
   	 
  $query="INSERT INTO ".MARKET_CALENDER." (Currency,Date) VALUES ('$currency','$date')";
  $result = mysql_query($query);
if($result)
{
return 1;
}
else{
	return 0;
}


 }
 else{
	 return 2;
 }
	
}
}

function all_EventInCalender($id)
{
if($id!='')
{
$query="SELECT * FROM ".MARKET_CALENDER." WHERE id ='".$id."'";
}
else{
$query="SELECT * FROM ".MARKET_CALENDER."  ORDER BY id DESC";
}
$result = mysql_query($query);
$i=0;
$arr=array();
while($row = @mysql_fetch_array($result))
{
	$arr[$i]=$row;
   $i++;	
}
return ($arr);
	
}

function delete_Faq($id)
{
$query="DELETE FROM ".FAQ_TBL." WHERE ID=$id";
$result = mysql_query($query);
if($result)
{
return 1;
}
else{
return 0;
}
	
}
 
function delete_Myth($id)
{
$query="DELETE FROM ".MYTH_TBL." WHERE ID=$id";
$result = mysql_query($query);
if($result)
{
return 1;
}
else{
return 0;
}
	
}

function delete_Event($id)
{
$query="DELETE FROM ".MARKET_CALENDER." WHERE ID=$id";
$result = mysql_query($query);
if($result)
{
return 1;
}
else{
return 0;
}
	
}
############## ADD Product Category ############
function add_ProductCategory($name,$parent_id,$status,$existId='')
{
 
//if not the first check exist already category 
  $query="SELECT * FROM ".TABLE_PRODUCT_CATEGORY." WHERE name ='".$name."' AND  parent_id =".$parent_id." ";
   $result = mysql_query($query);
   if(@mysql_num_rows($result)==0)
 {	 
 //if not exist then insert
   	 
$query="INSERT INTO ".TABLE_PRODUCT_CATEGORY."(name,parent_id,modified,status) VALUES ('$name','$parent_id','".time()."','$status')";
  $result = mysql_query($query);
if($result)
{
return mysql_insert_id();
}
else{
	return 0;
}


 }
 else{
	 return -1;
 }
	
}

##############Edit Product category ############
//if exist id exist then edit
function edit_ProductCategory($name,$status,$existId)
{
 
		$query="UPDATE ".TABLE_PRODUCT_CATEGORY." 
		SET		name 	        ='$name',
				status          ='$status',  
		        modified =".time()."
	          	WHERE ID='$existId' ";
		
  $result = mysql_query($query);
if($result)
{
return 1;
}
else{
	return 0;
}
}

##############Delete Product Category############
function delete_ProductCategory($id)
{
$query="DELETE FROM ".TABLE_PRODUCT_CATEGORY." WHERE id=$id";
$result = mysql_query($query);
if($result)
{
return 1;
}
else{
return 0;
}
}
##################Delete Product####################
function delete_Product($id)
{
$query="DELETE FROM ".TABLE_PRODUCT." WHERE id=$id";
$result = mysql_query($query);
if($result)
{
return 1;
}
else{
return 0;
}
}
############## ADD Product Category ############
function add_ArticleCategory($name,$parent_id,$status,$existId='')
{
 
//if not the first check exist already category 
  $query="SELECT * FROM ".ARTICLE_CATEGORY_TBL." WHERE name ='".$name."' AND  parent_id =".$parent_id." ";
   $result = mysql_query($query);
   if(@mysql_num_rows($result)==0)
 {	 
 //if not exist then insert
   	 $jobTitle	=	preg_replace('/[^a-zA-Z0-9 ]/s', '',$name);
	$website_url =  str_replace(" ","-",$jobTitle);


$query="INSERT INTO ".ARTICLE_CATEGORY_TBL."(name,parent_id,modified,website_url,status) VALUES ('$name','$parent_id','".time()."','".$website_url."','$status')";
  $result = mysql_query($query);
if($result)
{
return mysql_insert_id();
}
else{
	return 0;
}


 }
 else{
	 return -1;
 }
	
}

##############Edit Product category ############
//if exist id exist then edit
function edit_ArticleCategory($name,$status,$existId)
{
 	 $jobTitle	=	preg_replace('/[^a-zA-Z0-9 ]/s', '',$name);
	$website_url =  str_replace(" ","-",$jobTitle);

		$query="UPDATE ".ARTICLE_CATEGORY_TBL." 
		SET		name 	        ='$name',
		        website_url	='".$website_url."',
				status          ='$status',  
		        modified =".time()."
	          	WHERE ID='$existId' ";
		
  $result = mysql_query($query);
if($result)
{
return 1;
}
else{
	return 0;
}
}


##############Delete Product Category############
function delete_ArticleCategory($id)
{
$query="DELETE FROM ".ARTICLE_CATEGORY_TBL." WHERE parent_id=$id";
$result = mysql_query($query);

$query="DELETE FROM ".ARTICLE_CATEGORY_TBL." WHERE id=$id";
$result = mysql_query($query);
if($result)
{
return 1;
}
else{
return 0;
}
}
##################Delete Product####################
function delete_Article($id)
{
$query="DELETE FROM ".ARTICLE_TBL." WHERE id=$id";
$result = mysql_query($query);
if($result)
{
return 1;
}
else{
return 0;
}
}

##################Delete Product####################
function delete_Scratch($id)
{
$query="DELETE FROM ".SCRATCH_TBL." WHERE id=$id";
$result = mysql_query($query);
if($result)
{
return 1;
}
else{
return 0;
}
}

#################Quiz Section##########################
############## ADD QUIZ Category ############
function add_QuizCategory($name,$parent_id,$status,$existId='')
{
 
//if not the first check exist already category 
  $query="SELECT * FROM ".QUIZ_CATEGORY_TBL." WHERE name ='".$name."' AND  parent_id =".$parent_id." ";
   $result = mysql_query($query);
   if(@mysql_num_rows($result)==0)
 {	 
 //if not exist then insert
   	 $jobTitle	=	preg_replace('/[^a-zA-Z0-9 ]/s', '',$name);
	$website_url =  str_replace(" ","-",$jobTitle);


$query="INSERT INTO ".QUIZ_CATEGORY_TBL."(name,parent_id,modified,website_url,status) VALUES ('$name','$parent_id','".time()."','".$website_url."','$status')";
  $result = mysql_query($query);
if($result)
{
return mysql_insert_id();
}
else{
	return 0;
}


 }
 else{
	 return -1;
 }
	
}

##############Edit QUIZ category ############
//if exist id exist then edit
function edit_QuizCategory($name,$status,$existId)
{
 	 $jobTitle	=	preg_replace('/[^a-zA-Z0-9 ]/s', '',$name);
	$website_url =  str_replace(" ","-",$jobTitle);

		$query="UPDATE ".QUIZ_CATEGORY_TBL." 
		SET		name 	        ='$name',
		        website_url	='".$website_url."',
				status          ='$status',  
		        modified =".time()."
	          	WHERE ID='$existId' ";
		
  $result = mysql_query($query);
if($result)
{
return 1;
}
else{
	return 0;
}
}


##############Delete QUIZ Category############
function delete_QuizCategory($id)
{
$query="DELETE FROM ".QUIZ_CATEGORY_TBL." WHERE parent_id=$id";
$result = mysql_query($query);

$query="DELETE FROM ".QUIZ_CATEGORY_TBL." WHERE id=$id";
$result = mysql_query($query);
if($result)
{
return 1;
}
else{
return 0;
}
}
##################Delete QUIZ####################
function delete_Quiz($id)
{
$query="DELETE FROM ".QUIZ_TBL." WHERE id=$id";
$result = mysql_query($query);
if($result)
{
return 1;
}
else{
return 0;
}
}
###################Quiz Section End######################



##################Delete Fashion Image####################
function delete_FashionImg($id)
{
$query="DELETE FROM ".FASHION_TBL." WHERE id=$id";
$result = mysql_query($query);
if($result)
{
return 1;
}
else{
return 0;
}
}

##################Delete Product####################
function delete_Video($id)
{
$query="DELETE FROM ".VIDEO_TBL." WHERE ID=$id";
$result = mysql_query($query);
if($result)
{
return 1;
}
else{
return 0;
}
}
function  delete_QuoteAuthor($id)
{
$query="DELETE FROM ".QUOTE_AUTHOR_TBL." WHERE id=$id";
$result = mysql_query($query);
if($result)
{
return 1;
}
else{
return 0;
}
}


##################Check Stock Holidays Events ####################
function checkStockHoliday($currency,$date,$predayMtm)
{
  $query="SELECT * FROM ".MARKET_CALENDER." WHERE Currency ='".$currency."' AND Date='".$date."' ";
   $result = mysql_query($query);
   if(mysql_num_rows($result)==0)
 {
	 return 0;
 }
 else{
	
	 $result = mysql_query("SELECT * FROM  ".constant($predayMtm)." ORDER BY ID DESC LIMIT  1");
	 while($rowmtm = @mysql_fetch_array($result))
	{ 
	 return  $rowmtm['OnlyDate'];
	}

 }
	
}

?>