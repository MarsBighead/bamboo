<?php 
require_once('Connections/roche.php'); 
ob_start();
session_start(); 
if (empty($_SESSION['username'])){
	$_SESSION['loginerr']="您访问的页面需要先登录";
	header("location:loginerr.php");
	exit;
}
$id = $_GET['id'];
?>
<table width="98%" border="0" align="center" cellpadding="5">
    <tr style="border-bottom:#0099CC 1px solid;">      
        <td align="left">
			<strong><font color="#000000" size="+1" face="黑体，宋体, Times New Roman, Arial">订单详细</font></strong>
		</td>
        <td align="right"><img src="site_images/ras.gif" width="197" height="20" /></td>  
    </tr>
    <tr>
        <td valign="top" align="left"  colspan="2">				  
		<table width="100%"  border="0"  >
			<?php
				mysql_select_db($database_roche, $roche);
				$query=sprintf("select * from project where id = '%s' ", $id);
				$result = mysql_query($query,$roche) or die(mysql_error()); 
				while($row = mysql_fetch_array($result)){
					$id =$row[id];
					$number = $row[number];
					$username =$row[username];
					$name = $row[name];
					$date =$row[date];
					$date_f =$row[date_f];
					$title =$row[title];
					$xiazai=$row[xiazai];
					$detail=$row[detail];
					$downloads=$row[downloads];
					$intro=$row[intro];
					$leibie=$row[leibie]; 
					if($_SESSION['role']>5  || $_SESSION['username']=="2011003" ||$_SESSION['username']=="002"  )	{}
					elseif (strcasecmp($_SESSION['username'],$username)){
						$_SESSION['loginerr']="该项目并不是您的，您没有权限查看该项目";
						header("location:index.php");
						exit;
					}
			?>		
			<tr>
				<td width="190"  align="center" >
					<div align="left"><?php if($liebie==0) {echo "订单编号";} else {echo "项目编号";}?>: </div>
				</td>
				<td width="913"><?php echo $number ; ?></td>
			</tr>
			<tr>
				<td align="center"  ><div align="left">用&nbsp;户&nbsp;名&nbsp;:</div></td>
				<td><?php echo $username ; ?></td>
			</tr>
			<tr>
				<td align="center"  ><div align="left">项目名称:</div></td>
				<td><?php echo $name ; ?></td>
			</tr>
			<tr>
				<td align="center"  ><div align="left">开始时间:</div></td>
				<td><?php echo $date ; ?></td>
			</tr>
			<tr>
				<td align="center"  ><div align="left">完成时间:</div></td>
				<td><?php echo $date_f ; ?></td>
			</tr>  
			<tr>
				<td   valign="top">项目介绍:</td>
				<td width="913"     style="bordercolor:#333333"> <?php echo str_replace("\n","<br>",$intro); ?></td>
			</tr>
			<tr>
				<td valign="top">详细内容:</td>
				<td width="913" style="bordercolor:#333333"> 
					<table width="100%" border="1">
						<tr>
							<td width="18%" align="center" >日期</td>
							<td width="67%" align="center" >进展内容</td>
							<td width="15%" align="center" >操作员</td>
						</tr>
						<?php
						mysql_select_db($database_roche, $roche);
						$result2=mysql_query("select *  from project_user where pro_id='$number' and jinzhan<>'' order by  date");
						while($row2=@mysql_fetch_array($result2)){
							$username = $row2[username];
							$doing = $row2[doing];
							$jinzhan = $row2[jinzhan];
							$date = $row2[date];
							$p_id = $row2[pid];
						?>
						<tr>
							<td align="center" >&nbsp;<?php echo "$date";?></td>
							<td align="left">&nbsp;<?php echo  str_replace("\n","<br>",$jinzhan);  ?></td>
							<td align="center">&nbsp;<?php echo "$username";?></td>
						</tr>
						<?php } ?>
					</table>
				</td>
			</tr>
			<tr>
				<td  valign="top" ><div align="left">数据下载:</div></td>
				<td style="bordercolor:#333333">
				<?php  	 
					if(preg_match("/^(SZ[0-9]+A[A-Z]+)([0-9]+.*)$/", $number,$match))
					{
						$dir=$match[1]."/".$match[2];
						$xiazai=1;
					}else {
						$dir= $number ;	}
					$dir_1="/home/lch/httpd/web/service/download/".$dir;
					if(file_exists   ($dir_1)){
					   $handle=opendir($dir_1); 
					   $i=0;  
						while($file=readdir($handle))   {  
							if(($file!=".")and($file!=".."))   {  
								$i=$i+1;  
								$link="./download/".$dir."/".$file;
								if($xiazai==0){$link="waring.php";}
								echo iconv("GB2312","UTF-8" ,"<a href='$link' >$file</a><br>");
								$myfile=$file;
							}   
						}
					} 
					if ($myfile == "") {echo "暂无";}	 
				?>	 	
				</td>
			</tr>
			<?php } ?>		  
		</table>
		</td>
	<tr>
</table>
<?php 
require_once('smartyconfig.php'); 
$maincontent=ob_get_contents();
ob_get_clean();
$tpl->assign("maincontent",$maincontent);
$tpl->display('template_member.php');
?>
