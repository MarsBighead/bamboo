<?php require_once('Connections/roche.php'); ?>
<?PHP
//定义一些变量
date_default_timezone_set('Asia/Shanghai');
$incorrectLogin = "密码不正确";
$underAttackReLogin = "该帐号可能受到攻击，继续输入错误将锁定帐号";
$underAttackPleaseWait = "该帐号已被锁定，于请半小时后再试";
$accountNotActivated = "该帐号尚未激活";


// 获取用户的登录信息
$username1 = $_POST["username"];
$password1 = $_POST["password"];
$rememberMe = $_POST["rememberMe"];

// 判断是否用户选择了保存密码
if ($rememberMe == "rememberMe"){
	$rememberMe = "1";
}else{
	$rememberMe = "0";
}

//判断登陆后返回路径
switch($_GET['redirect']){
	case "/roche/register.php";
		//$_GET['redirect']=="/roche/index.php";
		break;
	default:
		//echo $_GET['redirect'];exit;

}

//检查用户名是否存在
mysql_select_db($database_roche, $roche);
$query = "Select * from  user where username='$username1'";
$result = mysql_query($query,$roche) or die(mysql_error()); 
if ($row = mysql_fetch_array($result)){ 
	// 检查该用户账号是否已经激活
	if ($row["actnum"] == "0"){
		//检查账号是否被锁定
		if ($row["numloginfail"] <= 5){  //如果登录失败大于5次，则自动锁定
			//检查密码是否正确
			if ($row["password"] == md5($password1)){
				//最后登录时间
				$datetime = date("d-m-Y G:i ");
				//修改记录
				$query = "UPDATE  user Set lastlogin = '$datetime' where username='$username1'";  
				$result = mysql_query($query,$roche) or die(mysql_error()); 
				// 清空登录失败记录，设置为0
				$query = "UPDATE  user Set numloginfail = '0' where username='$username1'";  
				$result = mysql_query($query,$roche) or die(mysql_error()); 
				// tell we want to work with sessions
				session_start();// 启动会话

				$redirect=$_SESSION['redirect'];
				session_unset();//删除会话
				
				session_destroy();
				$lifeTime = 24 * 3600; 
				session_set_cookie_params($lifeTime); 
				 
				session_start(3600);
 				
				session_register("redirect");	
				$_SESSION['redirect']=$redirect;			
				
				session_register("role");  //创建会话变量，保存角色
				$_SESSION["role"] = $row['role'];

				session_register("userid");  //保存用户id
				$_SESSION["userid"] = $row['userid'];
				
				session_register("username");  //保存用户名
				$_SESSION["username"] = $row['username'];

				session_register("useremail");  //保存用户email
				$_SESSION["useremail"] = $row['email'];
												
				// 发送cookie到客户端，密码被加密
				if($rememberMe=="1"){
					setcookie("rememberCookieUname",$username1,(time()+604800));
					setcookie("rememberCookiePassword",md5($password1),(time()+604800));
				}
				// go to the secured page.
				if($row['role']>0  ){
					//header("Location: $_SESSION[redirect]");				
					header("Location: project_user.php");
				}
				else{header("Location: member_order.php");}
				 
			}
			else{
				// 密码错误，登录失败
				// 改变当前时间的格式
				$datetime = date("d")*10000000000 + date("m")*100000000 + date("Y")*10000 + date("G")*100 + date("i");
				//检查上一次登录失败时间是否为5分钟内
				if ($row["lastloginfail"] >= ($datetime-5)){
					// 如果是，则将登录失败次数增加1
					$query = "UPDATE  user Set numloginfail = numloginfail + 1 where username='$username1'";  
					$result = mysql_query($query,$roche) or die(mysql_error()); 
					//修改登录失败时间
					$query = "UPDATE  user Set lastloginfail = '$datetime' where username='$username1'";  
					$result = mysql_query($query,$roche) or die(mysql_error()); 
				}
				else{
					// 如果5分钟之内，则只修改登录失败的时间
					$query = "UPDATE  user Set lastloginfail = '$datetime' where username='$username1'";  
					$result = mysql_query($query,$roche) or die(mysql_error()); 
				}
		// 输出登录错误信息
		makeform($incorrectLogin);}
		}
		// 如果登录失败5次，表示有人试图猜别人的密码
		// 因此需要检查时间，如果最后一次登录失败到现在间隔超过半个小时，则自动解锁
		// 然后需要重新等一次
		else {
			$datetime = date("d")*10000000000 + date("m")*100000000 + date("Y")*10000 + date("G")*100 + date("i");
			if ($row["lastloginfail"] <= ($datetime-30)){
				// 如果在半个小时之前，则修改5，表示解锁
				$query = "UPDATE  user Set numloginfail = '5' where username='$username1'";  
				$result = mysql_query($query,$roche) or die(mysql_error()); 
				//显示表单让用户重新登录
				makeform($underAttackReLogin, "$username1");
			}
			else{
			// 如果在30分钟之内，则仍然被锁定
				makeform($underAttackPleaseWait);
			}
		}
	}
	//如果账号没有被激活
	else{
		makeform($accountNotActivated);
	}
}
// 如果用户名不存在
else{
	// 检查用户是否输入用户名
	if ($username1 == ""){	
		makeform("请输入用户名");  //重新显示登录表单
	}
	else {  //如果输入了，则提示用户名输入错误
		makeform("不存在",$username1);
	}
}

//显示登录表单的函数
// ....m($errormessage="", ... indicates an optionale argument for this function, same for $username.
function makeform($errormessage="", $username2 = ""){
	session_register("loginerr");
	session_register("redirect");	
	$_SESSION['loginerr']=$username2.$errormessage;
	$_SESSION['redirect']=$_GET[redirect];
	header("location:loginfault.php");
}
?>
