<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>


	<head>
		<meta charset="utf-8">
	
		<meta name="viewport" content="width=device-width, minimum-scale=1.0, maximum-scale=1.0">
		<link rel="stylesheet" href="/biye/Public/teacher/css/sty.css" media="all" />
		<link rel="stylesheet" href="/biye/Public/teacher/css/style.css" media="all" />
		
	<title>成绩单</title>

	</head>

	<body>
		<div class="testing">
			<header class="main">
			<h1><strong>毕业设计管理系统后台</strong></h1>
				<input type="text" value="search" />
			</header>
			<section class="user">
				<div class="profile-img">
					<p><?php echo (session('Tname')); ?>-你进入的系统是:<strong>【<?php echo (session('selected_year')); ?>】</strong></p>
				</div>
                
                
               
				<div class="buttons">
					
					<a href="/biye/index.php/Teacher/Login/logout"><span class="button blue">登出</span></a>
				</div>
			</section>
		</div>
		<nav>
			<ul>
				<!--
                	以下是教师的功能
                -->
				<?php if(in_array(($role), explode(',',"1,2"))): ?><li class="section">
								<a href="/biye/index.php/Teacher/index/index" ><span class="icon">&#128276;</span>首页</a>
							</li>
							
							<li>
								<a href="/biye/index.php/Teacher/Topic/all"   ><span class="icon">&#128101;</span>全部课题 </a>
							</li>
							
							<li>
								<a href="/biye/index.php/Teacher/Topic/trial"><span class="icon">&#128100;</span>课题审批</a>
							</li>
							
							<li>
								<a href="/biye/index.php/Teacher/Topic/my_theme"><span class="icon">&#128100;</span>我的课题 </a>
							</li>
							
							<li>
								<a href="/biye/index.php/Teacher/MyStudent/index" ><span class="icon">&#128196;</span>我的学生</a>
							</li>
							
							<li>
								<a href="/biye/index.php/Teacher/Score/Ggrade" ><span class="icon">&#128202;</span>指导评分</a>
							</li>
							
							<li>
								<a href="/biye/index.php/Teacher/Score/Pgrade" ><span class="icon">&#128202;</span>论文评阅</a>
							</li>
							
							<li>
								<a href="/biye/index.php/Teacher/Score/Rgrade"><span class="icon">&#128202;</span>答辩评分</a>
							</li>
							
							<li>
								<a href="/biye/index.php/Teacher/TeaInformation/information"><span class="icon">&#9881;</span>个人信息修改</a>
							</li>
							
							<li>
								<a href="/biye/index.php/Teacher/TeaInformation/changePwd"><span class="icon">&#9881;</span>密码修改</a>
							</li><?php endif; ?>
			<!--	以下为二级管理员特有的功能-->
			
			<?php if(($role) == "2"): ?><li>
					<a href="/biye/index.php/Teacher/TeacherDefense/index"><span class="icon">&#9776;</span>答辩小组管理</a>
					
					
				</li><?php endif; ?>
			<!--
            	以下为超级管理员的功能
            -->
			<?php if(($role) == "3"): ?><li>
			    	<a href="/biye/index.php/Teacher/information/index"><span class="icon">&#128276;</span>新闻公告管理</a>
			    </li>
                 
				<li>
					<a href="/biye/index.php/Teacher/teacherManage/index"><span class="icon">&#128101;</span> 教师信息管理 </a>
				</li>				
				
				<li>
					<a href="/biye/index.php/Teacher/student/index"><span class="icon">&#128101;</span> 学生管理 </a>
				</li>
				
				<li>
					<a href="/biye/index.php/Teacher/teacherManage/ERG_group"><span class="icon">&#128101;</span>教研室管理</a>
				</li>
				
				<li><a href="/biye/index.php/Teacher/defence/index/status/1" ><span class="icon">&#128196;</span>一辩分组</a></li>
				
				<li><a href="/biye/index.php/Teacher/defence/index/status/2" ><span class="icon">&#128196;</span>二辩分组</a></li>
				
					<li>
								<a href="/biye/index.php/Teacher/config/changePwd"><span class="icon">&#9881;</span>密码修改</a>
					</li>
				
				<li><a href="/biye/index.php/Teacher/config/index" ><span class="icon">&#128202;</span>系统管理</a></li><?php endif; ?>
			</ul>
		</nav>

		<section class="alert">
			<div class="green">
				<p>欢迎进入毕业设计管理系统</p>
				
			</div>
		</section>
		<section class="content">
			<section class="widget">
				
	<header>
					<hgroup>
						<h1>成绩单</h1>
						<h2>学号：<?php echo ($Snum); ?>  ---   学生姓名:<?php echo ($Sname); ?></h2>
					</hgroup>

				</header>
					
			
				<div class="content">
			    <button>导出成绩单</button>	  
					<table id="myTable">
					    <tr>
					    	<td colspan="5">
					    	指导老师评分（满分60分）
					    	</td>
					    </tr>
						<tr>
							<td>序号</td>
							<td>考核项目</td>
							<td>满分</td>
							<td>得分</td>
							<td>评语</td>
							
						</tr>
						<tr>
							<td>1</td>
							<td>工作态度与纪律</td>
							<td>10</td>
							<td><?php echo ($Ggrade1); ?></td>
							<td rowspan="5">
                    <textarea name="txtGuidComment" rows="8" cols="20" id="txtGuidComment" style="width:95%;"><?php echo ($Gtext); ?>
