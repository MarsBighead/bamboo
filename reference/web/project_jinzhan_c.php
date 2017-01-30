<?php require_once('Connections/roche.php'); ?>
<?php 
if ($_SESSION['role']<2){
echo "you are not the administrator,or your ip address is not allowed!";
exit;}
?>

<?php ob_start();?>
<?php $id = $_GET['id'];?>
<?php 
if (!empty($_POST['submit'])){
	$id = $_POST["id"];
	$number=$_POST["pid"];
	$jinzhan = $_POST["jinzhan"];
	$date = $_POST["date"];
	mysql_select_db($database_roche, $roche);
	$query = "update `project_user` set jinzhan = '$jinzhan',date = '$date' where pid = '$id'";
	$result = mysql_query($query,$roche) or die(mysql_error()); 
	$query11 = "update `project` set view =view+1  where number = '$number'";
	$result11 = mysql_query($query11,$roche) or die(mysql_error()); 
	echo "<head>";
	echo "<meta http-equiv='Content-Type' content='text/html; charset=utf-8' />";
	echo "<meta http-equiv='refresh' content='3;url=project_jinzhan.php?id=".$number."'>";
	echo "</head>";
	echo "更新成功,3秒后自动跳转";
	exit ;
	}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" name="keywords" content="生物技术,天昊生物,测序,snp,PCR" />
<title></title>
 
<style type="text/css">
<!--
.STYLE113 {color: #0000FF}
-->
</style>
</head>
<body onLoad="initEditor();">
<table width="100%" border="0" align="center" bgcolor="#FFFFFF" height="400">
		<tr>
				<td valign="top"><table width="98%" border="0" align="center" cellpadding="5">
								<tr height="3">
										<td width="100"></td>
								</tr>
								<tr>
										<td colspan="2" ><table width="100%" border="0" style="border-bottom:#0099CC 1px solid;" align="center">
														<tr>
																<td align="left"><strong><font color="#000000" size="+1" face="黑体，宋体, Times New Roman, Arial"><br>
																项目进展管理</font></strong></td>
																<td align="right"><img src="site_images/ras.gif" width="197" height="20" /></td>
														</tr>
												</table></td>
								</tr>
								
<?php
mysql_select_db($database_roche, $roche);
$query = "select *  from project_user where pid = $id ";
$result = mysql_query($query,$roche) or die(mysql_error()); 
while($row = mysql_fetch_array($result)){
$pro_id = $row[pro_id];
$username = $row[username];
$doing = $row[doing];
$jinzhan = $row[jinzhan];
$date = $row[date];
 
?>

								<tr>
										<td align="left" bgcolor="#EAEAEA" width="100%">
										<br />
										<form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post">
										  <p>1、项目编号
										    <input  name="id" value="<?php echo $id ?>" type="hidden" size="40"/>
											<input  name="pid" value="<?php echo $pro_id ?>" type="hidden" size="40"/>
										    <?php echo $pro_id ?> 
										    <br />
										    <br />
										   2、人员
										    <?php echo $username ?> 
										    <br /> <br />
										    
										   3、工作内容<span class="STYLE113">
									       <?php  echo str_replace("\n","<br>",$doing);  ?>
									      </span>										  </p>
										  <p>
										    <label></label>
										    4、进展详细<br>
										    <textarea name="jinzhan"     cols="80" rows="5"><?php echo  str_replace("\n","<br>",$jinzhan);?></textarea>
										     					 
									        </p>
										  <p>5、时 间<input type="text" name="date" value="<?php echo "$date";?>" /> <br /><br />
									        <input type="submit" name="submit" value=" 提 交 " /> 
									      </p>
										</form>									  </td>
								</tr>
<?php 
}
?>	
								<tr>
										<td>&nbsp;</td>
								</tr>
						</table></td>
		</tr>
</table>
</body>
</html>
<?php require_once('smartyconfig.php'); 
if($role<6){
$html="template_admin_p.php";}
else{$html="template_admin_p.php";}
$maincontent=ob_get_contents();
ob_get_clean();
$tpl->assign("maincontent",$maincontent);
$tpl->display($html);
?>
