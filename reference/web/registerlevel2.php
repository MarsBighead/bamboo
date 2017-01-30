<?php require_once('Connections/roche.php'); ?>
<?php require_once('smartyconfig.php'); ?>
<?php require_once("checkNumber.php");?>
<?php require_once("sendmail.php");?>
<?php ob_start()?>
<?php

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

	if (!empty($_POST['submit'])){//检查验证码
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
			}
			else{
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
                       GetSQLValueString("1", "text"),
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
											 GetSQLValueString($_POST['receivemail'], "int"),
											 GetSQLValueString($login_time, "date"));
			//echo $query;
			$result = mysql_query($query,$roche) or die(mysql_error()); 
			if ($result){
				echo "<font color=darkred>{$username1}已成功注册,请记住您的用户名和密码，
				
				请登陆<br><br><br><br><br><br><br></font>";
				session_start();// 启动会话

				$redirect=$_SESSION['redirect'];
				session_unset();//删除会话
				
				session_destroy();

				session_start();

				session_register("redirect");	
				$_SESSION['redirect']=$redirect;			
				
				session_register("role");  //创建会话变量，保存角色
				$_SESSION["role"] = 2 ;

				 
				
				session_register("username");  //保存用户名
				$_SESSION["username"] = $username1;

				session_register("useremail");  //保存用户email
				$_SESSION["useremail"] = $email1;
				
				$lastuserid=mysql_insert_id();
				
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
					window.setTimeout("jump()",100);
					function jump(){
						window.location="index.php";
					}
				</script>
				<?php													 				
			}
			
					
		
		}
	}else{
		$errmsg="验证码不正确";
	}
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" name="keywords" content="生物技术,天昊生物,测序,snp,PCR" />
<title>无标题文档</title>
</head>
<body>
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
	if (form1.number.value==""){
		alert("验证码不可为空");
		form1.number.focus();
		return false;
	}
	if (form1.telephone.value==""){
		alert("telephone不可为空");
		form1.telephone.focus();
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
								</script>
						</td>
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
								<input type="password" name="password2" size="40" maxlength="20" style="width:180px"/>
						</td>
				</tr>
				<tr>
						<td align="left" nowrap="nowrap">Email:<font color="red" size="+1" >*</font></td>
						<td align="left">
								<input type="text" name="email" size="40" style="width:180px"/>
								<font color="#A9A9A9" size="-2">&nbsp;用于激活和重置密码，请认真填写</font> </td>
				</tr>
				<tr>
						<td align="left" nowrap="nowrap">验证码:<font color="red" size="+1" >*</font></td>
						<td align="left">
								<input type="text" name="number" maxlength=4 size="4">
								&nbsp;&nbsp;<img src=checkNumber.php?act=init></td>
				</tr>
				<tr>
						<td align="left" nowrap="nowrap">电话:<font color="red" size="+1" >*</font></td>
						<td align="left">
								<input type="text" name="telephone" size="40" style="width:200px"/>
								<font color="#A9A9A9" size="-2">区号,电话号码及分机号请详细填写</font>
						</td>
				</tr>
				<tr>
						<td align="left" nowrap="nowrap">称呼:</td>
						<td align="left">
								<select name="title">
										<option value="Mr./Ms.">Mr./Ms.</option>
										<option value="Mr.">Mr.</option>
										<option value="Mrs.">Mrs.</option>
										<option value="Ms.">Ms.</option>
										<option value="Miss">Miss</option>
										<option value="Dr">Dr</option>
										<option value="Professor">Professor</option>
								</select>
						</td>
				</tr>
				<tr>
						<td align="left" nowrap="nowrap">真实姓名:</td>
						<td align="left">
								<input type="text" name="realname" size="40" style="width:200px"/>
						</td>
				</tr>
				<tr>
						<td align="left" nowrap="nowrap">单位:</td>
						<td align="left">
								<input type="text" name="company" size="40" >
						</td>
				</tr>
				<tr>
						<td align="left" nowrap="nowrap">部门:</td>
						<td align="left">
								<input name="department" type="text"  size="40">
						</td>
				</tr>
				<tr>
						<td align="left" nowrap="nowrap">
								<p>联系地址:</p>
						</td>
						<td align="left"><table cellpadding="0px">
						<tr>
						<td style="border:none">
								<textarea name="address" cols="42" rows="4"></textarea>
								</td>
								<td valign="top" style="border:none">
								<font color="#A9A9A9" size="-2">请准确填写地址及邮编以便及时收取礼品,样品及资料</font></td>
								</tr>
								</table>
						</td>
				</tr>
				<tr>
						<td align="left" nowrap="nowrap">邮编:</td>
						<td align="left">
								<input name="zipcode" type="text" id="zipcode" style="width:200px" size="40"/>
						</td>
				</tr>
				<tr>
						<td align="left" nowrap="nowrap">城市:</td>
						<td align="left">
								<input name="city" type="text" id="city" style="width:200px" size="40"/>
						</td>
				</tr>
				
				<tr>
						<td align="left" nowrap="nowrap">手机:</td>
						<td align="left">
								<input name="mobiltel" type="text" id="mobiltel" style="width:200px" size="40"/>
						</td>
				</tr>
				<tr>
						<td align="left" nowrap="nowrap">传真:</td>
						<td align="left">
								<input name="fax" type="text" id="fax" style="width:200px" size="40"/>
						</td>
				</tr>
				<tr>
						<td align="left" nowrap="nowrap">感兴趣的技术服务:</td>
						<td align="left">
								<input type="checkbox" name="interest[]" value="DNA/RNA抽提与定量" />DNA/RNA抽提与定量
								<br />
								<input type="checkbox" name="interest[]" value="全基因组DNA扩增" />
								全基因组DNA扩增 <br />
								<input type="checkbox" name="interest[]" value="疾病－基因相关分析 (Case-Control Study)" />疾病－基因相关分析 (Case-Control Study)
								<br />
								<input type="checkbox" name="interest[]" value="基因突变检测" />
								基因突变检测<br />
								<input type="checkbox" name="interest[]" value="基因表达定量" />
								基因表达定量<br />
								<input type="checkbox" name="interest[]" value="疾病基因定位克隆(Pedigree Analysis)" />
								疾病基因定位克隆(Pedigree Analysis)<br />
								<input type="checkbox" name="interest[]" value="基因拷贝数多态分析(CNV)" />
								基因拷贝数多态分析(CNV)<br />
								<input type="checkbox" name="interest[]" value="DNA甲基化分析 (Epigenetics)" />
								DNA甲基化分析 (Epigenetics)<br />
								<input type="checkbox" name="interest[]" value="核酸分离纯化" />
								核酸分离纯化<br />
								<input type="checkbox" name="interest[]" value="功能SNP位点定位（rSNP Mapping）" />
								功能SNP位点定位（rSNP Mapping）<br />
								<input type="checkbox" name="interest[]" value="全基因组表达谱分析(Expression Profiling)" />
								全基因组表达谱分析(Expression Profiling)<br />
								<input type="checkbox" name="interest[]" value="全基因组相关分析（WGA）" />
								全基因组相关分析（WGA）<br />
								<input type="checkbox" name="interest[]" value="高通量单分子测序" />
								高通量单分子测序<br />
								<input type="checkbox" name="interest[]" value="染色体变异分析(核型分析/FISH)" />
								染色体变异分析(核型分析/FISH)<br />
								<input type="checkbox" name="interest[]" value="比较基因组杂交（CGH）" />
								比较基因组杂交（CGH）<br />
								<input type="checkbox" name="interest[]" value="目的片断克隆" />
								目的片断克隆<br />
								<input type="checkbox" name="interest[]" value="目的蛋白表达" />
								目的蛋白表达<br />
								<input type="checkbox" name="interest[]" value="蛋白表达定量（Western Blot）" />
								蛋白表达定量（Western Blot）
								</td>
				</tr>
				<tr>
						<td colspan="2" align="left" nowrap="nowrap"> *我们也将通过邮件发布最新的产品、技术和市场活动信息，及注册用户的特惠活动信息。 <br />
								<input type="checkbox" name="receivemail" value="1" checked="checked" />
								我愿意接受上海天昊生物科技服务 </td>
				</tr>
		</table>
		<p>
		<input type="submit" value="注册" name="submit"/>
		</p>
</form>
</body>
</html>
<?php 
$maincontent=ob_get_contents();
ob_get_clean();
$tpl->assign("maincontent",$maincontent);
$tpl->display('template_product.php');
?>
