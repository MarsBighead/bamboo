<?php
$flag=$_GET[flag];
$id=$_GET[id];

mysql_select_db($database_roche);
if(!empty($_GET[flag]) and $flag==-1){
	$sql_del="delete from project_download where id='$id'";
	// echo  "$sql_del <br>";
	if($role>50){
		mysql_query($sql_del,$roche) or die(mysql_error()) ;
		$i=mysql_affected_rows();
		if($i>0){
			echo "<script>alert('删除成功');</script>";
			echo "<meta http-equiv='refresh' content='0;url=check_order.php'>";
		}else{
			echo "<script>alert('删除失败');</script>";
			echo "<meta http-equiv='refresh' content='0;url=check_order.php'>";
		}
	}
}
$sql_show="select * from project_download order by date desc";
$result_show = mysql_query($sql_show);

?>
<span style="float:right">
		<a href='create_order.php?flag=1' target='_blank' style="color:red;">添加项目</a>
</span>
<table cellspacing="1px" style="background-color:#808080;width:100%;font-size:14px;color:#333333;"  >

<tr style="background-color:#FFFFFF;font-weight:bold;" >
	<td align="center"  width="80" >订单号</td>
	<td align="center"  width="80">客户姓名</td>
	<td align="center"  width="120">身份证号</td>
	<td align="center"  width="120;">报告文件</td>
	<td align="center"  width="60">进展</td>
	<td align="center"  width="120">项目管理</td>
</tr>
<?php 
while($rows=mysql_fetch_array($result_show)){
?>
<tr style="background-color:#FFFFFF;">
	<td align="center"><?php  echo $rows[pid]; ?></td>
	<td align="center"><?php  echo $rows[name]; ?></td>
	<td align="center"><?php  echo $rows[uid]; ?></td>
	<td align="center" >
	<?php
		$dir= opendir($rows[relative_dir]);
		// echo "$rows[relative_dir] <br>";
		$n=0;
		while($flist=readdir($dir)){
			// echo  "File $flist <br>";
			if(preg_match("/^\./",$flist)){	continue;
			}else{
				if($n>0){echo "<br>";}
				if($rows[state]>2 or $role>3){ echo "<a href='$rows[relative_dir]/$flist' target='_blank' style='color:blue;'>";}
				echo "$flist";
				if($rows[state]>2 or $role>3){ echo "</a>";}
				$n++;
			}
			
		}
		if($n==0){echo "报告整理中";}
		
	?>
	</td>
	<td align="center"><?php 
	if($rows[state]==1){
		echo "项目已创建";
	}elseif($rows[state]==2){
		echo "报告已上传";
	}elseif($rows[state]==3){
		echo "项目已结清";
	}
	?>
	</td>
	<td align="center"><?php 
		echo "<a href='create_order.php?id=$rows[id]&flag=1' target='_blank'>修改</a>    ";
		echo "<a href='check_order.php?id=$rows[id]&flag=-1'>删除</a>    ";
		echo "<a href='create_order.php?pid=$rows[pid]&flag=2'>上传文件</a>";
	?>
	</td>
</tr>
<?php } ?>
</table>