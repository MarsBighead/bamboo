<?php require_once('Connections/roche.php'); ?>
<?php 
$username=$_SESSION['username'];
if ($_SESSION['role']<1){
echo "you are not the administrator,or your ip address is not allowed!";
exit;}
?>

<?php ob_start();?>
<?php $id = $_GET['id'];?>
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
 
if (!empty($_POST['submit'])){
	$pro_id = $_POST["pro_id"];
	$doing= $_POST["doing"];
	$jinzhan = $_POST["jinzhan"];
	$username = $_POST["username"];
	$date = date("Y-m-d   H:i:s");
	mysql_select_db($database_roche, $roche);
	$query111 =  sprintf( "insert into   project_user(pro_id,username,doing,jinzhan,date) values(%s,%s,%s,%s,%s )",
	            GetSQLValueString($pro_id, "text"), 
				GetSQLValueString($username, "text"), 
				GetSQLValueString($doing, "text"),
				GetSQLValueString($jinzhan, "text"),
				GetSQLValueString($date, "date"));
  	 $result11 = mysql_query($query111,$roche) or die(mysql_error());
	$query11 = "update `project` set view =view+1  where number = '$pro_id'";
	$result11 = mysql_query($query11,$roche) or die(mysql_error()); 
	echo "<head>";
	echo "<meta http-equiv='Content-Type' content='text/html; charset=utf-8' />";
	echo "<meta http-equiv='refresh' content='3;url=project_jinzhan.php?id=".$pro_id."'>";
	echo "</head>";
	echo "更新成功,3秒后自动跳转";
	exit ;
	}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" name="keywords" content="生物技术,天昊生物,测序,snp,PCR" />
<title></title>
 
<style type="text/css">
<!--
.STYLE115 {color: #0000FF}
-->
</style>
</head>
<body onLoad="initEditor();">
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
																<?php echo "$number";?>添加一条项目进展记录，</font></strong></td>
																<td align="right"><img src="site_images/ras.gif" width="197" height="20" /></td>
														</tr>
												</table></td>
								</tr>
								
 
								<tr>
										<td align="left" bgcolor="#EAEAEA" width="100%">
					 <?php
mysql_select_db($database_roche, $roche);
$query = "select *  from project_user where pro_id = '$id'  and username='$username'" ;
$result = mysql_query($query,$roche) or die(mysql_error()); 
while($row = mysql_fetch_array($result)){
 
$doing = $doing. $row[doing];
 }
 
?>
<br />
										<form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post">
										  <p>1、项目编号
										    <input  name="pro_id" value="<?php echo $id ?>" type="hidden" size="40"/>
											 
										    <?php echo $id ?> 
										    <br />
										    <br />
										   2、人员 <input  name="username" value="<?php echo $username ?>" type="hidden" size="40"/>
										    <?php echo $username ?> 
										    <br /> <br />
										    
										   3、工作内容   
									      <br>
									      <span class="STYLE115"><?php  echo str_replace("\n","<br>",$doing); ?></span></p>
										  <p>
									        <label></label>
										    4、进展详细<br>
										    <textarea name="jinzhan"     cols="80" rows="5"> </textarea>
										  </p>
										  <input type="submit" name="submit" value=" 提 交 " /> </p>
										  </form>									  </td>
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
