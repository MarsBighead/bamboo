<?php 
require_once('Connections/roche.php'); 
if ($_SESSION['role']<1){
	echo "you are not the administrator,or your ip address is not allowed!";
	echo "<meta http-equiv='refresh' content='0;url=loginerr.php'>";
}
?>
<?php
$role=$_SESSION['role'];
$creatername=$_SESSION['username'];
$type=$_GET['type'];
$paixu=$_GET['paixu'];
$year=$_GET['year'];
$nb=$_GET['nb'];
$mounth=$_GET['month'];
if($paixu==""){$paixu=number;}
if($year==""){$year=date('Y');}
if (!empty($_POST['submit'])){
$mounth = $_POST["mounth"];
 
}
 // echo $role; 
ob_start();
?>

<table width="100%" border="0" align="center" cellpadding="5">
	<tr  style="border-bottom:#0099CC 1px solid;">
		<td align="left">
			<strong><font color="#000000" size="+1" face="黑体，宋体, Times New Roman, Arial">
			<?php 
			echo "$year 年 ";
			if($mounth>0){echo "$mounth 月 ";}
			if($type==2) {echo "完成项目";} elseif($type==3) {echo "结清项目";}?>
			</font></strong>
		</td>		
		<td>
			<img src="site_images/ras.gif" width="197" height="20" style="float:right;" />
		</td>
	</tr>
	<tr>
	<td width="100%" colspan="2" align="left" >
		<table width="100%" border="1" cellspacing=0 >
			<tr style="font-weight:bold;font-size:16px;" height="35">
				<td width="80" align="center" ><a href="./project_show_f.php?type=<?php echo "$type"; ?>&paixu=number" >项目编号</a></td>
				<td width="220" align="center" ><a href="./project_show_f.php?type=<?php echo "$type"; ?>&paixu=name">项目名称</a></td>
				<td width="100" align="center" ><a href="./project_show_f.php?type=<?php echo "$type"; ?>&paixu=date">开始时间</a></td>
				<td width="100" align="center" ><a href="./project_show_f.php?type=<?php echo "$type"; ?>&paixu=date_j">结束时间</a></td>
				<td width="80" align="center" >项目安排</td>
				<td width="120" align="center">查看进展</td> 
			</tr>
			<?php
			mysql_select_db($database_roche, $roche); 
			include("pageft.php"); //包含“pageft.php”文件
			$page = $_GET['page'];
			//取得总信息数
			if($role==4){ 
				$result= "select project.id,project.number,project.name,project.date,project.date_f,project.view,project.leibie,project_user.jinzhan from project left join  project_user on project.number=project_user.pro_id where  project.status='$type'  and left(project.date,4)='$year'  group by  project.id" ;
			}elseif($role==3){ 
				$result= "select project.id,project.number,project.name,project.date,project.date_f,project.view,project.leibie,project_user.jinzhan from project left join  project_user on project.number=project_user.pro_id where  project.status='$type'  and left(project.date,4)>=2012  group by  project.id" ;
			}elseif($role==2){
				$result= "select project.id,project.number,project.name,project.date,project.date_f,project.view,project.leibie,project_user.jinzhan from project left join  project_user on project.number=project_user.pro_id where project_user.username='$creatername'    and project.status='$type'  and left(project.date,4)='$year' group by  project.id " ; 
			}elseif($role>4){ 
				$result= "select *  from project where status='$type' and left(date,4)='$year' " ;
			}elseif($role==1){ 
				$result= "select project.id,project.number,project.name,project.date,project.date_f,project.view,project.leibie,project_user.jinzhan from project left join  project_user on project.number=project_user.pro_id where (project_user.username='$creatername' or  project.creater='$creatername')    and project.status='$type'  and left(project.date,4)='$year' group by  project.id " ;   }

			$row_result=mysql_query($result);
			$total=@mysql_num_rows($row_result);
			//调用pageft()，每页显示10条信息（使用默认的20时，可以省略此参数），使用本页URL（默认，所以省略掉）。
			pageft($total,20);
			//现在产生的全局变量就派上用场了：
			$result= $result." order by  $paixu limit $firstcount,$displaypg";   
			$result=mysql_query($result);
			while($row=@mysql_fetch_array($result)){
				$id=$row[id];
				$number=$row[number];
				$name=$row[name];
				//$username=$row[username];
				$date=$row[date];
				$date_f=$row[date_f]; 
			?>
			<tr>
				<td  align="center" height="25"><?php 
				if(preg_match("/^([0-9]+A[A-Z]{3})/",$number,$match) && $nb==""){
					$number=substr($number,0);
					if($mounth>0){
						echo "<a href='project_show_f.php?type=$type&nb=$number&year=$year&month=$mounth'  class='bluelink'>$number  </a>";
					}else{
						echo "<a href='project_show_f.php?type=$type&nb=$number&year=$year'  class='bluelink'>$number</a>";}
				}else{
					echo "<a target='_blank' class='bluelink' href='project_show_x.php?id=$id'>$number </a>"; }?>
				</td>
				<td  align="center" ><?php echo "$name ";  ?></td> 
				<td  align="center" valign="middle"><?php echo $date; ?></td> 
				<td align="center"	valign="middle"><?php echo $date_f ; ?></td>
				<td  align="center"><?php echo "<a  href='project_anpai_c.php?id=$number' target='_blank' class='bluelink'>查看</a>";  ?></td> 
				<td  align="center"><?php echo "<a target='_blank' class='bluelink' href='project_jinzhan.php?id=$number'>查看</a>";  ?></td>
				</tr>
				<?php	} ?>
				</table>
				
				</td>
			</tr>
			<tr>
				<td ><?php echo $pagenav; ?></td>
				<td>&nbsp;</td>
			</tr>
			<tr>
				<td align="left" colspan="2">
				<?php if($type==2) { ?>
				<a href="project_show_f.php?type=2&year=2013"><strong><span style="color:#FF0000">13年完成的项目</span> </strong></a><br>
				<a href="project_show_f.php?type=2&year=2012"><strong><span style="color:#FF0000">12年完成的项目</span> </strong></a><br>
				<a href="project_show_f.php?type=2&year=2011"><strong><span style="color:#FF0000">11年完成的项目</span> </strong></a><br><br>
				<?php }elseif($type==3) { ?>
				<a href="project_show_f.php?type=3&year=2013"><strong><span style="color:#FF0000">13年结清的项目</span> </strong></a><br>
				<a href="project_show_f.php?type=3&year=2012"><strong><span style="color:#FF0000">12年结清的项目</span> </strong></a><br>
				<a href="project_show_f.php?type=3&year=2011"><strong><span style="color:#FF0000">11年结清的项目</span> </strong></a><br><br>
				<?php }     ?>
				</td>
			</tr>
			<tr>
				<td >注：项目以项目建项时间为准。</td>
				<td>&nbsp;</td>
			</tr>								
		</table>


<?php 
require_once('smartyconfig.php');  
// $html="template_project.php"; 
$html="template_admin_p.php"; 
$maincontent=ob_get_contents();
ob_get_clean();
$tpl->assign("maincontent",$maincontent);
$tpl->display($html);
?>
