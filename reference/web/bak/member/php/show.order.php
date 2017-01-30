<?php
//echo "个人用户下载界面<br>";
$random_code=$_SESSION['randcode'];
$code=$_POST[code];
if($code != $random_code){
	echo "<script>alert('验证码输入错误')</script>";
	echo "random_code  $random_code  code $code<br>";
	// echo "<meta http-equiv='refresh' content='0;url=http://biotech.geneskies.com/diagnostics/member/'>";
}else{
$pid=$_POST[pid];
$uid=$_POST[uid];
$name=$_POST[name];
$code=$_POST[code];



if(!empty($_POST[input])){
	if($code == $random_code){
		$sql_check="Select * from suzhou_project where pid='$pid'";
		$result_check=mysql_query($sql_check);
		while($rows=mysql_fetch_array($result_show)){
			if($rows[personid]==$personid and $rows[name]==$name ){
			   echo "<script>alert('验证通过')</script>";
			   $name=urlencode($name);
			   echo "<meta http-equiv='refresh' content='0;url=check_order.php?id=$rows[id]&si_pid=$su_pid&personid=$personid&name=$name'>";
			}
		}
	}else{
		echo "<script>alert('验证码输入有误!')</script>";
	}
	}
}

?>
<table style='width:100%;' border="1">
<form method="post" action="check_order.php">
<tr>
	<td>订单号</td><td><input name="su_pid"  value="<?php echo $su_pid;?>"  id="su_pid" onBlur="check(2)"/></td><td></td>
</tr>
<tr>
	<td>身份证号</td><td><input name="personid"  value="<?php echo $personid;?>"  id="personid" onBlur="check(2)"/></td><td></td>
</tr>
<tr>
	<td>姓名</td><td><input name="name"  value="<?php echo $name;?>"  id="name" onBlur="check(2)"/></td><td></td>
</tr>
<tr>
	<td>验证码</td><td><input name="code"  value="<?php echo $code;?>"  id="code" onBlur="check(2)" /></td>
	<td style="height:24px;" valign='center'>
		<img src="code.php" style="position:relative;bottom:-5px;height:22px;">
	</td>
</tr>
<tr>
<td></td>
<td><input type="submit" name="input" style="height:24px;width:48px" value="提交"/></td><td></td>
</td>
</form>
</table>