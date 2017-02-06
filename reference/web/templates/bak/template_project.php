<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><head>
<meta http-equiv="X-UA-Compatible" content="IE=7">
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>天昊生物医药科技(苏州)有限公司</title>
<meta name="keywords" content="天昊生物医药科技(苏州)有限公司">
<meta name="description" content="">
<link href="css/reset.css" rel="stylesheet" type="text/css">
<link href="css/style.css" rel="stylesheet" type="text/css">
<link href="css/navigation.css" rel="stylesheet" type="text/css">
<script src="js/stuHover.js" type="text/javascript"></script>
<script src="js/jquery.js" type="text/javascript"></script>
<!--控制左侧导航栏收放
<script type="text/javascript">
    $(document).ready(function () {
        $("#hotPro>dd>dl>dd").hide();
        $.each($("#hotPro>dd>dl>dt"), function () {
            //$("#electrical>dd>dl>dd:first").show();
            $(this).click(function () {
                $("#hotPro>dd>dl>dd").not($(this).next()).slideUp();
                $(this).next().slideToggle(500);
                //$(this).next().toggle();
            });
        });
        $("#left_top_dl>dd>dl>dd").hide();
        $.each($("#left_top_dl>dd>dl>dt"), function () {
            //$("#electrical>dd>dl>dd:first").show();
            $(this).click(function () {
                $("#left_top_dl>dd>dl>dd").not($(this).next()).slideUp();
                $(this).next().slideToggle(500);
                //$(this).next().toggle();
            });
        });
    });
</script>-->
<script type="text/javascript">
    function nTabs(thisObj, Num) {
        if (thisObj.className == "active") return;
        var tabObj = thisObj.parentNode.id;
        var tabList = document.getElementById(tabObj).getElementsByTagName("li");
        for (i = 0; i < tabList.length; i++) {
            if (i == Num) {
                thisObj.className = "active";
                document.getElementById(tabObj + "_Content" + i).style.display = "block";
            } else {
                tabList[i].className = "normal";
                document.getElementById(tabObj + "_Content" + i).style.display = "none";
            }
        }
    }
</script>
</head>
<body id="technology1">
<!-- head-->
<%php%>
	include("templets/default_diagnostics/head_suzhou.php")
<%/php%>
<%if $smarty.session.username==""%>
	<table border="1" width="98%" bordercolorlight="#808080" cellspacing="0" bordercolordark="#FFFFFF" bgcolor="#FFFFFF">
		<tr>
			<td>
			<table width="90%" cellpadding="0" cellspacing="0" align="center" style="line-height:15px">
				<tr>
					<td width="100%">
					<div align="left"><b><img border="0" src="images/next.gif" width="12" height="12" /> 登录</b></div>
					</td>
				</tr>
				<tr>
					<td>
					<hr size="1" color="#808080" />
					</td>
				</tr>
				<tr>
				<td width="100%" valign="top" >
					<div align="left">
					<form action="login.php?redirect=<%php%>echo $_SERVER['PHP_SELF'],(!empty($_SERVER['QUERY_STRING']))?"?".$_SERVER['QUERY_STRING']:""<%/php%>" method="post" name="loginForm"  id="loginForm" style="margin:auto">
						<div><font color="#8B0000"><%$smarty.get.loginerrmsg%></font></div>
						<div> 用户名:<br />
							<input type="text" name="username" style="width:120px;height:15px"/>
						</div>
						<div> 密码:<br />
							<input type="password" name="password" style="width:120px;height:15px"/>
						</div>
						<div>
							<input type="submit" name="Submit2" value="登录" /> &nbsp;&nbsp;
						</div>
					</form>
					</div>
				</td>
				</tr>
			</table>
			</td>
		</tr>
	</table>
<%else%>
	<table width="90%" align="center">
		<tr>
			<td nowrap="nowrap" align="left" style="font-size:10pt"> <span style="color:blue;">欢迎你，</span>
				<%$smarty.session.username%>
					<a href="logoff.php" style="color:gray">[退出]</a>
																					 
			</td>
		</tr>
	</table>
<%/if%>
<!-- head-->

<!--技术中心内页banner图片
<div id="banner_bg2">
<div id="banner2">
<img src="templets/default_diagnostics/img/2013022840920501.png" alt="技术中心内页banner图片">
</div>
</div>-->

<!--
<div class="index_main_top">
    <div class="index_top_notice">
    <div id="new_rool_msg">
    {dede:arclist titlelen='68' typeid='25' row='5' flag='' orderby='pubdate'}
	<a href="[field:arcurl/]">[field:title/]&nbsp;&nbsp;[field:pubdate function="MyDate('20y-m-d',@me)"/]</a>
	{/dede:arclist}
    </div> 
        <script type="text/javascript">
            var c, _ = Function;
            with (o = document.getElementById("new_rool_msg")) { innerHTML += innerHTML; onmouseover = _("c=1"); onmouseout = _("c=0"); }
            (F = _("if(#%20||!c)#++,#%=o.scrollHeight>>1;setTimeout(F,#%20?10:1500);".replace(/#/g, "o.scrollTop")))();
        </script>
    </div>
</div>
-->


<div id="container">
<div id="main">
<!-- left-->
<%php%> include("templates/left_project.php") <%/php%>	
<!-- left-->


    <div id="rightsiderbar">
	<div id="nei"> 
 
<table width="700" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF" style="font-size:16px">
<tr><td><%$maincontent%></td></tr>
</table>
        </div>     
    </div>
</div>
</div>
<!-- foot-->
<%php%>include("templets/default_diagnostics/foot_suzhou.php")<%/php%>
<!-- foot-->
</body></html>
<script>
var page="main";
var npart=2;
var loadding=0;function init(){for(var i=1;i<=npart;i++){document.cookie=page+"_part"+i+"=0";}}function cookieset(id){if(loadding==0){var str=document.cookie;var arrstr=str.split(';');for(var i=0;i<arrstr.length;i++){arrstr[i]=arrstr[i].replace(" ","");var arr_cookie=arrstr[i].split('=');var spart=arr_cookie[0].split('_');if(spart[0]==page && spart[1]==id && arr_cookie[1]==1){init();document.cookie=page+"_"+id+"=0";}else if(spart[0]==page && spart[1]==id && arr_cookie[1]==0){init();document.cookie=page+"_"+id+"=1";}}}}window.onload=function(){loadding=1;var count=0;var str=document.cookie;var arrstr=str.split(';');for(var i=0;i<arrstr.length;i++){arrstr[i]=arrstr[i].replace(" ","");var arr_cookie=arrstr[i].split('=');var spart=arr_cookie[0].split('_');if(spart[0]==page && arr_cookie[1]==1){count++;try{document.getElementById(spart[1]).click();}catch(e){}}}if(count==0){init();}loadding=0;}
</script>
