<?php
header("Pragma:no-cache\r\n");
header("Cache-Control:no-cache\r\n");
header("Expires:0\r\n");
header("Content-Type: text/html; charset=utf-8");
 
 require_once("http://diagnostics.geneskies.com:8001/Connections/roche.php");
    require_once("http://diagnostics.geneskies.com:8001/smartyconfig.php");
   ob_start();
	   session_start();
	   $role=$_SESSION['role'];
if( empty($_SESSION['username']) ){ ?>
		<div style="width:250px; float:left;" id="_userboxform">
			<form name='loginForm' id="loginForm" method='POST' action='http://diagnostics.geneskies.com:8001/login.php?redirect=/loginerr.php'>
			<span>用户名：</span><input tabindex="1"  type="text" name="username" style="width:50px;"/>
			<span>密码：</span><input tabindex="2" type="password" name="password" style="width:50px;"/>
			<input type="image" src="/templets/default_diagnostics/img/login.png" />
			</form>
		</div>
	<?php  	  
		    }
else{

?>
  <div align="right"> 欢迎你，<a href="http://diagnostics.geneskies.com:8001/index.php" class="userName"><?php echo $_SESSION['username'] ?></a> <a href="http://diagnostics.geneskies.com:8001/logoff.php">[
退出]</a> 
  </div>
  <?php } ?>
