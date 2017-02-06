<?php require_once('Connections/roche.php'); ?>
<?php 
if ($_SESSION['role']<4){
	echo "you are not the administrator,or your ip address is not allowed!";
	echo "<meta http-equiv='refresh' content='0;url=loginerr.php'>";
	exit;
}
ob_start();
$id = $_GET['id'];
$action = $_GET['action'];
$username = $_GET['username'];
$leibie=$_GET['type'];
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
if($action=="del"){
	$pid = $_GET['pid'];
	$deluser=$_GET['deluser'];
	$leibie=$_GET['type'];
	mysql_select_db($database_roche, $roche);
	$sql_user = "select * from username where userid='$deluser' ";
	$result_user=mysql_query($sql_user);
	$row_user=@mysql_fetch_array($result_user);
	$jinzhan_username=$row_user[username2];
		 
	if($leibie==0){ 
		$dir="/home/snp/data/Projects/service/";
	}else{
		$dir="/home/snp/data/Projects/research/";}
	$pro_dir=$dir.$number."*";
	system("setfacl -m u:$jinzhan_username:--- $pro_dir ");
	$query111 =  sprintf( "delete from project_user where pid='$pid'  ");
	$result11 = mysql_query($query111,$roche) or die(mysql_error());   
	echo "<script>";
	echo "alert (\"删除安排已经完成\");";
	echo "</script>";
	echo "<head>";
	echo "<meta http-equiv='Content-Type' content='text/html; charset=utf-8' />";
	echo "<meta http-equiv='refresh' content='3;url=project_anpai.php?id=".$id."'>";
 	echo "</head>";
	exit ;
 }
if (!empty($_POST['submit'])){
	$number = $_POST["number"];
	$count=count($_POST["worker"]);
	$leibie1 = $_POST["leibie1"];
	$showtime=date("Y-m-d   H:i:s");
	     
	mysql_select_db($database_roche, $roche);
	for($i=0;$i<$count;$i++){
		echo  $_POST["worker"][$i] ;
		$work_name=$_POST["worker"][$i];
		if($work_name!=0){
			if($work_name==1){		$names = array("2011003","2011009","2011011");		}
			elseif($work_name==2){	   $names = array("2011002","2011024");	   }
			elseif($work_name==3){	   $names = array("2011004","2011022");	   }
			elseif($work_name==4){	   $names = array("2011016");   }
			elseif($work_name==5){	   $names = array("2011012","2011023");	   } 
			elseif($work_name==6){	   $names = array("2011019");	   } 
			elseif($work_name==7){	   $names = array("2011010");	   } 
	        elseif($work_name==8){	   $names = array("2011007","2011028","2011026");	   }   
			elseif($work_name==9){	   $names = array("2011008");	   }  
			elseif($work_name==10){	   $names = array("2011030");	   }
			elseif($work_name==11){	   $names = array("002");	   }
			elseif($work_name==12){	   $names = array("2011003","2011009","2011028","2011011");	   } 
			else{  $names = array($work_name);} 	   
		}
		echo "$work_name\t"; 
		foreach($names as $insert_name){	 
			$jinzhan_user=$insert_name;
			$query111 =  sprintf( "insert into   project_user(pro_id,username,doing,work,date) values(%s,%s,%s,%s,%s)",
	        GetSQLValueString($number, "text"), 
			GetSQLValueString($jinzhan_user, "text"), 
			GetSQLValueString($_POST["work"][$i], "text"),
			GetSQLValueString($_POST["work_2"][$i],"text"),
			GetSQLValueString($showtime, "date"));
			$result11 = mysql_query($query111,$roche) or die(mysql_error());	
			$sql_user = "select * from username where userid='$jinzhan_user' ";	    
			$result_user=mysql_query($sql_user);
			$row_user=@mysql_fetch_array($result_user);
			$jinzhan_username=$row_user[username2];      
            if($leibie1==0){ $dir="/home/snp/data/Projects/service/";}
			elseif($leibie1==2){ $dir="/home/snp/data/Projects/product/";}
			elseif($leibie1==1){$dir="/home/snp/data/Projects/research/";}
			elseif($leibie1==3){$dir="/home/snp/data/Projects/Internal_Project/";}
			elseif($leibie1==4){$dir="/home/snp/data/Projects/Long_Term/";}
			elseif($leibie1==5){$dir="/home/snp/data/Projects/Common_Project/";}
			elseif($leibie1==6){$dir="/home/snp/data/Projects/Small_Projects/";}
			elseif($leibie1==7){$dir="/home/snp/data/Projects/Scientific_Project/";}
            if(preg_match("/^(SZ[0-9]+A[A-Z]+)([0-9*]+)/", $number,$match)){
				$pro_dir=$dir.$match[1]."*/".$match[2];
            }else{$pro_dir=$dir.$number."*";     } 
		//echo "setfacl -m u:$jinzhan_username:rwx $pro_dir";
		system("setfacl -m u:$jinzhan_username:rwx $pro_dir ");	 
		}
	}
	$query = "update `project` set view = 1  where number = '$number'";
	$result = mysql_query($query,$roche) or die(mysql_error()); 
 	echo "<head>";
	echo "<meta http-equiv='Content-Type' content='text/html; charset=utf-8' />";
	echo "<meta http-equiv='refresh' content='3;url=project_anpai.php?type=".$leibie1."&id=".$number."'>";
	echo "</head>";
	echo "更新成功,3秒后自动跳转";
	exit ;
}
	
