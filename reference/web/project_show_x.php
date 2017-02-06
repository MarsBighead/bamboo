<?php
require_once('Connections/roche.php'); 
$role=$_SESSION['role'];
if ($_SESSION['role']<1){
	echo "you are not the user,or your ip address is not allowed!";
	echo "<meta http-equiv='refresh' content='0;url=loginerr.php'>";
	exit;
}
?>
<?php 
require_once('sendmail.php'); 
if (!empty($_POST['submit'])){
	$id = $_POST["id"];
	$xiazai = $_POST["xiazai"];
	$date_end = $_POST["date_end"];  
    $date_f = $_POST["date_f"];
	$date_j = $_POST["date_j"];
	$status = $_POST["status"];
	if($status==2){  $date_f = date("Y-m-d");  }
	elseif($status==3){  $date_j = date("Y-m-d");  }
	mysql_select_db($database_roche, $roche);
	$query = "update `project` set xiazai = '$xiazai',date_end='$date_end',date_f='$date_f',date_j='$date_j', status='$status' where id = '$id'";
	$result = mysql_query($query,$roche) or die(mysql_error()); 
	$leibie = $_POST["leibie"];	 
	$number = $_POST["number"];
	$status_old = $_POST["status_old"];
	$email = $_POST["email"];  
    $name = $_POST["name"];
	$lianxiren = $_POST["lianxiren"];
	$username = $_POST["username"];
	$danwei = $_POST["danwei"];	 
#	if($status_old==0 && $status==1 ){
#		send_mail("$email","您的项目：".$name."已经启动","尊敬的".$lianxiren."老师\n您好！\n您在天昊生物(http://www.geneskybiotech.com )的项目：".$name." 已经启动，项目编号为：".$number."。您可以通过您的用户名($username)和您的密码(请见项目合同)登录后，查看实时进展记录。\n或者直接点击：http://www.geneskybiotech.com/orde_detail.php?id=$id 查看该项目的进展记录\n该邮件为系统自动发送，请勿回复！\n上海天昊生物竭诚为您服务！\n\n\n\n上海天昊生物技术服务中心\n上海张江高科技园区郭守敬路351号2号楼609室\n office phone:02150802060转12\n fax:02150802059 \n");
#		send_mail("liuduozi@gmail.com","项目：".$number."已经启动","刘博士：您好！\n项目：".$name." 已经启动，项目编号为：".$number."。");
#		send_mail("liuyan@geneskybiotech.com","项目：".$number."已经启动","王颖：您好！\n项目：".$name." 已经启动，项目编号为：".$number."。");	
#	}
	  
    if($leibie==0){ $dir="/home/snp/data/Projects/service/";}
    elseif($leibie==2){ $dir="/home/snp/data/Projects/product/";}
    elseif($leibie==1){$dir="/home/snp/data/Projects/research/";}
    elseif($leibie==3){$dir="/home/snp/data/Projects/test/";}
    elseif($leibie==4){$dir="/home/snp/data/Projects/Long_Term/";}
    elseif($leibie==5){$dir="/home/snp/data/Projects/Common_Project/";} 
    elseif($leibie==6){$dir="/home/snp/data/Projects/Small_Projects/";} 
	elseif($leibie==7){$dir="/home/snp/data/Projects/Scientific_Project/";} 
	if(preg_match("/^(SZ[0-9]+A[A-Z]+)([0-9*]+)/", $number,$match)){
        $pro_dir=$dir.$match[1]."_".$danwei."_".$lianxiren."/".$match[2];
		$pro_dir2=$dir."Completed/".$match[1]."_".$danwei."_".$lianxiren."/";
		if(!file_exists($pro_dir2)){  mkdir   ($pro_dir2,   0770);}
		$pro_dir2=$dir."Completed/".$match[1]."_".$danwei."_".$lianxiren."/".$match[2];
    }else{
        $pro_dir=$dir.$number."_".$name."_".$lianxiren;
		$pro_dir2=$dir."Completed/".$number."_".$name."_".$lianxiren;
    } 
 	if($status_old==1 && $status==2 ){
		rename($pro_dir,$pro_dir2);	 
		send_mail("$email","您的项目：".$name."已经完成","尊敬的".$lianxiren."老师：\n您好！\n您在苏州天昊(http://diagnostics.geneskies.com )的项目：".$name." 已经完成，项目编号为：".$number."。您可以通过您的用户名($username)和您的密码登录后，查看实时进展记录。并授权的情况下下载原始数据以及实验操作步骤说明等文件。\n\n该邮件为系统自动发送，请勿回复！\n天昊生物竭诚为您服务！\n\n\n\n天昊生物科技苏州有限公司版权所有\n江苏省苏州市苏州工业园区星湖街218号生物纳米园A2楼428单元 \n  电话：0512-62956558 传真：0512-62956358");
		echo "$email $lianxiren 的邮件已经发送成功！";
	//	 send_mail("yufeng@geneskies.com","您的项目：".$name."已经完成","尊敬的".$lianxiren."老师：\n您好！\n您在苏州天昊(http://diagnostics.geneskies.com )的项目：".$name." 已经完成，项目编号为：".$number."。您可以通过您的用户名($username)和您的密码登录后，查看实时进展记录。并授权的情况下下载原始数据以及实验操作步骤说明等文件。\n\n该邮件为系统自动发送，请勿回复！\n天昊生物竭诚为您服务！\n\n\n\n天昊生物科技苏州有限公司版权所有\n江苏省苏州市苏州工业园区星湖街218号生物纳米园A2楼428单元 \n  电话：0512-62956558 传真：0512-62956358");
	}
	if($status_old==2 && $status<2 ){	 rename($pro_dir2,$pro_dir);	}
	echo "<head>";
	echo "<meta http-equiv='Content-Type' content='text/html; charset=utf-8' />";
	echo "<meta http-equiv='refresh' content='3;url=project_show_x.php?id=".$id."'>";
	echo "</head>";
	echo "更新成功,3秒后自动跳转";
	exit ;
	}
