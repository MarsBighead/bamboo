<?php 
require_once('Connections/roche.php'); 
ob_start();
session_start(); 
if (empty($_SESSION['username'])){
	$_SESSION['loginerr']="您访问的页面需要先登录";
	header("location:loginerr.php");
	exit;
}
?>
 
<table width="98%" border="0" align="center" cellpadding="5">
   <tr  style="border-bottom:#0099CC 1px solid;">
		<td align="left"> <font color="#000000" face="黑体，宋体, Times New Roman, Arial" size="+1" ><strong>我的资料 </strong></font></td>
		<td align="right"><img src="site_images/ras.gif" width="197" height="20" /></td>
	</tr>
	<tr>
		<td valign="top" align="left" colspan="2" width="100%">	
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
		<table width="584"  border="0" cellspacing="0" style="bordercolor:#CCCCCC" >			  
			<tr>
				<td width="64"   >用户名</td>
				<td width="420"><?php echo $username ; ?></td>
			</tr>
			<tr>
				<td   >姓名</td>
				<td><?php echo $realname ; ?></td>
			</tr>
			<tr>
				<td  >邮件</td>
				<td><?php echo $email ; ?></td>
			</tr>
			<tr>
				<td  >称谓</td>
				<td><?php echo $title ; ?></td>
			</tr>
			<tr>
				<td >公司</td>
				<td><?php echo $company ; ?></td>
			</tr>
			<tr>
				<td  >地址</td>
				<td><?php echo $address ; ?></td>
			</tr>
			<tr>
				<td  >邮编</td>
				<td><?php echo $zipcode ; ?></td>
			</tr>
			<tr>
				<td  >电话</td>
				<td><?php echo $telephone ; ?></td>
			</tr>
			<tr>
				<td  > 手机</td>
				<td><?php echo $mobiltel ; ?></td>
			</tr>
			<tr>
				<td  >传真</td>
				<td><?php echo $fax ; ?></td>
			</tr>
			<tr>
				<td  >爱好</td>
				<td>
				<?php 
				foreach ($interest_arr as  $key => $value){
					echo $value.'<br/>';
				} ?>
				</td>
			</tr>
			<tr>
				<td  >注册时间</td>
				<td><?php echo $login_time ; ?></td>
			</tr>
		 </table>		
		<?php } ?>				   
		<p>&nbsp;</p></td>
    </tr>
</table>
 
<?php require_once('smartyconfig.php'); 
$maincontent=ob_get_contents();
ob_get_clean();
$tpl->assign("maincontent",$maincontent);
$tpl->display('template_member.php');
?>