if (!empty($_POST['change'])){
	$number = $_POST["number"];
	$count=count($_POST["worker"]);
	$leibie2 = $_POST["leibie2"];
	mysql_select_db($database_roche, $roche);
	for($i=0;$i<$count;$i++){
		$username=$_POST['worker'][$i];
		$doing=$_POST['work'][$i];
		$pid= $_POST["pid"][$i];
		$work_2= $_POST["work_2"][$i];
		$lastname=$_POST['lastname'][$i];	 
		$query111 =  "update   project_user set doing='$doing',username='$username',work='$work_2' where  pid=$pid";
		$result11 = mysql_query($query111,$roche) or die(mysql_error());
		$sql_user = "select * from username where userid='$lastname' ";
		$result_user=mysql_query($sql_user);
		$row_user=@mysql_fetch_array($result_user);
		$jinzhan_username=$row_user[username2];
		$sql_user2 = "select * from username where userid='$username' ";
		$result_user2=mysql_query($sql_user2);
		$row_user2=@mysql_fetch_array($result_user2);
		$jinzhan_username2=$row_user2[username2];
	    if($leibie2==0){ $dir="/home/snp/data/Projects/service/";}
        elseif($leibie2==2){ $dir="/home/snp/data/Projects/product/";}
        elseif($leibie2==1){$dir="/home/snp/data/Projects/research/";}
        elseif($leibie2==3){$dir="/home/snp/data/Projects/Internal_Project/";}
        elseif($leibie2==4){$dir="/home/snp/data/Projects/Long_Term/";}
        elseif($leibie2==5){$dir="/home/snp/data/Projects/Common_Project/";}
        elseif($leibie2==6){$dir="/home/snp/data/Projects/Small_Projects/";}
        elseif($leibie2==7){$dir="/home/snp/data/Projects/Scientific_Project/";}
        if(preg_match("/^(SZ[0-9]+A[A-Z]+)([0-9*]+)/", $number,$match)){
            $pro_dir=$dir.$match[1]."*/".$match[2];
        }else{$pro_dir=$dir.$number."*"; }
        system("setfacl -m u:$jinzhan_username2:rwx $pro_dir ");
		echo "setfacl -m u:$jinzhan_username2:rwx $pro_dir ";	
		if($jinzhan_username != $jinzhan_username2 ) {system("setfacl -m u:$jinzhan_username:--- $pro_dir ");
			system("setfacl -m u:$jinzhan_username2:rwx $pro_dir ");
            echo "$pro_dir   ";	    
		}
	 
    }
	$query113 = "update `project` set view = 1  where number = '$number'"; 
	echo "<head>";
	echo "<meta http-equiv='Content-Type' content='text/html; charset=utf-8' />";
	echo "<meta http-equiv='refresh' content='3;url=project_anpai.php?type=".$leibie2."&id=".$number."'>";
	echo "</head>";
	echo "更新成功,3秒后自动跳转";
	exit ;
}
?>

