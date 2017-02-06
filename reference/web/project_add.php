<?php require_once('Connections/roche.php'); ?>
<?php 
$type=$_GET['type'];
$role=$_SESSION['role'];
#echo "$role";
$creatername=$_SESSION['username'];
if ($_SESSION['role']<3  && $_SESSION['role']!=1){
echo "you are not the administrator,or your ip address is not allowed!";
exit;}
?>

<?php ob_start();?>

<?php
 require_once('sendmail.php'); 
function generate_password( $length = 8 ) 
{
    // 密码字符集，可任意添加你需要的字符
    $chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
    $password = '';
    for ( $i = 0; $i < $length; $i++ )
    {
        $password .= $chars[ mt_rand(0, strlen($chars) - 1) ];
    }
    return $password;
}

function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "")
{
	$theValue=str_replace('"',"",trim($theValue));
	$theValue=addslashes($theValue);
	switch ($theType)
	{
		case "text":
		$theValue=($theValue != "") ? "'" . $theValue . "'" : "NULL";

		break;

		case "long":
		case "int":
		$theValue=($theValue != "") ? intval($theValue) : "NULL";

		break;

		case "double":
		$theValue=($theValue != "") ? "'" . doubleval($theValue) . "'" : "NULL";

		break;

		case "date":
		$theValue=($theValue != "") ? "'" . $theValue . "'" : "NULL";

		break;

		case "defined":
		$theValue=($theValue != "") ? $theDefinedValue : $theNotDefinedValue;

		break;
	}
	return $theValue;
}
	
