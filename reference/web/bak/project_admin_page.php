<?php require_once("check_admin.php"); ?>
<?php ob_start();?>
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
										<td width="500"></td>
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
										<td colspan="2" align="left" valign="top"><p><a href="project_add.php">项目添加</a></p>
										  <p><a href="project_show.php">项目查看和修改</a></p>
										  <p><a href="project_show_f.php">查看已经完成项目</a></p>
										  <p>&nbsp;</p></td>
								</tr>
								<tr>
										<td>&nbsp;</td>
										<td>&nbsp;</td>
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