<?php
//echo "项目管理界面 <br>";
include("include/func_ip.php");
$input_ip= getClientIP(); 
$date=date("Y-m-d H:m:s");
$pid=$_GET[pid];



//从数据库里面读取信息
mysql_select_db($database_roche);
if(!empty($_GET[pid])){
	$sql_entry="select * from project_download where pid='$pid'";
	$result_entry = mysql_query($sql_entry);
	$rows_entry=mysql_fetch_array($result_entry);
	$uid=$rows_entry[uid];
	$name=$rows_entry[name];
	$state=$rows_entry[state];
	$dir=$rows_entry[relative_dir];
}

//文件删除
$del=$_GET[del];
$file=$_GET[file];
$file_dir=$dir."/$file";
if($del==1){
	//文件权限
	$access=fileperms($file_dir);
	//PHP	删除文件
	unlink($file_dir);
	if(file_exists($file_dir)){
		echo "<script>alert('Remove file $file failed!')</script>";
		echo "<meta http-equiv='refresh' content='1;url=create_order.php?pid=$pid&flag=2'>";
	}else{
		echo "<script>alert('Remove file $file successful!')</script>";
		echo "<meta http-equiv='refresh' content='1;url=create_order.php?pid=$pid&flag=2'>";
	}
}
if(empty($dir)){$dir=$_POST[dir];}
if(empty($_GET[pid])){	$pid=$_POST[pid];}
$submit=$_POST[submit];


if ($_FILES["file"]["error"] > 0)
  {
  // echo  "Error <br>";
  echo "Error: " . $_FILES["file"]["error"] . "<br />";
  }
else
  { 
  // echo "Type: " . $_FILES["file"]["type"] . "<br />";
  // echo "Stored in: " . $_FILES["file"]["tmp_name"];
   if (file_exists("$dir/" . $_FILES["file"]["name"]))
    {
		if(isset($submit)){
			echo "已存在文件 ".$_FILES["file"]["name"]."<br>";
			echo "<meta http-equiv='refresh' content='1;url=create_order.php?pid=$pid&flag=2'>";
		}
    }
    else
    {
		echo "上传文件名称: " . $_FILES["file"]["name"] . "<br />";
	    echo "上传文件大小: " . ($_FILES["file"]["size"] / 1024) . " Kb<br />";
		move_uploaded_file($_FILES["file"]["tmp_name"],"$dir/" . $_FILES["file"]["name"]);
		chmod($_FILES["file"]["tmp_name"],"$dir/" . $_FILES["file"]["name"],0755);
		echo "<script>alert('文件上传成功！')</script>";
    }
  }
?>
<table style="font-size:15px;margin-bottom:10px;border:0px;;" width="100%;">
	<tr height="30" style="border:none;"><td > <?php echo $pid; ?> 项目报告管理</td><tr>
	<tr><td >
		<table   style="border:1px solid black;" width="100%">
			<tr height="30" style="border:1px solid black;">
				<td width="120" align="center" style="border:1px solid black;" >报告名称</td>
				<td width="60"  align="center" style="border:1px solid black;">报告状态</td>
				<td width="120"  align="center" style="border:1px solid black;">报告管理</td>
			<tr>
		<?php 
			$array_file= opendir($dir);
			while($file=readdir($array_file)){
				if(preg_match("/^\./",$file)){	continue;}
		?>
			<tr height="30" style="border:1px solid black;">
				<td  align="center" style="border:1px solid black;"><?php echo $file; ?></td>
				<td  align="center" style="border:1px solid black;"> 已上传</td>
				<td  align="center" style="border:1px solid black;">
				<?php 
					echo "<a href='$dir/$file' style='color:blue;'  download='$file'>下载</a>    ";
					// echo "<a href='create_order.php?id=$rows[id]&flag=2&file=$file' target='_blank'>重命名</a>    ";
					echo "<a href='create_order.php?pid=$pid&file=$file&flag=2&del=1'>删除</a>";				
				?>
				</td>
			<tr>
		<?php
			} 
		?>
		</table>
	</td>
	<tr>
</table>
<form action="create_order.php" method="post" enctype="multipart/form-data">
<input name="pid"  value="<?php echo $pid;?>"  id="pid" type="hidden"/>
<input name="flag"  value="<?php echo $flag;?>"  id="flag" type="hidden"/>
<input name="dir"  value="<?php echo $dir;?>"  id="dir" type="hidden"/>
	<label for="file" style="font-size:14px;color:blue;">上传文件:</label>
	<input type="file" name="file" id="file" /> 
	
	<input type="submit" name="submit" value="上传"  style="hight:25px;width:50px;"/>
	<input type="reset" name="submit" value="重置" style="hight:25px;width:50px;"/>
	<input type="button" name="submit" value="返回" onClick="javascript:window.location.href='manager_order.php?flag=1'" style="hight:25px;width:50px;"/>
</form>