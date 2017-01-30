<?php require_once('Connections/roche.php'); ?>
<?php 
if ($_SESSION['role']<4){
echo "you are not the administrator,or your ip address is not allowed!";
exit;}
?>

<?php ob_start();?>
<?php $id = $_GET['id'];
?>
<?php $action = $_GET['action'];
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
     
	   if($leibie==0){ $dir="/home/snp/data/Projects/service/";}
	  else{$dir="/home/snp/data/Projects/research/";}
	 $pro_dir=$dir.$number."*";
	 system("setfacl -m u:$jinzhan_username:--- $pro_dir ");

  $query111 =  sprintf( "delete from project_user where pid='$pid'  ");
   $result11 = mysql_query($query111,$roche) or die(mysql_error());
   
   echo "<script>";
	echo "alert (\"删除安排已经完成\");";
	echo "</script>";
	echo "<head>";
	echo "<meta http-equiv='Content-Type' content='text/html; charset=utf-8' />";
	echo "<meta http-equiv='refresh' content='3;url=project_anpai.php?id=".$number."'>";
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
	 $query111 =  sprintf( "insert into   project_user(pro_id,username,doing,work,date) values(%s,%s,%s,%s,%s)",
	            GetSQLValueString($number, "text"), 
				GetSQLValueString($_POST["worker"][$i], "text"), 
				GetSQLValueString($_POST["work"][$i], "text"),
				GetSQLValueString($_POST["work_2"][$i], "text"),
				GetSQLValueString($showtime, "date"));
  	 $result11 = mysql_query($query111,$roche) or die(mysql_error());
	 $jinzhan_user=$_POST["worker"][$i];
	   $sql_user = "select * from username where userid='$jinzhan_user' ";
	    
       $result_user=mysql_query($sql_user);
	   $row_user=@mysql_fetch_array($result_user);
       $jinzhan_username=$row_user[username2];
      
	   if($leibie1==0){ $dir="/home/snp/data/Projects/service/";}
	  else{$dir="/home/snp/data/Projects/research/";}
	 $pro_dir=$dir.$number."*";
	 system("setfacl -m u:$jinzhan_username:rwx $pro_dir ");
	  
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
	 $leibie2 = $_POST["liebie2"];
	  
	   
	mysql_select_db($database_roche, $roche);
	 for($i=0;$i<$count;$i++){
	 $username=$_POST['worker'][$i];
	 $doing=$_POST['work'][$i];
	 $pid= $_POST["pid"][$i];
	 $work_2= $_POST["work_2"][$i];
	 $lastname=$_POST['lastname'][$i];
	 echo "$lastname $username $doing";
	 $query111 =  "update   project_user set doing='$doing',username='$username',work='$work_2' where  pid=$pid";
  	 $result11 = mysql_query($query111,$roche) or die(mysql_error());
	 
	 if($lastname != $username){
	  
	   $sql_user = "select * from username where userid='$lastname' ";
       $result_user=mysql_query($sql_user);
	   $row_user=@mysql_fetch_array($result_user);
       $jinzhan_username=$row_user[username2];
      $sql_user2 = "select * from username where userid='$username' ";
       $result_user2=mysql_query($sql_user2);
	   $row_user2=@mysql_fetch_array($result_user2);
       $jinzhan_username2=$row_user2[username2];
	   if($leibie2==0){ $dir="/home/snp/data/Projects/service/";}
	  else{$dir="/home/snp/data/Projects/research/";}
	 $pro_dir=$dir.$number."*";
	 system("setfacl -m u:$jinzhan_username2:rwx $pro_dir ");
	  system("setfacl -m u:$jinzhan_username:--- $pro_dir ");
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
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" name="keywords" content="生物技术,天昊生物,测序,snp,PCR" />
<title></title>
<script type="text/javascript">
  _editor_url = "htmledit/";
  _editor_lang = "en";
</script>
		<script type="text/javascript" src="htmledit/htmlarea.js"></script>
<script type="text/javascript">
var editor = null;
function initEditor() {
  editor = new HTMLArea("message");

  // comment the following two lines to see how customization works
  editor.generate();
  return false;

  var cfg = editor.config; // this is the default configuration
  cfg.registerButton({
    id        : "my-hilite",
    tooltip   : "Highlight text",
    image     : "ed_custom.gif",
    textMode  : false,
    action    : function(editor) {
                  editor.surroundHTML("<span class=\"hilite\">", "</span>");
                },
    context   : 'table'
  });

  cfg.toolbar.push(["linebreak", "my-hilite"]); // add the new button to the toolbar

  // BEGIN: code that adds a custom button
  // uncomment it to test
  var cfg = editor.config; // this is the default configuration
  /*
  cfg.registerButton({
    id        : "my-hilite",
    tooltip   : "Highlight text",
    image     : "ed_custom.gif",
    textMode  : false,
    action    : function(editor) {
                  editor.surroundHTML("<span class=\"hilite\">", "</span>");
                }
  });
  */

function clickHandler(editor, buttonId) {
  switch (buttonId) {
    case "my-toc":
      editor.insertHTML("<h1>Table Of Contents</h1>");
      break;
    case "my-date":
      editor.insertHTML((new Date()).toString());
      break;
    case "my-bold":
      editor.execCommand("bold");
      editor.execCommand("italic");
      break;
    case "my-hilite":
      editor.surroundHTML("<span class=\"hilite\">", "</span>");
      break;
  }
};
cfg.registerButton("my-toc",  "Insert TOC", "ed_custom.gif", false, clickHandler);
cfg.registerButton("my-date", "Insert date/time", "ed_custom.gif", false, clickHandler);
cfg.registerButton("my-bold", "Toggle bold/italic", "ed_custom.gif", false, clickHandler);
cfg.registerButton("my-hilite", "Hilite selection", "ed_custom.gif", false, clickHandler);

cfg.registerButton("my-sample", "Class: sample", "ed_custom.gif", false,
  function(editor) {
    if (HTMLArea.is_ie) {
      editor.insertHTML("<span class=\"sample\">&nbsp;&nbsp;</span>");
      var r = editor._doc.selection.createRange();
      r.move("character", -2);
      r.moveEnd("character", 2);
      r.select();
    } else { // Gecko/W3C compliant
      var n = editor._doc.createElement("span");
      n.className = "sample";
      editor.insertNodeAtSelection(n);
      var sel = editor._iframe.contentWindow.getSelection();
      sel.removeAllRanges();
      var r = editor._doc.createRange();
      r.setStart(n, 0);
      r.setEnd(n, 0);
      sel.addRange(r);
    }
  }
);


  /*
  cfg.registerButton("my-hilite", "Highlight text", "ed_custom.gif", false,
    function(editor) {
      editor.surroundHTML('<span class="hilite">', '</span>');
    }
  );
  */
  cfg.pageStyle = "body { background-color: #efd; } .hilite { background-color: yellow; } "+
                  ".sample { color: green; font-family: monospace; }";
  cfg.toolbar.push(["linebreak", "my-toc", "my-date", "my-bold", "my-hilite", "my-sample"]); // add the new button to the toolbar
  // END: code that adds a custom button

  editor.generate();
}
function insertHTML() {
  var html = prompt("Enter some HTML code here");
  if (html) {
    editor.insertHTML(html);
  }
}
function highlight() {
  editor.surroundHTML('<span style="background-color: yellow">', '</span>');
}
</script>
<script language="JavaScript" src="/ch/js/clientSideInclude.js"></script>
<script language="JavaScript" src="/ch/js/clientSideInclude.js"></script>
<script language="JavaScript" src="/ch/js/menuFix.js"></script>
<style type="text/css">
<!--
.css_me {
	color: #0000FF;
	font-size: 18px;
	font-weight: bold;
}
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
																安排项目,项目编号：<?php echo "$id";?></font></strong></td>
																<td align="right"><img src="site_images/ras.gif" width="197" height="20" /></td>
														</tr>
												</table></td>
								</tr>
								
 

								<tr>
										<td width="100%" height="170" align="left" bgcolor="#EAEAEA">
										<br />
										<form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post">
										  <input  name="leibie1"     value="<?php echo "$leibie"; ?>" type="hidden" size="20" />
										  <p>项目安排:                                          
										  <p>项目编号<input  name="number" value="<?php echo "$id"; ?>"  type="text" size="20"/>
										  <br /> <br>
									        <label>员工 
											<?php
mysql_select_db($database_roche, $roche);											
 global $arr,$db;
$sql = "select * from username  ";
$result=mysql_query($sql);
while ($i=@mysql_fetch_array($result)){
    
   $arr[] =$i;
    
 
}
 
?>
<select name="worker[0]">
<option value="0" selected="selected">请选择员工</option>
<?php
for ($i=0;$i<count($arr);$i++) {
?>
<option value="<?php echo $arr[$i]["userid"] ?>"><?php echo $arr[$i]["username"] ?></option>

<?php }?>
</select>
											
										 
							              </label>  
										    <br> <br>
										    <label>工作量 
									        <input name="work_2[0]" type="text" size="20"  />
									        
									        </label> 
										                                          
										  <p>
										    <label>工作内容<br>
									        <textarea name="work[0]" cols="60" rows="10"></textarea>
									        </label>
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
        str='员工<select name="worker[' + file_count + ']"><option value="0" selected="selected">请选择员工</option><option value="2011001">周舜锋</option><option value="2011002">张希</option><option value="2011003">余锋</option><option value="2011004">胡军瑜</option><option value="2011005">姜龙森</option><option value="2011006">姚忻岑</option><option value="2011007">陈小燕</option><option value="2011008">张莹</option><option value="2011009">王磊</option><option value="2011010">辛秋红</option><option value="2011011">姜丽丽</option><option value="2011012">陶婧</option><option value="002">李才华</option><option value="011">姜正文</option></select><br><label>工作量<input name="work_2[' + file_count + ']" type="text" size="20"  /> </label> 工作内容<br><textarea name="work[' + file_count + ']" cols="60" rows="10"></textarea> ';

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
								  </form>									  </td>
								</tr>
 
								<tr>
										<td height="74"  align="left" bgcolor="#EAEAEA"><p> <span class="css_me"><br><br>
										  该项目已经有的安排情况</span>  </p>
									      <form id="form1" name="form1" method="post"  action="<?php echo $_SERVER['PHP_SELF'] ?>">
										   <input  name="leibie2"  type="hidden"   value="<?php echo "$leibie"; ?>" size="20"  />
                                         <p><p>项目编号<input  name="number" value="<?php echo "$id"; ?>"  type="text" size="20"/></p>  <?php
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

                                           
                                            <p> 
										   人员
										    <input  name="lastname[<?php echo "$j"; ?>]" value="<?php echo "$username"; ?>"  type="hidden" size="20"/>
										     <input  name="pid[<?php echo "$j"; ?>]" value="<?php echo "$pid"; ?>"  type="hidden" size="20"/>
										     <select name="worker[<?php echo "$j"; ?>]">
											 <?php
for ($i=0;$i<count($arr);$i++) {
?>
<option value="<?php echo $arr[$i]["userid"] ?>"  <?php if ( $username==$arr[$i]["userid"]) {echo "selected=\"selected\"";} ?>><?php echo $arr[$i]["username"] ?></option>

<?php }?>
 
                                             </select>
											 
										    <p>工作量
										      <input name="work_2[<?php echo "$j"; ?>]" value="<?php echo "$work_2"; ?>"   type="text" size="20"  />
                                            <p>工作内容<br>
										      <textarea name="work[<?php echo "$j"; ?>]" cols="60" rows="10"><?php echo $doing ?></textarea>
										     <?php echo "<a target='_blank' class='bluelink' href='project_anpai.php?pid=$pid&tpye=$leibie&deluser=$username&action=del'>删除此项</a>";?> 
										    <p>
										      <?php 
$j++;}
?>
										      <input type="submit" name="change" value=" 修改 " /> </p>
										  </form>									      <p>&nbsp;</p></td>
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
