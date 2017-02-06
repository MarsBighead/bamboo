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
	$query111 =  sprintf( "delete from project_report where pid='$pid'");
	$result11 = mysql_query($query111,$roche) or die(mysql_error());
    echo "<Script language='JavaScript'> alert('已删除');</Script>";
	echo "<head>";
	echo "<meta http-equiv='Content-Type' content='text/html; charset=utf-8' />";
	echo "<meta http-equiv='refresh' content='3;url=project_report.php?id=".$number."'>";
	echo "</head>";
	exit ;
 }
 ?>
<?php 
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "")
    {
  	$theValue=str_replace('"',"",trim($theValue));
		$theValue=addslashes($theValue);

    switch ($theType)
        {
        case "text":
            $theValue=($theValue != "") ? "'" . $theValue . "'" : "NULL";
            break;
        case "long":
        case "int":
            $theValue=($theValue != "") ? intval($theValue) : "NULL";
            break;
        case "double":
            $theValue=($theValue != "") ? "'" . doubleval($theValue) . "'" : "NULL";
            break;
        case "date":
            $theValue=($theValue != "") ? "'" . $theValue . "'" : "NULL";
            break;
        case "defined":
            $theValue=($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
            break;
        }
    return $theValue;
    } 
if (!empty($_POST['Submit'])){	 
	$doing= $_POST["box"];
	$shuliang = $_POST["shuliang"];
	 $doing=trim($doing);
	$date = date("Y-m-d   H:i:s");
	mysql_select_db($database_roche, $roche);
	$query111 =  sprintf( "insert into   project_report(pro_id,username,doing,num,date) values(%s,%s,%s,%s,%s )",
	            GetSQLValueString($number, "text"), 
				GetSQLValueString($worker, "text"), 
				GetSQLValueString($doing, "text"),
				GetSQLValueString($shuliang, "text"),
				GetSQLValueString($date, "date"));
  	 $result11 = mysql_query($query111,$roche) or die(mysql_error());
 
	echo "<head>";
	echo "<meta http-equiv='Content-Type' content='text/html; charset=utf-8' />";
	echo "<meta http-equiv='refresh' content='3;url=project_report.php?id=".$number."'>";
	echo "</head>";
	echo "更新成功,3秒后自动跳转";
	exit ;
}
?>
<table width="98%" border="0" align="center" cellpadding="5">
	<tr	style="border-bottom:#0099CC 1px solid;">
		<td align="left">
			<strong><font color="#000000" size="+1" face="黑体，宋体, Times New Roman, Arial">项目总结报告,项目编号：<?php echo $number ?></font></strong>
		</td>
		<td align="right"><img src="site_images/ras.gif" width="197" height="20" /></td>
	</tr>
	<tr>
		<td align="left" colspan='2'  width="100%">
		<table width="100%" height="77" border="0" cellpadding=0 cellspacing=0>
            <tr>
                <td width="14%" height="40" align="center" class="biankuang"> 日期 </td>
                <td width="14%" align="center" class="biankuang">员工</td>
                <td width="37%" align="center" class="biankuang">内容</td>
                <td width="19%" align="center" class="biankuang">数量</td>
                <td width="16%" align="center" class="biankuang">修改</td>
            </tr>										  
			<?php
			mysql_select_db($database_roche, $roche);
			$result=mysql_query(" select pid,pro_id,username,doing,sum(num) as all_num,date as name,date  from project_report where pro_id like '$number%' and num<>'' group by doing order by date");
			while($row=@mysql_fetch_array($result)){
				$username = $row[username];
				$doing = $row[doing];
				$shuliang = $row[all_num];
				$date = $row[date];
				$p_id = $row[pid];
			?>
			<tr>
                <td height="37" align="center" class="biankuang2"><?php echo $date ?></td>
                <td align="center" class="biankuang2"><?php echo "<a target='_blank' class='bluelink' href='project_user_do.php?username=$username'>$username</a>"; ?></td>
                <td align="left" class="biankuang2"><?php echo  str_replace("\n","<br>",$doing);  ?></td>
                <td align="center" class="biankuang3"><?php echo $shuliang ?></td>
                <td align="center" class="biankuang3">
				<?php 
				if($worker==$username  || $role==5){
					echo "<a href='project_report_c.php?id=$p_id' target='_blank' class='bluelink' >修改</a>/ <a target='_blank' class='bluelink' href='project_report.php?pid=$p_id&action=del'>删除</a>"; }
				else{echo "你不能修改";	}
				?>
				</td>
            </tr>
			 <?php } ?>
        </table>
		<br />
		</td>
	</tr>
	<tr>
		<td align="left" colspan="2"> 
		<strong><font color="#000000" size="+1" face="黑体，宋体, Times New Roman, Arial">添加新报告：</font></strong></br>
			<form id="form1" name="form1" method="post" action="<?php echo $_SERVER['REQUEST_URI'] ?>" >  
			<table width="100%" border="0">
                <tr>
                    <td width="8%">内容</td>
                    <td width="23%">
					<div style="position:relative">
						<span style="margin-left:102px;width:18px;overflow:hidden"> 
						<select name="box" id=tFrom style="width:125px;margin-left:-103px" onchange="sFrom.value=this.value;sFrom.focus();"> 
							<option></option> 
							<option value="测序">dna测序</option>
							<option value="选择二">选择二</option>
							<option value="选择三">选择三</option> 
						</select>
						</span><input name="box"  type=text id=sFrom style="width:102px;position:absolute;left:0px;font-size:12px" maxlength=50>
					</div> 
					</td>
                    <td width="5%">数量</td>
                    <td width="16%"> <input name="shuliang" type="text" value="1" size="5" /></td>
                    <td width="48%">  <input type="submit" name="Submit" value="确定" /></td>
                </tr>
            </table>
			</form>
		</td>
	</tr>
</table>
<?php 
require_once('smartyconfig.php'); 
if($role<6){
	$html="template_admin_p.php";
}else{
	$html="template_admin_p.php";}
$maincontent=ob_get_contents();
ob_get_clean();
$tpl->assign("maincontent",$maincontent);
$tpl->display($html);
?>
