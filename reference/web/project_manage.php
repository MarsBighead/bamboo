<?php require_once("check_admin.php"); ?>
<?php require_once('Connections/roche.php'); ?>
<?php ob_start();?>
<?php 
$role=$_SESSION['role'];
$paixu=$_GET['paixu'];
if($paixu==""){$paixu=number;}
if ($_SESSION['role']<5){
echo "you are not the administrator,or your ip address is not allowed!";
exit;}
?>
<?php 
$number = $_GET['id'];
$action = $_GET['action'];
$showtime=date("Y-m-d");
if($action=="run"){
mysql_select_db($database_roche, $roche);
$query = "update project set status=1,date='$showtime' where number='$number'";
$result = mysql_query($query,$roche) or die(mysql_error());
	  echo "<Script language='JavaScript'> alert('项目已经启动');</Script>";
}
elseif($action=="finish"){

mysql_select_db($database_roche, $roche);
$query = "update project set status=2,date_f='$showtime' where number='$number'";
$result = mysql_query($query,$roche) or die(mysql_error());
  echo "<Script language='JavaScript'> alert('项目已经结束');</Script>";
}
elseif($action=="over"){
mysql_select_db($database_roche, $roche);
$query = "update project set status=3,date_j='$showtime'where number='$number'";
$result = mysql_query($query,$roche) or die(mysql_error());
  echo "<Script language='JavaScript'> alert('项目已经结清');</Script>";

}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" name="keywords" content="生物技术,天昊生物,测序,snp,PCR" />
<title></title>
</head>

<body>
<table width="100%" border="0" align="center" bgcolor="#FFFFFF" height="400">
		<tr>
				<td valign="top">
						<table width="98%" border="0" align="center" cellpadding="5">
								<tr height="3">
										<td width="994"></td>
								</tr>
								<tr>
										<td colspan="2">
												<table width="100%" border="0" style="border-bottom:#0099CC 1px solid;" align="center">
														<tr>
																<td align="left"> <font color="#000000" face="黑体，宋体, Times New Roman, Arial" size="+1" ><strong></strong></font></td>
																<td align="right"><img src="site_images/ras.gif" width="197" height="20" /></td>
														</tr>
												</table>
										</td>
								</tr>
								<tr>
										<td colspan="2" align="left" valign="top"><p><?php 
										if($role==4   ){echo "<a target='_blank' class='bluelink' href='project_add.php'>添加一个新的项目</a>/<a target='_blank' class='bluelink' href='project_add.php?type=2'>添加一个产品订购</a>";}
										elseif($role==5){echo "<a target='_blank' class='bluelink' href='project_add.php'>添加一个新的项目</a>";}
										elseif($role>6){echo "<a target='_blank' class='bluelink' href='project_add.php'>添加一个新的项目</a>/<a target='_blank' class='bluelink' href='project_add.php?type=2'>添加一个产品订购</a>/<a target='_blank' class='bluelink' href='regist.php'>添加一个用户</a>"; }
										?></p>
										  <p>正在进行的项目</p>
									 
										  <table width="100%">
                                            <tr >
                                              <td width="17%" align="center" style=" border-bottom:black 1px dashed; BORDER-LEFT: black 1px dashed; border-right:black 1px dashed;BORDER-TOP: black 1px dashed;"><a href="./project_manage.php?paixu=number">项目编号</a></td>
                                              <td width="17%" align="center" style=" border-bottom:black 1px dashed; border-right:black 1px dashed;BORDER-TOP: black 1px dashed;">项目名称</td>
                                              <td width="9%" align="center" style=" border-bottom:black 1px dashed; border-right:black 1px dashed;BORDER-TOP: black 1px dashed;"><a href="./project_manage.php?paixu=date">开始日期</a></td>
                                              <td width="14%" align="center" style=" border-bottom:black 1px dashed; border-right:black 1px dashed;BORDER-TOP: black 1px dashed;"><a href="./project_manage.php?paixu=date_end">截止日期</a></td>
                                              <td width="11%" align="center" style=" border-bottom:black 1px dashed; border-right:black 1px dashed;BORDER-TOP: black 1px dashed;"><a href="./project_manage.php?paixu=status">项目状态</a></td>
                                              <td width="10%" align="center" style=" border-bottom:black 1px dashed; border-right:black 1px dashed;BORDER-TOP: black 1px dashed;">进展记录</td>
                                              <td width="10%" align="center" style=" border-bottom:black 1px dashed; border-right:black 1px dashed;BORDER-TOP: black 1px dashed;">项目详情</td>
											  
											         <td width="12%" align="center" style=" border-bottom:black 1px dashed; border-right:black 1px dashed;BORDER-TOP: black 1px dashed;">项目安排</td>
											 	 
                                            </tr>
                                            <?php
 mysql_select_db($database_roche, $roche); 
