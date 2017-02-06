<?php 
require_once("check_admin.php"); 
require_once('Connections/roche.php'); 
ob_start();
$role=$_SESSION['role'];
if ($_SESSION['role']<5){
	echo "you are not the administrator,or your ip address is not allowed!";
	echo "<meta http-equiv='refresh' content='0;url=index.php'>";
	exit;
}
$username = $_GET['username'];
$paixu=$_GET['paixu'];
if($paixu==""){$paixu=date;}
 ?>
<table width="98%" border="0" align="center" cellpadding="5">
	<tr style="border-bottom:#0099CC 1px solid;">
		<td align="left"> <font color="#000000" face="黑体，宋体, Times New Roman, Arial" size="+1" ><strong></strong></font></td>
		<td align="right"><img src="site_images/ras.gif" width="197" height="20" /></td>										
	</tr>
	<tr>
		<td colspan="2" align="left" valign="top"><p></p>
		<p><strong>用户<?php echo "$username";?>参与过的项目：</strong></p>							 
		<table width="100%" border="1" cellpadding='1' face="黑体，宋体, Times New Roman, Arial" style="font-size:15px;">
            <tr >
                <td width="15%" align="center" style=""><a href="./project_user_do.php?username=<?php echo "$username";?>&paixu=number">项目编号</a></td>
                <td width="12%" align="center" style="">项目名称</td>
				<td width="25%" align="center" style="">项目安排</td>
                <td width="34%" align="center" style=""> 进展记录 </td>
                 <td width="14%" align="center" style=""><a href="./project_user_do.php?username=<?php echo "$username";?>&paixu=date">日期</a></td>
            </tr>
            <?php
			mysql_select_db($database_roche, $roche); 
			include("pageft.php"); //包含“pageft.php”文件
			$page = $_GET['page'];
			//取得总信息数			 
			$result=mysql_query("select project.id,project.number,project.name,project_user.jinzhan,project_user.doing from project left join       	project_user on project.number=project_user.pro_id where project_user.username='$username'   group by   project.id    ");	 
			$total=@mysql_num_rows($result);
			//调用pageft()，每页显示10条信息（使用默认的20时，可以省略此参数），使用本页URL（默认，所以省略掉）。
			pageft($total,20);
			//现在产生的全局变量就派上用场了：
			$result=mysql_query("select project.id,project.number,project.name,group_concat(project_user.jinzhan),project_user.doing,project_user.date from project_user left join    project on project.number=project_user.pro_id where project_user.username='$username'   group by   project.id order by project.$paixu desc limit $firstcount,$displaypg   ");
			while($row=@mysql_fetch_array($result)){
				$pro_id=$row[id];
				$number=$row[number];
				$name=$row[name];
				$jinzhan=$row['group_concat(project_user.jinzhan)'];
				$date=$row[date];
				$doing=$row[doing];
			?>
            <tr>
                <td align="right" style=""><?php echo "<a href='project_show_x.php?id=$pro_id'  target='_blank' class='bluelink'>$number</a>" ; ?>&nbsp;&nbsp;</td>
                <td  align="left" style=""><?php echo "$name";  ?></td>
                <td  align="left" style=""><?php echo "$doing"; ?>&nbsp; </td>
				<td  align="left" style=""><?php echo "$jinzhan"; ?>&nbsp;</td>
                <td  align="left" style=""><?php echo "$date" ; ?></td>
            </tr>
            <?php } ?>
        </table>
		</td>
	</tr>
	<tr>
		<td><?php echo $pagenav; ?></td>
		<td width="118">&nbsp;</td>
	</tr>
</table>

<?php 
require_once('smartyconfig.php'); 
$maincontent=ob_get_contents();
ob_get_clean();
$tpl->assign("maincontent",$maincontent);
$tpl->display('template_admin_p.php');
?>