<?php 
require_once("check_admin.php");
require_once('Connections/roche.php'); 
ob_start();?>
<table width="98%" border="0" align="center" cellpadding="5">
	<tr  style="border-bottom:#0099CC 1px solid;">
		<td align="left"> <font color="#000000" face="黑体，宋体, Times New Roman, Arial" size="+1" ><strong>我的项目管理</strong></font></td>
		<td align="right"><img src="site_images/ras.gif" width="197" height="20" /></td>
	</tr>
	<tr>
		<td width="100%" colspan="2" style="text-indent:4ex;">
			<table width="100%" border="1" cellpadding='1' face="黑体，宋体, Times New Roman, Arial" style="font-size:15px;">
				<tr >
					<td width="15%" align="center">项目编号</td>
					<td width="15%" align="center">项目名称</td>
					<td width="15%" align="center">项目类别</td>
					<td width="15%" align="center">项目开始时间</td>
					<td width="15%" align="center">项目状态</td>
					<td width="15%" align="center">查看进展</td>
					<td width="15%" align="center">查看详情</td>
				</tr>
				<?php
				mysql_select_db($database_roche, $roche); 
				include("pageft.php"); //包含“pageft.php”文件
				$page = $_GET['page'];
				//取得总信息数
				$result=mysql_query("select * from project where status<3");
				$total=@mysql_num_rows($result);
				//调用pageft()，每页显示10条信息（使用默认的20时，可以省略此参数），使用本页URL（默认，所以省略掉）。
				pageft($total,10);
				//现在产生的全局变量就派上用场了：
				$result=mysql_query("select *  from project where status<3 limit $firstcount,$displaypg ");
				while($row=@mysql_fetch_array($result)){
					$id=$row[id];
					$number=$row[number];
					$name=$row[name];
					$username=$row[username];
					$date=$row[date];
					$date_f=$row[date_f];
					$leibie=$row[leibie];
					$status=$row[status];
				?>
				<tr>
					<td align="center"><?php echo $number ; ?></td>
					<td align="center"><?php echo "<a target='_blank' class='bluelink' href='project_change.php?id=$id'>$name</a>";  ?></td> 
					<td align="center">
					<?php 
						if($leibie==4){echo "普通订单小项目";}
						if($leibie==3){echo "普通合同项目";}
						if($leibie==2){echo "长期合作持续性重复项目";}
						if($leibie==1){echo "长期合作非持续性项目";}
						if($leibie==0){echo "试剂购买";}
					?>
					</td>
					<td  align="center"><?php echo $date ; ?></td>
					<td  align="center"><?php 
					if($status==0){echo "确认";}
					if($status==1){echo "启动";}
					if($status==2){echo "完成";}
					if($status==3){echo "结清";} 
					?></td>
					<td  align="center"><?php echo "<a target='_blank' class='bluelink' href='project_jinzhan.php?id=$number'>查看</a>";  ?></td>
					<td  align="center"><?php echo "<a target='_blank' class='bluelink' href='project_show_x.php?id=$id'>查看</a>/<a target='_blank' class='bluelink' href='project_change.php?id=$id'>修改</a>";  ?></td>
				</tr>
				<?php } ?>
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