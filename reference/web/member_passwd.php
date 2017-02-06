<?php 
require_once('Connections/roche.php');
ob_start();

function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
	$theValue = (!get_magic_quotes_gpc()) ? addslashes($theValue) : $theValue;
	switch ($theType) {
		case "text":
			$theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
			break;    
		case "long":
		case "int":
			$theValue = ($theValue != "") ? intval($theValue) : "NULL";
			break;
		case "double":
			$theValue = ($theValue != "") ? "'" . doubleval($theValue) . "'" : "NULL";
			break;
		case "date":
			$theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
			break;
		case "defined":
			$theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
			break;
  }
  return $theValue;
}
$username2=$_SESSION['username'] ; 
mysql_select_db($database_roche, $roche);
$query1 = "Select * From user where username = '$username2' ";
$result1 = mysql_query($query1,$roche) or die(mysql_error()); 
while($row1 = mysql_fetch_array($result1)){ 
	$password_old = $row1[password]; 
}
if (!empty($_POST['submit'])){
	$passwd_1=  md5($_POST["password"]);
	$passwd_2= md5($_POST["password1"]);
	$passwd_3=md5($_POST["password2"]);   
	if ($passwd_1 == "d41d8cd98f00b204e9800998ecf8427e" ){  $password = $password_old;
	}elseif ($passwd_1 != $password_old || $passwd_2 != $passwd_3){
		echo "<head>";
		echo "<meta http-equiv='Content-Type' content='text/html; charset=utf-8' />";
		echo "<meta http-equiv='refresh' content='3;url=member.php'>";
		echo "</head>";
		echo "密码不正确";
		exit ;
	}else {
		$password = $passwd_2 ; }
	$email = $_POST["email"];
	$company = $_POST["company"];
	$realname = $_POST["realname"];
	$address = $_POST["address"];
	$zipcode = $_POST["zipcode"];
	$telephone = $_POST["telephone"];
	$mobiltel = $_POST["mobiltel"];
	mysql_select_db($database_roche, $roche);
	$query = "update `user` set password = '$password',email = '$email',company = '$company',address = '$address',zipcode = '$zipcode' ,telephone = '$telephone',mobiltel = '$mobiltel',realname='$realname' where username =  '$username2'";
	$result = mysql_query($query,$roche) or die(mysql_error()); 
	echo "<head>";
	echo "<meta http-equiv='Content-Type' content='text/html; charset=utf-8' />";
	echo "<meta http-equiv='refresh' content='1;url=member.php'>";
	echo "</head>";
	echo "更新成功,1秒后自动跳转";
	exit ;
	}
?>
<script> 		
		function doCheck(){
	if (form1.username.value==""){
		alert("用户名不可为空");
		form1.username.focus();
		return false;
	}
	if (form1.password1.value!=form1.password2.value){
		alert("两次输入密码不一致");
		form1.password2.value="";
		form1.password2.focus();
		form1.password2.select();
		return false;
	}
	if (form1.password1.value==""){
		alert("密码不可为空");
		form1.password1.focus();
		return false;
	}	
	if (form1.password1.value.length>20 || form1.password1.value.length<6){
		alert("密码长度应为6~20位");
		form1.password1.focus();
		form1.password1.select();
		return false;
	}	
	if (form1.password1.value==""){
		alert("密码不可为空");
		form1.password1.focus();
		return false;
	}		
	if (form1.email.value==""){
		alert("email不可为空");
		form1.email.focus();
		return false;
	}		
	var str = form1.email.value; 
	var re = /^[\w-]+(\.[\w-]+)*@([\w-]+\.)+[a-zA-Z]{2,7}$/; 
	if (!str.match(re)) { 
		alert("您输入的不是有效的e-mail地址."); 
		form1.email.focus();
		form1.email.select();
		return false; 
	} 
	 			
	if (form1.company.value==""){
		alert("请填写单位信息");
		form1.company.focus();
		return false;
	}	
	 			
	if (form1.address.value==""){
		alert("请填写地址信息");
		form1.address.focus();
		return false;
	}				
	if (form1.telephone.value==""){
		alert("请填写电话信息");
		form1.telephone.focus();
		return false;
	}		
	return true;
}
</script>
<table width="98%" border="0" align="center" cellpadding="5">
	<tr  style="border-bottom:#0099CC 1px solid;">
		<td align="left"> <font color="#000000" face="黑体，宋体, Times New Roman, Arial" size="+1" ><strong>个人信息管理</strong></font></td>
		<td align="right"><img src="site_images/ras.gif" width="197" height="20" /></td>
	</tr>								
	<?php
	mysql_select_db($database_roche, $roche);
	$query = "Select * From user where username = '$username2' ";
	$result = mysql_query($query,$roche) or die(mysql_error()); 
	while($row = mysql_fetch_array($result)){
		$email = $row[email];
		$password_old = $row[password];
		$title = $row[title];
		$address = $row[address];
		$zipcode = $row[zipcode];
		$company = $row[company];
		$realname = $row[realname];
		$telephone = $row[telephone];
		$mobiltel = $row[mobiltel];
	?>
	<tr>
		<td bgcolor="#EAEAEA" width="100%"  colspan="2">
		<br />
		<form id="form1" name="form1" action="<?php echo $_SERVER['PHP_SELF'] ?>" onSubmit="javascript:return doCheck()"  method="post">
		<center><font color="darkred"><?php echo  $errmsg;?></font></center>
		<table width="100%" border="0">
            <tr>
                <td width="24%">原密码</td>
                <td width="76%">
					<input  name="password" type="password" size="40" maxlength="20" style="width:180px" />
                    如果不修改密码，请不要填写 。 
				</td>
            </tr>
            <tr>
                <td>新密码</td>
                <td><input type="password" name="password1" size="40" maxlength="20" style="width:180px"   /></td>
            </tr>
            <tr>
                <td>再次输入新密码</td>
                <td><input type="password" name="password2" size="40" maxlength="20" style="width:180px"  /></td>
            </tr>
			<tr>
                <td>真实姓名</td>
                <td><input type="text" name="realname" size="40" style="width:200px" value="<?php echo $realname; ?>"/></td>
            </tr>
            <tr>
                <td>邮箱</td>
                <td><input  name="email" type="text" size="40" value="<?php echo $email; ?>"/></td>
            </tr>
            <tr>
                <td>公司</td>
                <td><input type="text" name="company" size="40"  	value="<?php echo $company; ?>"/></td>
            </tr>
            <tr >
                <td   >地址</td>
                <td ><textarea  name="address" cols="42" rows="4"><?php echo $address; ?></textarea></td>
            </tr>
                                            <tr>
                                              <td>邮编</td>
                                              <td><input name="zipcode" type="text" id="zipcode" value="<?php echo $zipcode; ?>" style="width:200px" size="40"/></td>
                                            </tr>
                                            <tr>
                                              <td>电话</td>
                                              <td><input type="text" name="telephone"  value="<?php echo $telephone; ?>" size="40" style="width:200px"/></td>
                                            </tr>
											 <tr>
                                              <td>手机</td>
                                              <td><input name="mobiltel" type="text" id="mobiltel" value="<?php echo $mobiltel; ?>" style="width:200px" size="40"/></td>
                                            </tr>
        </table>
		<p><input type="submit" name="submit" value=" 提 交 " /></p>
		</form>	
		</td>
	</tr>
	<?php } ?>	
</table>
<?php 
require_once('smartyconfig.php'); 
$maincontent=ob_get_contents();
ob_get_clean();
$tpl->assign("maincontent",$maincontent);
$tpl->display('template_member.php');
?>
