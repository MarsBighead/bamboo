<?php 
	ob_start();
	session_start();
?>
<table width="100%" border="0" height="450">
	<tr>
		<td align="center" valign="middle" style="font-family:'黑体';font-size:11pt">
		错误:<p><font color="darkred"><?php echo $_SESSION['loginerr'] ?></font></p>
		<p>&nbsp;</p>
		<a href="#">忘记密码？</a>
		<form id="form1" name="form1" method="post" action="resetpassword.php" target="_blank">
		<table width="50%" border="0">
			<tr>
				<td align="right">用户名: </td>
				<td><input name="username" type="text" id="username" /></td>
			</tr>
			<tr>
				<td align="right">注册邮箱:</td>
				<td><input name="email" type="text" id="email" /></td>
			</tr>
		</table>
		<p><input type="submit" name="Submit" value="重置密码" /></p>
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