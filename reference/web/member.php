<?php require_once('Connections/roche.php'); ?>
<?php require_once('smartyconfig.php'); 
ob_start()
?>
<?php
session_start(); 
if (empty($_SESSION['username'])){
	$_SESSION['loginerr']="您访问的页面需要先登录";
	header("location:loginerr.php");
	exit;
}
?>
<style type="text/css">
<!--
.css_dingdan {color: #0000FF}
-->
</style>


 
 




<table width="100%" border="0" align="center" cellpadding="8" cellspacing="0" bgcolor="#F8F8F8" style="line-height:18px">
		<!--DWLayoutTable-->
		<tr height="3">
				<td width="100%" height="3" align="left" valign="top" ></td>
		</tr>
		<tr>
		  <td height="148" align="left" valign="top" style="font-size:7pt">
						<table width="99%" border="0" class="smalltable">
								 
								
								<tr>
										<td  >  
			                              <p>
			                    
                                  欢迎您<?php echo $_SESSION['username'] ?></p>
	                              </td>
  </tr>
  	    
	 	  </table>	  
			    	  <?php
mysql_select_db($database_roche, $roche);
$query=sprintf("select * from project where username = '%s'", $_SESSION['username']);
 $result = mysql_query($query,$roche) or die(mysql_error()); 
 $hangshu = mysql_affected_rows(); 
while($row = mysql_fetch_array($result)){
  $id =$row[id];
  $username =$row[username];
  $name = $row[name];
  $date =$row[date];
  $title =$row[title];
  $score=$row[score];
   
  }
?>	
					    <table width="100%"><tr>
			    	      <td  ><p>您总共<?php echo $hangshu ?>有项订单，点击查看<a href="member_order.php" class="css_dingdan">订单信息</a></p>
		    	            <p>&nbsp;</p></td>
			    	    </tr></table></td>
  </tr>
</table>		 	    	
<?php
$maincontent=ob_get_contents();
ob_get_clean();
$tpl->assign("maincontent",$maincontent);
$tpl->display('template_member.php');

?>
