<?php require_once('Connections/roche.php'); ?>
<?php
$username=$_SESSION['username'];
$role=$_SESSION['role'];
$paixu=$_GET['paixu'];
if($paixu==""){$paixu=number;}
 ob_start();
?>
<?php 
if ($_SESSION['role']<1){
echo "you are not the administrator,or your ip address is not allowed!";
exit;}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" name="keywords" content="生物技术,天昊生物,测序,snp,PCR" />
<title></title>
<style type="text/css">
<!--
.biankuang { border-top:black 1px solid;   border-left:black 1px solid;  border-bottom:black 1px solid;   border-right:black 1px solid;border-collapse:collapse;  }
.biankuang1 {  border-left:gray 1px solid; border-bottom:gray 1px solid; }
.biankuang2 {border-left:gray 1px solid; border-bottom:gray 1px solid; }
.biankuang3 {  border-right:gray 1px solid; border-left:gray 1px solid;border-bottom:gray 1px solid;  }
 
.biankuang4 {border-top: black 1px solid; border-left: black 1px solid; border-bottom: black 1px solid; border-right: black 1px solid; font-weight: bold; }
 
-->
</style>
</head>

<body>
<table width="100%" border="0" align="center" bgcolor="#FFFFFF" height="400">
		<tr>
				<td valign="top">
						<table width="98%" border="0" align="center" cellpadding="5">
								<tr height="3">
										<td width="500"></td>
								</tr>
								<tr>
										<td colspan="2">
												<table width="100%" border="0" style="border-bottom:#0099CC 1px solid;" align="center">
														<tr>
																<td align="left"> <font color="#000000" face="黑体，宋体, Times New Roman, Arial" size="+1" ><strong><br>我的项目管理</strong></font></td>
																<td align="right"><img src="site_images/ras.gif" width="197" height="20" /></td>
														</tr>
												</table>
										</td>
								</tr>
								<tr>
										<td height="227" colspan="2" align="left" valign="top"><p><?php 
										  
										if($role==6 ){echo "<a target='_blank' class='bluelink' href='project_add.php'>添加一个新的研发项目</a>/<a target='_blank' class='bluelink' href='project_add.php?type=2'>添加一个服务类项目</a>";}
										elseif($role==4){echo "<a target='_blank' class='bluelink' href='project_add.php?type=2'>添加一个服务类项目</a>";}
										?> </p>
										  <p><strong>正在进行的的项目</strong></p>
										 
 
										  <table width="100%" border="0" cellpadding=0 cellspacing=0>
                                                                                <tr>
                           <td width="10%" height="30" align="center"  class="biankuang"><a href="./project_user.php?paixu=number"><strong>项目编号</strong></a></td>
                        <td width="15%" align="center" class="biankuang"><a href="./project_user.php?paixu=name"><strong>项目名称</strong></a></td>
						  <td width="15%" align="center" class="biankuang"><a href="./project_user.php?paixu=name"><strong>项目类别</strong></a></td>
                         <td width="9%" align="center" class="biankuang"><a href="./project_user.php?paixu=date"><strong>开始日期</strong></a></td>
             <td width="15%" align="center"  class="biankuang"><a href="./project_user.php?paixu=date_end"><strong>截止日期</strong></a></td>
						  <td width="9%" align="center"   class="biankuang4">进展</td>
                           
                          <td width="10%" align="center"  class="biankuang4">详细</td>       
					    <td width="9%" align="center"   class="biankuang4">安排</td>
                                                                                </tr>
																				<?php
 mysql_select_db($database_roche, $roche); 			
  if($role==4){
   $result=mysql_query("select project.id,project.number,project.name,project.date,project.date_end,project.status,project.date_j2,project.view,project.leibie,project_user.jinzhan from project left join       	project_user on project.number=project_user.pro_id where (project_user.username='$username' or  project.leibie=0) and project.status=1 group by   project.id   order by project.$paixu");}
 elseif($role==2) {
 $result=mysql_query("select project.id,project.number,project.name,project.date,project.date_end,project.status,project.date_j2,project.view,project.leibie,project_user.jinzhan from project left join       	project_user on project.number=project_user.pro_id where project_user.username='$username' and project.status=1 group by   project.id   order by project.$paixu");

 }
 
 elseif($role>2){$result=mysql_query("select *  from project where status<2  order by  $paixu" );}
 else{$result=mysql_query("select *  from project where status=1  order by $paixu" );}														

