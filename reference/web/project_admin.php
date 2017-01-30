<?php 
require_once("check_admin.php");
require_once('Connections/roche.php'); 
ob_start();
$role=$_SESSION['role'];
if ($_SESSION['role']<7){
echo "you are not the administrator,or your ip address is not allowed!";
echo "<meta http-equiv='refresh' content='0;url=index.php'>";
exit;}
?>
<?php 
$number = $_GET['id'];
$action = $_GET['action'];
$showtime=date("Y-m-d");
mysql_select_db($database_roche, $roche);
if($action=="run"){
	$query = "update project set status=1,date='$showtime' where number='$number'";
	$result = mysql_query($query,$roche) or die(mysql_error());
	echo "<Script language='JavaScript'> alert('该项目已经启动');</Script>";
}elseif($action=="finish"){
	$query = "update project set status=2,date_f='$showtime' where number='$number'";
	$result = mysql_query($query,$roche) or die(mysql_error());
	echo "<Script language='JavaScript'> alert('项目已经结束');</Script>";
}elseif($action=="over"){
	$query = "update project set status=3,date_j='$showtime'where number='$number'";
	$result = mysql_query($query,$roche) or die(mysql_error());
	echo "<Script language='JavaScript'> alert('项目已经结清');</Script>";
}
?>

<table width="98%" border="0" align="center" cellpadding="5">
	<tr style="border-bottom:#0099CC 1px solid;">
		<td align="left"> <font color="#000000" face="黑体，宋体, Times New Roman, Arial" size="+1" ><strong>正在进行的项目</strong></font></td>
		<td align="right"><img src="site_images/ras.gif" width="197" height="20" /></td>
	</tr>
	<tr>
		<td colspan="2" align="left" valign="top">
		<p>
		<?php 
			echo "<a href='project_add.php' target='_blank' class='bluelink' >添加一个新的项目</a>/";
			echo "<a target='_blank' class='bluelink' href='project_add.php?type=2'>添加一个产品订购</a>/";
			echo"<a target='_blank' class='bluelink' href='regist.php'>添加一个用户</a>"; 		
		?>
		</p>
		<table width="100%"  border="1" cellpadding='1' face="黑体，宋体, Times New Roman, Arial" style="font-size:15px;">
            <tr >
                <td width="15%" align="center"  >项目编号</td>
                <td width="15%" align="center">项目名称</td>
                <td width="15%" align="center" >项目开始时间</td>
                <td width="15%" align="center" >项目状态</td>
                <td width="15%" align="center" >进展记录</td>
                <td width="15%" align="center" >项目详情</td>
				<td width="15%" align="center" >项目安排</td>
            </tr>
        <?php
			mysql_select_db($database_roche, $roche); 
			include("pageft.php"); //包含“pageft.php”文件
			$page = $_GET['page'];
			//取得总信息数
			$result=mysql_query("select * from project where status<2 ");
			$total=@mysql_num_rows($result);
			//调用pageft()，每页显示10条信息（使用默认的20时，可以省略此参数），使用本页URL（默认，所以省略掉）。
			pageft($total,20);
			//现在产生的全局变量就派上用场了：
			$result=mysql_query("select *  from project where status<2 order by  number  limit $firstcount,$displaypg  ");
			while($row=@mysql_fetch_array($result)){
				$id=$row[id];
				$number=$row[number];
				$name=$row[name];
				$username=$row[username];
				$date=$row[date];
				$date_f=$row[date_f];
				$leibie=$row[leibie];
				$status=$row[status];
				$view=$row[view];
		?>
			<tr>
                <td align="right" ><?php 
					if($view<2){echo "<img src='./images/new3.gif'/>";}
					echo "<a target='_blank' class='bluelink' href='project_show_x.php?id=$id'>$number</a>" ;
				?>&nbsp;&nbsp;</td>
                <td align="center"><?php echo "$name"; ?></td>
                <td align="center"><?php echo $date ; ?></td>
                <td  align="center"><?php 
				if($leibie==0){
					if($status==0){echo "确认";    echo "<a href='project_manage.php?id=$number&action=run' target='_blank' class='bluelink' >(我要处理)</a>";}
					if($status==1){echo "处理中";  echo "<a href='project_manage.php?id=$number&action=finish' target='_blank' class='bluelink' >(我要发货)</a>";}
					if($status==2){echo "已发货";  echo "<a  href='project_manage.php?id=$number&action=over' target='_blank' class='bluelink'>(结清)</a>";}
					if($status==3){echo "结清";}
				}else {											  
					if($status==0){echo "确认"; echo "<a href='project_manage.php?id=$number&action=run' target='_blank' class='bluelink' >(我要启动)</a>";}
					if($status==1){echo "启动"; echo "<a href='project_manage.php?id=$number&action=finish' target='_blank' class='bluelink' >(项目已经完)</a>";}
					if($status==2){echo "完成"; echo "<a  href='project_manage.php?id=$number&action=over' target='_blank' class='bluelink'>(项目结清)</a>";}
					if($status==3){echo "结清";}
				}?>
				</td>
                <td align="center"><?php echo "<a href='project_jinzhan.php?id=$number' target='_blank' class='bluelink' >查看</a> ";?></td>
                <td align="center"><?php 
				if($role==6 ) {
					echo "<a href='project_show_x.php?id=$id ' target='_blank' class='bluelink'>查看和修改</a>";
				}elseif($role>6){
					echo "<a href='project_show_x.php?id=$id' target='_blank' class='bluelink'>查看</a>/";
					echo "<a href='project_change_x.php?id=$id' target='_blank' class='bluelink' >修改</a>";
				}?>
				</td>
				 <td  align="center"><?php echo "<a href='project_anpai.php?id=$number' target='_blank' class='bluelink'>安排</a>";?></td>
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