if (!empty($_POST['submit']))
{
	$name = $_POST["name"];
	$number = $_POST["number"];
    $number=trim($number);       
	$number=preg_replace("/[\s]/","",$number);
    $username = $_POST["username"];
	$type=$_POST['hide_type'];
	$danwei = $_POST["danwei"];
	$leibie = $_POST["leibie"];
	$lianxiren = $_POST["lianxiren"];
	$dizhi = $_POST["dizhi"];
	$email = $_POST["email"];
	$tel = $_POST["tel"];
	$chuanzhen = $_POST["chuanzhen"];
	$intro = $_POST["intro"];
	$date_j2 = $_POST["date_j2"];
	$date_end = $_POST["date_end"];
	$showtime=date("Y-m-d");
	$status=1;
	if($leibie==5 || $leibie==7){$status=0;}
	$usrsendmail=$_POST["usersendmail"];
	mysql_select_db($database_roche, $roche);
	
	$insertSQL = sprintf("INSERT INTO project (`name`,number,leibie,danwei,lianxiren,dizhi,email,tel,chuanzhen,username, date_end,intro,status,date,date_j2,creater ) VALUES (%s, %s, %d, %s, %s,%s,%s,%s,%s,%s,%s,%s,%d,%s,%s,%s)",
				GetSQLValueString($name, "text"), 
				GetSQLValueString($number, "text"), 
				GetSQLValueString($leibie, "int"), 
				GetSQLValueString($danwei, "text"), 
				GetSQLValueString($lianxiren, "text"),
				GetSQLValueString($dizhi, "text"),
				GetSQLValueString($email, "text"),
				GetSQLValueString($tel, "text"),
				GetSQLValueString($chuanzhen, "text"),
				GetSQLValueString($username, "text"), 
				GetSQLValueString($date_end, "text"), 
				GetSQLValueString($intro, "text"),
				GetSQLValueString($status, "int"),
				GetSQLValueString($showtime, "date"),
				GetSQLValueString($date_j2, "date"),
				GetSQLValueString($creatername, "text")); 
  		$Result1 = mysql_query($insertSQL, $roche) or die(mysql_error());
		 
    if($leibie>=0)
	{  
		if($leibie==0){ $dir="/home/snp/data/Projects/service/";}
		elseif($leibie==2){ $dir="/home/snp/data/Projects/product/";}
		elseif($leibie==1){$dir="/home/snp/data/Projects/research/";}
		elseif($leibie==3){$dir="/home/snp/data/Projects/Internal_Project/";}
		elseif($leibie==4){$dir="/home/snp/data/Projects/Long_Term/";}
		elseif($leibie==5){$dir="/home/snp/data/Projects/Common_Project/";} 
		elseif($leibie==6){$dir="/home/snp/data/Projects/Small_Projects/";} 	
		elseif($leibie==7){$dir="/home/snp/data/Projects/Scientific_Project/";} 	
	  
	    if(preg_match("/^(SZ[0-9]+A[A-Z]+)([0-9*]+)/", $number,$match))
		{  
			$path_a=$dir.$match[1]."_".$danwei."_".$lianxiren;
			$path_a_1=$path_a."/".$match[2];
			$pro_dir=$dir.$match[1]."*/".$match[2];
			if(file_exists($path_a))
			{
				if(!file_exists($path_a_1))  {mkdir($path_a_1, 0770);}
			}
			else 
			{ 
				mkdir ($path_a, 0775);
				mkdir ($path_a_1, 0770); 
			}
        }
        else
		{
            $path=$dir.$number."_".$name."_".$lianxiren;
            if(!file_exists($path)) {mkdir   ($path, 0770);}
            $pro_dir=$dir.$number."*";
        }
	   
		$sql_user = "select * from username where userid='$creatername' ";
		$result_user=mysql_query($sql_user);
		$row_user=@mysql_fetch_array($result_user);
		$jinzhan_username=$row_user[username2];
		system("setfacl -m u:$jinzhan_username:rwx $pro_dir");
		system("setfacl -m u:yufeng:rwx $pro_dir "); 
	}
		
	if($leibie>=0)
	{  
		$dir="/home/lch/httpd/web/service/download/";
		$path=$dir.$number;
		$oldumask=umask(0);
		if(preg_match("/^(SZ[0-9]+A[A-Z]+)([0-9]+.*)$/", $number,$match))
		{
			$path_a=$dir.$match[1];
			$path_a_1=$path_a."/".$match[2];
			if(file_exists($path_a))
			{
				if(file_exists($path_a_1));
				else {mkdir   ($path_a_1,   0775);}
			}
			else 
			{ 
				mkdir   ($path_a,   0775);
				mkdir   ($path_a_1,   0775); 
			}
		}
		else
		{
			if(file_exists($path));
			else{mkdir   ($path,   0775);}
		}	
		umask($oldumask); 
	}
		
	if($usrsendmail==1)
	{
		$userped=generate_password();
		$userped_md=md5($userped);
		$query = sprintf("INSERT INTO `user`(username,password,email,actnum,role,company,address,telephone,fax,receivemail,login_time) VALUES(%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
					GetSQLValueString($username, "text"),
					GetSQLValueString($userped_md, "text"),
					GetSQLValueString($email, "text"),
					GetSQLValueString("0", "text"),
					GetSQLValueString("0", "text"),
					GetSQLValueString($danwei, "text"),
					GetSQLValueString($dizhi,"text"),											 
					GetSQLValueString($tel, "text"),
					GetSQLValueString($chuanzhen, "text"),
					GetSQLValueString(1, "int"),
					GetSQLValueString($showtime, "date"));
		$result = mysql_query($query,$roche) or die(mysql_error()); 	
		send_mail("$email","您的项目：".$name."已建立","尊敬的".$lianxiren."老师\n您好！\n您在天昊生物(http://www.geneskies.com )的项目：".$name." 已经启动，项目编号为：".$number."。您可以通过您的用户名($username)和您的密码($userped), 密码为系统自动生成，请自己修改，登录后，到客户中心的订单查询中查看实时进展记录。\n\n请您在收到密码后尽快修改初始密码，如由于密码遗失发生的数据丢失，天昊不承担相应责任。如您的遗失或者忘记密码请尽快联系我们进行密码重置。\n\n该邮件为系统自动发送，请勿回复！\n天昊生物科技苏州有限公司 \n 地址： 江苏省苏州市苏州工业园区星湖街218号生物纳米园A2楼428单元\n 电话：0512-62956558  \n");
		send_mail("lch@geneskies.com","项目：".$number."已经建立","李才华：您好！\n项目：".$name." 已经启动，项目编号为：".$number."。用户名：".$username."密码：".$userped."。");
	}
	echo "<head>";
	echo "<meta http-equiv='Content-Type' content='text/html; charset=utf-8' />";
	echo "<meta http-equiv='refresh' content='3;url=project_add.php?type=$type'>";
	echo "</head>";
	echo "更新成功,3秒后自动跳转";
	exit ;
}

