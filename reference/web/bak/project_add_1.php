<?php require("check_admin.php"); ?>
<?php require_once('Connections/roche.php'); ?>
<?php ob_start();?>
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
	$name = $_POST["name"];
	$number = $_POST["number"];
	$money = $_POST["money"];
	$username = $_POST["username"];
	$leibie = $_POST["leibie"];
	$lianxiren = $_POST["lianxiren"];
	$dizhi = $_POST["dizhi"];
	$email = $_POST["email"];
	$tel = $_POST["tel"];
	$status = $_POST["status"];
	$downloads = $_POST["downloads"];
	$xiazai = $_POST["xiazai"];
	$intro=$_POST["intro"];
	$date = $_POST["date"];
	$finish = $_POST["finish"];
	$date_f = $_POST["date_f"];
	 	 
	mysql_select_db($database_roche, $roche);
	
	$insertSQL = sprintf("INSERT INTO project (`name`,number,leibie,lianxiren,dizhi,email,tel,status,username,xiazai,downloads, date, money,intro,date_f ) VALUES (%s, %s, %d, %s, %s,%s,%s,%d,%s,%d,%s,%s,%s,%s,%s)",
				GetSQLValueString($name, "text"), 
				GetSQLValueString($number, "text"), 
				GetSQLValueString($leibie, "int"), 
				GetSQLValueString($lianxiren, "text"),
				GetSQLValueString($dizhi, "text"),
				GetSQLValueString($email, "text"),
				GetSQLValueString($tel, "text"),
				GetSQLValueString($status, "int"),
				GetSQLValueString($username, "text"), 
				GetSQLValueString($xiazai, "int"), 
				GetSQLValueString($downloads, "text"), 
				GetSQLValueString($date, "date"), 
				GetSQLValueString($money, "text"), 
				GetSQLValueString($intro, "text"), 
				GetSQLValueString($date_f, "date")); 
  		$Result1 = mysql_query($insertSQL, $roche) or die(mysql_error());
		mysql_select_db($database_roche, $roche);
	
     $count=count($_POST["worker"]);
	 echo  $_POST['worker'][0] ;
	 for($i=0;$i<$count;$i++){
	 $query111 =  sprintf( "insert into   project_user(pro_id,username,doing,date) values(%s,%s,%s,%s)",
	            GetSQLValueString($number, "text"), 
				GetSQLValueString($_POST["worker"][$i], "text"), 
				GetSQLValueString($_POST["work"][$i], "text"), 
				GetSQLValueString($date, "text"));
  	 $result11 = mysql_query($query111,$roche) or die(mysql_error());
	 
	 }
	
	echo "<head>";
	echo "<meta http-equiv='Content-Type' content='text/html; charset=utf-8' />";
	echo "<meta http-equiv='refresh' content='3;url=project_add.php'>";
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
																  项目启动
																</font></strong></td>
																<td align="right"><img src="site_images/ras.gif" width="197" height="20" /></td>
														</tr>
												</table></td>
								</tr>

								<tr>
										<td align="left" bgcolor="#EAEAEA" width="100%">
										<br />
										<form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post">
										  <p>1、项目名称
										    <input  name="name" type="text" size="40"/>
										    <br />
										    <br />
										   2、项目编号
										    <input  name="number" type="text" size="20"/>
										    <br /> <br />
										    
										   3、项目用户
										    <input  name="username" type="text" size="20"/>
										  </p>
										  <p>4、项目分类
										    <label>
										     <select name="leibie"   >
											 <option value="0"  >试剂购买</option>
										     <option value="1" selected="selected">长期合作非持续性项目</option>
											 <option value="2"  >长期合作持续性重复项目</option>
											 <option value="3">普通合同项目</option>
										     <option value="4">普通订单小项目</option>
									        </select>
										    </label>
									      </p>
										  <p>5、项目单位
										    <input  name="danwei" type="text" size="40"/>
									      </p>
										  <p>6、项目联系人
										    <input  name="lianxiren" type="text" size="20"/>
									      </p>
										  <p>7、联系地址
										    <input  name="dizhi" type="text" size="40"/>
									      </p>
										  <p>8、联系email
										    <input  name="email" type="text" size="40"/>
									      </p>
										  <p>9、联系电话
										    <input  name="tel" type="text" size="40"/>
										  </p>
										   <p>10、截止日期
										     <input  name="date_end" type="text" size="20"/>
</p>
										  <p>10、项目状态
										    <label>
										    <select name="status">
										      <option value="1" selected="selected">签订合同</option>
										       <option value="2">项目启动</option>
										       <option value="3">项目完成</option>
										      <option value="4">项目结清</option>
									        </select>
										    </label>
									      </p>
										  <p>										    11、项目简介<br>
										    <textarea name="intro" cols="80" rows="8"></textarea>
										    <br />
										    <br>
										  12、项目安排<br />
										  <label>员工 
										  <input type="text" name="worker[0]" />
										  </label>
										  <label>工作内容
										  <input name="work[0]" type="text" size="40" />
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
        str='<input  type="text"  name="worker[' + file_count + ']" style="width:150px" /><input  type="text"  name="work[' + file_count + ']" style="width:300px" />';

    str += "&nbsp;<input type="+'"'+"button"+'"'+" value="+'"'+"删除"+'"'+"   onclick='deleteitem(this,"+'"'+"tb"+'"'+");'>";
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
										  <p>13、数据下载   
										    <label>
										    <input type="radio" name="xiazai" value="1" />
可以下载</label>
                                            <label>
                                            <input name="xiazai" type="radio" value="0" checked="checked" />
不能下载</label>
</p>
										  <p>
										    <label></label>
										    <textarea name="downloads" cols="50" rows="4" ></textarea>
									      </p>
										  <p>14、项目开始时间
										    <input  name="date" type="text" size="20"/> 
										  时间 格式：  2008-07-24 12:30:00 </p>
										  <p>15、项目金额  
										    <input  name="money" type="text" size="15"  /></p>
										  <p>16、 项目已经完成
										    <label>
										    <input name="finish" type="radio" value="1" />
										    是</label><label>
										    <input name="finish" type="radio" value="0" checked="checked" />
										    否</label>
										    完成时间：  <input  name="date_f" type="text" size="20"/>
									        时间 格式：  2008-08-24 <br />
									        <br />
									        <br />
									      </p>
										  <p><input type="submit" name="submit" value=" 提 交 " /> </p>
										</form>								  </td>
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
$maincontent=ob_get_contents();
ob_get_clean();
$tpl->assign("maincontent",$maincontent);
$tpl->display('template_admin_p.php');
?>
