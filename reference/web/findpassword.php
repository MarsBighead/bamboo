<?php 
require_once('Connections/roche.php'); 
ob_start();
session_start();
// $lifeTime = 24 * 3600; 
// session_set_cookie_params($lifeTime); 
// session_start(3600);
//初始化基本参数
mysql_select_db($database_roche, $roche);

if(isset($_GET[confirmation])){
	$confirmation=$_GET[confirmation];
	$confirmation=base64_decode($confirmation);
	$array=explode("+",$confirmation);
	$email=$array[0];
	$token=$array[1];
	$token_username=$array[2];
	$check=base64_encode($email);
	//查询账号信息
	$sql_check="select * from user where email='$email'";
	$result= mysql_query($sql_check,$roche);
	$row = mysql_fetch_array($result);
}
$now=date("d-m-Y H:i");
$passtime=date("d-m-Y H:i",strtotime("$token+24 hours"));

// session_register("email");  //保存用户E-mail
// $_SESSION['email']=$email;
// session_register("username");  //保存用户名
// $_SESSION['username']=$token_username;

//POST信息
$submit=$_POST[Submit];
if(isset($submit)){	
	// $email=$_SESSION['email'];
	$username=$_SESSION['username'];
	$email=$_POST[check];
	$email=base64_decode($email);
	$password2=$_POST[password2];
	$password=$_POST[password];
	//Reset Password
	if(strcmp($password,$password2)==0 and !empty($password)){
		$password=md5($password);
		$sql_password="update user set password='$password',lastlogin='$now' where email='$email'";
		mysql_query($sql_password,$roche) or die(mysql_error());
		$sql_check="select * from user where email='$email'";
		$result= mysql_query($sql_check,$roche)  or die(mysql_error());
		$row = mysql_fetch_array($result);
		if(strcmp($password,$row[password])==0){
			$find=1;
		}else{
			$find=0;
			// echo "<meta http-equiv='refresh' content='0;url=find.php?username=$row[username]&find=0'>";
		}
	}else{
		$sql_password="update user set lastlogin='$now' where email='$email'";
		mysql_query($sql_password,$roche) or die(mysql_error());
		$find=0;
		
	}
}

?>