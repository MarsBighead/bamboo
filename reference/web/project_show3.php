<?php 
require_once('Connections/roche.php'); 
ob_start();
// echo "role ".$_SESSION['role'];
if ($_SESSION['role']<3){
	echo "you are not the administrator,or your ip address is not allowed!";
	echo "<meta http-equiv='refresh' content='0;url=index.php'>";
	exit;
}
$role=$_SESSION['role'];
$creatername=$_SESSION['username'];
$nb=$_GET['nb'];
$date1= date('Y-m-d');
$date2= date('Y-m-d');
$fenlei = $_GET["fenlei"];
$username = $_GET["username"];
if($fenlei>0){
	$date1= $_GET["date1"];
	$date2= $_GET["date2"]; }
?>

<table width="98%" border="0" align="center" cellpadding="5">
	<tr  style="border-bottom:#0099CC 1px solid;">
		<td align="left"><font color="#000000" face="黑体，宋体, Times New Roman, Arial" size="+1" ><strong>项目完成报告</strong></font></td>
		<td align="right"><img src="site_images/ras.gif" width="197" height="20" /></td>
	</tr>
	<tr>
		<td  colspan="2"  valign="top" >
		<p align="center"></p><br>
		<table width="100%" border="1" cellpadding='1' face="黑体，宋体, Times New Roman, Arial" style="font-size:15px;">
            <tr>
                <td width="17%" height="30" align="center" ><a href="./project_user.php?paixu=number"><strong>项目编号</strong></a></td>
                <td width="21%" align="center" ><a href="./project_user.php?paixu=name"><strong>项目名称</strong></a></td>
                <td width="11%" align="center"><a href="./project_user.php?paixu=date"><strong>开始日期</strong></a></td>
                <td width="17%" align="center"><a href="./project_user.php?paixu=date_end"><strong>完成日期</strong></a></td>
				<td width="11%" align="center">完成报告</td>
            </tr>
            <?php
			mysql_select_db($database_roche, $roche); 			
			if($role==1){
				$result=mysql_query("select *  from project where status<2  and creater=$username order by  $paixu" );
			}elseif($role==2){
				if($username=="011"){
					$result=mysql_query("select *  from project where status=1 and leibie=0 order by $paixu" );
				}else {
					$result=mysql_query("select project.id,project.number,project.name,project.date,project.date_end,project.view,project.leibie,project_user.jinzhan from project left join       	project_user on project.number=project_user.pro_id where project_user.username='$username' and project.status=1 group by   project.id   order by project.$paixu");
				}
			 }elseif($role>2){
				$result=mysql_query("select *  from project where status<2  order by  $paixu" );
			}else{$result=mysql_query("select *  from project where status=1  order by $paixu" );}
			while($row=@mysql_fetch_array($result)){
				$id=$row[id];
				$number=$row[number];
				$name=$row[name];
				$date=$row[date];
				$status=$row[status];
				$date_end=$row[date_end];
				$view=$row[view];
				$leibie=$row[leibie]; 
				$cishu=mysql_query("select * from project_user where pro_id='$number' and username='$username'");
				$jinzhan_c=@mysql_num_rows($cishu);
			?>
            <tr>
                <td height="32"><div align="center">
                <?php 
				if(preg_match("/^([0-9]+A[A-Z]{3})/",$number,$match) && $nb==""){
					$number=substr($number,0,6);
					if($username!=""){
						echo "<a href='project_show2.php?fenlei=$fenlei&date1=$date1&date2=$date2&nb=$number&username=$username' class='bluelink'>$number <img src='images/main1_08.gif' /> </a>"; 
					}else{
						echo "<a href='project_show2.php?fenlei=$fenlei&date1=$date1&date2=$date2&nb=$number' class='bluelink'>$number <img src='images/main1_08.gif' /> </a>"; }
				}else {
						echo "<a href='project_show_x.php?id=$id' target='_blank' class='bluelink'>$number </a>"; }?>
				</td>
                <td align="left"><?php echo "$name"  ; ?></td>
                <td align="left"><?php echo "$date"  ; ?></td>
                <td align="left"><?php echo "$date"  ; ?></td>
                <td align="center"><?php echo "<a href='project_jinzhan.php?id=$number' target='_blank' class='bluelink'>查看</a> ";?></td>
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
$html="template_admin_p.php";
$maincontent=ob_get_contents();
ob_get_clean();
$tpl->assign("maincontent",$maincontent);
$tpl->display($html);
?>
