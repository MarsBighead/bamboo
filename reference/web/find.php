<?php
include ('findpassword.php');
?>
<div  style="width:1000px;height:400px" >			
<?php
if(empty($_GET[username]) and isset($_GET[confirmation])  ){
	if($now>=$passtime ){
		echo "<script>alert('找回密码链接已过期!')</script>";?>
		<div style="font-size:14px;position:relative;top:30px;left:150px;width:700px;" align="left">	
		<a href="forget.php" style="color:#1357a2;">再次尝试重设密码</a></br>
		与我们的客服联系，电话：0512-62956558</br>
		</div>
	<?php
		}elseif(strcmp($token,$row[lastlogin])!=0){
		echo "<script>alert('找回密码链接已失效!')</script>";?>
		<div style="font-size:14px;position:relative;top:30px;left:150px;width:700px;" align="left">	
		<a href="forget.php" style="color:#1357a2;">再次尝试重设密码</a></br>
		与我们的客服联系，电话：0512-62956558</br>
		</div>
	<?php
		}else{
	?>
	<strong style="font-size:18px;position:relative;left:5px;top:10px;">重设密码</strong>	
	<div width="100%" align="center" style="position:relative;top:45px;font-size:16px;">
		<table width="50%" border="0"  >
		<form id="find" name="find" method="post" action="find.php">	
			<tr>
				<td width="30%" height="30"><input name="check" type="hidden" value="<?php echo "$check";?>"/></td>
				<td width="70%">请设置一个新密码</td>
			</tr>		
			<tr>
				<td width="30%" height="30" align="right">输入新密码:</td>
				<td width="70%"><input name="password" type="password" id="password" style="width:250px;position:relative;left:10px;"/></td>
			</tr>
			<tr>
				<td width="30%" height="30" align="right">确认密码:</td>
				<td width="70%"><input name="password2" type="password" id="password2" style="width:250px;position:relative;left:10px;"/></td>
			</tr>
			<tr>
				<td height="30"></td>
				<td ><input type="submit" name="Submit" value="确定" style="width:45px;position:relative;left:10px;"/></span></td>
			</tr>
		</form>
		</table>
	</div>
<?php }
}else{
		if($find==1){?>
		<div style="font-size:14px;position:relative;top:30px;left:150px;width:700px;" align="left">
			<span style="font-size:18px;">新密码已经生效！</span></br>
			<a href="index.php" >立即登录</a></br>
			与我们的客服联系，电话：0512-62956558</br>
		</div>		
		<?php		
		}elseif($find==0){
			// echo "<script>alert('密码重置失败!')</script>";
		?>
		<div style="font-size:14px;position:relative;top:30px;left:150px;width:700px;" align="left">	
			<span style="font-size:18px;">密码重置失败！</span>
			<a href="forget.php" style="color:#1357a2;">再次尝试重设密码</a></br>
			与我们的客服联系，电话：0512-62956558</br>
		</div>
		<?php
		}
	}
	?>
</div>
<?php require_once('smartyconfig.php'); 
$maincontent=ob_get_contents();
ob_get_clean();
$tpl->assign("maincontent",$maincontent);
$tpl->display('template_reset.php');
?>