ob_start();
$id = $_GET['id'];
?>
<style type="text/css">
.STYLE112 {color: #0000FF}
</style>
<table width="98%" border="0" align="center" cellpadding="5">
	<tr	 style="border-bottom:#0099CC 1px solid;">
		<td align="left">
			<strong><font color="#000000" size="+1" face="黑体，宋体, Times New Roman, Arial">项目详细信息</font></strong>
		</td>
		<td align="right"><img src="site_images/ras.gif" width="197" height="20" /></td>
	</tr>								
	<?php
	mysql_select_db($database_roche, $roche);
	$query = "Select * From project where id = $id ";
	$result = mysql_query($query,$roche) or die(mysql_error()); 
	while($row = mysql_fetch_array($result)){
		$name = $row[name];
		$number =$row[number];
		$username = $row[username];
		$danwei = $row[danwei];
		$lianxiren = $row[lianxiren];
		$xiazai = $row[xiazai];
		$dizhi = $row[dizhi];
		$tel = $row[tel];
		$chuanzhen = $row[chuanzhen];
		$email = $row[email];
		$downloads = $row[downloads];
		$date_end = $row[date_end];
		$date = $row[date];
		$status = $row[status];
		$leibie = $row[leibie];
		$creater=$row[creater];
		$intro = $row[intro];
		$finish = $row[finish];
		$date_f = $row[date_f];
		$date_j = $row[date_j];
	?>
	<tr>
		<td align="left" bgcolor="#EAEAEA" width="100%" colspan="2">
		<p>
			1、 项目名称： <?php echo $name ?> <br /><br />
			2、 项目编号：<?php echo $number ?>  <br /> <br />
			3、 用&nbsp;户&nbsp;名&nbsp; ：<?php echo $username ?>
		</p>
		<p>	4、 开始时间：<?php echo $date ?>	 </p>
		<p>	5、 项目类别：
		<?php 
			if($leibie==1){echo "研发项目";}
			elseif($leibie==0){echo "服务项目";}
			elseif($leibie==2) {echo "生产项目";}
			elseif($leibie==3) {echo "内部项目补充测试";}
			elseif($leibie==4){echo "长期合作服务项目";}
			elseif($leibie==5) {echo "普通服务项目";}
			elseif($leibie==6) {echo "小型服务项目";}	
			elseif($leibie==7) {echo "科研合作服务项目";}		
		?>
		</p>
		<p>	6、	 用户单位：<?php echo $danwei; ?> </p>
		<p>	7、  联&nbsp;系&nbsp;人&nbsp;：<?php echo $lianxiren; ?> </p>
		<p>	8、	 联系地址：<?php echo $dizhi; ?> </p>
		<p>	9、  E-mail&nbsp;&nbsp;&nbsp;：<?php echo $email; ?> </p>
		<p>	10、联系电话 ：<?php echo $tel ?> </p>
		<p>	11、传&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;真：<?php echo $chuanzhen ?></p>
		<p>	12、项目状态:
		<?php 
			if($status==0){ echo "确认";}
			if($status==1){	echo "启动";} 
			if($status==2){ echo "完成";} 
		?>
		</p>
		<p>	13、项目简介：<br></p>
		<p style="margin-left:30px;">	<span class="STYLE112"> <?php  echo str_replace("\n","<br>",$intro);  ?>  </span><br />	
		</p>
		<p>	14、建&nbsp;项&nbsp;人&nbsp;：<?php echo $creater;?></p>
		<p>	15、截止时间：<?php echo $date_end ?> </p>
		<?php if($role==7 || $role==6 || ($role==4 && ($leibie==0 || $leibie>=3 )) ||($role==5 && ($leibie==5 || $leibie==7 )) ){ ?>  
		<form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post" >
		<p style="margin-left:30px;"> 修改截止时间&nbsp;&nbsp;&nbsp;&nbsp;
			<input  name="date_end" value="<?php echo $date_end ?>" type="text"  /> 
		</p>
			<input  name="id" value="<?php echo $id ?>" type="hidden"  />
			<input  name="email" value="<?php echo $email ?>" type="hidden"  />
			<input  name="status_old" value="<?php echo $status ?>" type="hidden"  />
			<input  name="name" value="<?php echo $name ?>" type="hidden"  />
			<input  name="number" value="<?php echo $number ?>" type="hidden"  />
			<input  name="leibie" value="<?php echo $leibie ?>" type="hidden"  />
			<input  name="lianxiren" value="<?php echo $lianxiren ?>" type="hidden"  />
			<input  name="danwei" value="<?php echo $danwei ?>" type="hidden"  />
			<input  name="username" value="<?php echo $username ?>" type="hidden"  />
		<?php if($leibie>=0) {?>
		<p> 16、数据下载 : 
			<input <?php if ($xiazai==1) {echo "checked=\"checked\"";} ?> type="radio" name="xiazai" value="1" />可以下载 <label>
            <input <?php if ($xiazai==0) {echo "checked=\"checked\"";} ?> name="xiazai" type="radio" value="0"/>不能下载</label>
		<?php }?>
		<p>	17、完成时间:&nbsp;&nbsp;<input  name="date_f" value="<?php echo $date_f ?>" type="text" size="20"/>格式： 2009-04-09 </p>
		<p>	18、项目状态:
            <label>
			<select name="status" > 
				<option value="0" <?php if ($status==0) {echo "selected=\"selected\"";} ?>>建项</option>
                <option value="1" <?php if ($status==1) {echo "selected=\"selected\"";} ?>>启动</option>
                <option value="2" <?php if ($status==2) {echo "selected=\"selected\"";} ?>>完成</option>
                <?php if($role>=5){ ?>  <option value="3" <?php if ($status==3) {echo "selected=\"selected\"";} ?>>结清</option><?php } ?>
			</select>
            </label> 
		<p>	<input type="submit" name="submit" value=" 修改 " /></p>
		</form>	
		<?php }?>  							 
		</td>
	</tr>
	<?php } ?>	
</table>
<?php 
	require_once('smartyconfig.php');  
	$html="template_admin_p.php"; 
	$maincontent=ob_get_contents();
	ob_get_clean();
	$tpl->assign("maincontent",$maincontent);
	$tpl->display($html);
?>