<table width="98%" border="0" align="center" cellpadding="5" bgcolor="#FFFFFF" height="400">
	<tr  style="border-bottom:#0099CC 1px solid;">
		<td align="left">
			<strong><font color="#000000" size="+1" face="黑体，宋体, Times New Roman, Arial">安排项目,项目编号：<?php echo "$id";?></font></strong>
		</td>
		<td align="right"><img src="site_images/ras.gif" width="197" height="20" /></td>
	</tr>
	<tr>
		<td width="100%" height="170" align="left" bgcolor="#EAEAEA" colspan="2">
		<br />
		<form  name="doublecombo" action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post">
		<input  name="leibie1"     value="<?php echo "$leibie"; ?>" type="hidden" size="20" />
		<p>项目安排:                                          
		<p>项目编号<input  name="number" value="<?php echo "$id"; ?>"  type="text" size="20"/><br> <br>
		<label>工作组
			<?php
			mysql_select_db($database_roche, $roche);
			global $arr,$db;
			$sql = "select * from username  ";
			$result=mysql_query($sql);
			while ($i=@mysql_fetch_array($result)){   $arr[] =$i;} 
			?>
			<select name="worker[0]"     id="trest" onChange="redirect(this.options.selectedIndex)"> 
				<option value="0">请选择</option>
				<option value="1">余锋组</option>
				<option value="2">张希组</option>
				<option value="3">胡军瑜组</option>
				<option value="4">刘德远组</option>
				<option value="5">陶静组</option>
				<option value="6">杨娜组</option>
				<option value="7">辛秋红组</option>
				<option value="8">陈晓燕组</option>
				<option value="9">张莹组</option>
				<option value="10">逯昌华组</option>
				<option value="11">李才华组</option>
				<option value="12"  >余锋-检测组</option>					
			</select>
			组员:
			<select name="stage2" size="1"   > 
				<option value="0"  >请选择</option>
			</select>			
			<script> 
			<!-- 
			/* 
			Double Combo Script Credit 
			By Website Abstraction (www.wsabstract.com) 
			Over 200+ free javascripts here! 
			*/ 
			var groups=document.doublecombo.trest.options.length 
			var group=new Array(groups) 
			for (i=0; i<groups; i++) 
				group[i]=new Array() 
				group[0][0] = new Option("请选择", " ");
				group[1][0] = new Option("余锋", " ");
				group[1][1] = new Option("王磊", " ");
				group[1][2] = new Option("姜丽丽", " ");
				group[2][0] = new Option("张希", " ");
				group[2][1] = new Option("沈蕾", " ");
				group[3][0] = new Option("胡军瑜", " ");
				group[3][1] = new Option("张桂平", " ");
				group[4][0] = new Option("刘德远", " ");
				group[5][0] = new Option("陶静", " ");
				group[5][1] = new Option("孙银萍", " ");
				group[6][0] = new Option("杨娜", " ");
				group[7][0] = new Option("辛秋红", " ");
				group[8][0] = new Option("陈晓燕", " ");
				group[9][0] = new Option("张莹", " ");
				group[10][0] = new Option("逯昌华", " ");
				group[11][0] = new Option("李才华", " ");
				group[12][0] = new Option("余锋", " ");
				group[12][1] = new Option("王磊", " ");
				group[12][2] = new Option("高扬", " ");
				group[12][3] = new Option("姜丽丽", " ");
			var temp=document.doublecombo.stage2 
			function redirect(x){ 
				for (m=temp.options.length-1;m>0;m--) 
					temp.options[m]=null 
				for (i=0;i<group[x].length;i++){ 
					temp.options[i]=new Option(group[x][i].text,group[x][i].value) 
				} 
				temp.options[0].selected=true 
			}  
			//--> 
			</script>
		</label><br> <br>
		<label>工作量 <input name="work_2[0]" type="text" size="20"  /></label> 
		<p><label>工作内容<br> <textarea name="work[0]" cols="60" rows="10"></textarea> </label>
			<input type=button value="Add" onclick='additem("tb")'>  
			<table id="tb"></table>  
			<script language="javascript">  
			var file_count = 1;
			function additem(id){  
				var row,cell,str;  
				row = eval("document.all["+'"'+id+'"'+"]").insertRow();  
				if(row != null ){  
					cell = row.insertCell();  
				//  str="员工<input type="+'"'+"text"+'"'+" name="+'"'+"worker[' + file_count + ']"+'"'+">工作内容<input type="+'"'+"text"+'"'+"  size="+'"'+"40"+'"'+" name="+'"'+"work[' + file_count + ']"+'"'+"><input type="+'"'+"button"+'"'+" value="+'"'+"delete"+'"'+" onclick='deleteitem(this,"+'"'+"tb"+'"'+");'>"  
					str='员工<select name="worker[' + file_count + ']"><option value="0" selected="selected">请选择员工</option><option value="2011001">周舜锋</option><option value="2011002">张希</option><option value="2011003">余锋</option><option value="2011004">胡军瑜</option><option value="2011005">姜龙森</option><option value="2011006">姚忻岑</option><option value="2011007">陈小燕</option><option value="2011008">张莹</option><option value="2011009">王磊</option><option value="2011010">辛秋红</option><option value="2011011">姜丽丽</option><option value="2011012">陶婧</option><option value="2011019">杨娜</option><option value="002">李才华</option><option value="011">姜正文</option></select><br><label>工作量<input name="work_2[' + file_count + ']" type="text" size="20"  /> </label> 工作内容<br><textarea name="work[' + file_count + ']" cols="60" rows="10"></textarea> ';
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
			</p>
			<input type="submit" name="submit" value=" 提 交 " /> 
			</form>	
		</td>
	</tr>
	<tr>
		<td height="74"  align="left" bgcolor="#EAEAEA" colspan="2">
			<p> <span class="css_me"><br><br>该项目已经有的安排情况</span> </p>
			<form id="form1" name="form1" method="post"  action="<?php echo $_SERVER['PHP_SELF'] ?>">
			<input  name="leibie2"  type="hidden"   value="<?php echo "$leibie"; ?>" size="20"  />
            <p><p>项目编号<input  name="number" value="<?php echo "$id"; ?>"  type="text" size="20"/></p>
			<?php
			mysql_select_db($database_roche, $roche);
			$j=0;
			$query = "select *  from project_user where pro_id = '$id'  and doing <> ''  ";
			$result = mysql_query($query,$roche) or die(mysql_error()); 
			while($row = mysql_fetch_array($result)){
				$pid = $row[pid];
				$pro_id = $row[pro_id];
				$username = $row[username];
				$doing = $row[doing];
				$jinzhan = $row[jinzhan];
				$date = $row[date];
				$work_2 = $row[work];
			?>     
			<p>人员 <input  name="lastname[<?php echo "$j"; ?>]" value="<?php echo "$username"; ?>"  type="hidden" size="20"/>
			<input  name="pid[<?php echo "$j"; ?>]" value="<?php echo "$pid"; ?>"  type="hidden" size="20"/>
			<select name="worker[<?php echo "$j"; ?>]">
			<?php
			for ($i=0;$i<count($arr);$i++) {
			?>
			<option value="<?php echo $arr[$i]["userid"] ?>"  <?php if ( $username==$arr[$i]["userid"]) {echo "selected=\"selected\"";} ?>><?php echo $arr[$i]["username"] ?></option>
			<?php }?>
			</select>
			<p>工作量<input name="work_2[<?php echo "$j"; ?>]" value="<?php echo "$work_2"; ?>"   type="text" size="20"  />
            <p>工作内容<br> <textarea name="work[<?php echo "$j"; ?>]" cols="60" rows="10"><?php echo $doing ?></textarea>
			<?php echo "<a target='_blank' class='bluelink' href='project_anpai.php?id=$id&pid=$pid&tpye=$leibie&deluser=$username&action=del'>删除此项</a>";?> 
			<p>
			<?php 
				$j++;
			}?>
			<input type="submit" name="change" value=" 修改 " /> </p>
			</form>
		</td>
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
