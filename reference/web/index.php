<?php 
ob_start();
session_start();
require_once('Connections/roche.php');
require_once('smartyconfig.php'); 
$role=$_SESSION['role'];
// $role=0;
$username=$_SESSION['username'];
?>
 <?php if($role>=0 and isset($username)){ ?>
<p>	</br></p><p>&nbsp;</p>
 <table width="100%" border="0" align="center" cellpadding="8" cellspacing="0" bgcolor="#F8F8F8" style="line-height:18px;font-family:'黑体';font-size:12pt">
	<tr>
			<td  ><p>欢迎您   <?php echo $_SESSION['username']; ?>!</p></td>
	</tr>
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
	<tr>
		<td>
		<?php 
		// echo "ro $role";
		if($role==0){?>
			<p>您总共<?php echo $hangshu; ?>有项订单，点击查看
				<a href="member_order.php" style="color:blue;text-decoration:none;">正在进行项目信息</a>
			</p>
		<?php }elseif($role>0){ 
		
		?>
		<p>我的项目，点击查看
				<a href="project_user.php" style="color:blue;text-decoration:none;">项目信息</a>
			</p>
		<?php } ?>
	    </td>			    	    
	</tr>
</table>
<p>	</br></p><p>&nbsp;</p>	
 <?php } else{?>
<table width="100%" border="0" height="450">
	<tr>
		<td align="center" valign="middle" style="font-family:'黑体';font-size:12pt">
			<p> <p><font color="darkred"><?php echo $_SESSION['loginerr'] ?></font></p></p><p>&nbsp;</p>
			<form id="form1" name="form1" method="post" action="login/login.php">
			<table width="50%" border="0">
				<tr>
					<td align="right">用户名: </td>
					<td><input tabindex="1", type="username" name="username" style="width:150px;" /></td>
				</tr>
				<tr>
					<td align="right">密码:</td>
					<td><input tabindex="2" type="password" name="password" style="width:150px;" /></td>
				</tr>
				<tr>
					<td colspan='2'  align="center">
					<p>	<input type="submit" name="Submit" value="登陆" style="height:25px;width:50px;position:relative;top:10px;left:-52px;"/>	
					<a href="forget.php" style="position:relative;top:10px;left:-30px;">忘记密码?</a></p>
					</td>					
				</tr>
			</table>			
			</form>
		</td>
	</tr>
</table>
<?php }
$html="template_login.php";
require_once('smartyconfig.php');
$maincontent=ob_get_contents();
ob_get_clean();
$tpl->assign("maincontent",$maincontent);
$tpl->display($html);
?>
