<?php 
ob_start();
session_start();
$email=$_GET[email];

?>

<div  style="width:1000px;height:400px" align="center">	
		<?php 
		if(isset($_GET[email])){ 
			$array_email=explode("@",$email);
			// print_r ($array_email);
			$link="http://mail.".$array_email[1];
			// echo "$link<br>";			
		?> 		
		<div style="font-size:14px;position:relative;top:30px;left:150px;width:700px;" align="left">		

		<span style="font-size:18px;">请进入邮箱重设密码</span></br>
		我们已向 <strong><?php echo "$email"; ?> </strong> 发送密码重置邮件</br>
		请登录邮箱点击重置链接重置密码。</br>
		<a href="<?php echo "$link"; ?>" target="_blank" style="line-height:30px;"><strong>进入邮箱查看</strong></a><br>
		没有收到重置密码邮件？你可以：</br>
		到邮箱中的垃圾邮件、广告邮件目录中找找</br>
		<a href="forget.php" style="color:#1357a2;">再次尝试重设密码</a></br>
		与我们的客服联系，电话：0512-62956558</br>
		</div>

		
		<?php }else{?>
		<span style="font-size:18px;position:relative;top:30px;">请输入注册邮箱，用于接收重设密码信息</span>		
		<table width="50%" border="0" style="position:relative;top:45px;font-size:18px;" >
		<form id="forget" name="forget" method="post" action="/reset.php"  onSubmit="check()">		
			<tr>
				<td width="30%" height="30" align="right">注册邮箱:</td>
				<td width="70%">
					<input name="email" type="text" id="email" style="width:250px;position:relative;left:10px;" Onblur="doCheck()"/>
					<span id="flag" style="position:relative;left:10px;"></span>
				</td>
			</tr>
			<tr>
				<td height="30"></td>
				<td ><input type="submit" name="Submit" value="确定" style="width:45px;"/></span></td>
			</tr>
		</form>
		</table>
		<?php } ?>
</div>
<script type="text/javascript">
function doCheck(){
	var email = document.getElementById("email").value;
	var ref=/^[\w-]+(\.[\w-]+)*@([\w-]+\.)+[a-zA-Z]{2,7}$/;
	var flag;
	if(email.match(ref)){		
		/*alert("E-mail address right!");*/
		flag="<strong style='color:green;'>&or;</strong>";
		document.getElementById("flag").innerHTML=flag;
	}else{
		flag="<strong style='color:red;'>&times;</strong>";
		document.getElementById("flag").innerHTML=flag;
		document.getElementById("email").innerHTML='';
		/*window.location.href='forget.php';*/
	}
}
function check(){
    if (document.forget.getElementById("flag").value!="<strong style='color:green;'>&or;</strong>")    {        
        alert("E-mail不正确");        
        return false;    
        }
    else{
        return true;
        }
}
	
</script>
<?php
require_once('smartyconfig.php'); 
$maincontent=ob_get_contents();
ob_get_clean();
$tpl->assign("maincontent",$maincontent);
$tpl->display('template_reset.php');
?>