while($row=@mysql_fetch_array($result)){
$id=$row[id];
$number=$row[number];
$name=$row[name];
$date=$row[date];
$status=$row[status];
$date_end=$row[date_end];
$date_j2=$row[date_j2];
$view=$row[view];
$leibie=$row[leibie]; 
 $cishu=mysql_query("select * from project_user where pro_id='$number' and username='$username'");
$jinzhan_c=@mysql_num_rows($cishu);

?>		
                                                                                <tr>
                        <td height="32"  class="biankuang1"><div align="center">
                          <?php  
if($status==0 && $role>2){echo "<img src='./images/s_desc.png'/> ";}
elseif(( ($jinzhan_c <2 && $view<2))  ){echo "<img src='./images/new3.gif'/>";}
																				  
																				  echo "<a target='_blank' class='bluelink' href='project_show_x.php?id=$id'>$number </a> " ; ?> 
                          &nbsp;</div></td>
          <td align="left" class="biankuang2"><?php echo "$name"  ; ?></td>
		    <td align="left" class="biankuang2"><?php if($leibie==0) {echo "服务项目"  ; } else{echo "研发项目";}?></td>
           <td align="left" class="biankuang2"><?php echo "$date"  ; ?></td>
           <td align="left"class="biankuang2"><?php 																			  
 $d1=strtotime(date("Y-m-d"));
 $w1=date('w');


 $d3=strtotime($date);
 $w3=date('w',strtotime("$date"));
 
 echo "$date_end";
 $d2=strtotime($date_end);
 $w2=date('w',strtotime("$date_end"));
 $workdays=round(($d2-$d1)/3600/24);
 if($w1>5){$w1=5;}
 if($w2>5){$w2=5;}
 $workday=5 * floor($workdays/7) +(($w2<$w1)?(5-$w1+$w2):($w2-$w1));
 if(($workday<7 &&$workday>3)   ) {echo "<font color='#D2D200'><b>Alert!</b></font>  ";
     }
elseif($workday<4 && $workday>1) {echo "<font color='#FF6600'><b>Alert!!</b></font> ";}
elseif($workday<2 && $workday>=-100) {echo "<font color='#FF0000'><b>Alert!!!</b></font> ";}
else {echo "&nbsp;";}	 ?></td>
        <td align="center"class="biankuang2"><?php
	 echo "<a target='_blank' class='bluelink'       href='project_jinzhan.php?id=$number'>查看</a> ";   
  
  
  ?></td>
                                                                                 
        
        <td align="center"class="biankuang2"><?php if($role==6 || ($role==4 && $leibie==0) ) {echo "<a target='_blank' class='bluelink' href='project_show_x.php?id=$id'>查看</a>/<a target='_blank' class='bluelink' href='project_change_x.php?id=$id'>修改</a";}
					 
					else {echo "<a target='_blank' class='bluelink' href='project_show_x.php?id=$id'>查看</a>";}															   
																				     ?></td>
			 <td align="center"class="biankuang3"><?php 
																				   
if($role==6 || ($role==4 && $leibie==0)   ) {echo "<a target='_blank' class='bluelink' href='project_anpai.php?id=$number'>安排</a>";} 
else{echo "<a target='_blank' class='bluelink' href='project_anpai_c.php?id=$number'>查看</a>";}
 
?> </td>
                                                                                </tr>
																				
																		
                                                                                
																				<?php
}

?>
                                          </table>
										  
  <p>注： </p>
  <p>&nbsp;</p></td>
								</tr>
								 
						</table>
				</td>
		</tr>
</table>
</body>
</html>
<?php require_once('smartyconfig.php'); 
 
$html="template_admin_p.php"; 
$maincontent=ob_get_contents();
ob_get_clean();
//$tpl->assign("articleTitle", 'test-上海天昊生物科技有限公司|上海天昊遗传分析中心');
$tpl->assign("maincontent",$maincontent);
$tpl->display($html);
?>
