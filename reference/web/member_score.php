<?php require_once('Connections/roche.php'); ?>
<?php require_once('smartyconfig.php'); 
ob_start()
?>
<?php
session_start(); 
if (empty($_SESSION['username'])){
	$_SESSION['loginerr']="您访问的页面需要先登录";
	header("location:loginerr.php");
	exit;
}
?>
 

<table width="100%" border="0" align="center" cellpadding="8" cellspacing="0" bgcolor="#F8F8F8" style="line-height:18px">
		<!--DWLayoutTable-->
		<tr height="3">
				<td width="100%" height="3" align="left" valign="top" ></td>
		</tr>
		<tr>
		  <td height="148" align="left" valign="top" style="font-size:7pt">
						<table width="99%" border="0" class="smalltable">
								 
								
								<tr>
										<td  >  
			                              <p>
			                                <?php
mysql_select_db($database_roche, $roche);
$query=sprintf("select * from user where username = '%s'", $_SESSION['username']);
 $result = mysql_query($query,$roche) or die(mysql_error()); 
while($row = mysql_fetch_array($result)){
  $userid =$row[userid];
  $username =$row[username];
  $email = $row[email];
  $lastlogin =$row[lastlogin];
  $title =$row[title];
  $realname=$row[realname];
  $company=$row[company];
  $department =$row[department];
  $address=$row[address];
  $zipcode=$row[zipcode];
  $city =$row[city];
  $telephone =$row[telephone];
  $mobiltel =$row[mobiltel];
  $fax =$row[fax];
  $score =$row[score];
  $login_time =$row[login_time];
  $receivemail =$row[receivemail];
    $j =0;
	$interest_arr = array();
  $query1="select * from interest where userid = ".$userid;
 $result1 = mysql_query($query1,$roche) or die(mysql_error()); 
 while($row1 = mysql_fetch_array($result1)){
 $interest_arr[$j]= $row1[interest];
 $j++;
}
?>
                                  欢迎您<?php echo $username ?>!</p>
	                              <p>您的积分为<?php echo $score ?>， 您可以进行积分兑换！</p></td>
  </tr>
  	   <?php
 }
?>
	 	  </table>	  
			    	  <?php
mysql_select_db($database_roche, $roche);
$query=sprintf("select * from project where username = '%s'", $_SESSION['username']);
 $result = mysql_query($query,$roche) or die(mysql_error()); 
 $hangshu = mysql_affected_rows(); 
while($row = mysql_fetch_array($result)){
  $id =$row[id];
  $username =$row[username];
  $name = $row[name];
  $date =$row[date];
  $title =$row[title];
  $score=$row[score];
   
  }
?>	
					    <table width="100%"><tr>
			    	      <td  ><p> <a href="member_order.php"></a></p>
		    	            <p>&nbsp;</p></td>
			    	    </tr></table></td>
								</tr>
						</table>		 	     
 
<?php
$maincontent=ob_get_contents();
ob_get_clean();
$tpl->assign("maincontent",$maincontent);
$tpl->display('template_member.php');

?>
