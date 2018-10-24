<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>


	<head>
		<meta charset="utf-8">
	
		<meta name="viewport" content="width=device-width, minimum-scale=1.0, maximum-scale=1.0">
		<link rel="stylesheet" href="/biye/Public/teacher/css/sty.css" media="all" />
		<link rel="stylesheet" href="/biye/Public/teacher/css/style.css" media="all" />
		
	<title><?php echo ($status); ?>辩分组管理</title>

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
		
		    <h1><?php echo ($status); ?>辩分组管理  </h1>
				<h2>未分配的学生人数：<?php echo ($count); ?></h2>		
		</hgroup>
	</header>
	
	
	<div class="content">
					<a href="/biye/index.php/Teacher/Defence/add/status/<?php echo ($status); ?>"><button class="green" style="margin-bottom: 10px;">新增分组</button></a>
					<table id="myTable">
						<thead>
							<tr>
								<td>分组编号</td>
								<td>组长</td>
								<td>分组成员</td>
								<td>答辩时间</td>						
								<td>答辩教室</td>
								<td>答辩学生</td>
								<td>操作</td>
							</tr>
						</thead>
						<?php if(is_array($defenseinfo)): foreach($defenseinfo as $key=>$vo): ?><tr>
							<td><?php echo ($vo["defense_group"]); ?></td>
							<td><?php echo ($vo["admin"]); ?></td>
							<td><?php echo ($vo["TEA"]); ?></td>
							<td><?php echo ($vo["time"]); ?></td>
							<td><?php echo ($vo["class"]); ?></td>
							<td><?php echo ($vo["STU"]); ?></td>
							<td>
								<a href="/biye/index.php/Teacher/Defence/editTeam/defense_group/<?php echo ($vo["defense_group"]); ?>">修改</a>
								<a href="/biye/index.php/Teacher/Defence/delectTeam/defense_group/<?php echo ($vo["defense_group"]); ?>" style="margin-left: 15px;">删除</a>
								<a href="/biye/index.php/Teacher/Defence/showAddStudent/defense_group/<?php echo ($vo["defense_group"]); ?>/year/<?php echo ($vo["year"]); ?>/ERG_group/<?php echo ($vo["ERG_group"]); ?>/status/<?php echo ($status); ?>" style="margin-left: 15px;">分配学生</a></td>
						</tr><?php endforeach; endif; ?>
					</table>
				</div>
		<div class="page">
			<?php echo ($page); ?>
		</div>
	

	    	</section>
		</section>
	</body>
    
</html>