<?php 
ob_start();
 session_start();
 ?>
<table width="100%" border="0" height="450">
	<tr>
		<td align="center" valign="middle" style="font-family:'黑体';font-size:12pt">
			<p>	</br></br></br></br></p><p>&nbsp;</p>
			<form id="form1" name="form1" method="post" action="login.php">
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
					<p>	<input type="submit" name="Submit" value="登陆" style="height:25px;width:50px;position:relative;top:10px;"/>	
					<a href="forget.php" style="position:relative;top:10px;">忘记密码?<sup style="font-size:6pt">测试中</sup></a></p>
					</td>					
				</tr>
			</table>			
			</form>
		</td>
	</tr>
</table>
<?php require_once('smartyconfig.php'); 
$maincontent=ob_get_contents();
ob_get_clean();
$tpl->assign("maincontent",$maincontent);
$tpl->display('template_member.php');
?>