if(!empty($_POST['change']))
{
	$username=$_POST["username"];
	$name=$_POST["name"];
	$number=$_POST["number"];
	$type=$_POST['hide_type'];
	mysql_select_db($database_roche, $roche); 
	$result=mysql_query("select *  from project where username='$username' " );

	while($row=@mysql_fetch_array($result))
	{
		$danwei=$row[danwei];
		$lianxiren=$row[lianxiren];
		$dizhi=$row[dizhi];
		$email=$row[email];
		$tel=$row[tel];
		$chuanzhen=$row[chuanzhen];
	} 
} 

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8" name="keywords" content="生物技术,天昊生物,测序,snp,PCR" />
<title></title>
 

<style type="text/css">
<!--
.STYLE1 {color: #FF0000}
-->
</style>
</head>

<script language="javascript">
function doCheck()
{
if(!test_username(document.form1.number.value))
{
alert("项目编号不正确");
return false;
} 

   
         
	if (form1.name.value==""){
		alert("项目名称不可为空");
		form1.name.focus();
		return false;
	}
	if (form1.username.value==""){
		alert("用户名不可为空");
		form1.username.focus();
		return false;
	}
	
		if (form1.danwei.value==""){
		alert("用户单位不可为空");
		form1.danwei.focus();
		return false;
	}
	
		if (form1.lianxiren.value==""){
		alert("用户的联系人不可为空");
		form1.lianxiren.focus();
		return false;
	}
		if (form1.dizhi.value==""){
		alert("用户的联地址不可为空");
		form1.dizhi.focus();
		return false;
	}
			if (form1.tel.value==""){
		alert("用户电话不可为空");
		form1.tel.focus();
		return false;
	}
			if (form1.intro.value==""){
		alert("项目信息不可为空");
		form1.intro.focus();
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
	
return true;

function test_username(str_username)
{
var pattern = /[a-z0-9A-Z_]/;
if(pattern.test(str_username))
return true;
else
return false;
} 
}
</script>
<body   >

<table width="100%" border="0" align="center" bgcolor="#FFFFFF" height="400">
		<tr>
				<td valign="top"><table width="98%" border="0" align="center" cellpadding="5">
								<tr height="3">
										<td width="100"></td>
								</tr>
								<tr>
										<td colspan="2" ><table width="100%" border="0" style="border-bottom:#0099CC 1px solid;" align="center">
														<tr>
																<td align="left"><strong><font color="#000000" size="+1" face="黑体，宋体, Times New Roman, Arial"><br>
																  <?php if($type==2){echo "添加服务类项目";} else {echo "项目添加";}?>
																</font></strong></td>
																<td align="right"><img src="site_images/ras.gif" width="197" height="20" /></td>
														</tr>
												</table></td>
								</tr>

								<tr>
										<td align="left" bgcolor="#EAEAEA" width="100%">
										<br />
										<form  name="form1"   action="<?php echo $_SERVER['PHP_SELF'] ?>"  method="post">
										  <p>1、项目名称
										    <input  name="name"  value="<?php echo  $name ; ?>" type="text" size="40"/>
										 
										    <span class="STYLE1">*</span><br />
										    <br />
										   2、项目编号
										    <input  name="number"  value="<?php  echo "$number" ; ?>" type="text" size="20"/>
										    <span class="STYLE1">*</span><br /> <br />

										   3、项目用户
										    <input  name="username"  value="<?php if($username != ""){echo "$username";} ?>"type="text" size="20"   />
									        <label>
									        <span class="STYLE1">*</span>
											  <input type="hidden" name="hide_type" value="<?php echo "$type" ?>" />
									        <input type="submit" name="change" value="已有用户" />
									        </label>
										  (为用户网络登录名)</p>
										  <p>4、项目类别
										    <label>
										    <select name="leibie"   >
                                              <?php if($type==2) {?>
                                              <option value="4"  >长期合作服务项目</option>
											   <option value="3"    >内部项目补充测试</option>
                                              <?php 
												 }
												  elseif($type==4) {?>
                                              <option value="3" selected="selected"  >内部项目补充测试</option>
                                               <?php 
												 } 										 
												  elseif($type==3) {?>
                                              <option value="2" selected="selected"  >生产项目</option>
                                               <?php 
												 }
                                                 elseif($type==1) {?>
                                              <option value="1" selected="selected"  >研发项目</option>
					       <option value="7"    >科研合作服务项目</option>
                                              <?php } else{?>
											   
											   <option value="1"    >研发项目</option>
											     <option value="2"  >生产项目</option>
												  <option value="3"    >内部项目补充测试</option>
												  <option value="4"    >长期合作服务项目</option>
												  <option value="5"    >普通服务项目</option>
												  <option value="6"    >小型服务项目</option>
												  <option value="7" selected="selected"    >科研合作服务项目</option>
											   <?php }  ?>
                                            </select>
										    </label>
									        <span class="STYLE1">*</span>
							              </p>
										  <p>5、项目单位
										    <input  name="danwei" type="text" value="<?php if($danwei != ""){echo "$danwei";}  ?>" size="40"/>
									        <span class="STYLE1">*</span></p>
										  <p>6、联系人
										    <input  name="lianxiren" type="text" value="<?php if($lianxiren != ""){echo "$lianxiren";} ?>" size="20"/>
										    <span class="STYLE1">*</span></p>
										  <p>7、联系地址
										    <input  name="dizhi" type="text" value="<?php  if($dizhi != ""){echo "$dizhi";}  ?>" size="40"/>
									      <span class="STYLE1">*</span>									      </p>
										  <p>8、联系email
										    <input  name="email" type="text" value="<?php  if($email != ""){echo "$email";}  ?>"  size="40"/>
									        <span class="STYLE1">*</span></p>
										  <p>9、联系电话
										    <input  name="tel" type="text" value="<?php if($tel != ""){echo "$tel";} ?>"  size="40"/>
										    <span class="STYLE1">*</span></p>
										   <p>10、传真
										     <input  name="chuanzhen" type="text" value="<?php if($chuanzhen != ""){echo "$chuanzhen";}  ?>"  size="40"/>
										  </p>
										   <p>11、截止日期
										     <input  name="date_end" type="text" size="20"/>
									      格式：1984-09-06										   </p>
   <p>12、项目简介<br>
			    <textarea name="intro" cols="80" rows="8"></textarea>
			    <span class="STYLE1">*</span><br />
											 
			    <br>
			   </p>
           <p>
										    <label>
										    13、自动创建用户名：
										    <input type="checkbox" name="usersendmail" value="1" />
										    </label>
										    <span class="STYLE1">(勾上将会自动创建上面填写的项目用户名并将该用户名和自动生成的随机密码发送到用户联系人邮箱)</span><br>
										    打<span class="STYLE1">*</span>为必填项目</p>                                 								   

										  <p><input type="submit" name="submit" value=" 提 交 " onclick="javascript:return doCheck()"    /> </p>
										</form>								  </td>
								</tr>
								<tr>
										<td>&nbsp;</td>
								</tr>
						</table></td>
		</tr>
</table>
</body>
</html>
<?php require_once('smartyconfig.php'); 
 
 $html="template_admin_p.php"; 
$maincontent=ob_get_contents();
ob_get_clean();
$tpl->assign("maincontent",$maincontent);
$tpl->display($html);
?>
