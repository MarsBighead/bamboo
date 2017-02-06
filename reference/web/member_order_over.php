<?php require_once('Connections/roche.php'); 
ob_start();
session_start(); 
if (empty($_SESSION['username'])){
	$_SESSION['loginerr']="您访问的页面需要先登录";
	header("location:loginerr.php");
	exit;
}
// $username='011';
?>
<table width="98%" border="0" align="center" cellpadding="5">
    <tr  style="border-bottom:#0099CC 1px solid;">
		<td align="left"> <font color="#000000" face="黑体，宋体, Times New Roman, Arial" size="+1" ><strong>我的已完成项目</strong></font></td>
		<td align="right"><img src="site_images/ras.gif" width="197" height="20" /></td>
	</tr>           
    <tr>
        <td valign="top" align="left"  width="100%" colspan="2">
		<br>
		<table   width="100%"border="1" cellpadding='1' face="黑体，宋体, Times New Roman, Arial" style="font-size:15px;" >
			<tr>
			    <td width="15%"  align="center">日期</td>
			    <td width="15%"  align="center">订单编号</td>
				<td width="20%"  align="center">订单名称</td>
				<td width="15%"  align="center">完成时间</td>	 
				<td width="15%"  align="center">详细内容</td>
			</tr>			   
			<?php
				mysql_select_db($database_roche, $roche);
				$query=sprintf("select * from project where status='2' and username = '%s' order by date desc", $_SESSION['username']);
				// echo "$query";
				$result = mysql_query($query,$roche) or die(mysql_error()); 
				while($row = mysql_fetch_array($result)){
					$id =$row[id];
					$username =$row[username];
					$number =$row[number];
					$name = $row[name];
					$date =$row[date];
					$status =$row[status];
					$date_f =$row[date_f];
					$title =$row[title];
				?>			   
			<tr>
				<td align="center" ><?php echo $date ; ?></td>
				<td align="center" ><?php echo $number ; ?></td>
				<td align="center" ><?php echo $name ; ?></td>
				<td align="center" ><?php echo (!empty($date_f))?$date_f:"&nbsp; " ; ?></td>	 
				<td align="center"><?php echo "<a href='order_detail.php?id=$id' target='_blank' >查看</a> "?></td>
			</tr>   	  
			<?php } ?>		  
		</table>	  
	    <p class="STYLE14" >注：1、完成时间，若为试剂的购买，以发货为准，若为科研服务，已项目结清时间为准。</p>
		</td>
    </tr>
</table>
<?php 
require_once('smartyconfig.php'); 
$maincontent=ob_get_contents();
ob_get_clean();
$tpl->assign("maincontent",$maincontent);
$tpl->display('template_member.php');
?>