<?php
require_once('Connections/roche.php'); 
require_once('sendmail.php'); 
ob_start();
session_start(); 
//设定秘钥条件
$token=date("d-m-Y H:i");
$email=$_POST[email];
mysql_select_db($database_roche, $roche);
$sql_check="select * from user where email='$email'";
$result= mysql_query($sql_check,$roche) or die(mysql_error());
$row = mysql_fetch_array($result);
if(empty($email)){
	// echo "No email不存在该邮箱注册的账号,请重填写!";
	echo "<meta http-equiv='refresh' content='0;url=forget.php'>";
}else{
	$subject="重设".$row[username]."在天昊医药的密码";
	if(isset($row[lastlogin])){
		$sql_token="update user set lastlogin='$token' where email='$email'";
		mysql_query($sql_token,$roche) or die(mysql_error());
		$confirmation=$email."+".$token."+".$row[username];
		$confirmation=base64_encode($confirmation);
		$find_url="http://diagnostics.geneskies.com:8001/find.php?confirmation=$confirmation";
		$body="亲爱的".$row[username]."：\n\n你的密码重设要求已经得到验证。请点击以下链接(链接将在24小时后过期，链接使用一次后失效)输入你新的密码\n\n(pleae click on the following link to reset your password:)\n\n".$find_url."\n\n如果你的E-mail程序不支持链接点击，请将上面的地址拷贝至你的浏览器(例如IE)的地址栏进入天昊。\n\n感谢对天昊的支持，再次希望你在天昊的体验有益和愉快。\n\n天昊 http://www.geneskies.com/\n\n(这是一封自动产生的E-mail，请勿回复。)";
		send_mail($email,$subject,$body);
		// echo "Mail Sent.";
		echo "<meta http-equiv='refresh' content='0;url=forget.php?email=$email'>";
	}else{
		echo "不存在该邮箱注册的账号,请重填写!";
		echo "<meta http-equiv='refresh' content='0;url=forget.php'>";
	}
}
?>