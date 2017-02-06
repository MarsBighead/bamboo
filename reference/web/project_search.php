<?php
	require_once('Connections/roche.php');
	if (empty($_SESSION['username'])){
		// echo "u 1<br>";
		$_SESSION['loginerr']="您访问的页面需要先登录";
		header("location:index.php");		
		exit;
	}
	if($_SESSION['role']==0){
		// echo "r 0<br>";
		echo "<script>history.go(-1);</script>";
	}
	ob_start();
?> 
<table width="98%" border="0" align="center" cellpadding="5">
	<tr  style="border-bottom:#0099CC 1px solid;">
		<td align="left">订单查询</td>
		<td align="right"><img src="site_images/ras.gif" width="197" height="20" /></td>
	</tr>
	<tr>
		<td width="100%" colspan="2"  >
		<strong>项目查询</strong>
		<table   width="94%" border="1"  cellpadding='1'>
            <tr >
                <td width="158"  align="center"  > 项目编号 </td>
                <td width="294"  align="center"  >开始时间</td>
                <td width="271"  align="center"   >项目状态</td>
                 <td width="210"  align="center" >查看详细</td>
            </tr>
			<?php
			$jj=1; 
			if (!empty($_REQUEST['searchitem'])) {	$_REQUEST['searchitem']=trim($_REQUEST['searchitem']);}
			mysql_select_db($database_roche, $roche); 
			include("pageft.php"); //包含“pageft.php”文件
			$page = $_GET['page'];
			//取得总信息数
			$result=mysql_query("select * from project where number like '%$_REQUEST[searchitem]%' or name LIKE  '%$_REQUEST[searchitem]%' ");
			$total=@mysql_num_rows($result);
			//调用pageft()，每页显示10条信息（使用默认的20时，可以省略此参数），使用本页URL（默认，所以省略掉）。
			pageft($total,10);
			//现在产生的全局变量就派上用场了：
			$result=mysql_query("select * from project  where number like '%$_REQUEST[searchitem]%' or name LIKE  '%$_REQUEST[searchitem]%' limit $firstcount,$displaypg ");
			while($row=@mysql_fetch_array($result)){
				$id=$row[id];
				$number=$row[number];
				$date=$row[date];
				$detail=$row[detail];
				$leibie=$row[leibie]; 
				$status=$row[status]; 
			?> 							  
            <tr>
                <td  align="center" ><?php echo "$number"; ?></td>
                <td   align="center"  ><?php echo "$date"; ?></td>
                <td  align="center"  >
				<?php 
				if($status==0){echo "确认";}
				if($status==1){echo "启动";}
				if($status==2){echo "完成";} 
				?>
				</td>
                <td  align="center"  >
					<?php echo "<a href='order_detail.php?id=$id'>查看</a> "?>
				</td>
            </tr>
			<?php }	?>
		</table>
		</td>
	</tr>
	<tr>
		<td><?php echo $pagenav; ?></td>
		<td>&nbsp;</td>
	</tr>
</table>

<?php 
	require_once('smartyconfig.php'); 
	$maincontent=ob_get_contents();
	ob_get_clean();
	$tpl->assign("maincontent",$maincontent);
	$tpl->display('template_admin_p.php');
?>