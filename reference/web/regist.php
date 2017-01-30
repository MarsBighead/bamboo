<?php
require_once('Connections/roche.php'); 
require_once('smartyconfig.php'); 
require_once("checkNumber.php");
require_once("sendmail.php");
ob_start();
if ($_SESSION['role']<1){
	echo "you are not the administrator,or your ip address is not allowed!";
	echo "<meta http-equiv='refresh' content='0;url=index.php'>";
	exit;
}
$emailvalidate=0;
//print_r($_POST);
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

if (!empty($_POST['submit'])){
	// 获取用户的注册信息
	$username1 = $_POST["username"];
	$password1 = md5($_POST["password1"]);
	$email1 = $_POST["email"];

	if (1){//检查验证码
		mysql_select_db($database_roche, $roche);
		$query = "Select * from `user` where username='$username1'";
		$result = mysql_query($query,$roche) or die(mysql_error()); 
		if ($row = mysql_fetch_array($result)){ 
			$errmsg="该用户已存在";
		}else{
			if($emailvalidate==1){
				$chars_for_actnum = array ("A", "B", "C", "D", "E", "F", "G", "H", "I", "J", "K", "L", "M", "N", "O", "P", "Q", "R", "S", "T", "U", "V", "W", "X", "Y", "Z","a", "b", "c", "d", "e", "f", "g", "h", "i", "j", "k", "l", "m", "n", "o", "p", "q", "r", "s", "t", "u", "v", "w", "x", "y", "z","1","2","3","4","5","6","7","8","9","0");
				// take 20 times (1 to 20) an random char and add it to the $actnum variable
				for ($i = 1; $i <= 20; $i++) {
					$actnum = $actnum . $chars_for_actnum[mt_rand (0, count ($chars_for_actnum)-1)];
				}
				send_mail("$_POST[email]","您已成功在www.geneskybiotech.com注册","您已成功注册帐号$_POST[username]<br><a href='http://www.ras-biosino.com/research/activate.php?username=".urlencode($_POST[username])."&actnum=$actnum' >点击这里激活</a>");				
			}else{
					$actnum=0;
			}		
			//$query = "INSERT INTO `user`(username,password,email,actnum,role,company,address,title,realname,zipcode,telephone,fax,receivemail) VALUES('$username1','$password1','$email1','$actnum','user','$_POST[company]','$_POST[address]','$_POST[title]','$_POST[realname]','$_POST[zipcode]','$_POST[telephone]','$_POST[fax]',$_POST[receivemail])";
			if($_POST['receivemail']!=1) $_POST['receivemail']=0;
			$login_time = date("Y-m-d");
			$query = sprintf("INSERT INTO `user`(username,password,email,actnum,role,company,department,address,title,realname,city,zipcode,telephone,mobiltel,fax,receivemail,login_time) VALUES(%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s,%s,%s,%s,%s)",
            GetSQLValueString($username1, "text"),
			GetSQLValueString($password1, "text"),
            GetSQLValueString($email1, "text"),
            GetSQLValueString("0", "text"),
            GetSQLValueString("0", "text"),
            GetSQLValueString($_POST['company'], "text"),
            GetSQLValueString($_POST['department'], "text"),
			GetSQLValueString($_POST['address'],"text"),											 
            GetSQLValueString($_POST['title'],"text"),
            GetSQLValueString($_POST['realname'], "text"),
			GetSQLValueString($_POST['city'], "text"), 
            GetSQLValueString($_POST['zipcode'], "text"),
            GetSQLValueString($_POST['telephone'], "text"),
			GetSQLValueString($_POST['mobiltel'], "text"),
			GetSQLValueString($_POST['fax'], "text"),
			GetSQLValueString(1, "int"),
			GetSQLValueString($login_time, "date"));
			//echo $query;
			$result = mysql_query($query,$roche) or die(mysql_error()); 
			if ($result){
				echo "<font color=darkred>{$username1}已成功注册,请记住您的用户名和密码!<br><br><br><br><br><br><br></font>";				
				//插入兴趣
				if (!empty($_POST['interest'])){
					foreach($_POST['interest'] as $interest){
						$query = sprintf("INSERT INTO interest(userid,interest) VALUES(%s, %s)",
						$lastuserid,
						GetSQLValueString($interest, "text"));	
						mysql_query($query,$roche) or die(mysql_error());								 
					}				
				}	
				?>
				<script>
					window.setTimeout("jump()",500);
					function jump(){
						window.location="regist.php";
					}
				</script>
	<?php	}
		}
	}else{
		$errmsg="验证码不正确";
	}
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
	if (form1.password1.value.length>20 || form1.password1.value.length<4){
		alert("密码长度应为4~20位");
		form1.password1.focus();
		form1.password1.select();
		return false;
	}	
	if (form1.password1.value==""){
		alert("密码不可为空");
		form1.password1.focus();
		return false;
	}		
 	
 
	if (form1.number.value==""){
		alert("验证码不可为空");
		form1.number.focus();
		return false;
	}
	 			
	 		
	return true;
}
</script>
<br />
<form id="form1" name="form1" method="post" action="<?php echo $_SERVER['PHP_SELF'] ?>" onSubmit="javascript:return doCheck()">
		<center>
				<font color="darkred"><?php echo  $errmsg;?></font>
		</center>
		<table width="95%"  cellpadding="0" cellspacing="0" class="innertable" align="center">
				<tr>
						<th colspan="2" align="left"> 用户注册
								&nbsp;&nbsp;<font size="-2">&nbsp;&nbsp;(带<font color="#FF6666" size="+1" >*</font>为必填项)</font>
