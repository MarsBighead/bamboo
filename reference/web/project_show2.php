<?php 
require_once('Connections/roche.php'); 

if ($_SESSION['role']<2){
	echo "you are not the administrator,or your ip address is not allowed!";
	echo "<meta http-equiv='refresh' content='0;url=loginerr.php'>";
	exit;
}
?>
 
<?php 
$role=$_SESSION['role'];
$creatername=$_SESSION['username'];
$nb=$_GET['nb'];
$date1= date('Y-m');
$date1=$date1."-1";
$date2= date('Y-m-d');
$fenlei = $_GET["fenlei"];
$username = $_GET["username"];
if($fenlei>0){
	$date1= $_GET["date1"];
	$date2= $_GET["date2"]; 
}
// $role=2;
ob_start();
?>
<script language="javascript">
function popupCal()
{
    var popup = window.open('wnl/wnl.php', '_blank', 'width=600,height=200,resizable=1,scrollbars=auto');

}
</script>
<script language="javascript">
function popupCal2()
{    var popup = window.open('wnl/wnl2.php', '_blank', 'width=600,height=200,resizable=1,scrollbars=auto');}
</script>

<table width="100%" border="0" align="center" cellpadding="0">
	<tr style="border-bottom:#0099CC 1px solid;">
		<td align="left" height="20"> 
			<font color="#000000" face="黑体，宋体, Times New Roman, Arial" size="+1" ><strong>项目分类检索</strong></font>
		</td>
		<td align="right">
			<img src="site_images/ras.gif" width="197" />		
		</td>
	</tr>
	<tr>
		<td align="left" colspan="2" height="30">
		<form action="<?php echo $_SERVER['REQUEST_URI'] ?>" method="get" enctype="application/x-www-form-urlencoded" name="form1" id="from1">
			<strong>项目状态： <label>
			<select name="fenlei">
				<option value="1" <?php if ( $fenlei=="1") {echo "selected=\"selected\"";} ?>>新建项目</option>
				<option value="2"  <?php if ( $fenlei=="2") {echo "selected=\"selected\"";} ?>>完成的项目</option>
				<option value="0" <?php if ( $fenlei=="0" || $fenlei=="") {echo "selected=\"selected\"";} ?>>正在进行的项目</option>
			</select>
			</label></strong>
			从<input name="date1" type="text" onClick="popupCal()" value="<?php echo "$date1"?>" size="10" readonly="true">
			到<input name="date2" type="text" onclick="popupCal2()" value="<?php echo "$date2"?>" size="10" readonly="true" />
			员工
			<?php
			global $arr,$db;
			$sql = "select * from username";
			$result=mysql_query($sql);
			while ($i=@mysql_fetch_array($result)){    
			   $arr[] =$i; 		 
			}
			?>
			<select name="username">
				<option value="" selected="selected">所有人员</option>
				<?php
				for ($i=0;$i<count($arr);$i++) {
				?>
				<option value="<?php echo $arr[$i]["userid"] ?>" <?php if ( $username==$arr[$i]["userid"]) {echo "selected=\"selected\"";} ?>><?php echo $arr[$i]["username"] ?></option>
				<?php }?>
			</select>
			<input type="submit" name="submit" value="确定" />
		</form>
		</td>
	</tr>								 
	<tr>
		<td width="100%" colspan="2" align="left">
		<table width="100%" border="1" cellpadding="1" >
			<tr >
				<td width="12%" height="36" align="center" ><strong>项目编号</strong></td> 
				<td width="19%" align="center" ><strong>项目名称</strong></td>
				<td width="12%" align="center" ><strong>开始时间</strong></td>
				<td width="12%" align="center" >
						<strong>
						<?php if($fenlei==3){echo "结清时间";}
						elseif($fenlei==0) {echo "截止时间";}
						else {echo "结束时间";}
					   ?>
						</strong>
				</td>
				<td width="11%" align="center" ><strong>安排</strong></td>
				<td width="11%" align="center" ><strong>进展</strong></td> 
			</tr>
			<?php
				mysql_select_db($database_roche, $roche); 
				include("pageft.php"); //包含“pageft.php”文件
				$page = $_GET['page'];
				//取得总信息数			 
				if($fenlei==1){
					$tpye1="project.date >=date('$date1') and project.date <=date('$date2')";
					$tpye2=" date >=date('$date1')   and date <=date('$date2')";
				}elseif($fenlei==2){ 
					$tpye1="project.status=2  and project.date_f >=date('$date1') and project.date_f <=date('$date2')";
					$tpye2=" status=2 and date_f >=date('$date1')   and date_f <=date('$date2')"; 
				}elseif($fenlei==3){ 
					$tpye1="project.status=3  and project.date_j >=date('$date1') and project.date_j <=date('$date2')";
					$tpye2="status=3 and  date_j >=date('$date1')   and date_j <=date('$date2')"; 
				}elseif($fenlei==0){ 
					$tpye1="project.status=1";
					$tpye2="status=1"; 
				}
				if($username !=""){  
				  $result= "select project.id,project.number,project.name,project.date,project.date_f,project.date_j,project.date_end,project.view,project.leibie,project_user.jinzhan,sum(project_user.work) as work_sum from project left join  project_user on project.number=project_user.pro_id where project_user.username='$username' and $tpye1  group by  project.number   " ;}
				else{ $result= "select *  from project where   $tpye2  group by  number " ;}  
				$row_result=mysql_query($result);
				$total=@mysql_num_rows($row_result);
				//调用pageft()，每页显示10条信息（使用默认的20时，可以省略此参数），使用本页URL（默认，所以省略掉）。
				pageft($total,20);
				//现在产生的全局变量就派上用场了：
				$result= $result."limit $firstcount,$displaypg"; 
				$result=mysql_query($result);
				while($row=@mysql_fetch_array($result)){
				$id=$row[id];
				$leibie=$row[leibie];
				$number=$row[number];
				$name=$row[name]; 
				$date=$row[date];
				$date_f=$row[date_f];
				$date_j=$row[date_j];
				$date_end=$row[date_end];
				$score=$row[score];
				$work_sum=$row[work_sum];
			?>
			<tr>
				<td height="31"  align="center" ><?php 
					if(preg_match("/^([0-9]+A[A-Z]{3})/",$number,$match) && $nb==""){
						$number=substr($number,0,6);
						if($username!=""){echo "<a  href='project_show2.php?fenlei=$fenlei&date1=$date1&date2=$date2&nb=$number&username=$username' class='bluelink' >$number <img src='images/main1_08.gif' /> </a>"; }
						else{ echo "<a href='project_show2.php?fenlei=$fenlei&date1=$date1&date2=$date2&nb=$number' class='bluelink'>$number <img src='images/main1_08.gif' /> </a>"; }
					}else {	
						echo "<a  href='project_show_x.php?id=$id' target='_blank' class='bluelink'>$number </a>"; }
					?>
				</td> 
				<td  align="center"><?php echo "$name ";  ?></td> 
				<td  align="center"><?php echo $date; ?></td> 
				<td align="center">
						<?php 
						if($fenlei==3){echo "$date_j";}
						elseif($fenlei==0){echo "$date_end";}
						else {echo "$date_f";}?>
				</td>
				<td  align="center"><?php echo "<a href='project_anpai_c.php?id=$number' target='_blank' class='bluelink' >查看</a>";  ?></td> 
				<td  align="center"><?php echo "<a  href='project_jinzhan.php?id=$number' target='_blank' class='bluelink'>查看</a>";  ?></td>
			</tr>
		<?php	} ?>
		</table>
		</td>
	</tr>
	<tr><td><?php   if($username !="") {echo "$username:工作量为：$work_sum  ";} ?></td></tr>
	<tr>
		<td><?php echo $pagenav; ?></td>
		<td>&nbsp;</td>
	</tr>
	<tr>
		<td width="100%" colspan="2" align="left" valign="top" style="background-color:red;text-indent:4ex;">
		<p align="center">  </p>
        </td>
	</tr>							
</table>

<?php 
require_once('smartyconfig.php'); 
if($role<3){$html="template_admin_u.php";}
else{$html="template_admin_p.php";}
$maincontent=ob_get_contents();
ob_get_clean();
$tpl->assign("maincontent",$maincontent);
$tpl->display($html);
?>