</textarea>
                            </td>  
						</tr>
						<tr>
							<td>2</td>
							<td>基本理论、专业知识、基本技能和外语水平</td>
							<td>10</td>
							<td><?php echo ($Ggrade2); ?></td>
						</tr>
						<tr>
							<td>3</td>
							<td>完成情况与水平、工作量及完成质量</td>
							<td>20</td>
							<td><?php echo ($Ggrade3); ?></td>
						</tr>
						<tr>
							<td>4</td>
							<td>独立工作能力、分析解决问题和实际工作能力</td>
							<td>15</td>
							<td><?php echo ($Ggrade4); ?></td>
						</tr>
						<tr>
							<td>5</td>
							<td>创新能力</td>
							<td>5</td>
							<td><?php echo ($Ggrade5); ?></td>
						</tr>
					    <tr>
					    	 <td colspan="5">

					    	2.评阅教师评分（满分20分）评阅人：
					    	</td>
					    </tr>
					    <tr>
					    	<td>序号</td>
							<td>考核项目</td>
							<td>满分</td>
							<td>得分</td>
							<td>评语</td>
					    </tr>
					    <tr>
					    	<td>6</td>
					    	<td>质量(正确性、条理性、创造性和实用性）</td>
					    	<td>12</td>
					    	<td><?php echo ($Pgrade1); ?></td>
					    	 <td rowspan="2">
			                     <textarea name="txtGuidComment" rows="7" cols="20" id="txtGuidComment" style="width:95%;"><?php echo ($Ptext); ?>
</textarea>
			
			                </td>      
					    </tr>
					     <tr>
					    	<td>7</td>
					    	<td>成果的技术水平（理论、分析、计算、实验和实物性能）</td>
					    	<td>8</td>
					    	<td><?php echo ($Pgrade2); ?></td>
					    </tr>
					    <tr>
					    	<td colspan="5">
					    	  3.答辩组教师评分（满分20分）	
					    	</td>
					    </tr>
					     <tr>
					    	<td>序号</td>
							<td>考核项目</td>
							<td>满分</td>
							<td>得分</td>
							<td>评语</td>
					    </tr>
					    <tr>
					    	<td>8</td>
					    	<td>完成任务情况与水平</td>
					    	<td>5</td>
					    	<td><?php echo ($Rgrade1); ?></td>
					    	<td rowspan="4">
				                    <textarea name="txtTalkComment" rows="8" cols="20" id="txtTalkComment" style="width:95%;"><?php echo ($Rtext); ?>
									</textarea>
					        </td>               

					    </tr>
					     <tr>
					    	<td>9</td>
					    	<td>论文、设计任务书、图纸与实物的质量</td>
					    	<td>5</td>
					    	<td><?php echo ($Rgrade2); ?></td>
					    </tr>
					     <tr>
					    	<td>10</td>
					    	<td>答辩时讲述的系统性和语言表达能力</td>
					    	<td>5</td>
					    	<td><?php echo ($Rgrade3); ?></td>
					    </tr>
					     <tr>
					    	<td>11</td>
					    	<td>回答问题的正确性</td>
					    	<td>5</td>
					    	<td><?php echo ($Rgrade4); ?></td>
					    </tr>
				</div>
	

	    	</section>
		</section>
	</body>
    
</html>