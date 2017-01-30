<?php  
require_once('Connections/roche.php');
if ($_SESSION['role']<2){
	echo "you are not the administrator,or your ip address is not allowed!";
	echo "<meta http-equiv='refresh' content='0;url=loginerr.php'>";
	exit;
}
ob_start();
?>
<?php 
$id = $_GET['id'];
if (!empty($_POST['submit'])){
	$id = $_POST["id"];
	$number=$_POST["pid"];
	$doing=$_POST["doing"];
	$shuliang = $_POST["shuliang"];
	$doing=trim($doing);
	$date = $_POST["date"];
	mysql_select_db($database_roche, $roche);
	$query = "update `project_report` set doing='$doing',num = '$shuliang',date = '$date' where pid = '$id'";
	$result = mysql_query($query,$roche) or die(mysql_error()); 	  
	echo "<head>";
	echo "<meta http-equiv='Content-Type' content='text/html; charset=utf-8' />";
	echo "<meta http-equiv='refresh' content='3;url=project_report.php?id=".$number."'>";
	echo "</head>";
	echo "更新成功,3秒后自动跳转";
	exit ;
}
?>

<style type="text/css">
<!--
.STYLE113 {color: #0000FF}
-->
</style>
<table width="98%" border="0" align="center" cellpadding="5">
	<tr style="border-bottom:#0099CC 1px solid;">
		<td align="left">
		<strong><font color="#000000" size="+1" face="黑体，宋体, Times New Roman, Arial">项目报告更改 </font></strong>
		</td>
		<td align="right"><img src="site_images/ras.gif" width="197" height="20" /></td>
	</tr>								
	<?php
	mysql_select_db($database_roche, $roche);
	$query = "select *  from project_report where pid = $id ";
	$result = mysql_query($query,$roche) or die(mysql_error()); 
	while($row = mysql_fetch_array($result)){
		$pro_id = $row[pro_id];
		$username = $row[username];
		$doing = $row[doing];
		$shuliang = $row[num];
		$date = $row[date]; 
	?>
	<tr>
		<td align="left" bgcolor="#EAEAEA" colspan="2" width="100%">
		<br />
		<form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post">
		<p>	1、项目编号
			<input  name="id" value="<?php echo $id ?>" type="hidden" size="40"/>
			<input  name="pid" value="<?php echo $pro_id ?>" type="hidden" size="40"/>
			<?php echo $pro_id ?> 
			<br />
			<br />
			2、人员 <?php echo $username ?>  <br /> <br />
			3、报告内容 
			<input name="doing" type="text" value="<?php echo  $doing;?>" size="20" />
		</p>
		<p>	4、数量：<input name="shuliang" type="text" value="<?php echo  $shuliang;?>" size="20" /> </p>
		<p>	5、时 间<input type="text" name="date" value="<?php echo "$date";?>" /> <br /><br />
			<input type="submit" name="submit" value=" 提 交 " /> 
		</p>
		</form>	
		</td>
	</tr>
	<?php }?>	

</table>
<?php 
require_once('smartyconfig.php'); 
if($role<6){
	$html="template_admin_p.php";}
else{
	$html="template_admin_p.php";}
$maincontent=ob_get_contents();
ob_get_clean();
$tpl->assign("maincontent",$maincontent);
$tpl->display($html);
?>
