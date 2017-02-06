<script language="javascript" src="include/dedeajax2.js"></script>
<script language="javascript">
function CheckUser(){
var taget_obj = document.getElementById('_userboxform');
myajax = new DedeAjax(taget_obj,false,false,"","","");
myajax.SendGet2("/templets/default_diagnostics/userboxsta.php");
DedeXHTTP = null;
}
</script>
<div id="header">
<div id="head">
    <div id="head_middle">
        <a href="" id="logo">
            <img src="/templets/default_diagnostics/img/2013022753081569.png" alt="logo图片">
        </a>
        <div id="head_middle_right">				
				<img src="/templets/default_diagnostics/img/logo_tel.png" alt="0512-62956558" class='su_tel'>				
				<div id="head_ul">
					<ul >
						<li  class="logo_right"><img src="/templets/default_diagnostics/img/slogan.png"></li>						
						<li  class="language_bg"><a href="" style="color:#ffffff;">中文</a></li>
						<li  class="language_en"><a href="">English</a></li>
						
					</ul>
				</div>
				
				<span style="position:relative;left:440px;top:13px;">欢迎你，</span>
				<span style="color:blue;position:relative;left:440px;top:13px;"><?php echo $_SESSION['username']; ?>&nbsp;</span>
				<a href="logoff.php" style="color:gray;position:relative;left:440px;top:13px;">[退出]</a>			
				<div id="search">
					<form method="get" name="id" action="http://diagnostics.geneskies.com:8001/project_search.php"> 
						<input name="searchitem" id="id" value="请输入搜索关键词" class="skey" onfocus="this.select()" onclick="if(this.value=='请输入搜索关键词')this.value=''" type="text">
						<input name="submit" class="submit" value=" " type="submit" style="cursor:pointer;">
					</form>
				</div>
			</div>
        <div id="nav_c">
<!--
    <ul id="nav">
	<li class="top"><a href="" class="top_link"><span>网站首页</span></a></li>
	<li class="top"><a href="" id="products" class="top_link"><span>公司简介</span></a></li>
	<li class="top"><a href="" id="services" class="top_link"><span class="down">技术中心</span></a>
		<ul class="sub">
            
			<li>
                
                <a href="" class="fly">拷贝数(CNV)检测</a>
                <ul>
                
					<li><a href="">AccuCopy多重CNV检测</a></li>
                
					<li><a href="">CNVplex高通量CNV检测</a></li>
                
				</ul>
            </li>
            
			<li>
            
            <a href="" class="fly">第二代测序技术</a>
                <ul>
                
					<li><a href="">全外显子组测序</a></li>
                
					<li><a href="">全基因组测序</a></li>
                
					<li><a href="">全基因组RNA-Seq</a></li>
                
					<li><a href="">目的区段富集测序</a></li>
                
					<li><a href="">全基因组microRNA分析</a></li>
                
				</ul>
            </li>
            
			<li>
            
           <a href="" class="fly">基因测序及突变筛查</a>
                <ul>
                
					<li><a href="">候选基因测序及筛查</a></li>
                
					<li><a href="">cDNA常规测序及筛查</a></li>
                
				</ul>
            </li>
            
			<li>
            
            <a href="" class="fly">SNP基因分型</a>
                <ul>
                
					<li><a href="">iMLDRTM多重SNP分型</a></li>
                
					<li><a href="">SNaPshot多重SNP分型</a></li>
                
				</ul>
            </li>
            
		</ul>
	</li>
	<li class="top"><a href="" id="contacts" class="top_link"><span class="down">检测中心</span></a>
		<ul class="sub">
            
			<li>
            
            <a href="" class="fly">家庭遗传病分子检测</a>
                <ul>
                
					<li><a href="">假肥大型肌营养不良检测</a></li>
                
				</ul>
            </li>
            
			<li>
            
             <a href="" class="fly">出生缺陷筛查与诊断</a>
                <ul>
                
					<li><a href="">DiGeorge综合症检测</a></li>
                
					<li><a href="">测腭心面综合症检测</a></li>
                
					<li><a href="">Cat-Eye综合症检测</a></li>
                
					<li><a href="">22q11重复综合症检测</a></li>
                
					<li><a href="">先天愚型及发育异常</a></li>
                
					<li><a href="">染色体数目异常检测</a></li>
                
				</ul>
            </li>
            
			<li>
            
             <a href="" class="fly">产前筛查</a>
                <ul>
                
					<li><a href="">产前筛查检测</a></li>
                
				</ul>
            </li>
            
			<li>
            
             <a href="" class="fly">个体化治疗</a>
                <ul>
                
					<li><a href="">个体化治疗检测</a></li>
                
				</ul>
            </li>
            
			<li>
            
             <a href="" class="fly">癌症早期检测</a>
                <ul>
                
					<li><a href="">癌症早期检测检测</a></li>
                
				</ul>
            </li>
            
            </ul>
	</li>
	<li class="top"><a href="" id="shop" class="top_link"><span class="down">产品中心</span></a>
		<ul class="sub">
            
			<li>
            
            <a href="" class="fly">按疾病系统分类</a>
                <ul>
                
					<li><a href="">骨内骨髓系统</a></li>
                
				</ul>
            </li>
            
			<li>
            
            <a href="" class="fly">按检测位点分类</a>
                <ul>
                
					<li><a href="">假肥大型股不良检测</a></li>
                
				</ul>
            </li>
            
			<li>
            
            <a href="" class="fly">其它</a>
                <ul>
                
					<li><a href="">染色体数目异常</a></li>
                
				</ul>
            </li>
            
		</ul>
	</li>
	<li class="top"><a href="" id="privacy" class="top_link"><span class="down">技术支持</span></a>
        <ul class="sub">
			<li><a href="">留言咨询</a></li>
			<li><a href="" target="_blank">检测结果查询</a></li>
			<li><a href="" target="_blank">订单查询</a></li>
            <li><a href="">常见问题</a></li>
		</ul>
    </li>
    <li class="top"><a href="" id="news" class="top_link"><span>新闻中心</span></a>
        <ul class="sub">
             
                <li><a href="">公司新闻</a></li>
             
                <li><a href="">行业新闻</a></li>
             
                <li><a href="">最新公告</a></li>
            
            </ul>
    </li>
    <li class="top"><a href="" id="network" class="top_link"><span>营销网点</span></a></li>
	 <li class="top"><a href="" id="contact" class="top_link"><span class="down">联系方式</span></a>
        <ul class="sub">
			<li><a href="">人才招聘</a></li>
			<li><a href="">联系我们</a></li>
		</ul>
    </li>

</ul>
-->

    </div>
    </div>    
</div>
</div>
