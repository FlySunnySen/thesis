<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>


	<head>
		<meta charset="utf-8">
	
		<meta name="viewport" content="width=device-width, minimum-scale=1.0, maximum-scale=1.0">
		<link rel="stylesheet" href="/biye/Public/teacher/css/sty.css" media="all" />
		<link rel="stylesheet" href="/biye/Public/teacher/css/style.css" media="all" />
		
<title>我的课题</title>
<link rel="stylesheet" href="/biye/Public/teacher/css/style.css" media="all" />


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
		
		    <h1>我的课题列表</h1>
						
		</hgroup>
	</header>

<div class="content">
	
	
		
			<a href="/biye/index.php/Teacher/Topic/add/Cnum/<?php echo ($tnum); ?>"><button>添加课题</button></a>
		
		    <a href="/biye/index.php/Teacher/Score/importGrage"><button>导出成绩单</button></a>
		    
            <table id="myTable">
				<thead>
					<tr>
						<td>指导老师</td>
						<td>课题名</td>
						<td>类别</td>
						<td>来源</td>
						<td>学生</td>
						<td>任务分派</td>
						<td>传任务书</td>
						<td>传答辩稿</td>
						<td>成绩单</td>
						<td>删除</td>
					</tr>
				</thead>
				<?php if(is_array($topic)): foreach($topic as $key=>$v): ?><tr>
					<td><?php echo ($v["Tname"]); ?></td>
					<td><?php echo ($v["Cname"]); ?></td>
					<td><?php echo ($v["Ctype"]); ?></td>
					<td><?php echo ($v["Csource"]); ?></td>
					<td><?php echo ($v["Sname"]); ?></td>
					<td>
						<a href="/biye/index.php/Teacher/Topic/giveStu/Cnum/<?php echo ($v["Cnum"]); ?>/Tnum/<?php echo ($v["Tnum"]); ?>">分配学生</a>
					</td>
					<td>
						<a href="/biye/index.php/Teacher/Topic/upload_taskbook/Snum/<?php echo ($v["Snum"]); ?>">跟新任务书</a>
					</td>
					<td>
						<a href="/biye/index.php/Teacher/Topic/upload_denfense_draft/Snum/<?php echo ($v["Snum"]); ?>">跟新答辩稿</a>
					</td>
					<td>
						<a href="/biye/index.php/Teacher/Topic/grade/Snum/<?php echo ($v["Snum"]); ?>">成绩单</a>
					</td>
					<td>
						<a href="/biye/index.php/Teacher/Topic/delTopic/Cnum/<?php echo ($v["Cnum"]); ?>">
							<button class="button blue" style="color:white;height: 25px;padding-top: 2px;">删除</button>
						</a>
						
					</td>
				</tr><?php endforeach; endif; ?>
			</table>
	
	
</div>

	    	</section>
		</section>
	</body>
    
</html>