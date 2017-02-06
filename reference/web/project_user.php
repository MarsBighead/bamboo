<?php require_once('Connections/roche.php'); ?>
<?php
$username=$_SESSION['username'];
$role=$_SESSION['role'];
$paixu=$_GET['paixu'];
$line=$_GET['line'];
if($paixu==""){$paixu=number;}
ob_start();
if ($_SESSION['role']<1){
	echo "you are not the administrator,or your ip address is not allowed!";
	echo "<meta http-equiv='refresh' content='0;url=index.php'>";
	exit;
}
// if($username=="wangli"){$_SESSION['username']='2011003';$_SESSION['role']='0';}
?>
<table width="98%" border="0" align="center" cellpadding="5">
	<tr  style="border-bottom:#0099CC 1px solid;">
		<td align="left"> <font color="#000000" face="黑体，宋体, Times New Roman, Arial" size="+1" ><strong>我的项目管理</strong></font></td>
		<td align="right"><img src="site_images/ras.gif" width="197" height="20" /></td>
	</tr>
	<tr>
		<td height="230" colspan="2" align="left" valign="top"><p>
		<?php 						  
			if($role==6 ){echo "<a target='_blank' class='bluelink' href='project_add.php'>添加一个新的研发项目</a>/<a target='_blank' class='bluelink' href='project_add.php?type=2'>添加一个服务类项目</a>/<a target='_blank' class='bluelink' href='project_add.php?type=3'>添加一个生产项目</a>";}
			elseif($role==4  ){echo "<a target='_blank' class='bluelink' href='project_add.php?type=2'>添加一个服务类项目</a>/<a target='_blank' class='bluelink' href='project_add.php?type=4'>添加一个内部项目补充测试</a>";}
            elseif( $role==3 ){echo "<a target='_blank' class='bluelink' href='project_add.php'>添加一个新的项目</a>";}									
			elseif($role==1){
				if($username == 2011016){echo "<a target='_blank' class='bluelink' href='project_add.php?type=1'>添加一个新的研发项目</a>";}
				else{	echo "<a target='_blank' class='bluelink' href='project_add.php'>添加一个新的项目</a>";		}
			}
			if($role<4){
				if($line==""){	$order=" order by project.$paixu";	$line=1;
				}elseif($line<0){
					$order=" order by project.$paixu desc";	$line*=-1;
				}elseif($line>0){
					$order=" order by project.$paixu asc";	$line*=-1;
				}
			}else{
				if($line==""){
					$order=" order by $paixu";	$line=1;				
				}elseif($line<0){
					$order=" order by $paixu desc";	$line*=-1;
				}elseif($line>0){
					$order=" order by $paixu asc";	$line*=-1;
				}
			}
		?> </p>
		<p><strong>正在进行的的项目</strong></p>
		<table width="100%" border="1" cellpadding='1' face="黑体，宋体, Times New Roman, Arial" style="font-size:15px;">
			<tr>
                <td width="20%" height="30" align="center"  ><a href="<?php echo "./project_user.php?paixu=number&line=$line";?>"><strong>项目编号</strong></a></td>
                <td width="27%" align="center" ><a href="<?php echo "./project_user.php?paixu=name&line=$line";?>"><strong>项目名称</strong></a></td>
		        <td width="13%" align="center" ><a href="<?php echo "./project_user.php?paixu=date&line=$line";?>"><strong>开始日期</strong></a></td>
				<td width="19%" align="center" ><a href="<?php echo "./project_user.php?paixu=date_end&line=$line";?>"><strong>截止日期</strong></a></td>
				<td width="21%" align="center" >项目管理</td>
            </tr>
			<?php
			mysql_select_db($database_roche, $roche); 			
			$sql_right="select project.id,project.number,project.name,project.date,project.date_end,project.status,project.creater,project.date_j2,project.view,project.leibie,project_user.jinzhan from project left join project_user on project.number=project_user.pro_id";
			
			if($role==4){
				$sql="$sql_right where   project.status<=1 group by   project.id   $order";
			}elseif($role==3){
				$sql="$sql_right where   project.status<=1 group by   project.id   $order";
			}elseif($role==1){
				$sql="$sql_right where (project_user.username='$username' or project.creater='$username' ) and project.status<=1 group by  project.id $order";
			}elseif($role==2) {
				$sql="$sql_right where project_user.username='$username' and project.status=1 group by  project.id  $order";
			}elseif($role>4){
				$sql="select *  from project where status<2  $order";
			}
			$result=mysql_query($sql);
			$n=0;
			while($row=@mysql_fetch_array($result)){
				$n++;
				$id=$row[id];
				$name=$row[name];
				$date=$row[date];
				$status=$row[status];
				$date_end=$row[date_end];
				$date_j2=$row[date_j2];
				$view=$row[view];
				$leibie=$row[leibie];
				$creater= $row[creater];
				$cishu=mysql_query("select * from project_user where pro_id='$row[number]' and username='$username'");
				$jinzhan_c=@mysql_num_rows($cishu);
			?>		
			<tr>
                <td height="32">
					<div align="center">
					<?php  
					if($status==0 && $role>2){echo "<img src='./images/s_desc.png'/> ";}
					elseif(( ($jinzhan_c <2 && $view<2))  ){echo "<img src='./images/new3.gif'/>";}																				  
					echo "<a target='_blank' class='bluelink' href='project_show_x.php?id=$id'>$row[number] </a> " ;
					?>&nbsp;
					</div>
				</td>
				<td align="center"><?php echo "$name"; ?></td>
				<td align="center"><?php echo "$date"; ?></td>
				<td align="center">
				<?php 																			  
					$d1=strtotime(date("Y-m-d"));
					$w1=date('w');
					$d3=strtotime($date);
					$w3=date('w',strtotime("$date")); 
					echo "$date_end &nbsp;";
					$d2=strtotime($date_end);
					$w2=date('w',strtotime("$date_end"));
					$workdays=round(($d2-$d1)/3600/24);
					if($w1>5){$w1=5;} if($w2>5){$w2=5;}
					$workday=5 * floor($workdays/7) +(($w2<$w1)?(5-$w1+$w2):($w2-$w1));
					if(($workday<7 &&$workday>3)   ) {echo "<font color='#D2D200'><b>Alert!</b></font>  ";   }
					elseif($workday<4 && $workday>1) {echo "<font color='#FF6600'><b>Alert!!</b></font> ";}
					elseif($workday<2 && $workday>=0) {echo "<font color='#FF0000'><b>Alert!!!</b></font> ";}
					elseif($workday<0 && $workday>=-10000){ echo "<b><font color='#FF00FF'>Alert!!!</font>";}
					else {echo "&nbsp;";}	
				?>
				</td>
				<td align="center">
				<?php echo "<a href='project_jinzhan.php?id=$row[number]' target='_blank' class='bluelink'>进展</a> ";   ?>
				<?php
				if($role==6 ||   ($creater==$username)) {
					echo "<a target='_blank' class='bluelink' href='project_show_x.php?id=$id'>详情</a>";
					echo "/<a target='_blank' class='bluelink' href='project_change_x.php?id=$id'>修改</a>";
				}else {echo "<a target='_blank' class='bluelink' href='project_show_x.php?id=$id'> 详情</a>";}															   
				?>			
				<?php 
				if($status==0){ echo "<span style='color:#CCCCCC'>未启动</span>";}
				else{
					if($role==6 || ($role==4 )  ) {echo "<a href='project_anpai.php?type=$leibie&id=$row[number]' target='_blank' class='bluelink' >安排</a>";} 
					else{echo "<a href='project_anpai_c.php?id=$row[number]' target='_blank' class='bluelink' >安排</a>";}
				}
				?>
				</td>
            </tr>
			<?php } ?>			
        </table>										  
			<p>注：
			<?php
				mysql_select_db($database_roche, $roche); 		
				$tomonth=date("m");
				$season=0;
				if($tomonth>0 && $tomonth<4 ){ $season="(1,2,3)";}
				elseif($tomonth>3 && $tomonth<7 ){ $season="(4,5,6)";}
				elseif($tomonth>6 && $tomonth<10 ){ $season="(7,8,9)";}
				elseif($tomonth>9 ){ $season="(10,11,12)";}
				$sql_result=mysql_query("select sum(project_user.work) as work_sum from project left join  project_user on project.number=project_user.pro_id where project_user.username='$username' and project.status>1 and   MONTH(project.date_f) in $season  ");
				$sql_row=@mysql_fetch_array($sql_result);
				$user_season=$sql_row[work_sum];
				echo "本季度你已经完成的工作量为：$user_season";
			?> 
			</p>
		</td>
		
	</tr>
	<tr>
		<td><?php echo $pagenav; ?></td>
		<td>&nbsp;</td>
	</tr>
</table>
<?php
require_once('smartyconfig.php');  
//$html="template_project.php"; 
$html="template_admin_p.php"; 
$maincontent=ob_get_contents();
ob_get_clean();
//$tpl->assign("articleTitle", 'test-上海天昊生物科技有限公司|上海天昊遗传分析中心');
$tpl->assign("maincontent",$maincontent);
$tpl->display($html);
?>
