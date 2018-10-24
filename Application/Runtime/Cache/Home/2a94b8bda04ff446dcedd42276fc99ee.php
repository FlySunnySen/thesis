<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>


	<head>
		<meta charset="utf-8">
	
		<meta name="description" content="" />
		<meta name="keywords" content="" />
		<meta name="robots" content="" />
		<meta name="viewport" content="width=device-width, minimum-scale=1.0, maximum-scale=1.0">
		<link rel="stylesheet" href="/biye/Public/teacher/css/sty.css" media="all" />
		<link rel="stylesheet" href="/biye/Public/teacher/css/style.css" media="all" />
		
	<title>首页</title>

	</head>

	<body>
		<div class="testing">
			<header class="main">
			<h1><strong>毕业设计管理系统后台</strong></h1>
				<input type="text" value="search" />
			</header>
			<section class="user">
				<div class="profile-img">
					<p><?php echo ($_SESSION['student']['name']); ?>--<strong>欢迎你</strong></p>
				</div>
                
                
               
				<div class="buttons">
					
					<a href="/biye/index.php/Home/Login/logout"><span class="button blue">登出</span></a>
				</div>
			</section>
		</div>
		<nav>
		     <ul>
				
				<li class="section">
					<a href="/biye/index.php/Home/index/index"><span class="icon">&#59146;</span>新闻</a>
				</li>
				
				<li >
					<a href="/biye/index.php/Home/Topic/index"><span class="icon">&#59146;</span>课题一览</a>
				</li>
				<li>
					<a href="/biye/index.php/Home/Apply/index"><span class="icon">&#128101;</span>课题申请</a>
				</li>
				<li>
					<a href="/biye/index.php/Home/MyTopic/index"><span class="icon">&#128196;</span>我的课题</a>
				</li>
				<li>
					<a href="/biye/index.php/Home/Grade/index"><span class="icon">&#128202;</span>我的成绩</a>
				</li>
				<li>
					<a href="/biye/index.php/Home/Student/index"><span class="icon">&#128101;</span>学生信息</a>
				</li>
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
						<h1>公告一览</h1>
						
					</hgroup>
				</header>
				<div class="content">
					<table id="myTable">
						<thead>
							<tr>
								<td>公告编号</td>
								<td>公告标题</td>
								<td>发送时间</td>						
							
							</tr>
						</thead>
						<?php if(is_array($new)): foreach($new as $key=>$vo): ?><tr>
							<td><?php echo ($vo["infonum"]); ?></td>
							<td><a href='/biye/index.php/Home/information/show/infonum/<?php echo ($vo["infonum"]); ?>'><?php echo ($vo["infotitle"]); ?></a></td>
							<td><?php echo ($vo["infotime"]); ?></td>
						
							
						</tr><?php endforeach; endif; ?>
					</table>
				</div>
		

		<script src="/biye/Public/teacher/js/jquery.min.js"></script>
	
	
	
	    	</section>
		</section>
	</body>
    
</html>