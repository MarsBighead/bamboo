<?php require("check_admin.php"); ?>
<?php require_once('Connections/roche.php'); ?>
<?php ob_start();?>
<?php $id = $_GET['id'];?>
<?php 
if (!empty($_POST['submit'])){
	$id = $_POST["id"];
	$name = $_POST["name"];
	$leibie = $_POST["leibie"];
	$number = $_POST["number"];
	$username = $_POST["username"];
	$danwei = $_POST["danwei"];
	$lianxiren = $_POST["lianxiren"];
	$dizhi = $_POST["dizhi"];
	$email = $_POST["email"];
	$tel = $_POST["tel"];
	$status = $_POST["status"];
	$xiazai = $_POST["xiazai"];
	$downloads = $_POST["downloads"];
    $date = $_POST["date"];
	$money = $_POST["money"];
	$intro = $_POST["intro"];
    $date_f = $_POST["date_f"];
		mysql_select_db($database_roche, $roche);
	$query = "update `project` set xiazai = '$xiazai',date_f='$date_f' ,downloads='$downloads' where id = '$id'";
	$result = mysql_query($query,$roche) or die(mysql_error()); 
	echo "<head>";
	echo "<meta http-equiv='Content-Type' content='text/html; charset=utf-8' />";
	echo "<meta http-equiv='refresh' content='3;url=project_show.php?id=".$id."'>";
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
																项目管理</font></strong></td>
																<td align="right"><img src="site_images/ras.gif" width="197" height="20" /></td>
														</tr>
												</table></td>
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
$dizhi = $row[dizhi];
$tel = $row[tel];
$xiazai = $row[xiazai];
$leibie = $row[leibie];
$email = $row[email];
$downloads = $row[downloads];
$date = $row[date];
$status = $row[status];
 $money = $row[money];
$intro = $row[intro];
$finish = $row[finish];
$date_f = $row[date_f];
?>

								<tr>
										<td align="left" bgcolor="#EAEAEA" width="100%">
										项目编号：<?php echo "$number";?><br />
										<form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post">
										  <p>
										    <input  name="id" value="<?php echo $id ?>" type="hidden"  />
										    <br />
										    1、数据下载   
										    <label>
										    <input type="radio" name="xiazai" <?php if($xiazai==1){echo "checked='checked'";}?> value="1" />
可以下载</label>
                                            <label>
                                            <input name="xiazai" type="radio" value="0" <?php if($xiazai==0){echo "checked='checked'";}?>/>
不能下载</label>
</p>
										  <p>
										    <label></label>
										    <textarea name="downloads" cols="50"     rows="4" ><?php echo $downloads ?></textarea>
										  </p>
										  
										  <p>2、 项目完成时间
										      <input  name="date_f" value="<?php echo $date_f ?>" type="text" size="20"/>
									        时间 格式：  2008-08-24 <br />
									        <br />
									        <br /><input type="submit" name="submit" value=" 提 交 " /> </p>
										  </form>									  </td>
								</tr>
<?php 
}
?>	
								<tr>
										<td>&nbsp;</td>
								</tr>
						</table></td>
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
