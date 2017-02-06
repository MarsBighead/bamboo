<?php 
require("check_admin.php");
require_once('Connections/roche.php'); 
ob_start();
$id = $_GET['id']; 
$action = $_GET['action'];
?>
<?php 
if($action=="del"){
	$pid = $_GET['pid'];
	mysql_select_db($database_roche, $roche);
	$query111 =  sprintf("delete from product where pid='$pid'");
	$result11 = mysql_query($query111,$roche) or die(mysql_error());
	echo "<Script language='JavaScript'> alert('该产品已经删除');</Script>";
}

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
    $chuanzhen = $_POST["chuanzhen"];
    $date_end = $_POST["date_end"];
	$date_j2= $_POST["date_j2"];
    $creater= $_POST["creater"];
	$intro = $_POST["intro"];
    mysql_select_db($database_roche, $roche);
	$query = "update `project` set name = '$name', number = '$number', leibie = '$leibie',username = '$username',danwei = '$danwei',lianxiren = '$lianxiren',dizhi = '$dizhi',email = '$email',tel = '$tel',chuanzhen = '$chuanzhen',date_j2 = '$date_j2',date_end = '$date_end', intro='$intro', creater = '$creater' where id = '$id'";
	$result = mysql_query($query,$roche) or die(mysql_error()); 
	$number_old=$_POST['number_old'];
	if($number_old!=$number){
		$query_p="update project_user set  pro_id='$number' where pro_id='$number_old'";
		$result = mysql_query($query_p,$roche) or die(mysql_error()); 
	}
	
	$count=count($_POST["huohao"]);
	for($i=0;$i<$count;$i++){
		$p_id=$_POST['p_id'][$i];
		$huohao=$_POST['huohao'][$i];
		$guige=$_POST['guige'][$i];
		$jiliang=$_POST['jiliang'][$i];
		$shuliang=$_POST['shuliang'][$i];
		$beizhu=$_POST['beizhu'][$i];
		$query1 = "update `product` set number='$huohao',name='$guige',danwei='$jiliang',shuliang='$shuliang',beizhu='$beizhu',pro_id='$number' where pid='$p_id'";
		$result = mysql_query($query1,$roche) or die(mysql_error()); 
	}	
	$count2=count($_POST["huohao_a"]);
	for($j=0;$j<$count2;$j++){	 
		$huohao_a=$_POST['huohao_a'][$j];
		$guige_a=$_POST['guige_a'][$j];
		$jiliang_a=$_POST['jiliang_a'][$j];
		$shuliang_a=$_POST['shuliang_a'][$j];
		$beizhu_a=$_POST['beizhu_a'][$j];
		$query1 = "insert into  product(number,name,danwei,shuliang,beizhu,pro_id) values('$huohao_a','$guige_a','$jiliang_a','$shuliang_a','$beizhu_a','$number')";
		$result = mysql_query($query1,$roche) or die(mysql_error()); 
	}
	echo "<head>";
	echo "<meta http-equiv='Content-Type' content='text/html; charset=utf-8' />";
	echo "<meta http-equiv='refresh' content='3;url=project_change_x.php?id=".$id."'>";
	echo "</head>";
	echo "更新成功,3秒后自动跳转";
	exit ;
} 
?>
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
<table width="98%" border="0" align="center" cellpadding="5">
	<tr style="border-bottom:#0099CC 1px solid;">
		<td align="left"><strong><font color="#000000" size="+1" face="黑体，宋体, Times New Roman, Arial"><br>项目管理</font></strong></td>
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
		$dizhi = $row[dizhi];
		$tel = $row[tel];
		$chuanzhen = $row[chuanzhen];
		$xiazai = $row[xiazai];
		$leibie = $row[leibie];
		$email = $row[email];
		$downloads = $row[downloads];
		$date = $row[date];
		$status = $row[status];
		$creater = $row[creater]; 
		$intro = $row[intro];
		$finish = $row[finish];
		$date_end = $row[date_end];
		$date_j2 = $row[date_j2];
	?>
	<tr>
		<td align="left" bgcolor="#EAEAEA" width="100%" colspan="2"><br />
			<form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post">
			<input  name="id" value="<?php echo $id ?>" type="hidden"  />
			<p>	1、项目名称<input  name="name" value="<?php echo $name ?>" type="text" size="40"/><br /><br />
				2、项目编号<input  name="number" value="<?php echo $number ?>" type="text" size="20"/>
							<input  name="number_old" value="<?php echo $number ?>" type="hidden" size="20"/><br /> <br />
				3、项目用户名<input  name="username" value="<?php echo $username ?>" type="text" size="20"/>
			</p>
			<p>	4、项目类别<label>	
							<select name="leibie"   >
								<option value="0"   <?php if ($leibie==0) {echo "selected=\"selected\"";} ?>>服务项目</option>
								<option value="1"   <?php if ($leibie==1) {echo "selected=\"selected\"";} ?>>研发项目</option>
								<option value="2"   <?php if ($leibie==2) {echo "selected=\"selected\"";} ?>>生产项目</option>
								<option value="3"  <?php if ($leibie==3) {echo "selected=\"selected\"";} ?>  >内部项目补充测试</option>
								<option value="4"  <?php if ($leibie==4) {echo "selected=\"selected\"";} ?>  >长期合作服务项目</option>
								<option value="5"  <?php if ($leibie==5) {echo "selected=\"selected\"";} ?>  >普通服务项目</option>
								<option value="6"  <?php if ($leibie==6) {echo "selected=\"selected\"";} ?>  >小型服务项目</option>
								<option value="7" <?php if ($leibie==7) {echo "selected=\"selected\"";} ?>   >科研合作服务项目</option>
							</select></label>
			</p>
			<p>	5、项目单位 <input  name="danwei" value="<?php echo $danwei ?>" type="text" size="40"/> </p>
			<p>	6、<?php if($leibie==0){echo "订单联系人";} else {echo "项目联系人";}?>
							<input  name="lianxiren" value="<?php echo $lianxiren ?>" type="text" size="20"/>
			</p>
			<p>	7、联系地址	<input  name="dizhi" value="<?php echo $dizhi ?>" type="text" size="40"/></p>
			<p>	8、联系email<input  name="email" value="<?php echo $email ?>" type="text" size="40"/></p>
			<p>	9、联系电话	<input  name="tel" value="<?php echo $tel ?>"  type="text" size="40"/></p>
			<p>	10、传真	<input  name="chuanzhen" value="<?php echo $chuanzhen ?>"  type="text" size="40"/></p>
			<p>	11、截止日期<input  name="date_end" value="<?php echo $date_end ?>" type="text" size="20"/>格式：1984-09-06</p>
			<p>	12、内部截止日期<input  name="date_j2" value="<?php echo $date_j2 ?>" type="text" size="20"/>格式：1984-09-06</p>
			<p>	12、项目简介<br><textarea name="intro"    cols="80" rows="8"><?php echo $intro ?></textarea><br /></p>
			<p>	13:建项人：	<input  name="creater" value="<?php echo $creater ?>"  type="text" size="40"/></p>
			<p> <input type="submit" name="submit" value=" 提 交 " /> </p>
			</form>	
		</td>
	</tr>
	<?php }?>	
</table>

<?php 
require_once('smartyconfig.php');  
$html="template_admin_p.php"; 
$maincontent=ob_get_contents();
ob_get_clean();
$tpl->assign("maincontent",$maincontent);
$tpl->display($html);
?>
