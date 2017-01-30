<?php 
require_once('Connections/roche.php'); 
if ($_SESSION['role']<1){
	echo "you are not the administrator,or your ip address is not allowed!";
	echo "<meta http-equiv='refresh' content='0;url=loginerr.php'>";
	exit;
}
ob_start();
?>
<?php 
	$number = $_GET['id'];
	$action= $_GET['action'];
	$worker=$_SESSION['username'];
	$role=$_SESSION["role"];
	if($action=="del"){
		$pid= $_GET['pid'];
		mysql_select_db($database_roche, $roche);
		$query111 =  sprintf( "delete from project_user where pid='$pid'");
		$result11 = mysql_query($query111,$roche) or die(mysql_error());
		echo "<Script language='JavaScript'> alert('已删除');</Script>";
		echo "<head>";
		echo "<meta http-equiv='Content-Type' content='text/html; charset=utf-8' />";
		echo "<meta http-equiv='refresh' content='3;url=project_anpai.php?id=".$number."'>";
		echo "</head>";
		exit ;
	}
?>
<style type="text/css">
.biankuang {border-top: black 1px solid; border-bottom:black 1px solid; font-weight: bold;font-size:18px;}
</style>
<table width="98%" border="0" align="center" cellpadding="5">
	<tr style="border-bottom:#0099CC 1px solid;">
		<td align="left">
			<strong><font color="#000000" size="+1" face="黑体，宋体, Times New Roman, Arial">项目进展管理,项目编号：
			<?php echo "$number\t<a target='_blank' class='bluelink' href='project_jinzhan_a.php?id=$number'>添加记录</a>"; ?>
			</font></strong>
		</td>
		<td align="right"><img src="site_images/ras.gif" width="197" height="20" />
		</td>
	</tr>
	<tr style="border-bottom:#000000 2px solid;">
		<td align="left" colspan="2"   width="100%">
		<table width="100%" border="0"  cellspacing=0 >
            <tr style="border-bottom:#000000 2px solid;">
				<td width="17%" height="40" align="center" ><span style="font-weight: bold;font-size:18px;">日期</span> </td>
				<td width="17%" align="center" ><span style="font-weight: bold;font-size:18px;">员工</span></td>
				<td width="48%" align="center" ><span style="font-weight: bold;font-size:18px;">详情</span></td>
				<td width="18%" align="center" ><span style="font-weight: bold;font-size:18px;">修改</span></td>
			</tr>										  
			<?php
			mysql_select_db($database_roche, $roche);
			$result=mysql_query("select *  from project_user where pro_id='$number' and jinzhan<>'' order by  date");
			while($row=@mysql_fetch_array($result)){
				$username = $row[username];
				$doing = $row[doing];
				$jinzhan = $row[jinzhan];
				$date = $row[date];
				$p_id = $row[pid];
				$result2=mysql_query("select *  from username where  userid='$username' ");
				$row2=@mysql_fetch_array($result2);
				$username2=$row2[username];
			?>
			<tr style="border-bottom:#888088 1px solid;" >
                <td height="37" align="center" ><?php echo $date ?></td>
                <td align="center" ><?php echo "<a target='_blank' class='bluelink' href='project_user_do.php?username=$username'>$username2</a>"; ?></td>
                <td align="left">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo  str_replace("\n","<br>",$jinzhan);  ?></td>
                <td align="center">
				<?php 
				if($worker==$username  || $role==4){
					echo "<a target='_blank' class='bluelink' href='project_jinzhan_c.php?id=$p_id'>修改</a>/ <a target='_blank' class='bluelink' href='project_jinzhan.php?pid=$p_id&action=del'>删除</a>"; }
				else{echo "你不能修改";}?>
				</td>
            </tr>
			<?php } ?>
        </table>
		<br />
		</td>
	</tr >	
</table>
<?php require_once('smartyconfig.php'); 
if($role<6){
$html="template_admin_p.php";}
else{$html="template_admin_p.php";}
$maincontent=ob_get_contents();
ob_get_clean();
$tpl->assign("maincontent",$maincontent);
$tpl->display($html);
?>
