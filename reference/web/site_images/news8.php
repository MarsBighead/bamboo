<?php ob_start();?>
<?php require_once("sendmail.php");?>
<?php
$content ="";

if (!empty($_POST['submit'])){
	

$realname = $_POST["realname"];
$content.="姓名:&nbsp;$realname<br/>";

$telephone = $_POST["telephone"];
$content.="电话:&nbsp;$telephone<br/>";

$address = $_POST["address"];
$content.="地址:&nbsp;$address<br/>";

$mail = $_POST["mail"];
$content.="email:&nbsp;$mail<br/>";

$corp = $_POST["corp"];
$content.="单位名称:&nbsp;$corp<br/>";

$jobTitle = $_POST[jobTitle];
if (!empty($_POST['jobTitle'])){
foreach ($jobTitle as  $key => $value)
{
$jobTitle_all = $jobTitle_all.$value.';';
}
}
$field = $_POST[field];
if (!empty($_POST['field'])){
foreach ($field as  $key => $value)
{
$field_all = $field_all.$value.';';
}
}
$city = $_POST[city];
if (!empty($_POST['city'])){
foreach ($city as  $key => $value)
{
$city_all = $city_all.$value.';';
}
}
$content.="职务:&nbsp;$jobTitle_all<br/>";
$content.="关注的技术领域:&nbsp;$field_all<br/>";
$content.="所选城市:&nbsp;$city_all<br />";



$content.='<table width="100%" border=1>';
$content.='<tr bgcolor="#f0f0f0">';
$content.='<th align="center" colspan="8">联系方式</th>';
$content.='</tr>';
$content.='<tr>';
$content.='<th>单位名称</th>';
$content.='<th>姓名</th>';
$content.='<th>电子邮件</th>';
$content.='<th>电话</th>';
$content.='<th>联系地址</th>';
$content.='<th colspan="3">职务</th>';
$content.='</tr>';

$content.='<tr>';
$content.='<td align="center">'.$realname.' </td>';
$content.='<td align="center">'.$telephone.' </td>';
$content.='<td align="center">'.$$address.' </td>';
$content.='<td align="center">'.$mail.' </td>';
$content.='<td align="center">'.$corp.' </td>';
$content.='<td align="center">'.$jobTitle_all.'&nbsp;</td>';
$content.='</tr>';

$content.='<tr bgcolor="#f0f0f0">';
$content.='<th align="center" colspan="8">关注的技术领域</th>';
$content.='</tr>';

$content.='<tr>';
$content.='<td align="center" colspan="8">'.$field_all.'&nbsp;</td>';
$content.='</tr>';

$content.='<tr bgcolor="#f0f0f0">';
$content.='<th align="center" colspan="8">所选城市</th>';
$content.='</tr>';

$content.='<tr>';
$content.='<td align="center" colspan="8">'.$city_all.'&nbsp;</td>';
$content.='</tr>';


echo "<font color='#FF0000'>信息提交成功!!!请耐心等待我们的客服与您联系!!!</font><br><br>";

if (empty($mailtitle)) $mailtitle="讲座回执";
	send_mail('yangbo@scbit.org',$mailtitle,$content);
	//send_mail('hsshen@scbit.org',$mailtitle,$content);
	//send_mail('china.as@roche.com',$mailtitle,$content);
}
?>



<html xmlns:v="urn:schemas-microsoft-com:vml"
xmlns:o="urn:schemas-microsoft-com:office:office"
xmlns:w="urn:schemas-microsoft-com:office:word"
xmlns:st1="urn:schemas-microsoft-com:office:smarttags"
xmlns="http://www.w3.org/TR/REC-html40">

