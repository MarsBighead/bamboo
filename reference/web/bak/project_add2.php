<?php require_once('Connections/roche.php'); ?>
<?php 
$type=$_GET['type'];
$role=$_SESSION['role'];
echo "$role";
$creatername=$_SESSION['username'];
if ($_SESSION['role']<1){
echo "you are not the administrator,or your ip address is not allowed!";
exit;}
?>

<?php ob_start();?>
<?php
 require_once('sendmail.php'); 
function generate_password( $length = 8 ) {
    // 密码字符集，可任意添加你需要的字符
    $chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
    $password = '';
    for ( $i = 0; $i < $length; $i++ )
    {
        $password .= $chars[ mt_rand(0, strlen($chars) - 1) ];
    }
    return $password;
}
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
	
if (  !empty($_POST['submit'])){
	$name = $_POST["name"];
	$number = $_POST["number"];
        $number=trim($number);       
        $number=str_replace(" ","",$number);
        $username = $_POST["username"];
	if($creatername=="018"){
	if(!(preg_match("/[0-9]+AAA[RDIZ]/",$number))){
	echo "$number you can not create,please check !";
	exit;
	}
	}
	$danwei = $_POST["danwei"];
	$leibie = $_POST["leibie"];
	$lianxiren = $_POST["lianxiren"];
	$dizhi = $_POST["dizhi"];
	$email = $_POST["email"];
	$tel = $_POST["tel"];
	$chuanzhen = $_POST["chuanzhen"];
	$intro = $_POST["intro"];
	$date_j2 = $_POST["date_j2"];
	$date_end = $_POST["date_end"];
	$showtime=date("Y-m-d");
	$usrsendmail=$_POST["usersendmail"];
	 mysql_select_db($database_roche, $roche);
	
	$status=0;
 
	if ($leibie==1 ){ $status=1;}
	if( $leibie==2){
	$status=1;
	$w3=date('w');
 $date_end=date("Y-m-d",strtotime("$date + 4   day"));
 if(preg_match("/[0-9]+AAA[EAFGHOPS]/",$number)){
  $date_end=date("Y-m-d",strtotime("$date + 7   day"));
  }
  elseif(preg_match("/[0-9]+AAA[BL]/",$number)){
  $date_end=date("Y-m-d",strtotime("$date + 5   day"));
  }
  elseif(preg_match("/[0-9]+AAA[CJ]/",$number)){
  $date_end=date("Y-m-d",strtotime("$date + 3   day"));
  }
   elseif(preg_match("/[0-9]+AAA[M]/",$number)){
   $date_num=5;
   $i=0;
   $j=1;
   while($i<$date_num){
     $date_end=date("Y-m-d",strtotime("$date + $j   day"));
     $week_day=date("w", strtotime($date_end) );
	 if($week_day>0 && $week_day<6){$i++;}
	 
	 
     $j++;
   }
    
   
  }
  
   } 	 

	$insertSQL = sprintf("INSERT INTO project (`name`,number,leibie,danwei,lianxiren,dizhi,email,tel,chuanzhen,username, date_end,intro,status,date,date_j2,creater ) VALUES (%s, %s, %d, %s, %s,%s,%s,%s,%s,%s,%s,%s,%d,%s,%s,%s)",
				GetSQLValueString($name, "text"), 
				GetSQLValueString($number, "text"), 
				GetSQLValueString($leibie, "int"), 
				GetSQLValueString($danwei, "text"), 
				GetSQLValueString($lianxiren, "text"),
				GetSQLValueString($dizhi, "text"),
				GetSQLValueString($email, "text"),
				GetSQLValueString($tel, "text"),
				GetSQLValueString($chuanzhen, "text"),
				GetSQLValueString($username, "text"), 
				GetSQLValueString($date_end, "text"), 
				GetSQLValueString($intro, "text"),
				GetSQLValueString($status, "int"),
				GetSQLValueString($showtime, "date"),
				GetSQLValueString($date_j2, "text"),
				GetSQLValueString($creatername, "text")); 
  		$Result1 = mysql_query($insertSQL, $roche) or die(mysql_error());
		 
	$count=count($_POST["huohao"]);
	for($i=0;$i<$count;$i++){
	$huohao=$_POST['huohao'][$i];
	$jiliang=$_POST['jiliang'][$i];
	$shuliang=$_POST['shuliang'][$i];
	$beizhu=$_POST['beizhu'][$i];
	$insertSQL1 = sprintf("INSERT into product_order(`number`,danwei,shuliang,beizhu,pro_id) values (%s,%s,%s,%s,%s)",
	GetSQLValueString($huohao, "text"), 
	GetSQLValueString($jiliang, "text"), 
	GetSQLValueString($shuliang, "text"), 
	GetSQLValueString($beizhu, "text"), 
	GetSQLValueString($number, "text"));
	$Result11 = mysql_query($insertSQL1, $roche) or die(mysql_error());
		 
	}
   if($leibie>0){  
	  $dir="/usr/local/apache/htdocs/geneskybiotech/download/";
	  $path=$dir.$number;
	  $oldumask=umask(0);
      if(preg_match("/^([0-9]+A[A-Z]+)([0-9]+.*)$/", $number,$match)){
		   
		  
		   $path_a=$dir.$match[1];
		   $path_a_1=$path_a."/".$match[2];
		  if(file_exists($path_a)){
		     if(file_exists($path_a_1));
			 else {mkdir   ($path_a_1,   0777);}
		  }
		  else { 
		  mkdir   ($path_a,   0777);
		  mkdir   ($path_a_1,   0777); }
		  
		 }
	else{
	  if(file_exists($path));
	  else {mkdir   ($path,   0777); }
	}	
	umask($oldumask); 
	}	 
		 
	 if($usrsendmail==1){
	$userped=generate_password();
	$userped_md=md5($userped);
	 $query = sprintf("INSERT INTO `user`(username,password,email,actnum,role,company,address,telephone,fax,receivemail,login_time) VALUES(%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
	                  GetSQLValueString($username, "text"),
					  GetSQLValueString($userped_md, "text"),
                       GetSQLValueString($email, "text"),
                       GetSQLValueString("0", "text"),
                       GetSQLValueString("0", "text"),
                       GetSQLValueString($danwei, "text"),
                       GetSQLValueString($dizhi,"text"),											 
                       GetSQLValueString($tel, "text"),
					   GetSQLValueString($chuanzhen, "text"),
					   GetSQLValueString(1, "int"),
					  GetSQLValueString($showtime, "date"));
    $result = mysql_query($query,$roche) or die(mysql_error()); 	
	send_mail("$email","您的项目：".$name."已建立","尊敬的".$lianxiren."老师\n您好！\n您在天昊生物(http://www.geneskybiotech.com )的项目：".$name." 已经启动，项目编号为：".$number."。您可以通过您的用户名($username)和您的密码($userped), 密码为系统自动生成，请自己修改，登录后，到客户中心的订单查询中查看实时进展记录。\n\n请您在收到密码后尽快修改初始密码，如由于密码遗失发生的数据丢失，天昊不承担相应责任。如您的遗失或者忘记密码请尽快联系我们进行密码重置。\n\n该邮件为系统自动发送，请勿回复！\n上海天昊生物竭诚为您服务！\n\n\n\n上海天昊生物技术服务中心\n上海张江高科技园区郭守敬路351号2号楼609室\n office phone:021-50802060转12\n fax:021-50802059 \n");
		 
	//	send_mail("lch@geneskybiotech.com","项目：".$number."已经建立","王颖：您好！\n项目：".$name." 已经启动，项目编号为：".$number."。用户名：".$username."密码：".$userped."。");
					  
	}
	echo "<head>";
	echo "<meta http-equiv='Content-Type' content='text/html; charset=utf-8' />";
	echo "<meta http-equiv='refresh' content='3;url=project_add.php'>";
	echo "</head>";
	echo "更新成功,3秒后自动跳转";
	exit ;
	}
