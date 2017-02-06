<div id="leftsiderbar">
        <div id="project_left">
            <h1></h1>
            <dl id="left_top_dl">
                <dd>
                <dl>               
                    <dt id='part1' onclick="cookieset('part1');"><span>项目管理</span></dt>
                        <dd><!-- style="display: none;" -->
                        <ul>						
                            <li><a href="project.php">项目查看和修改</a></li>                        
                            <li><a href="project_show_f.php?type=2">已经完成项目</a></li>
							<li><a href="project_show_f.php?type=3">已经结清项目</a></li>
							<li><a href="member/manager_order.php">报告下载管理</a></li>							
                           <!--- <li><a href="http://192.168.1.10:901/passwd" target="_blank">修改Z盘密码</a></li> -->
                            <li><a href="project_show2.php">项目分类检索</a></li>							
							<li>
								<a><form action="project_search.php" method="get" name="SearchForm"  id="SearchForm" style="margin:auto">
									<input type="text" name="searchitem" size="10" style="width:100px;height:20px" />
									<input type="submit" name="Submit" value="搜索" />
								</form></a>
							</li>							                        
                        </ul>
                        </dd>                    
                        <dt id='part2' onclick="cookieset('part2');"><span>其它</span></dt>
                        <dd><!-- style="display: none;" -->
                        <ul>
                            <li><a href="http://mail.geneskies.com" target="_blank">邮箱登录</a></li>                        
                            <li><a href="http://192.168.1.10:8000" target="_blank">生物信息软件</a></li>                        
                            <!--<li><a href="help.php" target="_blank">帮助说明</a></li>-->                        
                        </ul>
                        </dd>                                        
                </dl>
                </dd>
            </dl>
        </div>
 </div>