&nbsp;&nbsp;</th>
				</tr>
				<tr >
						<td width="20%" align="left" nowrap="nowrap">用户名:<font color="red" size="+1" >*</font></td>
						<td width="80%" align="left">
								<input type="text" name="username" size="20" style="width:180px"/>
								<input type="button" onClick="checkusername()" value="检测用户名" />
								<script>
									function checkusername(){
										if (form1.username.value=="") {
											alert("请填写用户名");
											form1.username.focus();
											return false;
										}
										showModalDialog('checkusername.php?username='+form1.username.value,'newwindow','dialogwidth:200px;dialogHeight:120px;dialogLeft:700px;dialogTop:400px;center:yes;help:yes;resizable:no;status:yes');
									}
								</script>						</td>
				</tr>
				<tr >
						<td align="left" nowrap="nowrap">密码:<font color="red" size="+1" >*</font></td>
						<td align="left">
								<input type="password" name="password1" size="40" maxlength="20" style="width:180px"/>
								<font color="#A9A9A9" size="-2">&nbsp;&nbsp;8~20位</font> </td>
				</tr>
				<tr >
						<td align="left" nowrap="nowrap">重复密码:<font color="red" size="+1" >*</font></td>
						<td align="left">
								<input type="password" name="password2" size="40" maxlength="20" style="width:180px"/>						</td>
				</tr>
			 
				<tr>
				  <td align="left" nowrap="nowrap">email:<font color="red" size="+1" >*</font></td>
				  <td align="left"><input type="text" name="email" size="20" style="width:180px"/></td>
		  </tr>
				<tr>
						<td align="left" nowrap="nowrap">验证码:<font color="red" size="+1" >*</font></td>
						<td align="left">
								<input type="text" name="number" maxlength=4 size="4">
								&nbsp;&nbsp;<img src=checkNumber.php?act=init></td>
				</tr>
		</table>
		<p>
		<input type="submit" value="注册" name="submit"/>
		</p>
</form>
<?php 
$maincontent=ob_get_contents();
ob_get_clean();
$tpl->assign("maincontent",$maincontent);
$tpl->display('template_main.php');
?>
