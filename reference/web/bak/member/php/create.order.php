<?php
//echo "项目管理界面 <br>";
$pid=$_POST[pid];
$uid=$_POST[uid];
$name=$_POST[name];
$state=$_POST[state];
if($state<2){
	$access=0;
}else{	
	$access=10;
}
$flag=$_GET[flag];
if(empty($_GET[flag])){	$flag=$_POST[flag];}
if(!empty($_POST[pid])){
	$dir_name="download_file/".$pid;	
	$dir=mkdir($dir_name,0777);
	if($dir){echo "<script>alert('Make dir $pid successful!')</script>";}else{
		$dir= opendir($dir_name);
		$n=0;
		while($flist=readdir($dir)){
			$n++;			
		}
		if($n>=2){  
			echo "<script>alert('Dir $pid has been made!')</script>";
		}else{
			echo "<script>alert('Make dir $pid failed!')</script>";
		}
	}
}
$input=$_POST[input];
include("include/func_ip.php");
$input_ip= getClientIP(); 
$date=date("Y-m-d H:m:s");
$id=$_GET[id];
//从数据库里面读取信息
mysql_select_db($database_roche);
if(!empty($_GET[id])){
	$sql_entry="select * from project_download where id='$id'";
	$result_entry = mysql_query($sql_entry);
	$rows_entry=mysql_fetch_array($result_entry);
	$pid=$rows_entry[pid];
	$uid=$rows_entry[uid];
	$name=$rows_entry[name];
	$state=$rows_entry[state];
}
if($input=="提交"){
	if($flag==1){
		$sql_insert="insert into project_download (pid,uid,name,state,relative_dir,access,date,input_ip) values ('$pid','$uid','$name','$state','$dir_name','$access','$date','$input_ip') ";
		//echo  "$sql_insert";
		mysql_query($sql_insert,$roche) or die(mysql_error()) ;
		$i=mysql_affected_rows();
		if($i>0){
			echo "<script>alert('项目信息添加成功！')</script>";
			echo "<meta http-equiv='refresh' content='0;url=manager_order.php'>";
		}else{
			echo "<script>alert('项目信息添加失败！')</script>";
		}
	}elseif($flag==2){
		$sql_update="update project_download set uid='$uid',name='$name',state='$state',relative_dir='$dir_name',access='$access',date='$date',input_ip='$input_ip' where su_pid='$input_ip'";
		mysql_query($sql_update,$roche) or die(mysql_error()) ;	
	}
}
?>
<table style='width:100%' border="1">
<tr>
	<td colspan='3' style="border-bottom:#0099CC 1px solid;"><strong>修改订单信息</strong></td>
</tr>
<form method="post" action="create_order.php">
<tr style="height:30px;">
	<td>订单号</td><td><input name="pid"  value="<?php echo $pid;?>"  id="pid" onBlur="check(2)"/></td><td></td>
</tr>
<tr style="height:30px;">
	<td>身份证号</td><td><input name="uid"  value="<?php echo $uid;?>"  id="uid" onBlur="check(2)"/></td><td></td>
</tr>
<tr style="height:30px;">
	<td>客户姓名</td><td><input name="name"  value="<?php echo $name;?>"  id="name" onBlur="check(2)"/></td><td></td>
</tr>
<tr style="height:30px;">
	<td>项目状态</td>
	<td>
		<select name="state">
			<option value="1" <?php if($state=='1'){?> selected="selected"<?php }?>)>项目已创建</option>
			<option value="2" <?php if($state=='2'){?> selected="selected"<?php }?>)>报告已上传</option>		
			<option value="3" <?php if($state=='3'){?> selected="selected"<?php }?>)>开放下载</option>
		</select>
	</td>
	<td>
	</td>
</tr>
<tr style="height:30px;">
<td align="center" colspan='3'>
	<input name="flag"  value="<?php if(empty($flag)){ echo "1";} else{echo $flag;}?>"  type='hidden' id="name" onBlur="check(2)"/>
	<input type="submit" name="input" style="height:24px;width:48px" value="提交"/>
	<!--	<input type="submit" name="input" style="height:24px;width:48px" value="修改"/>-->
	<input type="button" name="return" style="height:24px;width:48px;" value="返回" align="middle" onClick="javascript:window.location.href='manager_order.php'">
</td>
</td>
</form>
</table>