<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" name="keywords" content="生物技术,天昊生物,测序,snp,PCR" />
<script type="text/javascript">
function Check(){
	
	if (form.realname.value==""){
		alert("真实姓名不可为空");
		form.realname.focus();
		return false;
	}
	if (form.telephone.value==""){
		alert("请填写电话");
		form.telephone.focus();
		return false;
	}
	if (form.mail.value==""){
		alert("请填写邮件地址");
		form.zipcode.focus();
		return false;
	}
	if (form.corp.value==""){
		alert("请填写单位名称");
		form.address.focus();
		return false;
	}									
	return true;
}
</script>
<meta name=ProgId content=Word.Document>
<meta name=Generator content="Microsoft Word 11">
<meta name=Originator content="Microsoft Word 11">
<link rel=File-List href="Web_notice-roadshow.files/filelist.xml">
<link rel=Edit-Time-Data href="Web_notice-roadshow.files/editdata.mso">
<!--[if !mso]>
<style>
v\:* {behavior:url(#default#VML);}
o\:* {behavior:url(#default#VML);}
w\:* {behavior:url(#default#VML);}
.shape {behavior:url(#default#VML);}
</style>
<![endif]-->
<title>                                                                        
         </title>
<o:SmartTagType namespaceuri="urn:schemas-microsoft-com:office:smarttags"
 name="place"/>
<o:SmartTagType namespaceuri="urn:schemas-microsoft-com:office:smarttags"
 name="City"/>
<o:SmartTagType namespaceuri="urn:schemas-microsoft-com:office:smarttags"
 name="country-region"/>
<!--[if gte mso 9]><xml>
 <o:DocumentProperties>
  <o:Author>zhangl35</o:Author>
  <o:LastAuthor>DELL</o:LastAuthor>
  <o:Revision>2</o:Revision>
  <o:TotalTime>150</o:TotalTime>
  <o:Created>2008-06-03T07:29:00Z</o:Created>
  <o:LastSaved>2008-06-03T07:29:00Z</o:LastSaved>
  <o:Pages>3</o:Pages>
  <o:Words>552</o:Words>
  <o:Characters>3148</o:Characters>
  <o:Company>F. Hoffmann-La Roche, Ltd.</o:Company>
  <o:Lines>26</o:Lines>
  <o:Paragraphs>7</o:Paragraphs>
  <o:CharactersWithSpaces>3693</o:CharactersWithSpaces>
  <o:Version>11.9999</o:Version>
 </o:DocumentProperties>
 <o:OfficeDocumentSettings>
  <o:RelyOnVML/>
  <o:AllowPNG/>
 </o:OfficeDocumentSettings>
</xml><![endif]--><!--[if gte mso 9]><xml>
 <w:WordDocument>
  <w:PunctuationKerning/>
  <w:ValidateAgainstSchemas/>
  <w:SaveIfXMLInvalid>false</w:SaveIfXMLInvalid>
  <w:IgnoreMixedContent>false</w:IgnoreMixedContent>
  <w:AlwaysShowPlaceholderText>false</w:AlwaysShowPlaceholderText>
  <w:Compatibility>
   <w:BreakWrappedTables/>
   <w:SnapToGridInCell/>
   <w:ApplyBreakingRules/>
   <w:WrapTextWithPunct/>
   <w:UseAsianBreakRules/>
   <w:DontGrowAutofit/>
   <w:UseFELayout/>
  </w:Compatibility>
 </w:WordDocument>
</xml><![endif]--><!--[if gte mso 9]><xml>
 <w:LatentStyles DefLockedState="false" LatentStyleCount="156">
 </w:LatentStyles>
</xml><![endif]--><!--[if !mso]><object
 classid="clsid:38481807-CA0E-42D2-BF39-B33AF135CC4D" id=ieooui></object>
<style>
st1\:*{behavior:url(#ieooui) }
</style>
<![endif]-->
<style>
<!--
 /* Font Definitions */
 @font-face
	{font-family:Wingdings;
	panose-1:5 0 0 0 0 0 0 0 0 0;
	mso-font-charset:2;
	mso-generic-font-family:auto;
	mso-font-pitch:variable;
	mso-font-signature:0 268435456 0 0 -2147483648 0;}
@font-face
	{font-family:宋体;
	panose-1:2 1 6 0 3 1 1 1 1 1;
	mso-font-alt:SimSun;
	mso-font-charset:134;
	mso-generic-font-family:auto;
	mso-font-pitch:variable;
	mso-font-signature:3 135135232 16 0 262145 0;}
@font-face
	{font-family:PMingLiU;
	panose-1:2 2 3 0 0 0 0 0 0 0;
	mso-font-alt:新細明體;
	mso-font-charset:136;
	mso-generic-font-family:roman;
	mso-font-pitch:variable;
	mso-font-signature:3 137232384 22 0 1048577 0;}
@font-face
	{font-family:黑体;
	panose-1:2 1 6 0 3 1 1 1 1 1;
	mso-font-alt:SimHei;
	mso-font-charset:134;
	mso-generic-font-family:auto;
	mso-font-pitch:variable;
	mso-font-signature:1 135135232 16 0 262144 0;}
@font-face
	{font-family:"Angsana New";
	panose-1:2 2 6 3 5 4 5 2 3 4;
	mso-font-charset:222;
	mso-generic-font-family:roman;
	mso-font-format:other;
	mso-font-pitch:variable;
	mso-font-signature:16777217 0 0 0 65536 0;}
@font-face
	{font-family:"Arial Unicode MS";
	panose-1:2 11 6 4 2 2 2 2 2 4;
	mso-font-alt:Arial;
	mso-font-charset:0;
	mso-generic-font-family:roman;
	mso-font-format:other;
	mso-font-pitch:variable;
	mso-font-signature:3 0 0 0 1 0;}
@font-face
	{font-family:Imago-Medium;
	panose-1:0 0 0 0 0 0 0 0 0 0;
	mso-font-alt:Arial;
	mso-font-charset:0;
	mso-generic-font-family:swiss;
	mso-font-format:other;
	mso-font-pitch:auto;
	mso-font-signature:3 0 0 0 1 0;}
@font-face
	{font-family:Minion;
	mso-font-charset:0;
	mso-generic-font-family:auto;
	mso-font-pitch:variable;
	mso-font-signature:-1610612697 0 0 0 273 0;}
@font-face
	{font-family:"\@宋体";
	panose-1:2 1 6 0 3 1 1 1 1 1;
	mso-font-charset:134;
	mso-generic-font-family:auto;
	mso-font-pitch:variable;
	mso-font-signature:3 135135232 16 0 262145 0;}
@font-face
	{font-family:"\@黑体";
	panose-1:2 1 6 0 3 1 1 1 1 1;
	mso-font-charset:134;
	mso-generic-font-family:auto;
	mso-font-pitch:variable;
	mso-font-signature:1 135135232 16 0 262144 0;}
@font-face
	{font-family:"\@PMingLiU";
	panose-1:2 2 3 0 0 0 0 0 0 0;
	mso-font-charset:136;
	mso-generic-font-family:roman;
	mso-font-pitch:variable;
	mso-font-signature:3 137232384 22 0 1048577 0;}
 /* Style Definitions */
 p.MsoNormal, li.MsoNormal, div.MsoNormal
	{mso-style-parent:"";
	margin:0cm;
	margin-bottom:.0001pt;
	mso-pagination:widow-orphan;
	font-size:12.0pt;
	font-family:"Times New Roman";
	mso-fareast-font-family:宋体;
	mso-bidi-font-family:"Angsana New";
	mso-bidi-language:TH;}
a:link, span.MsoHyperlink
	{color:blue;
	text-decoration:underline;
	text-underline:single;}
a:visited, span.MsoHyperlinkFollowed
	{color:purple;
	text-decoration:underline;
	text-underline:single;}
p
	{mso-margin-top-alt:auto;
	margin-right:0cm;
	mso-margin-bottom-alt:auto;
	margin-left:0cm;
	mso-pagination:widow-orphan;
	font-size:12.0pt;
	font-family:"Times New Roman";
	mso-fareast-font-family:宋体;
	mso-bidi-language:TH;}
@page Section1
	{size:612.0pt 792.0pt;
	margin:72.0pt 90.0pt 72.0pt 90.0pt;
	mso-header-margin:35.4pt;
	mso-footer-margin:35.4pt;
	mso-paper-source:0;}
div.Section1
	{page:Section1;}
 /* List Definitions */
 @list l0
	{mso-list-id:462815398;
	mso-list-type:hybrid;
	mso-list-template-ids:15661862 67698699 67698693 67698693 67698689 67698691 67698693 67698689 67698691 67698693;}
@list l0:level1
	{mso-level-number-format:bullet;
	mso-level-text:\F0D8;
	mso-level-tab-stop:36.0pt;
	mso-level-number-position:left;
	text-indent:-18.0pt;
	font-family:Wingdings;}
@list l0:level2
	{mso-level-number-format:bullet;
	mso-level-text:\F0A7;
	mso-level-tab-stop:72.0pt;
	mso-level-number-position:left;
	text-indent:-18.0pt;
	font-family:Wingdings;}
@list l1
	{mso-list-id:1264537959;
	mso-list-type:hybrid;
	mso-list-template-ids:-800060650 67698689 67698691 67698693 67698689 67698691 67698693 67698689 67698691 67698693;}
@list l1:level1
	{mso-level-number-format:bullet;
	mso-level-text:\F0B7;
	mso-level-tab-stop:36.0pt;
	mso-level-number-position:left;
	text-indent:-18.0pt;
	font-family:Symbol;}
ol
	{margin-bottom:0cm;}
ul
	{margin-bottom:0cm;}
-->
</style>
<!--[if gte mso 10]>
<style>
 /* Style Definitions */
 table.MsoNormalTable
	{mso-style-name:普通表格;
	mso-tstyle-rowband-size:0;
	mso-tstyle-colband-size:0;
	mso-style-noshow:yes;
	mso-style-parent:"";
	mso-padding-alt:0cm 5.4pt 0cm 5.4pt;
	mso-para-margin:0cm;
	mso-para-margin-bottom:.0001pt;
	mso-pagination:widow-orphan;
	font-size:10.0pt;
	font-family:"Times New Roman";
	mso-ansi-language:#0400;
	mso-fareast-language:#0400;
	mso-bidi-language:#0400;}
table.MsoTableGrid
	{mso-style-name:网格型;
	mso-tstyle-rowband-size:0;
	mso-tstyle-colband-size:0;
	border:solid windowtext 1.0pt;
	mso-border-alt:solid windowtext .5pt;
	mso-padding-alt:0cm 5.4pt 0cm 5.4pt;
	mso-border-insideh:.5pt solid windowtext;
	mso-border-insidev:.5pt solid windowtext;
	mso-para-margin:0cm;
	mso-para-margin-bottom:.0001pt;
	mso-pagination:widow-orphan;
	font-size:10.0pt;
	font-family:"Times New Roman";
	mso-ansi-language:#0400;
	mso-fareast-language:#0400;
	mso-bidi-language:#0400;}
</style>
<![endif]--><!--[if gte mso 9]><xml>
 <o:shapedefaults v:ext="edit" spidmax="2050"/>
</xml><![endif]--><!--[if gte mso 9]><xml>
 <o:shapelayout v:ext="edit">
  <o:idmap v:ext="edit" data="1"/>
 </o:shapelayout></xml><![endif]-->
 

 
 
</head>

<body lang=ZH-CN link=blue vlink=purple style='tab-interval:36.0pt'>

<div class=Section1>

<p class=MsoNormal><b><span lang=EN-US style='font-size:16.0pt;font-family:
Imago-Medium;mso-bidi-font-family:Imago-Medium;color:#00C0CD'><span
style='mso-spacerun:yes'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
</span><v:shapetype id="_x0000_t75" coordsize="21600,21600" o:spt="75"
 o:preferrelative="t" path="m@4@5l@4@11@9@11@9@5xe" filled="f" stroked="f">
 <v:stroke joinstyle="miter"/>
 <v:formulas>
  <v:f eqn="if lineDrawn pixelLineWidth 0"/>
  <v:f eqn="sum @0 1 0"/>
  <v:f eqn="sum 0 0 @1"/>
  <v:f eqn="prod @2 1 2"/>
  <v:f eqn="prod @3 21600 pixelWidth"/>
  <v:f eqn="prod @3 21600 pixelHeight"/>
  <v:f eqn="sum @0 0 1"/>
  <v:f eqn="prod @6 1 2"/>
  <v:f eqn="prod @7 21600 pixelWidth"/>
  <v:f eqn="sum @8 21600 0"/>
  <v:f eqn="prod @7 21600 pixelHeight"/>
  <v:f eqn="sum @10 21600 0"/>
 </v:formulas>
 <v:path o:extrusionok="f" gradientshapeok="t" o:connecttype="rect"/>
 <o:lock v:ext="edit" aspectratio="t"/>
</v:shapetype><v:shape id="_x0000_i1071" type="#_x0000_t75" style='width:80.25pt;
 height:48pt'>

</v:shape></span></b><b><span lang=EN style='font-family:宋体;mso-ansi-language:
EN'><o:p></o:p></span></b></p>

<p class=MsoNormal><b><span lang=EN style='font-family:宋体;mso-ansi-language:
EN'><o:p>&nbsp;</o:p></span></b></p>

<img style="padding-left:600px" src="image/image003.bmp">

<p class=MsoNormal><b><span lang=EN style='font-family:宋体;mso-ansi-language:
EN'><o:p>&nbsp;</o:p></span></b></p>

<p class=MsoNormal><b><span style='font-size:10.0pt;font-family:宋体;mso-ansi-language:
EN'>罗氏应用科学部巡回讲座邀请函<span lang=EN><span style='mso-spacerun:yes'>&nbsp; </span><span
style='mso-spacerun:yes'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span><o:p></o:p></span></span></b></p>

<p class=MsoNormal><span lang=EN-US style='font-family:宋体'><o:p>&nbsp;</o:p></span></p>

<p class=MsoNormal><b><span style='font-family:宋体;mso-bidi-font-family:"Times New Roman";
color:blue'>生物和疾病研究的重大突破<span lang=EN-US><o:p></o:p></span></span></b></p>

<p class=MsoNormal><b><span style='font-family:宋体;mso-bidi-font-family:"Times New Roman";
color:blue'>－罗氏<span lang=EN-US>454</span>测序<span lang=EN-US> &amp; NimbleGen</span>基因芯片<span
lang=EN-US><o:p></o:p></span></span></b></p>

<p class=MsoNormal style='text-align:justify;text-justify:inter-ideograph'><span
lang=EN style='font-size:14.0pt;font-family:宋体;mso-ansi-language:EN'><span
style='mso-spacerun:yes'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </span><o:p></o:p></span></p>

<p class=MsoNormal style='text-align:justify;text-justify:inter-ideograph'><span
lang=EN style='font-size:10.0pt;mso-ansi-language:EN'><span
style='mso-spacerun:yes'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </span></span><span
style='font-size:10.0pt;font-family:宋体;mso-ascii-font-family:"Times New Roman";
mso-hansi-font-family:"Times New Roman";mso-ansi-language:EN'>罗氏</span><span
lang=EN style='font-size:10.0pt;mso-ansi-language:EN'>454</span><span
style='font-size:10.0pt;font-family:宋体;mso-ascii-font-family:"Times New Roman";
mso-hansi-font-family:"Times New Roman";mso-ansi-language:EN'>公司推出的第二代测序技术平台</span><span
style='font-size:10.0pt;mso-ansi-language:EN'> </span><span style='font-size:
10.0pt;font-family:宋体;mso-ascii-font-family:"Times New Roman";mso-hansi-font-family:
"Times New Roman";mso-ansi-language:EN'>－</span><span style='font-size:10.0pt;
mso-ansi-language:EN'> </span><span style='font-size:10.0pt;font-family:宋体;
mso-ascii-font-family:"Times New Roman";mso-hansi-font-family:"Times New Roman";
mso-ansi-language:EN'>超高通量基因组测序系统</span><span lang=EN style='font-size:10.0pt;
mso-ansi-language:EN'>GX FLX</span><span style='font-size:10.0pt;font-family:
宋体;mso-ascii-font-family:"Times New Roman";mso-hansi-font-family:"Times New Roman";
mso-ansi-language:EN'>拥有</span><span lang=EN style='font-size:10.0pt;
mso-ansi-language:EN'>Sanger</span><span style='font-size:10.0pt;font-family:
宋体;mso-ascii-font-family:"Times New Roman";mso-hansi-font-family:"Times New Roman";
mso-ansi-language:EN'>技术无法比拟的超高通量，率先突破读长技术瓶颈，</span><span style='font-size:
10.0pt;font-family:宋体;mso-ansi-language:EN'>在基因组从头测序、再测序、环境基因组学、<span lang=EN>RNA</span>分析等方面</span><span
style='font-size:10.0pt;font-family:宋体;mso-ascii-font-family:"Times New Roman";
mso-hansi-font-family:"Times New Roman";mso-ansi-language:EN'>具有更灵活广泛的应用前景。同时，罗氏</span><span
lang=EN style='font-size:10.0pt;font-family:宋体;mso-ansi-language:EN'>NimbleGen</span><span
style='font-size:10.0pt;font-family:宋体;mso-ansi-language:EN'>为基因组学及表观基因组学的进一步研究提供了一系列芯片。<span
lang=EN><o:p></o:p></span></span></p>

<p class=MsoNormal style='text-align:justify;text-justify:inter-ideograph'><span
lang=EN style='font-size:10.0pt;font-family:宋体;mso-ansi-language:EN'><o:p>&nbsp;</o:p></span></p>

<p class=MsoNormal style='text-align:justify;text-justify:inter-ideograph;
text-indent:24.0pt'><span style='font-size:10.0pt;font-family:宋体;mso-ascii-font-family:
"Times New Roman";mso-hansi-font-family:"Times New Roman";mso-ansi-language:
EN'>此次，来自</span><span style='font-size:10.0pt;font-family:宋体;mso-ansi-language:
EN'>罗氏应用科学部的技术及市场专家将与您一起分享<span lang=EN>GS FLX</span>在微生物基因组装配、新型病毒、癌症转录体及<span
lang=EN>SNP</span>的发现、环境基因组学测序、表观学领域的最新应用，及用超深测序法对来自混合群体的逆转录病毒进行定量，从而指导治疗策略。同时探讨<span
lang=EN>NimbleGen</span>芯片在序列捕获、比较基因组杂交、染色体免疫沉淀、甲基化及表达等方面的应用。</span><span
style='font-size:10.0pt;font-family:宋体;mso-ascii-font-family:"Times New Roman";
mso-hansi-font-family:"Times New Roman";mso-ansi-language:EN'>诚挚邀请您的莅临。</span><span
lang=EN style='font-size:10.0pt;mso-ansi-language:EN'><o:p></o:p></span></p>

<p class=MsoNormal style='text-align:justify;text-justify:inter-ideograph;
text-indent:24.0pt'><span lang=EN style='font-size:10.0pt;mso-ansi-language:
EN'><o:p>&nbsp;</o:p></span></p>

<p class=MsoNormal style='text-align:justify;text-justify:inter-ideograph;
text-indent:24.0pt'><span style='font-size:10.0pt;font-family:宋体;mso-ascii-font-family:
"Times New Roman";mso-hansi-font-family:"Times New Roman";mso-ansi-language:
EN'>与会者参加“体验罗氏</span><span lang=EN style='font-size:10.0pt;mso-ansi-language:
EN'>NimbleGen</span><span style='font-size:10.0pt;font-family:宋体;mso-ascii-font-family:
"Times New Roman";mso-hansi-font-family:"Times New Roman";mso-ansi-language:
EN'>序列捕获芯片定制服务”活动，将现场获得半价优惠，并获得精美礼品一份。</span><span lang=EN style='font-size:
10.0pt;mso-ansi-language:EN'><o:p></o:p></span></p>

<p class=MsoNormal><b><span lang=EN style='font-size:10.0pt;font-family:宋体;
mso-ansi-language:EN'><o:p>&nbsp;</o:p></span></b></p>

<p class=MsoNormal align=center style='text-align:center'><b><a href="news9.php"><span lang=EN-US
style='font-size:10.0pt;font-family:Arial;mso-hansi-font-family:宋体;mso-bidi-font-family:
"Angsana New"'>2008</span></b><b><span style='font-size:10.0pt;font-family:
宋体;mso-ascii-font-family:Arial'>年</span></b><b><span lang=EN-US
style='font-size:10.0pt;font-family:Arial;mso-hansi-font-family:宋体;mso-bidi-font-family:
"Angsana New"'>5</span></b><b><span style='font-size:10.0pt;font-family:宋体;
mso-ascii-font-family:Arial'>月</span></b><b><span lang=EN-US style='font-size:
10.0pt;font-family:Arial;mso-hansi-font-family:宋体;mso-bidi-font-family:"Angsana New"'>30</span></b><b><span
style='font-size:10.0pt;font-family:宋体;mso-ascii-font-family:Arial'>日</span></b><b><span
style='font-size:10.0pt;font-family:Arial;mso-hansi-font-family:宋体;mso-bidi-font-family:
"Angsana New"'> </span></b><b><span style='font-size:10.0pt;font-family:宋体;
mso-ascii-font-family:Arial'>～</span></b><b><span style='font-size:10.0pt;
font-family:Arial;mso-hansi-font-family:宋体;mso-bidi-font-family:"Angsana New"'>
<span lang=EN-US>6</span></span></b><b><span style='font-size:10.0pt;
font-family:宋体;mso-ascii-font-family:Arial'>月</span></b><b><span lang=EN-US
style='font-size:10.0pt;font-family:Arial;mso-hansi-font-family:宋体;mso-bidi-font-family:
"Angsana New"'>30</span></b><b><span style='font-size:10.0pt;font-family:宋体;
mso-ascii-font-family:Arial'>日</span></b><b><span lang=EN-US style='font-size:
10.0pt;font-family:Arial;mso-hansi-font-family:宋体;mso-bidi-font-family:"Angsana New"'><o:p></o:p></span></b></p>

<p class=MsoNormal align=center style='text-align:center'><b><span
style='font-size:10.0pt;font-family:宋体;mso-ascii-font-family:Arial'>体验罗氏</span></b><b><span
lang=EN-US style='font-size:10.0pt;font-family:Arial;mso-hansi-font-family:
宋体;mso-bidi-font-family:"Angsana New"'>NimbleGen</span></b><b><span
style='font-size:10.0pt;font-family:宋体;mso-ascii-font-family:Arial'>序列捕获芯片定制服务</span></b><b><span
lang=EN-US style='font-size:10.0pt;font-family:Arial;mso-hansi-font-family:
宋体;mso-bidi-font-family:"Angsana New"'><o:p></o:p></span></b></p>

<p class=MsoNormal align=center style='text-align:center'><b><span
style='font-size:10.0pt;font-family:宋体;mso-ascii-font-family:Arial;color:blue'>半价体验，即刻行动</span></a></b><b><span
lang=EN-US style='font-size:10.0pt;font-family:Arial;mso-hansi-font-family:
宋体;mso-bidi-font-family:"Angsana New";color:blue'><o:p></o:p></span></b></p>

<p class=MsoNormal><b><span lang=EN style='font-size:10.0pt;font-family:宋体;
mso-ansi-language:EN'><o:p>&nbsp;</o:p></span></b></p>

<p class=MsoNormal style='text-align:justify;text-justify:inter-ideograph'><span
lang=EN style='font-size:10.0pt;font-family:宋体;mso-ansi-language:EN'><o:p>&nbsp;</o:p></span></p>

<p class=MsoNormal><b><span style='font-size:10.0pt;font-family:宋体;mso-ascii-font-family:
Arial;mso-hansi-font-family:Arial;mso-bidi-font-family:"Times New Roman";
color:blue'>讲座时间</span></b><b><span lang=EN-US style='font-size:10.0pt;
font-family:Arial;mso-bidi-font-family:"Times New Roman";color:blue'>/</span></b><b><span
style='font-size:10.0pt;font-family:宋体;mso-ascii-font-family:Arial;mso-hansi-font-family:
Arial;mso-bidi-font-family:"Times New Roman";color:blue'>场次</span></b><b><span
lang=EN-US style='font-size:10.0pt;font-family:Arial;mso-bidi-font-family:"Times New Roman";
color:blue'><o:p></o:p></span></b></p>

<p class=MsoNormal><span lang=EN-US style='font-size:10.0pt;font-family:宋体'><o:p>&nbsp;</o:p></span></p>

<ul style='margin-top:0cm' type=disc>
 <li class=MsoNormal style='color:black;mso-list:l1 level1 lfo1;tab-stops:list 36.0pt'><b><span
     style='font-size:10.0pt;font-family:宋体;mso-ascii-font-family:Arial;
     mso-hansi-font-family:Arial;mso-bidi-font-family:"Times New Roman";
     color:#CC0033'>北京站</span></b><span lang=EN-US style='font-size:10.0pt;
     color:windowtext'><span
     style='mso-spacerun:yes'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </span></span><b><span
     lang=EN-US style='font-size:10.0pt;font-family:Arial;mso-bidi-font-family:
     "Times New Roman"'>2008</span></b><b><span style='font-size:10.0pt;
     font-family:宋体;mso-ascii-font-family:Arial;mso-hansi-font-family:Arial;
     mso-bidi-font-family:"Times New Roman"'>年</span></b><b><span lang=EN-US
     style='font-size:10.0pt;font-family:Arial;mso-bidi-font-family:"Times New Roman"'>6</span></b><b><span
     style='font-size:10.0pt;font-family:宋体;mso-ascii-font-family:Arial;
     mso-hansi-font-family:Arial;mso-bidi-font-family:"Times New Roman"'>月</span></b><b><span
     lang=EN-US style='font-size:10.0pt;font-family:Arial;mso-bidi-font-family:
     "Times New Roman"'>16</span></b><b><span style='font-size:10.0pt;
     font-family:宋体;mso-ascii-font-family:Arial;mso-hansi-font-family:Arial;
     mso-bidi-font-family:"Times New Roman"'>日，星期一（</span></b><b><span
     lang=EN-US style='font-size:10.0pt;font-family:Arial;mso-bidi-font-family:
     "Times New Roman"'>09</span></b><b><span style='font-size:10.0pt;
     font-family:宋体;mso-ascii-font-family:Arial;mso-hansi-font-family:Arial;
     mso-bidi-font-family:"Times New Roman"'>：</span></b><b><span lang=EN-US
     style='font-size:10.0pt;font-family:Arial;mso-bidi-font-family:"Times New Roman"'>30</span></b><b><span
     style='font-size:10.0pt;font-family:宋体;mso-ascii-font-family:Arial;
     mso-hansi-font-family:Arial;mso-bidi-font-family:"Times New Roman"'>开始会议注册）</span></b><b><span
     lang=EN-US style='font-size:10.0pt;font-family:Arial;mso-bidi-font-family:
     "Times New Roman"'><o:p></o:p></span></b></li>
</ul>

<p class=MsoNormal><b><span lang=EN-US style='font-size:10.0pt;font-family:
Arial;mso-bidi-font-family:"Times New Roman";color:black'><span
style='mso-spacerun:yes'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
</span></span></b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b><span style='font-size:10.0pt;font-family:宋体;mso-ascii-font-family:
Arial;mso-hansi-font-family:Arial;mso-bidi-font-family:"Times New Roman";
color:black'><a target="_blank" href="http://www.genomics.org.cn/bgi_new/menu/service/contact.htm">中科院北京基因组研究所</a></span><span style='font-size:10.0pt;font-family:宋体;mso-ascii-font-family:
Arial;mso-hansi-font-family:Arial;mso-bidi-font-family:"Times New Roman";
color:black'>, 二楼会议室</span></a></b><b><span lang=EN-US style='font-size:
10.0pt;font-family:Arial;mso-bidi-font-family:"Times New Roman";color:black'><o:p></o:p></span></b></p>

<p class=MsoNormal><span lang=EN-US style='font-size:10.0pt;font-family:Arial;
mso-bidi-font-family:"Times New Roman";color:black'><span
style='mso-spacerun:yes'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
</span></span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span style='font-size:10.0pt;font-family:宋体;mso-ascii-font-family:
Arial;mso-hansi-font-family:Arial;mso-bidi-font-family:"Times New Roman";
color:black'>北京市朝阳区北土城西路</span><span lang=EN-US style='font-size:10.0pt;
font-family:Arial;mso-bidi-font-family:"Times New Roman";color:black'>7</span><span
style='font-size:10.0pt;font-family:宋体;mso-ascii-font-family:Arial;mso-hansi-font-family:
Arial;mso-bidi-font-family:"Times New Roman";color:black'>号</span><span
lang=EN-US style='font-size:10.0pt;font-family:Arial;mso-bidi-font-family:"Times New Roman";
color:black'><o:p></o:p></span></p>

<p class=MsoNormal><span lang=EN-US style='font-size:10.0pt;font-family:Arial;
mso-bidi-font-family:"Times New Roman";color:black'><o:p>&nbsp;</o:p></span></p>

<ul style='margin-top:0cm' type=disc>
 <li class=MsoNormal style='color:black;mso-list:l1 level1 lfo1;tab-stops:list 36.0pt'><b><span
     style='font-size:10.0pt;font-family:宋体;mso-ascii-font-family:Arial;
     mso-hansi-font-family:Arial;mso-bidi-font-family:"Times New Roman";
     color:#CC0033'>上海站</span></b><span lang=EN-US style='font-size:10.0pt;
     color:windowtext'><span
     style='mso-spacerun:yes'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </span><span
     style='mso-spacerun:yes'>&nbsp;</span></span><b><span lang=EN-US
     style='font-size:10.0pt;font-family:Arial;mso-bidi-font-family:"Times New Roman"'>2008</span></b><b><span
     style='font-size:10.0pt;font-family:宋体;mso-ascii-font-family:Arial;
     mso-hansi-font-family:Arial;mso-bidi-font-family:"Times New Roman"'>年</span></b><b><span
     lang=EN-US style='font-size:10.0pt;font-family:Arial;mso-bidi-font-family:
     "Times New Roman"'>6</span></b><b><span style='font-size:10.0pt;
     font-family:宋体;mso-ascii-font-family:Arial;mso-hansi-font-family:Arial;
     mso-bidi-font-family:"Times New Roman"'>月</span></b><b><span lang=EN-US
     style='font-size:10.0pt;font-family:Arial;mso-bidi-font-family:"Times New Roman"'>17</span></b><b><span
     style='font-size:10.0pt;font-family:宋体;mso-ascii-font-family:Arial;
     mso-hansi-font-family:Arial;mso-bidi-font-family:"Times New Roman"'>日，星期二（</span></b><b><span
     lang=EN-US style='font-size:10.0pt;font-family:Arial;mso-bidi-font-family:
     "Times New Roman"'>09</span></b><b><span style='font-size:10.0pt;
     font-family:宋体;mso-ascii-font-family:Arial;mso-hansi-font-family:Arial;
     mso-bidi-font-family:"Times New Roman"'>：</span></b><b><span lang=EN-US
     style='font-size:10.0pt;font-family:Arial;mso-bidi-font-family:"Times New Roman"'>30</span></b><b><span
     style='font-size:10.0pt;font-family:宋体;mso-ascii-font-family:Arial;
     mso-hansi-font-family:Arial;mso-bidi-font-family:"Times New Roman"'>开始会议注册）</span></b><b><span
     lang=EN-US style='font-size:10.0pt;font-family:Arial;mso-bidi-font-family:
     "Times New Roman"'><o:p></o:p></span></b></li>
</ul>

<p class=MsoNormal><b><span lang=EN-US style='font-size:10.0pt;font-family:
Arial;mso-bidi-font-family:"Times New Roman";color:black'><span
style='mso-spacerun:yes'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
</span></span></b><b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span style='font-size:10.0pt;font-family:宋体;mso-ascii-font-family:
Arial;mso-hansi-font-family:Arial;mso-bidi-font-family:"Times New Roman";
color:black'>复旦大学生物医学研究院，明道楼二楼会议室</span></b><b><span lang=EN-US
style='font-size:10.0pt;font-family:Arial;mso-bidi-font-family:"Times New Roman";
color:black'><o:p></o:p></span></b></p>

<p class=MsoNormal><span lang=EN-US style='font-size:10.0pt;font-family:Arial;
mso-bidi-font-family:"Times New Roman";color:black'><span
style='mso-spacerun:yes'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
</span></span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span style='font-size:10.0pt;font-family:宋体;mso-ascii-font-family:
Arial;mso-hansi-font-family:Arial;mso-bidi-font-family:"Times New Roman";
color:black'>上海市徐汇区医学院路</span><span lang=EN-US style='font-size:10.0pt;
font-family:Arial;mso-bidi-font-family:"Times New Roman";color:black'>138</span><span
style='font-size:10.0pt;font-family:宋体;mso-ascii-font-family:Arial;mso-hansi-font-family:
Arial;mso-bidi-font-family:"Times New Roman";color:black'>号</span><span
lang=EN-US style='font-size:10.0pt;font-family:Arial;mso-bidi-font-family:"Times New Roman";
color:black'><span
style='mso-spacerun:yes'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
</span><o:p></o:p></span></p>

<p class=MsoNormal><span lang=EN-US style='font-size:10.0pt;font-family:Arial;
mso-bidi-font-family:"Times New Roman";color:black'><span
style='mso-spacerun:yes'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
</span><o:p></o:p></span></p>

<ul style='margin-top:0cm' type=disc>
 <li class=MsoNormal style='color:black;mso-list:l1 level1 lfo1;tab-stops:list 36.0pt'><b><span
     style='font-size:10.0pt;font-family:宋体;mso-ascii-font-family:Arial;
     mso-hansi-font-family:Arial;mso-bidi-font-family:"Times New Roman";
     color:#CC0033'>武汉站</span></b><span lang=EN-US style='font-size:10.0pt;
     color:windowtext'><span
     style='mso-spacerun:yes'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </span></span><b><span
     lang=EN-US style='font-size:10.0pt;font-family:Arial;mso-bidi-font-family:
     "Times New Roman"'>2008</span></b><b><span style='font-size:10.0pt;
     font-family:宋体;mso-ascii-font-family:Arial;mso-hansi-font-family:Arial;
     mso-bidi-font-family:"Times New Roman"'>年</span></b><b><span lang=EN-US
     style='font-size:10.0pt;font-family:Arial;mso-bidi-font-family:"Times New Roman"'>6</span></b><b><span
     style='font-size:10.0pt;font-family:宋体;mso-ascii-font-family:Arial;
     mso-hansi-font-family:Arial;mso-bidi-font-family:"Times New Roman"'>月</span></b><b><span
     lang=EN-US style='font-size:10.0pt;font-family:Arial;mso-bidi-font-family:
     "Times New Roman"'>18</span></b><b><span style='font-size:10.0pt;
     font-family:宋体;mso-ascii-font-family:Arial;mso-hansi-font-family:Arial;
     mso-bidi-font-family:"Times New Roman"'>日，星期三（</span></b><b><span
     lang=EN-US style='font-size:10.0pt;font-family:Arial;mso-bidi-font-family:
     "Times New Roman"'>09</span></b><b><span style='font-size:10.0pt;
     font-family:宋体;mso-ascii-font-family:Arial;mso-hansi-font-family:Arial;
     mso-bidi-font-family:"Times New Roman"'>：</span></b><b><span lang=EN-US
     style='font-size:10.0pt;font-family:Arial;mso-bidi-font-family:"Times New Roman"'>30</span></b><b><span
     style='font-size:10.0pt;font-family:宋体;mso-ascii-font-family:Arial;
     mso-hansi-font-family:Arial;mso-bidi-font-family:"Times New Roman"'>开始会议注册）</span></b><b><span
     style='font-size:10.0pt;font-family:Arial;mso-bidi-font-family:"Times New Roman"'>
     <span lang=EN-US><span style='mso-spacerun:yes'>&nbsp;&nbsp;</span><o:p></o:p></span></span></b></li>
</ul>

<p class=MsoNormal><b><span lang=EN-US style='font-size:10.0pt;font-family:
Arial;mso-bidi-font-family:"Times New Roman";color:black'><span
style='mso-spacerun:yes'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
</span></span></b><b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span style='font-size:10.0pt;font-family:宋体;mso-ascii-font-family:
Arial;mso-hansi-font-family:Arial;mso-bidi-font-family:"Times New Roman";
color:black'><a href="http://www.wdhy-hotel.com/cn/contacts_with_us.html" target="_blank">武汉弘毅大酒店博雅斋</a></span></b><b><span lang=EN-US style='font-size:10.0pt;
font-family:Arial;mso-bidi-font-family:"Times New Roman";color:black'><o:p></o:p></span></b></p>

<p class=MsoNormal><span lang=EN-US style='font-size:10.0pt;font-family:Arial;
mso-bidi-font-family:"Times New Roman";color:black'><span
style='mso-spacerun:yes'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
</span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp<span
style='mso-spacerun:yes'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span></span><span
style='font-size:10.0pt;font-family:宋体;mso-ascii-font-family:Arial;mso-hansi-font-family:
Arial;mso-bidi-font-family:"Times New Roman";color:black'>武汉市东湖路</span><span
lang=EN-US style='font-size:10.0pt;font-family:Arial;mso-bidi-font-family:"Times New Roman";
color:black'>136</span><span style='font-size:10.0pt;font-family:宋体;mso-ascii-font-family:
Arial;mso-hansi-font-family:Arial;mso-bidi-font-family:"Times New Roman";
color:black'>号</span><span lang=EN-US style='font-size:10.0pt;font-family:Arial;
mso-bidi-font-family:"Times New Roman";color:black'><o:p></o:p></span></p>

<p class=MsoNormal><span lang=EN-US style='font-size:10.0pt;font-family:Arial;
mso-bidi-font-family:"Times New Roman";color:black'><o:p>&nbsp;</o:p></span></p>

<ul style='margin-top:0cm' type=disc>
 <li class=MsoNormal style='color:black;mso-list:l1 level1 lfo1;tab-stops:list 36.0pt left 72.0pt 90.0pt'><b><span
     style='font-size:10.0pt;font-family:宋体;mso-ascii-font-family:Arial;
     mso-hansi-font-family:Arial;mso-bidi-font-family:"Times New Roman";
     color:#CC0033'>昆明站</span></b><span lang=EN-US style='font-size:10.0pt;
     color:windowtext'><span
     style='mso-spacerun:yes'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </span></span><b><span
     lang=EN-US style='font-size:10.0pt;font-family:Arial;mso-bidi-font-family:
     "Times New Roman"'>2008</span></b><b><span style='font-size:10.0pt;
     font-family:宋体;mso-ascii-font-family:Arial;mso-hansi-font-family:Arial;
     mso-bidi-font-family:"Times New Roman"'>年</span></b><b><span lang=EN-US
     style='font-size:10.0pt;font-family:Arial;mso-bidi-font-family:"Times New Roman"'>6</span></b><b><span
     style='font-size:10.0pt;font-family:宋体;mso-ascii-font-family:Arial;
     mso-hansi-font-family:Arial;mso-bidi-font-family:"Times New Roman"'>月</span></b><b><span
     lang=EN-US style='font-size:10.0pt;font-family:Arial;mso-bidi-font-family:
     "Times New Roman"'>19</span></b><b><span style='font-size:10.0pt;
     font-family:宋体;mso-ascii-font-family:Arial;mso-hansi-font-family:Arial;
     mso-bidi-font-family:"Times New Roman"'>日，星期四（</span></b><b><span
     lang=EN-US style='font-size:10.0pt;font-family:Arial;mso-bidi-font-family:
     "Times New Roman"'>09</span></b><b><span style='font-size:10.0pt;
     font-family:宋体;mso-ascii-font-family:Arial;mso-hansi-font-family:Arial;
     mso-bidi-font-family:"Times New Roman"'>：</span></b><b><span lang=EN-US
     style='font-size:10.0pt;font-family:Arial;mso-bidi-font-family:"Times New Roman"'>30</span></b><b><span
     style='font-size:10.0pt;font-family:宋体;mso-ascii-font-family:Arial;
     mso-hansi-font-family:Arial;mso-bidi-font-family:"Times New Roman"'>开始会议注册）</span></b><b><span
     style='font-size:10.0pt;font-family:Arial;mso-bidi-font-family:"Times New Roman"'>
     <span lang=EN-US><span style='mso-spacerun:yes'>&nbsp;&nbsp;</span><o:p></o:p></span></span></b></li>
</ul>

<p class=MsoNormal><b><span lang=EN-US style='font-size:10.0pt;font-family:
Arial;mso-bidi-font-family:"Times New Roman";color:black'><span
style='mso-spacerun:yes'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
</span></span></b><b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span style='font-size:10.0pt;font-family:宋体;mso-ascii-font-family:
Arial;mso-hansi-font-family:Arial;mso-bidi-font-family:"Times New Roman";
color:black'>中国科学院昆明动物研究所，三楼学术报告厅</span></b><b><span lang=EN-US
style='font-size:10.0pt;font-family:Arial;mso-bidi-font-family:"Times New Roman";
color:black'><o:p></o:p></span></b></p>

<p class=MsoNormal><span lang=EN-US style='font-size:10.0pt;font-family:Arial;
mso-bidi-font-family:"Times New Roman";color:black'><span
style='mso-spacerun:yes'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
</span></span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span style='font-size:10.0pt;font-family:宋体;mso-ascii-font-family:
Arial;mso-hansi-font-family:Arial;mso-bidi-font-family:"Times New Roman";
color:black'>昆明市教场东路</span><span lang=EN-US style='font-size:10.0pt;font-family:
Arial;mso-bidi-font-family:"Times New Roman";color:black'>32</span><span
style='font-size:10.0pt;font-family:宋体;mso-ascii-font-family:Arial;mso-hansi-font-family:
Arial;mso-bidi-font-family:"Times New Roman";color:black'>号</span><span
lang=EN-US style='font-size:10.0pt;font-family:Arial;mso-bidi-font-family:"Times New Roman";
color:black'><o:p></o:p></span></p>

<p class=MsoNormal><span lang=EN-US style='font-size:10.0pt;font-family:Arial;
mso-bidi-font-family:"Times New Roman";color:black'><o:p>&nbsp;</o:p></span></p>

<p class=MsoNormal><b><span style='font-size:10.0pt;font-family:宋体;mso-ascii-font-family:
Arial;mso-hansi-font-family:Arial;mso-bidi-font-family:"Times New Roman";
color:blue'>讲座日程安排</span></b><b><span lang=EN-US style='font-size:10.0pt;
font-family:Arial;mso-bidi-font-family:"Times New Roman";color:blue'><o:p></o:p></span></b></p>

<p class=MsoNormal><b><span lang=EN-US style='font-size:10.0pt;font-family:
Arial;mso-bidi-font-family:"Times New Roman";color:blue'><o:p>&nbsp;</o:p></span></b></p>

<table class=MsoNormalTable border=0 cellspacing=0 cellpadding=0 align="center"
 width=417 style='width:312.95pt;border-collapse:collapse;mso-table-lspace:
 9.0pt;margin-left:6.75pt;mso-table-rspace:9.0pt;margin-right:6.75pt;
 mso-table-anchor-vertical:paragraph;mso-table-anchor-horizontal:margin;
 mso-table-left:left;mso-table-top:7.25pt;mso-padding-alt:0cm 5.4pt 0cm 5.4pt'>
 <tr style='mso-yfti-irow:0;mso-yfti-firstrow:yes;height:15.75pt'>
  <td width=57 nowrap valign=bottom style='width:42.5pt;padding:0cm 5.4pt 0cm 5.4pt;
  height:15.75pt'>
  <p class=MsoNormal align=center style='text-align:center;mso-element:frame;
  mso-element-frame-hspace:9.0pt;mso-element-wrap:around;mso-element-anchor-vertical:
  paragraph;mso-element-anchor-horizontal:margin;mso-element-top:7.25pt;
  mso-height-rule:exactly'><b><span lang=EN-US style='font-size:10.0pt;
  font-family:Arial;mso-bidi-font-family:"Times New Roman"'>9:30<o:p></o:p></span></b></p>
  </td>
  <td width=361 nowrap valign=bottom style='width:270.45pt;padding:0cm 5.4pt 0cm 5.4pt;
  height:15.75pt'>
  <p class=MsoNormal style='mso-element:frame;mso-element-frame-hspace:9.0pt;
  mso-element-wrap:around;mso-element-anchor-vertical:paragraph;mso-element-anchor-horizontal:
  margin;mso-element-top:7.25pt;mso-height-rule:exactly'><b><span lang=EN-US
  style='font-size:10.0pt;font-family:Arial;mso-bidi-font-family:"Times New Roman"'><span
  style='mso-spacerun:yes'>&nbsp; </span>Registration<o:p></o:p></span></b></p>
  </td>
 </tr>
 <tr style='mso-yfti-irow:1;height:15.75pt'>
  <td width=57 nowrap valign=bottom style='width:42.5pt;background:silver;
  padding:0cm 5.4pt 0cm 5.4pt;height:15.75pt'>
  <p class=MsoNormal align=center style='text-align:center;mso-element:frame;
  mso-element-frame-hspace:9.0pt;mso-element-wrap:around;mso-element-anchor-vertical:
  paragraph;mso-element-anchor-horizontal:margin;mso-element-top:7.25pt;
  mso-height-rule:exactly'><b><span lang=EN-US style='font-size:10.0pt;
  font-family:Arial;mso-bidi-font-family:"Times New Roman"'>9:50<o:p></o:p></span></b></p>
  </td>
  <td width=361 nowrap valign=bottom style='width:270.45pt;background:silver;
  padding:0cm 5.4pt 0cm 5.4pt;height:15.75pt'>
  <p class=MsoNormal style='mso-element:frame;mso-element-frame-hspace:9.0pt;
  mso-element-wrap:around;mso-element-anchor-vertical:paragraph;mso-element-anchor-horizontal:
  margin;mso-element-top:7.25pt;mso-height-rule:exactly'><b><span lang=EN-US
  style='font-size:10.0pt;font-family:Arial;mso-bidi-font-family:"Times New Roman"'><span
  style='mso-spacerun:yes'>&nbsp; </span>Welcome<o:p></o:p></span></b></p>
  </td>
 </tr>
 <tr style='mso-yfti-irow:2;height:31.5pt'>
  <td width=57 nowrap valign=bottom style='width:42.5pt;padding:0cm 5.4pt 0cm 5.4pt;
  height:31.5pt'>
  <p class=MsoNormal align=center style='text-align:center;mso-element:frame;
  mso-element-frame-hspace:9.0pt;mso-element-wrap:around;mso-element-anchor-vertical:
  paragraph;mso-element-anchor-horizontal:margin;mso-element-top:7.25pt;
  mso-height-rule:exactly'><b><span lang=EN-US style='font-size:10.0pt;
  font-family:Arial;mso-bidi-font-family:"Times New Roman"'>10:00<o:p></o:p></span></b></p>
  <p class=MsoNormal style='mso-element:frame;mso-element-frame-hspace:9.0pt;
  mso-element-wrap:around;mso-element-anchor-vertical:paragraph;mso-element-anchor-horizontal:
  margin;mso-element-top:7.25pt;mso-height-rule:exactly'><b><span lang=EN-US
  style='font-size:10.0pt;font-family:Arial;mso-bidi-font-family:"Times New Roman"'><o:p>&nbsp;</o:p></span></b></p>
  </td>
  <td width=361 valign=bottom style='width:270.45pt;padding:0cm 5.4pt 0cm 5.4pt;
  height:31.5pt'>
  <p class=MsoNormal style='mso-element:frame;mso-element-frame-hspace:9.0pt;
  mso-element-wrap:around;mso-element-anchor-vertical:paragraph;mso-element-anchor-horizontal:
  margin;mso-element-top:7.25pt;mso-height-rule:exactly'><b><span lang=EN-US
  style='font-size:10.0pt;font-family:Arial;mso-bidi-font-family:"Times New Roman"'><span
  style='mso-spacerun:yes'>&nbsp; </span>Roche 454 Sequencing </span></b><b><span
  lang=EN-US style='font-family:宋体;mso-bidi-font-family:"Times New Roman"'>-</span></b><b><span
  lang=EN-US style='font-size:10.0pt;font-family:Arial;mso-bidi-font-family:
  "Times New Roman"'><br>
  <span style='mso-spacerun:yes'>&nbsp; </span>Applications in Biological and
  Disease Research<o:p></o:p></span></b></p>
  </td>
 </tr>
 <tr style='mso-yfti-irow:3;height:15.75pt'>
  <td width=57 nowrap valign=bottom style='width:42.5pt;padding:0cm 5.4pt 0cm 5.4pt;
  height:15.75pt'>
  <p class=MsoNormal align=center style='text-align:center;mso-element:frame;
  mso-element-frame-hspace:9.0pt;mso-element-wrap:around;mso-element-anchor-vertical:
  paragraph;mso-element-anchor-horizontal:margin;mso-element-top:7.25pt;
  mso-height-rule:exactly'><b><span lang=EN-US style='font-size:10.0pt;
  font-family:Arial;mso-bidi-font-family:"Times New Roman"'><o:p>&nbsp;</o:p></span></b></p>
  </td>
  <td width=361 nowrap valign=bottom style='width:270.45pt;padding:0cm 5.4pt 0cm 5.4pt;
  height:15.75pt'>
  <p class=MsoNormal style='text-indent:6.0pt;mso-element:frame;mso-element-frame-hspace:
  9.0pt;mso-element-wrap:around;mso-element-anchor-vertical:paragraph;
  mso-element-anchor-horizontal:margin;mso-element-top:7.25pt;mso-height-rule:
  exactly'><span lang=EN-US style='font-size:10.0pt;font-family:Arial;
  mso-bidi-font-family:"Times New Roman"'>Dr. Lei Du<o:p></o:p></span></p>
  <p class=MsoNormal style='text-indent:6.0pt;mso-element:frame;mso-element-frame-hspace:
  9.0pt;mso-element-wrap:around;mso-element-anchor-vertical:paragraph;
  mso-element-anchor-horizontal:margin;mso-element-top:7.25pt;mso-height-rule:
  exactly'><span lang=EN-US style='font-size:10.0pt;font-family:Arial;
  mso-bidi-font-family:"Times New Roman"'>Director Healthcare Informatics<o:p></o:p></span></p>
  <p class=MsoNormal style='text-indent:6.0pt;mso-element:frame;mso-element-frame-hspace:
  9.0pt;mso-element-wrap:around;mso-element-anchor-vertical:paragraph;
  mso-element-anchor-horizontal:margin;mso-element-top:7.25pt;mso-height-rule:
  exactly'><span lang=EN-US style='font-size:10.0pt;font-family:Arial;
  mso-bidi-font-family:"Times New Roman"'>Roche 454 Life Sciences, <st1:place
  w:st="on"><st1:country-region w:st="on">USA</st1:country-region></st1:place><o:p></o:p></span></p>
  </td>
 </tr>
 <tr style='mso-yfti-irow:4;height:15.75pt'>
  <td width=57 nowrap valign=bottom style='width:42.5pt;background:silver;
  padding:0cm 5.4pt 0cm 5.4pt;height:15.75pt'>
  <p class=MsoNormal align=center style='text-align:center;mso-element:frame;
  mso-element-frame-hspace:9.0pt;mso-element-wrap:around;mso-element-anchor-vertical:
  paragraph;mso-element-anchor-horizontal:margin;mso-element-top:7.25pt;
  mso-height-rule:exactly'><b><span lang=EN-US style='font-size:10.0pt;
  font-family:Arial;mso-bidi-font-family:"Times New Roman"'>10:50<o:p></o:p></span></b></p>
  </td>
  <td width=361 nowrap valign=bottom style='width:270.45pt;background:silver;
  padding:0cm 5.4pt 0cm 5.4pt;height:15.75pt'>
  <p class=MsoNormal style='mso-element:frame;mso-element-frame-hspace:9.0pt;
  mso-element-wrap:around;mso-element-anchor-vertical:paragraph;mso-element-anchor-horizontal:
  margin;mso-element-top:7.25pt;mso-height-rule:exactly'><b><span lang=EN-US
  style='font-size:10.0pt;font-family:Arial;mso-bidi-font-family:"Times New Roman"'><span
  style='mso-spacerun:yes'>&nbsp; </span>Coffee Break<o:p></o:p></span></b></p>
  </td>
 </tr>
 <tr style='mso-yfti-irow:5;height:15.75pt'>
  <td width=57 nowrap valign=bottom style='width:42.5pt;padding:0cm 5.4pt 0cm 5.4pt;
  height:15.75pt'>
  <p class=MsoNormal align=center style='text-align:center;mso-element:frame;
  mso-element-frame-hspace:9.0pt;mso-element-wrap:around;mso-element-anchor-vertical:
  paragraph;mso-element-anchor-horizontal:margin;mso-element-top:7.25pt;
  mso-height-rule:exactly'><b><span lang=EN-US style='font-size:10.0pt;
  font-family:Arial;mso-bidi-font-family:"Times New Roman"'>11:00<o:p></o:p></span></b></p>
  </td>
  <td width=361 nowrap valign=bottom style='width:270.45pt;padding:0cm 5.4pt 0cm 5.4pt;
  height:15.75pt'>
  <p class=MsoNormal style='mso-element:frame;mso-element-frame-hspace:9.0pt;
  mso-element-wrap:around;mso-element-anchor-vertical:paragraph;mso-element-anchor-horizontal:
  margin;mso-element-top:7.25pt;mso-height-rule:exactly'><b><span lang=EN-US
  style='font-size:10.0pt;font-family:Arial;mso-bidi-font-family:"Times New Roman"'><span
  style='mso-spacerun:yes'>&nbsp; </span>NimbleGen – High Definition Genomics<o:p></o:p></span></b></p>
  </td>
 </tr>
 <tr style='mso-yfti-irow:6;height:15.75pt'>
  <td width=57 nowrap valign=bottom style='width:42.5pt;padding:0cm 5.4pt 0cm 5.4pt;
  height:15.75pt'>
  <p class=MsoNormal align=center style='text-align:center;mso-element:frame;
  mso-element-frame-hspace:9.0pt;mso-element-wrap:around;mso-element-anchor-vertical:
  paragraph;mso-element-anchor-horizontal:margin;mso-element-top:7.25pt;
  mso-height-rule:exactly'><b><span lang=EN-US style='font-size:10.0pt;
  font-family:Arial;mso-bidi-font-family:"Times New Roman"'><o:p>&nbsp;</o:p></span></b></p>
  </td>
  <td width=361 valign=bottom style='width:270.45pt;padding:0cm 5.4pt 0cm 5.4pt;
  height:15.75pt'>
  <p class=MsoNormal style='text-indent:6.0pt;mso-element:frame;mso-element-frame-hspace:
  9.0pt;mso-element-wrap:around;mso-element-anchor-vertical:paragraph;
  mso-element-anchor-horizontal:margin;mso-element-top:7.25pt;mso-height-rule:
  exactly'><span lang=EN-US style='font-size:10.0pt;font-family:Arial;
  mso-bidi-font-family:"Times New Roman"'>Dr. Peter Matthiesen<o:p></o:p></span></p>
  <p class=MsoNormal style='text-indent:6.0pt;mso-element:frame;mso-element-frame-hspace:
  9.0pt;mso-element-wrap:around;mso-element-anchor-vertical:paragraph;
  mso-element-anchor-horizontal:margin;mso-element-top:7.25pt;mso-height-rule:
  exactly'><span lang=EN-US style='font-size:10.0pt;font-family:Arial;
  mso-bidi-font-family:"Times New Roman"'>Global Marketing Manager<o:p></o:p></span></p>
  <p class=MsoNormal style='text-indent:6.0pt;mso-element:frame;mso-element-frame-hspace:
  9.0pt;mso-element-wrap:around;mso-element-anchor-vertical:paragraph;
  mso-element-anchor-horizontal:margin;mso-element-top:7.25pt;mso-height-rule:
  exactly'><span lang=EN-US style='font-size:10.0pt;font-family:Arial;
  mso-bidi-font-family:"Times New Roman"'>Roche Diagnostics <st1:place w:st="on"><st1:City
   w:st="on">GmbH</st1:City>, <st1:country-region w:st="on">Germany</st1:country-region></st1:place><o:p></o:p></span></p>
  </td>
 </tr>
 <tr style='mso-yfti-irow:7;mso-yfti-lastrow:yes;height:15.75pt'>
  <td width=57 nowrap valign=bottom style='width:42.5pt;background:silver;
  padding:0cm 5.4pt 0cm 5.4pt;height:15.75pt'>
  <p class=MsoNormal align=center style='text-align:center;mso-element:frame;
  mso-element-frame-hspace:9.0pt;mso-element-wrap:around;mso-element-anchor-vertical:
  paragraph;mso-element-anchor-horizontal:margin;mso-element-top:7.25pt;
  mso-height-rule:exactly'><b><span lang=EN-US style='font-size:10.0pt;
  font-family:Arial;mso-bidi-font-family:"Times New Roman"'>11:50<o:p></o:p></span></b></p>
  </td>
  <td width=361 nowrap valign=bottom style='width:270.45pt;background:silver;
  padding:0cm 5.4pt 0cm 5.4pt;height:15.75pt'>
  <p class=MsoNormal style='mso-element:frame;mso-element-frame-hspace:9.0pt;
  mso-element-wrap:around;mso-element-anchor-vertical:paragraph;mso-element-anchor-horizontal:
  margin;mso-element-top:7.25pt;mso-height-rule:exactly'><b><span lang=EN-US
  style='font-size:10.0pt;font-family:Arial;mso-bidi-font-family:"Times New Roman"'><span
  style='mso-spacerun:yes'>&nbsp; </span>Conclusion<o:p></o:p></span></b></p>
  </td>
 </tr>
</table>

<p class=MsoNormal style='margin-left:18.0pt;tab-stops:81.0pt 90.0pt'><b><span
lang=EN-US style='font-size:10.0pt;mso-bidi-font-size:12.0pt;font-family:Arial;
mso-bidi-font-family:"Times New Roman";color:black'><o:p>&nbsp;</o:p></span></b></p>



<p class=MsoNormal><span lang=EN-US style='font-size:10.0pt;font-family:Arial;
mso-bidi-font-family:"Times New Roman";color:black'>&nbsp;<v:shape id="_x0000_i1072"
 type="#_x0000_t75" alt="button_note" style='width:11.25pt;height:11.25pt'>
 <v:imagedata src="image/image002.png" o:href="http://image.exct.net/lib/fefd16717d6601/i/1/222adcb3-f.gif"/>
</v:shape> <span style='mso-spacerun:yes'>&nbsp;&nbsp;</span></span><span
style='font-size:10.0pt;font-family:宋体;mso-ascii-font-family:Arial;mso-hansi-font-family:
Arial;mso-bidi-font-family:"Times New Roman";color:black'>*&nbsp;报名时间截止到</span><span
lang=EN-US style='font-size:10.0pt;font-family:Arial;mso-bidi-font-family:"Times New Roman";
color:black'>2008</span><span style='font-size:10.0pt;font-family:宋体;
mso-ascii-font-family:Arial;mso-hansi-font-family:Arial;mso-bidi-font-family:
"Times New Roman";color:black'>年</span><span lang=EN-US style='font-size:10.0pt;
font-family:Arial;mso-bidi-font-family:"Times New Roman";color:black'>6</span><span
style='font-size:10.0pt;font-family:宋体;mso-ascii-font-family:Arial;mso-hansi-font-family:
Arial;mso-bidi-font-family:"Times New Roman";color:black'>月</span><span
lang=EN-US style='font-size:10.0pt;font-family:Arial;mso-bidi-font-family:"Times New Roman";
color:black'>12</span><span style='font-size:10.0pt;font-family:宋体;mso-ascii-font-family:
Arial;mso-hansi-font-family:Arial;mso-bidi-font-family:"Times New Roman";
color:black'>日，由于场地有限，我们</span><span style='font-size:10.0pt;font-family:宋体;
mso-bidi-font-family:"Times New Roman";color:black'>将</span><span
style='font-size:10.0pt;font-family:宋体;mso-ascii-font-family:Arial;mso-hansi-font-family:
Arial;mso-bidi-font-family:"Times New Roman";color:black'>与每场的前</span><span
lang=EN-US style='font-size:10.0pt;font-family:Arial;mso-bidi-font-family:"Times New Roman";
color:black'>40</span><span style='font-size:10.0pt;font-family:宋体;mso-ascii-font-family:
Arial;mso-hansi-font-family:Arial;mso-bidi-font-family:"Times New Roman";
color:black'>名报名者以<u>电话</u>或<u>邮件</u>确认参会信息。</span><span lang=EN-US
style='font-size:10.0pt'><o:p></o:p></span></p>

<p class=MsoNormal><span lang=EN style='font-size:10.0pt;mso-ansi-language:
EN'><o:p>&nbsp;</o:p></span></p>

<p class=MsoNormal><b><span lang=EN-US style='font-size:10.0pt;mso-bidi-font-size:
12.0pt;font-family:Arial;mso-bidi-font-family:"Times New Roman";color:blue'><span
style='mso-spacerun:yes'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </span></span></b><span
style='font-size:10.0pt;font-family:宋体;mso-ascii-font-family:Arial;mso-hansi-font-family:
Arial'>请确定参加本次会议的人员，按下列格式填妥回执。</span><span lang=EN-US style='font-size:10.0pt;
font-family:Arial;mso-bidi-font-family:"Angsana New"'><o:p></o:p></span></p>

<p class=MsoNormal><span style='font-size:10.0pt;font-family:宋体;mso-ascii-font-family:
Arial;mso-hansi-font-family:Arial'>　</span><b><span lang=EN-US
style='font-size:10.0pt;mso-bidi-font-size:12.0pt;font-family:Arial;mso-bidi-font-family:
"Times New Roman";color:blue'><o:p></o:p></span></b></p>

<p class=MsoNormal><span lang=EN-US style='font-size:10.0pt;font-family:Arial;
mso-bidi-font-family:"Times New Roman";color:black'><span
style='mso-spacerun:yes'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </span></span><span
style='font-size:10.0pt;font-family:宋体;mso-ascii-font-family:Arial;mso-hansi-font-family:
Arial;mso-bidi-font-family:"Times New Roman";color:black'>感谢您长期以来对罗氏诊断优质产品和解决方案的支持与信任！期待着您的光临！</span><span
lang=EN-US style='font-size:10.0pt;font-family:Arial;mso-bidi-font-family:"Times New Roman";
color:black'><o:p></o:p></span></p>

<p class=MsoNormal><b><span lang=EN-US style='font-size:10.0pt;mso-bidi-font-size:
12.0pt;font-family:Arial;mso-bidi-font-family:"Times New Roman";color:blue'><o:p>&nbsp;</o:p></span></b></p>

<p class=MsoNormal><b><span style='font-size:10.0pt;mso-bidi-font-size:12.0pt;
font-family:宋体;mso-ascii-font-family:Arial;mso-hansi-font-family:Arial;
mso-bidi-font-family:"Times New Roman";color:blue'>讲座回执</span></b><b><span
lang=EN-US style='font-size:10.0pt;mso-bidi-font-size:12.0pt;font-family:Arial;
mso-bidi-font-family:"Times New Roman";color:blue'><span
style='mso-spacerun:yes'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
</span><o:p></o:p></span></b></p>

<p class=MsoNormal><b><span lang=EN-US style='font-size:10.0pt;mso-bidi-font-size:
12.0pt;font-family:Arial;mso-bidi-font-family:"Times New Roman";color:blue'><span
style='mso-spacerun:yes'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
</span><o:p></o:p></span></b></p>

<table class=MsoTableGrid border=1 cellspacing=0 cellpadding=0
 style='border-collapse:collapse;border:none;mso-border-alt:solid windowtext .5pt;
 mso-yfti-tbllook:480;mso-padding-alt:0cm 5.4pt 0cm 5.4pt;mso-border-insideh:
 .5pt solid windowtext;mso-border-insidev:.5pt solid windowtext'>
 <form id="form" name="form" method="post" action="<?php echo $_SERVER['PHP_SELF']?>" onSubmit="javascript:return Check()" >
 <tr style='mso-yfti-irow:0;mso-yfti-firstrow:yes;height:114.1pt'>
  <td width=590 style='width:442.8pt;border:solid windowtext 1.0pt;mso-border-alt:
  solid windowtext .5pt;padding:0cm 5.4pt 0cm 5.4pt;height:114.1pt'>
  <p class=MsoNormal style='line-height:150%;tab-stops:9.0pt 27.0pt'><b
  style='mso-bidi-font-weight:normal'><span style='font-size:10.0pt;mso-bidi-font-size:
  12.0pt;line-height:150%;font-family:"Arial Unicode MS";mso-fareast-font-family:
  "Arial Unicode MS";mso-bidi-font-family:"Arial Unicode MS";color:#333399'>联系方式

	<span
  lang=EN-US><span style='mso-spacerun:yes'>&nbsp;&nbsp;&nbsp; </span><span
  style='mso-spacerun:yes'>&nbsp;</span></span></span></b><span lang=EN-US
  style='font-size:10.0pt;mso-bidi-font-size:12.0pt;line-height:150%;
  font-family:"Arial Unicode MS";mso-fareast-font-family:"Arial Unicode MS";
  mso-bidi-font-family:"Arial Unicode MS";color:#333399;mso-bidi-font-weight:
  bold'>(*</span><span style='font-size:10.0pt;mso-bidi-font-size:12.0pt;
  line-height:150%;font-family:"Arial Unicode MS";mso-fareast-font-family:"Arial Unicode MS";
  mso-bidi-font-family:"Arial Unicode MS";color:#333399;mso-bidi-font-weight:
  bold'>必填）<span lang=EN-US><o:p></o:p></span></span></p>
  <p class=MsoNormal style='margin-left:21.0pt'><span lang=EN-US
  style='font-size:10.0pt;mso-bidi-font-size:12.0pt;font-family:宋体;color:#333399'>*</span><span
  style='font-size:10.0pt;mso-bidi-font-size:12.0pt;font-family:宋体;color:black'>单位名称:&nbsp;<span
  lang=EN-US><o:p></o:p></span></span><input type="text" name="corp"/></p>
  <p class=MsoNormal style='margin-left:21.0pt'><span lang=EN-US
  style='font-size:10.0pt;mso-bidi-font-size:12.0pt;font-family:宋体;color:#333399'>*</span><span
  style='font-size:10.0pt;mso-bidi-font-size:12.0pt;font-family:宋体;color:black'>姓名:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="text" name="realname"/>
  <p class=MsoNormal style='margin-left:21.0pt'><span lang=EN-US
  style='font-size:10.0pt;mso-bidi-font-size:12.0pt;font-family:宋体;color:#333399'>*</span><span
  style='font-size:10.0pt;mso-bidi-font-size:12.0pt;font-family:宋体;color:black'>电子邮件:&nbsp;<input type="text" name="mail"/><span
  lang=EN-US><span
  style='mso-spacerun:yes'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
  </span><o:p></o:p></span></span></p>
  <p class=MsoNormal style='margin-left:21.0pt'><span lang=EN-US
  style='font-size:10.0pt;mso-bidi-font-size:12.0pt;font-family:宋体;color:#333399'>*</span><span
  style='font-size:10.0pt;mso-bidi-font-size:12.0pt;font-family:宋体;color:black'>电话:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="text" name="telephone"/><span
  lang=EN-US> <o:p></o:p></span></span></p>
  <p class=MsoNormal style='margin-left:21.0pt'><span style='font-size:10.0pt;
  mso-bidi-font-size:12.0pt;font-family:宋体;color:black'>联系地址:&nbsp;&nbsp;<input type="text" name="address"/></span><span
  lang=EN-US style='font-size:10.0pt;mso-bidi-font-size:12.0pt;font-family:
  宋体;mso-bidi-font-family:"Arial Unicode MS"'><o:p></o:p></span></p>
  <p class=MsoNormal style='margin-left:21.0pt'><span style='font-size:10.0pt;
  mso-bidi-font-size:12.0pt;font-family:宋体;mso-bidi-font-family:"Arial Unicode MS"'>职务：<span
  lang=EN-US><INPUT TYPE="checkbox" name="jobTitle[]" value="教授"></span>教授 <span lang=EN-US><INPUT TYPE="checkbox" name="jobTitle[]" value="研究员"></span>研究员 <span lang=EN-US><INPUT TYPE="checkbox" name="jobTitle[]" value="实验技师"></span>实验技师 <span lang=EN-US><INPUT TYPE="checkbox" name="jobTitle[]" value="医生"></span>医生 <span lang=EN-US><INPUT TYPE="checkbox" name="jobTitle[]" value="博士"></span>博士 <span lang=EN-US><INPUT TYPE="checkbox" name="jobTitle[]" value="硕士"></span>硕士<span lang=EN-US><INPUT TYPE="checkbox" name="jobTitle[]" value="研究生"></span>研究生 <span lang=EN-US><INPUT TYPE="checkbox" name="jobTitle[]" value="其它"></span>其他
  </td>
 </tr>
 <tr style='mso-yfti-irow:1;height:76.75pt'>
  <td width=590 valign=top nowrap='true' style='width:442.8pt;border:solid windowtext 1.0pt;
  border-top:none;mso-border-top-alt:solid windowtext .5pt;mso-border-alt:solid windowtext .5pt;
  padding:0cm 5.4pt 0cm 5.4pt;height:76.75pt'>
  <p class=MsoNormal style='line-height:150%;tab-stops:9.0pt 27.0pt'><b
  style='mso-bidi-font-weight:normal'><span style='font-size:10.0pt;mso-bidi-font-size:
  12.0pt;line-height:150%;font-family:"Arial Unicode MS";mso-fareast-font-family:
  "Arial Unicode MS";mso-bidi-font-family:"Arial Unicode MS";color:#333399'>关注的技术领域<span
  lang=EN-US><o:p></o:p></span></span></b></p>
  <p class=MsoNormal style='margin-left:36.0pt;text-indent:-18.0pt'><span
  lang=EN-US style='font-size:10.0pt;mso-bidi-font-size:12.0pt;font-family:
  宋体;mso-bidi-font-family:"Arial Unicode MS"'><INPUT TYPE="checkbox" name="field[]" value="微阵列、芯片"></span>
  <span style='font-size:10.0pt;mso-bidi-font-size:12.0pt;
  font-family:宋体;mso-bidi-font-family:"Arial Unicode MS"'>微阵列、芯片<span
  lang=EN-US><span
  style='mso-spacerun:yes'>&nbsp;&nbsp;&nbsp;&nbsp; </span><INPUT TYPE="checkbox" name="field[]" value="基因测序"></span>基因测序<span lang=EN-US><span
  style='mso-spacerun:yes'>&nbsp;&nbsp;&nbsp;&nbsp; </span><INPUT TYPE="checkbox" name="field[]" value="基因分型和突变检测"></span>基因分型和突变检测<span lang=EN-US><span
  style='mso-spacerun:yes'>&nbsp; </span><INPUT TYPE="checkbox" name="field[]" value="单核苷酸多态性位点验证"></span>单核苷酸多态性位点验证<span lang=EN-US><o:p></o:p></span></span></p>
  <p class=MsoNormal style='margin-left:36.0pt;text-indent:-18.0pt'><span
  lang=EN-US style='font-size:10.0pt;mso-bidi-font-size:12.0pt;font-family:
  宋体;mso-bidi-font-family:"Arial Unicode MS"'><INPUT TYPE="checkbox" name="field[]" value="疾病相关区域验证"></span><span style='font-size:10.0pt;mso-bidi-font-size:12.0pt;
  font-family:宋体;mso-bidi-font-family:"Arial Unicode MS"'>疾病相关区域验证<span
  lang=EN-US><span style='mso-spacerun:yes'>&nbsp; </span><INPUT TYPE="checkbox" name="field[]" value="外显子测序"></span>外显子测序<span lang=EN-US><span
  style='mso-spacerun:yes'>&nbsp;&nbsp; </span><INPUT TYPE="checkbox" name="field[]" value="基因沉默"></span>基因沉默<span lang=EN-US><span
  style='mso-spacerun:yes'>&nbsp;&nbsp;&nbsp; </span><span
  style='mso-spacerun:yes'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span><span
  style='mso-spacerun:yes'>&nbsp;</span><INPUT TYPE="checkbox" name="field[]" value="PCR">PCR</span>和<span lang=EN-US>RT-PCR<span
  style='mso-spacerun:yes'>&nbsp;&nbsp;&nbsp;&nbsp;
  </span><span style='mso-spacerun:yes'>&nbsp;</span><o:p></o:p></span></span></p>
  <p class=MsoNormal style='margin-left:36.0pt;text-indent:-18.0pt;line-height:
  150%;tab-stops:9.0pt 27.0pt'><span lang=EN-US style='font-size:10.0pt;
  mso-bidi-font-size:12.0pt;line-height:150%;font-family:宋体;mso-bidi-font-family:
  "Arial Unicode MS"'><INPUT TYPE="checkbox" name="field[]" value="细胞生物学"></span><span style='font-size:10.0pt;mso-bidi-font-size:12.0pt;
  line-height:150%;font-family:宋体;mso-bidi-font-family:"Arial Unicode MS"'>细胞生物学<span
  lang=EN-US><span
  style='mso-spacerun:yes'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span><span
  style='mso-spacerun:yes'></span><INPUT TYPE="checkbox" name="field[]" value="蛋白表达"></span>蛋白表达<span lang=EN-US><span
  style='mso-spacerun:yes'>&nbsp;&nbsp; </span><span
  style='mso-spacerun:yes'>&nbsp;&nbsp;</span><INPUT TYPE="checkbox" name="field[]" value="其它领域"></span>其它领域 
  </td>
 </tr>
 <tr style='mso-yfti-irow:2;height:141.55pt'>
  <td width=590 valign=top style='width:442.8pt;border:solid windowtext 1.0pt;
  border-top:none;mso-border-top-alt:solid windowtext .5pt;mso-border-alt:solid windowtext .5pt;
  padding:0cm 5.4pt 0cm 5.4pt;height:141.55pt'>
  <p class=MsoNormal><b style='mso-bidi-font-weight:normal'><span
  style='font-size:10.0pt;mso-bidi-font-size:12.0pt;font-family:"Arial Unicode MS";
  mso-fareast-font-family:"Arial Unicode MS";mso-bidi-font-family:"Arial Unicode MS";
  color:#333399'>请选择参加 “生物和疾病研究的重大突破－罗氏<span lang=EN-US>454</span>测序<span
  lang=EN-US> &amp; NimbleGen</span>基因芯片” 巡回讲座所在的城市</span></b><span
  style='font-size:7.0pt;font-family:宋体;mso-ascii-font-family:Arial;mso-hansi-font-family:
  Arial'>：</span><b style='mso-bidi-font-weight:normal'><span lang=EN-US
  style='font-size:10.0pt;mso-bidi-font-size:12.0pt;font-family:"Arial Unicode MS";
  mso-fareast-font-family:"Arial Unicode MS";mso-bidi-font-family:"Arial Unicode MS";
  color:#333399'><o:p></o:p></span></b></p>
  <p class=MsoNormal><b style='mso-bidi-font-weight:normal'><span lang=EN-US
  style='font-size:10.0pt;mso-bidi-font-size:12.0pt;font-family:"Arial Unicode MS";
  mso-fareast-font-family:"Arial Unicode MS";mso-bidi-font-family:"Arial Unicode MS"'><o:p>&nbsp;</o:p></span></b></p>
  <p class=MsoNormal style='tab-stops:16.7pt'><b style='mso-bidi-font-weight:
  normal'><span lang=EN-US style='font-size:10.0pt;mso-bidi-font-size:12.0pt;
  font-family:"Arial Unicode MS";mso-fareast-font-family:"Arial Unicode MS";
  mso-bidi-font-family:"Arial Unicode MS"'><span
  style='mso-spacerun:yes'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </span></span></b><span
  lang=EN-US style='font-size:10.0pt;mso-bidi-font-size:12.0pt;font-family:
  宋体;mso-bidi-font-family:"Arial Unicode MS"'>&nbsp;<INPUT TYPE="checkbox" name="city[]" value="2008年6月16日(9:30-11:50)：北京，中科院北京基因组研究所，二楼会议室
"><span style='mso-spacerun:yes'>&nbsp;</span></span><span lang=EN-US
  style='font-size:10.0pt;mso-bidi-font-size:12.0pt;font-family:宋体'>2008</span><span
  style='font-size:10.0pt;mso-bidi-font-size:12.0pt;font-family:宋体'>年<span
  lang=EN-US>6</span>月<span lang=EN-US>16</span>日<span lang=EN-US>(9:30-11:50)</span>：北京，中科院北京基因组研究所，二楼会议室<span
  lang=EN-US><o:p></o:p></span></span></p>
  <p class=MsoNormal><span lang=EN-US style='font-size:10.0pt;mso-bidi-font-size:
  12.0pt;font-family:宋体'><span style='mso-spacerun:yes'>&nbsp;&nbsp; </span><span
  style='mso-spacerun:yes'>&nbsp;</span><INPUT TYPE="checkbox" name="city[]" value="2008年6月17日(9:30-11:50)：上海，复旦大学生物医学研究院，明道楼二楼会议室
  "><span style='mso-spacerun:yes'>&nbsp;</span>2008</span><span
  style='font-size:10.0pt;mso-bidi-font-size:12.0pt;font-family:宋体'>年<span
  lang=EN-US>6</span>月<span lang=EN-US>17</span>日<span lang=EN-US>(9:30-11:50)</span>：上海，复旦大学生物医学研究院，明道楼二楼会议室<span
  lang=EN-US><o:p></o:p></span></span></p>
  <p class=MsoNormal style='tab-stops:16.7pt'><span lang=EN-US
  style='font-size:10.0pt;mso-bidi-font-size:12.0pt;font-family:宋体'><span
  style='mso-spacerun:yes'>&nbsp;&nbsp; </span><span
  style='mso-spacerun:yes'>&nbsp;</span><INPUT TYPE="checkbox" name="city[]" value="2008年6月18日(9:30-11:50)：武汉，武汉弘毅大酒店博雅斋"><span style='mso-spacerun:yes'>&nbsp;</span>2008</span><span
  style='font-size:10.0pt;mso-bidi-font-size:12.0pt;font-family:宋体'>年<span
  lang=EN-US>6</span>月<span lang=EN-US>18</span>日<span lang=EN-US>(9:30-11:50)</span>：武汉，武汉弘毅大酒店博雅斋<span
  lang=EN-US><o:p></o:p></span></span></p>
  <p class=MsoNormal style='tab-stops:16.7pt'><span lang=EN-US
  style='font-size:10.0pt;mso-bidi-font-size:12.0pt;font-family:宋体'><span
  style='mso-spacerun:yes'>&nbsp;&nbsp; </span><span
  style='mso-spacerun:yes'>&nbsp;</span><INPUT TYPE="checkbox" name="city[]" value="2008年6月19日(9:30-11:50)：昆明，中国科学院昆明动物研究所，三楼学术报告厅
  "><span style='mso-spacerun:yes'>&nbsp;</span>2008</span><span
  style='font-size:10.0pt;mso-bidi-font-size:12.0pt;font-family:宋体'>年<span
  lang=EN-US>6</span>月<span lang=EN-US>19</span>日<span lang=EN-US>(9:30-11:50)</span>：</span><span
  style='font-size:10.0pt;mso-bidi-font-size:12.0pt;font-family:宋体;mso-ascii-font-family:
  Arial;mso-hansi-font-family:Arial'>昆明，中国科学院昆明动物研究所，三楼学术报告厅</span><span
  lang=EN-US style='font-size:10.0pt;mso-bidi-font-size:12.0pt;font-family:
  Arial;mso-bidi-font-family:"Angsana New"'><o:p></o:p></span></p>
  <p class=MsoNormal><span lang=EN-US style='font-size:10.0pt;mso-bidi-font-size:
  12.0pt;font-family:Arial;mso-bidi-font-family:"Angsana New"'><span
  style='mso-spacerun:yes'>&nbsp; </span><span
  style='mso-spacerun:yes'>&nbsp;&nbsp;&nbsp;</span><span
  style='mso-spacerun:yes'>&nbsp;&nbsp;</span><INPUT TYPE="checkbox" name="city[]" value="所在城市没有安排讲座，但仍希望获得活动或产品信息"><span style='mso-spacerun:yes'>&nbsp;</span></span><span
  style='font-size:10.0pt;mso-bidi-font-size:12.0pt;font-family:宋体;mso-ascii-font-family:
  Arial;mso-hansi-font-family:Arial'>所在城市没有安排讲座，但仍希望获得活动或产品信息</span><b
  style='mso-bidi-font-weight:normal'><span lang=EN-US style='font-size:11.0pt;
  mso-bidi-font-size:12.0pt;font-family:"Arial Unicode MS";mso-fareast-font-family:
  "Arial Unicode MS";mso-bidi-font-family:"Arial Unicode MS"'><o:p></o:p></span></b></p>
  </td>
 </tr>
 <tr style='mso-yfti-irow:3;mso-yfti-lastrow:yes;height:28.75pt'>
  <td width=590 valign=top style='width:442.8pt;border:solid windowtext 1.0pt;
  border-top:none;mso-border-top-alt:solid windowtext .5pt;mso-border-alt:solid windowtext .5pt;
  padding:0cm 5.4pt 0cm 5.4pt;height:28.75pt'>
  <p class=MsoNormal><b style='mso-bidi-font-weight:normal'><span
  style='font-size:10.0pt;mso-bidi-font-size:12.0pt;font-family:"Arial Unicode MS";
  mso-fareast-font-family:"Arial Unicode MS";mso-bidi-font-family:"Arial Unicode MS";
  color:#333399'>备注:
  <br>
  <textarea name="comments" rows="5" cols="50" wrap="off">
  </textarea>
  <br>
  
  </span></b><span lang=EN-US style='font-size:10.0pt;
  mso-bidi-font-size:12.0pt;font-family:宋体;color:black'><o:p></o:p></span></p>
  <input type="submit" name="submit" value="提交">
  </td>
<tr>
 </form>
</table>

<p class=MsoNormal><span lang=EN-US style='font-size:11.0pt;font-family:Arial;
mso-bidi-font-family:"Times New Roman";color:black'><o:p>&nbsp;</o:p></span></p>

<p class=MsoNormal><span lang=EN style='mso-ansi-language:EN'><o:p>&nbsp;</o:p></span></p>

<p class=MsoNormal><span lang=EN style='mso-ansi-language:EN'><o:p>&nbsp;</o:p></span></p>

<p class=MsoNormal><b><span style='font-size:10.0pt;mso-bidi-font-size:12.0pt;
font-family:宋体;mso-bidi-font-family:Minion'>罗氏诊断产品（上海）有限公司<span lang=EN-US><span
style='mso-spacerun:yes'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
</span><span
style='mso-spacerun:yes'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span></span></span></b><b
style='mso-bidi-font-weight:normal'><i style='mso-bidi-font-style:normal'><span
lang=EN-US style='font-family:黑体;mso-hansi-font-family:"Arial Unicode MS";
mso-bidi-font-family:"Arial Unicode MS"'><o:p></o:p></span></i></b></p>

<table class=MsoNormalTable border=0 cellspacing=0 cellpadding=0 align=left
 style='border-collapse:collapse;mso-yfti-tbllook:480;mso-table-lspace:9.0pt;
 margin-left:6.75pt;mso-table-rspace:9.0pt;margin-right:6.75pt;mso-table-anchor-vertical:
 paragraph;mso-table-anchor-horizontal:margin;mso-table-left:left;mso-table-top:
 26.45pt;mso-padding-alt:0cm 5.4pt 0cm 5.4pt'>
 <tr style='mso-yfti-irow:0;mso-yfti-firstrow:yes;page-break-inside:avoid'>
  <td width=196 rowspan=2 valign=top style='width:147.35pt;padding:0cm 5.4pt 0cm 5.4pt'>
  <p class=MsoNormal style='mso-element:frame;mso-element-frame-hspace:9.0pt;
  mso-element-wrap:around;mso-element-anchor-vertical:paragraph;mso-element-anchor-horizontal:
  margin;mso-element-top:26.45pt;mso-height-rule:exactly'><span
  style='font-size:8.0pt;font-family:宋体'>上海市淮海中路<span lang=EN-US>1045</span>号<span
  lang=EN-US><o:p></o:p></span></span></p>
  <p class=MsoNormal style='mso-element:frame;mso-element-frame-hspace:9.0pt;
  mso-element-wrap:around;mso-element-anchor-vertical:paragraph;mso-element-anchor-horizontal:
  margin;mso-element-top:26.45pt;mso-height-rule:exactly'><span
  style='font-size:8.0pt;font-family:宋体'>淮海国际广场<span lang=EN-US>12</span>楼<span
  lang=EN-US><o:p></o:p></span></span></p>
  <p class=MsoNormal style='mso-element:frame;mso-element-frame-hspace:9.0pt;
  mso-element-wrap:around;mso-element-anchor-vertical:paragraph;mso-element-anchor-horizontal:
  margin;mso-element-top:26.45pt;mso-height-rule:exactly'><span lang=EN-US
  style='font-size:8.0pt;font-family:宋体'>Tel: 021-2412 1000<o:p></o:p></span></p>
  <p class=MsoNormal style='mso-element:frame;mso-element-frame-hspace:9.0pt;
  mso-element-wrap:around;mso-element-anchor-vertical:paragraph;mso-element-anchor-horizontal:
  margin;mso-element-top:26.45pt;mso-height-rule:exactly'><span lang=EN-US
  style='font-size:8.0pt;font-family:宋体'>Fax: 021-2412 1188<o:p></o:p></span></p>
  <p class=MsoNormal><span style='font-size:8.0pt;font-family:宋体'>邮编：<span
  lang=EN-US> 200031</span></span><b><span lang=EN-US style='font-size:8.0pt'> <o:p></o:p></span></b></p>
  <p class=MsoNormal><span lang=EN-US style='font-size:8.0pt;mso-bidi-font-weight:
  bold'>E-mail: china.as@roche.com</span><span lang=EN-US style='font-size:
  8.0pt;font-family:宋体;mso-bidi-font-weight:bold'><o:p></o:p></span></p>
  </td>
  <td width=213 valign=top style='width:159.75pt;padding:0cm 5.4pt 0cm 5.4pt'>
  <p class=MsoNormal style='mso-element:frame;mso-element-frame-hspace:9.0pt;
  mso-element-wrap:around;mso-element-anchor-vertical:paragraph;mso-element-anchor-horizontal:
  margin;mso-element-top:26.45pt;mso-height-rule:exactly'><b><span
  style='font-size:8.0pt;font-family:宋体'>北京办事处<span lang=EN-US><o:p></o:p></span></span></b></p>
  </td>
  <td width=173 valign=top style='width:129.7pt;padding:0cm 5.4pt 0cm 5.4pt'>
  <p class=MsoNormal style='mso-element:frame;mso-element-frame-hspace:9.0pt;
  mso-element-wrap:around;mso-element-anchor-vertical:paragraph;mso-element-anchor-horizontal:
  margin;mso-element-top:26.45pt;mso-height-rule:exactly'><b><span
  style='font-size:8.0pt;font-family:宋体'>广州办事处<span lang=EN-US><o:p></o:p></span></span></b></p>
  </td>
 </tr>
 <tr style='mso-yfti-irow:1;mso-yfti-lastrow:yes;page-break-inside:avoid'>
  <td width=213 valign=top style='width:159.75pt;padding:0cm 5.4pt 0cm 5.4pt'>
  <p class=MsoNormal style='mso-element:frame;mso-element-frame-hspace:9.0pt;
  mso-element-wrap:around;mso-element-anchor-vertical:paragraph;mso-element-anchor-horizontal:
  margin;mso-element-top:26.45pt;mso-height-rule:exactly'><span
  style='font-size:8.0pt;font-family:宋体;mso-bidi-font-family:"Times New Roman"'>北京市东城区东长安街<span
  lang=EN-US>1</span>号东方广场<span lang=EN-US><br>
  </span>东方经贸城中二办公楼六层<span lang=EN-US>09</span>室<span lang=EN-US><br>
  Tel: 010-8515 4100<br>
  Fax: 010-8515 4100<br>
  </span>邮编：<span lang=EN-US>&nbsp;100738</span></span><span lang=EN-US
  style='font-size:8.0pt;font-family:宋体'><o:p></o:p></span></p>
  </td>
  <td width=173 valign=top style='width:129.7pt;padding:0cm 5.4pt 0cm 5.4pt'>
  <p class=MsoNormal style='mso-element:frame;mso-element-frame-hspace:9.0pt;
  mso-element-wrap:around;mso-element-anchor-vertical:paragraph;mso-element-anchor-horizontal:
  margin;mso-element-top:26.45pt;mso-height-rule:exactly'><span
  style='font-size:8.0pt;font-family:宋体'>广州市环世东路<span lang=EN-US>403</span>号<span
  lang=EN-US><o:p></o:p></span></span></p>
  <p class=MsoNormal style='mso-element:frame;mso-element-frame-hspace:9.0pt;
  mso-element-wrap:around;mso-element-anchor-vertical:paragraph;mso-element-anchor-horizontal:
  margin;mso-element-top:26.45pt;mso-height-rule:exactly'><span
  style='font-size:8.0pt;font-family:宋体'>广州国际电子大厦<span lang=EN-US>25</span>楼全层<span
  lang=EN-US><o:p></o:p></span></span></p>
  <p class=MsoNormal style='mso-element:frame;mso-element-frame-hspace:9.0pt;
  mso-element-wrap:around;mso-element-anchor-vertical:paragraph;mso-element-anchor-horizontal:
  margin;mso-element-top:26.45pt;mso-height-rule:exactly'><span lang=EN-US
  style='font-size:8.0pt;font-family:宋体'>Tel: 020 8713 2600<o:p></o:p></span></p>
  <p class=MsoNormal style='mso-element:frame;mso-element-frame-hspace:9.0pt;
  mso-element-wrap:around;mso-element-anchor-vertical:paragraph;mso-element-anchor-horizontal:
  margin;mso-element-top:26.45pt;mso-height-rule:exactly'><span lang=EN-US
  style='font-size:8.0pt;font-family:宋体'>Fax: 020-8713 2700<o:p></o:p></span></p>
  <p class=MsoNormal style='mso-element:frame;mso-element-frame-hspace:9.0pt;
  mso-element-wrap:around;mso-element-anchor-vertical:paragraph;mso-element-anchor-horizontal:
  margin;mso-element-top:26.45pt;mso-height-rule:exactly'><span
  style='font-size:8.0pt;font-family:宋体'>邮编：<span lang=EN-US> 510095<b><o:p></o:p></b></span></span></p>
  </td>
 </tr>

</table>
<p class=MsoNormal style='mso-margin-top-alt:auto;mso-margin-bottom-alt:auto'><b><span
lang=EN-US style='font-size:10.0pt;mso-bidi-font-size:12.0pt;font-family:Arial;
mso-bidi-font-family:"Times New Roman";color:black'><o:p>&nbsp;</o:p></span></b></p>

<p class=MsoNormal><span lang=EN-US style='mso-bidi-font-family:"Times New Roman";
color:black;display:none;mso-hide:all'><o:p>&nbsp;</o:p></span></p>

<p class=MsoNormal><span lang=EN-US><o:p>&nbsp;</o:p></span></p>

</div>

</body>

</html>

<?php require_once('smartyconfig.php'); 
$maincontent=ob_get_contents();
ob_get_clean();
$tpl->assign("maincontent",$maincontent);
$tpl->display('template_main.php');
?>
