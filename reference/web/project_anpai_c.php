<?php
require_once('Connections/roche.php'); 
if ($_SESSION['role']<2){
	echo "you are not the administrator,or your ip address is not allowed!";
	echo "<meta http-equiv='refresh' content='0;url=loginerr.php'>";
	exit;
}
ob_start();
$id = $_GET['id'];
mysql_select_db($database_roche, $roche);
include('id2name.php');
?>
 
<table width="98%" border="0" align="center" cellpadding="5">
	<tr style="border-bottom:#0099CC 1px solid;" >
		<td align="left">
			<strong><font color="#000000" size="+1" face="黑体，宋体, Times New Roman, Arial">安排项目</font></strong>
		</td>
		<td align="right"><img src="site_images/ras.gif" width="197" height="20" /></td>										
	</tr>
	<tr>
		<td height="74" align="left"  colspan="2" bgcolor="#EAEAEA">
		<p>该项目已的安排情况：</p>
		<p>项目编号 <?php echo "$id"; ?> </p>  
        <?php
			$j=1;
			
			$query = "select *  from project_user where pro_id = '$id'";
			$result = mysql_query($query,$roche) or die(mysql_error()); 
			while($row = mysql_fetch_array($result)){
				$pro_id = $row[pro_id];
				$username = $row[username];
				$doing = $row[doing];
				$work = $row[work];
				$jinzhan = $row[jinzhan];
				$date = $row[date];
				if($doing !=""){
		?>
			<p> <?php echo $j; ?>、人&nbsp;&nbsp;&nbsp;&nbsp;员&nbsp;：<?php if(isset($array_id2name{$row[username]})){echo $array_id2name{$row[username]};}else{echo $row[username];} ?> 
			<p>&nbsp;&nbsp;&nbsp;&nbsp;工&nbsp;作&nbsp;量&nbsp;： <?php echo  $work;  ?> <p>
			<p>&nbsp;&nbsp;&nbsp;&nbsp;工作内容： <?php echo str_replace("\n","<br>",$doing);  ?> <p>											
		<?php 
			$j++; 
			}
		}
		?>	
		</p>   								      
		</td>
	</tr>
</table>
<?php 
	require_once('smartyconfig.php');  
	$html="template_admin_p.php"; 
	$maincontent=ob_get_contents();
	ob_get_clean();
	$tpl->assign("maincontent",$maincontent);
	$tpl->display($html);
?>