include("pageft.php"); //包含“pageft.php”文件
$page = $_GET['page'];
//取得总信息数
$result=mysql_query("select * from project where status<2");
$total=@mysql_num_rows($result);
//调用pageft()，每页显示10条信息（使用默认的20时，可以省略此参数），使用本页URL（默认，所以省略掉）。
pageft($total,20);
//现在产生的全局变量就派上用场了：
$result=mysql_query("select *  from project where status<2 order by  $paixu limit $firstcount,$displaypg  ");
while($row=@mysql_fetch_array($result)){
$id=$row[id];
$number=$row[number];
$name=$row[name];
$username=$row[username];
$date=$row[date];
$date_end=$row[date_end];
$date_f=$row[date_f];
$leibie=$row[leibie];
$status=$row[status];
$view=$row[view];
?>
                                            <tr>
                                              <td align="right" style=" border-bottom:black 1px dashed; BORDER-LEFT: black 1px dashed; border-right:black 1px dashed;"><?php if($view<2){echo "<img src='./images/new3.gif'/>";}  echo "<a target='_blank' class='bluelink' href='project_show_x.php?id=$id'>$number</a>" ; ?>&nbsp;&nbsp;</td>
                                              <td  align="left" style=" border-bottom:black 1px dashed; border-right:black 1px dashed;"><?php echo "$name ";  ?></td>
                                              <td  align="left" style=" border-bottom:black 1px dashed; border-right:black 1px dashed;"><?php echo "$date"  ; ?></td>
                                              <td  align="left" style=" border-bottom:black 1px dashed; border-right:black 1px dashed;"><?php 																			  
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
                                              <td  align="center" style=" border-bottom:black 1px dashed; border-right:black 1px dashed;"><?php 
if($leibie==0){
if($status==0){echo "确认"; echo "<a target='_blank' class='bluelink' href='project_manage.php?id=$number&action=run'>(处理)</a>";}
if($status==1){echo "处理中";  echo "<a target='_blank' class='bluelink' href='project_manage.php?id=$number&action=finish'>(发货)</a>";}
if($status==2){echo "已发货";  echo "<a target='_blank' class='bluelink' href='project_manage.php?id=$number&action=over'>(结清)</a>";}
if($status==3){echo "结清";}}
else {											  
if($status==0){echo "确认"; echo "<a target='_blank' class='bluelink' href='project_manage.php?id=$number&action=run'>(启动)</a>";}
if($status==1){echo "启动";  echo "<a target='_blank' class='bluelink' href='project_manage.php?id=$number&action=finish'>(完成)</a>";}
if($status==2){echo "完成";  echo "<a target='_blank' class='bluelink' href='project_manage.php?id=$number&action=over'>(结清)</a>";}
if($status==3){echo "结清";}}
 
?></td>
                                              <td  align="center" style=" border-bottom:black 1px dashed; border-right:black 1px dashed;"><?php echo "<a target='_blank' class='bluelink' href='project_jinzhan.php?id=$number'>查看</a> ";
 										  
											    ?></td>
                                              <td  align="center" style=" border-bottom:black 1px dashed; border-right:black 1px dashed;"><?php 
											  if($role==6  ) {echo "<a target='_blank' class='bluelink' href='project_show_x.php?id=$id'>查看和修改</a>";} 
elseif($role>6){echo "<a target='_blank' class='bluelink' href='project_show_x.php?id=$id'>查看</a>/<a target='_blank' class='bluelink' href='project_change_x.php?id=$id'>修改</a>";}
											   ?></td>
											    
											        <td  align="center" style=" border-bottom:black 1px dashed; border-right:black 1px dashed;"><?php 
										if($role>6 && $leibie>0) {	 echo "<a target='_blank' class='bluelink' href='project_anpai.php?id=$number'>安排</a>"; }
									if($role==6 && $leibie>0) {	 echo "<a target='_blank' class='bluelink' href='project_anpai_c.php?id=$number'>查看</a>"; }	
											   ?></td>
											 
                                            </tr>
                                            <?php
}

?>
                                          </table></td>
								</tr>
								<tr>
										<td><?php echo $pagenav; ?>
									    <p>注：1、若为长期持续性项目，截止日期为项目启动后三天，其中09AAAA,09AAAE和09AAAL为项目启动后一个礼拜。 </p>
									    <p>2、其他项目 ，距离项目截止日期5个工作日天后显示为黄色警示标志，3个工作日为橙色警示标志，1个工作日为红色警示标志 。</p></td>
										<td width="118">&nbsp;</td>
								</tr>
						</table>
				</td>
		</tr>
</table>
</body>
</html>
<?php require_once('smartyconfig.php'); 
$maincontent=ob_get_contents();
ob_get_clean();
$tpl->assign("maincontent",$maincontent);
$tpl->display('template_admin_p.php');
?>