if(!empty($_POST['change'])){
$username=$_POST["username"];
$name=$_POST["name"];
$number=$_POST["number"];
mysql_select_db($database_roche, $roche); 
$result=mysql_query("select *  from project where username='$username' " );

while($row=@mysql_fetch_array($result)){
  $danwei=$row[danwei];
   $lianxiren=$row[lianxiren];
   $dizhi=$row[dizhi];
  $email=$row[email];
  $tel=$row[tel];
   $chuanzhen=$row[chuanzhen];
  
  } } 

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8" name="keywords" content="生物技术,天昊生物,测序,snp,PCR" />
<title></title>
 

<style type="text/css">
<!--
.STYLE1 {color: #FF0000}
-->
</style>
</head>

<script language="javascript">
function doCheck()
{
if(!test_username(document.form1.number.value))
{
alert("项目编号不正确");
return false;
} 

    var pattern2 = /^\d+A/;
	var pattern3 = /^\d+D/;
        if(pattern2.test(form1.number.value) && form1.leibie.value>2){
           alert("项目类别选择不正确");
		   form1.leibie.focus();
		   return false;
          }
	 if(!pattern2.test(form1.number.value) && form1.leibie.value<3){
           alert("项目类别选择不正确");
		   form1.leibie.focus();
		   return false;
          }	  
	if (form1.name.value==""){
		alert("项目名称不可为空");
		form1.name.focus();
		return false;
	}
	if (form1.username.value==""){
		alert("用户名不可为空");
		form1.username.focus();
		return false;
	}
	
		if (form1.danwei.value==""){
		alert("用户单位不可为空");
		form1.danwei.focus();
		return false;
	}
	
		if (form1.lianxiren.value==""){
		alert("用户的联系人不可为空");
		form1.lianxiren.focus();
		return false;
	}
		if (form1.dizhi.value==""){
		alert("用户的联地址不可为空");
		form1.dizhi.focus();
		return false;
	}
			if (form1.tel.value==""){
		alert("用户电话不可为空");
		form1.tel.focus();
		return false;
	}
			if (form1.intro.value==""){
		alert("项目信息不可为空");
		form1.intro.focus();
		return false;
	}
		var str = form1.email.value; 
	var re = /^[\w-]+(\.[\w-]+)*@([\w-]+\.)+[a-zA-Z]{2,7}$/; 
	if (!str.match(re)) { 
		alert("您输入的不是有效的e-mail地址."); 
		form1.email.focus();
		form1.email.select();
		return false; 
	} 
	
return true;

function test_username(str_username)
{
var pattern = /[a-z0-9A-Z_]/;
if(pattern.test(str_username))
return true;
else
return false;
} 
}
</script>
<body   >

<table width="100%" border="0" align="center" bgcolor="#FFFFFF" height="400">
		<tr>
				<td valign="top"><table width="98%" border="0" align="center" cellpadding="5">
								<tr height="3">
										<td width="100"></td>
								</tr>
								<tr>
										<td colspan="2" ><table width="100%" border="0" style="border-bottom:#0099CC 1px solid;" align="center">
														<tr>
																<td align="left"><strong><font color="#000000" size="+1" face="黑体，宋体, Times New Roman, Arial"><br>
																  <?php if($type==2){echo "添加产品订购信息";} else {echo "项目添加";}?>
																</font></strong></td>
																<td align="right"><img src="site_images/ras.gif" width="197" height="20" /></td>
														</tr>
												</table></td>
								</tr>

								<tr>
										<td align="left" bgcolor="#EAEAEA" width="100%">
										<br />
										<form  name="form1"   action="<?php echo $_SERVER['PHP_SELF'] ?>"  method="post">
										  <p>1、<?php if($type==2){echo "订单名称";} else {echo "项目名称";}?>
										    <input  name="name"  value="<?php echo  $name ; ?>" type="text" size="40"/>
										    <span class="STYLE1">*</span><br />
										    <br />
										   2、<?php if($type==2){echo "订单编号";} else {echo "项目编号";}?>
										    <input  name="number"  value="<?php if($creatername==018) {echo  "11AAA" ; }  else{echo "$number" ;}?>" type="text" size="20"/>
										    <span class="STYLE1">*</span><br /> <br />

										   3、<?php if($type==2){echo "订单用户";} else {echo "项目用户";}?>
										    <input  name="username"  value="<?php echo  $username ; ?>"type="text" size="20"   />
									        <label>
									        <span class="STYLE1">*</span>
									        <input type="submit" name="change" value="已有用户" />
									        </label>
										  (为用户网络登录名)</p>
										  <p>4、<?php if($type==2){echo "产品订购";} else {echo "项目类别";}?>
										    <label>
										     <select name="leibie"   >
										       <?php if($type==2) {?>
											     <option value="0"  >产品订购</option>
												 
									 
												<?php 
												 }
												  elseif($creatername =="008"  || $creatername =="018"){
												?>
												  <option value="1"  >长期合作非持续性项目</option>
										       <option value="2" selected="selected"   >长期合作持续性重复项目</option>
									 
												<?php 
												 }
												   elseif($creatername =="011"){
												?>
												   <option value="5"  >科研合作项目</option>
												<?php 
												 }
												 
												  else {?>
										       <option value="1"  >长期合作非持续性项目</option>
										       <option value="2" selected="selected"   >长期合作持续性重复项目</option>
										       <option value="3"  >普通合同项目</option>
										       <option value="4"  >普通订单小项目</option>
											   <option value="5"  >科研合作项目</option>
											   <?php }?>
						                    </select>
										    </label>
									        <span class="STYLE1">*</span>
								          <?php if($role==5){echo "对于项目经理只能添加长期合作持续性项目，此项不能填";}?> </p>
										  <p>5、<?php if($type==2){echo "订购单位";} else {echo "项目单位";}?>
										    <input  name="danwei" type="text" value="<?php echo  $danwei ; ?>" size="40"/>
									        <span class="STYLE1">*</span></p>
										  <p>6、<?php if($type==2){echo "订单联系人";} else {echo "项目联系人";}?>
										    <input  name="lianxiren" type="text" value="<?php echo  $lianxiren ; ?>" size="20"/>
										    <span class="STYLE1">*</span></p>
										  <p>7、联系地址
										    <input  name="dizhi" type="text" value="<?php echo  $dizhi ; ?>" size="40"/>
									      <span class="STYLE1">*</span>									      </p>
										  <p>8、联系email
										    <input  name="email" type="text" value="<?php echo  $email ; ?>"  size="40"/>
									        <span class="STYLE1">*</span></p>
										  <p>9、联系电话
										    <input  name="tel" type="text" value="<?php echo  $tel ; ?>"  size="40"/>
										    <span class="STYLE1">*</span></p>
										   <p>10、传真
										     <input  name="chuanzhen" type="text" value="<?php echo  $chuanzhen ; ?>"  size="40"/>
										  </p>
										   <p>11、合同承诺截止日期
										     <input  name="date_end" type="text" size="20"/>
										     格式：项目启动后10个工作日 </p>
                                           <p>12、内部截止日期
										     <input  name="date_j2" type="text" size="20"/>
										     格式：1984-09-06
										   </p>
                                           <?php if($type==2){?>12、货号
										  <input  name="huohao[0]" type="text" size="10"  />
										   
										  计量单位
										  <input  name="jiliang[0]" type="text" size="5"  /> 
										  数量
										  <input  name="shuliang[0]" type="text" size="5"  />
										  备注
										  <input name="beizhu[0]" type="text" value="" size="10" />
										  <input type=button value="Add" onclick='additem("tb")'> 
										   <table id="tb"></table>  
										   <script language="javascript">  
var file_count = 1;
function additem(id){  
    var row,cell,str;  
    row = eval("document.all["+'"'+id+'"'+"]").insertRow();  
    if(row != null ){  
        cell = row.insertCell();  
    //    str="员工<input type="+'"'+"text"+'"'+" name="+'"'+"worker[' + file_count + ']"+'"'+">工作内容<input type="+'"'+"text"+'"'+"  size="+'"'+"40"+'"'+" name="+'"'+"work[' + file_count + ']"+'"'+"><input type="+'"'+"button"+'"'+" value="+'"'+"delete"+'"'+" onclick='deleteitem(this,"+'"'+"tb"+'"'+");'>"  
        str='货号<input name="huohao[' + file_count + ']" tpye="text" size="10" /> 计量单位<input  name="jiliang[' + file_count + ']" type="text" size="5"  />数量<input  name="shuliang[' + file_count + ']" type="text" size="5"  />备注<input  name="beizhu[' + file_count + ']" type="text" size="10"  />';

    str += "&nbsp;<input type="+'"'+"button"+'"'+" value="+'"'+"删除"+'"'+"   onclick='deleteitem(this,"+'"'+"tb"+'"'+");'><br>";
	    cell.innerHTML=str;  
		file_count++;
    }  
}  
function deleteitem(obj,id){  
    var rowNum,curRow;  
    curRow = obj.parentNode.parentNode;  
    rowNum = eval("document.all."+id).rows.length - 1;  
    eval("document.all["+'"'+id+'"'+"]").deleteRow(curRow.rowIndex);
	file_count--;  
}  
</script> 
										   <?php }else{?>
										   
										   
										   

										  <p>12、项目简介<br>
										    <textarea name="intro" cols="80" rows="8"></textarea>
										    <span class="STYLE1">*</span><br />
											<?php }?>
										    </p>
										  <p>
										    <label>
										    13、自动创建用户名：
										    <input type="checkbox" name="usersendmail" value="1" />
										    </label>
										    <span class="STYLE1">(勾上将会自动创建上面填写的项目用户名并将该用户名和自动生成的随机密码发送到用户联系人邮箱)</span><br>
										    打<span class="STYLE1">*</span>为必填项目</p>
										  <p><input type="submit" name="submit" value=" 提 交 " onclick="javascript:return doCheck()"    /> </p>

										</form>					
										
										
								  </td>
								</tr>
								<tr>
										<td>&nbsp;</td>
								</tr>
						</table></td>
		</tr>
</table>
</body>
</html>
<?php require_once('smartyconfig.php'); 
 
 $html="template_admin_p.php"; 
$maincontent=ob_get_contents();
ob_get_clean();
$tpl->assign("maincontent",$maincontent);
$tpl->display($html);
?>
