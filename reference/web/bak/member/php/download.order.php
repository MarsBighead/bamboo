<?php 
$random_code=$_SESSION['randcode'];
$code=$_POST[code];
// echo "code $code $random_code<br>";
if($code != $random_code){
	echo "<script>alert('验证码输入错误！')</script>";
	// echo "random_code  $random_code  code $code<br>";
	// echo "<meta http-equiv='refresh' content='0;url=history.back(-1);'>";
}else{
	$_SESSION['randcode']=$random_code;
	$pid=$_POST[pid];
	$uid=$_POST[uid];
	$name=$_POST[name];	
	$sql_check="Select * from project_download where pid='$pid'";
	// echo "check $sql_check<br>";
	$result_check=mysql_query($sql_check);	
	$flag=-1;
	// echo "flag $flag <br>";
	while($rows=mysql_fetch_array($result_check)){
		$flag=1;
		echo  "uid $rows[uid] $uid<br>";
		echo  "name $rows[name] $name<br>";
		if($rows[uid]!=$uid){
			echo "<script>alert('身份证号码输入错误！')</script>";
			echo  "uid $rows[uid] $pid<br>";
			// echo "<meta http-equiv='refresh' content='0;url=http://biotech.geneskies.com/diagnostics/member/'>";
		}
		if($rows[name]!=$name){
			echo "<script>alert('姓名输入错误！')</script>";
			echo  "name $rows[name] $name<br>";
			// echo "<meta http-equiv='refresh' content='0;url=http://biotech.geneskies.com/diagnostics/member/'>";
		}
		if($flag<0){		
			echo "<script>alert('合同号输入错误！')</script>";
			// echo "<meta http-equiv='refresh' content='0;url=history.back(-1);'>";
			// echo  "pid $rows[pid] $pid<br>";
		}
		
	}
	// echo "2 $flag<br>";	
}
$sql_load="Select * from project_download where pid='$pid'";
// echo "$sql_load <br>";
$result_load=mysql_query($sql_load);
$rows=mysql_fetch_array($result_load);
// echo "$rows[relative_dir] $rows[pid]<br>";
$dir= opendir($rows[relative_dir]);
while($flist=readdir($dir)){
	echo "文件 $flist <br>";
	if(preg_match("/\./",$flist)){	continue;}
	$file_url=$rows[relative_dir]."/$flist";
	// echo  "<a href='$file_url' target='_blank' style='color:blue;'>$flist<a><br>";
	if(is_file ($flist)){
		echo  "<a href='$file_url' target='_blank' style='color:blue;'>$flist<a>";
	}elseif(is_dir ($flist)){
		// print "dir <br>";
	}
}
?>