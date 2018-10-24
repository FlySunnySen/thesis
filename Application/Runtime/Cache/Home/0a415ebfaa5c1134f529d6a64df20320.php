<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>


	<head>
		<meta charset="utf-8">
	
		<meta name="description" content="" />
		<meta name="keywords" content="" />
		<meta name="robots" content="" />
		<meta name="viewport" content="width=device-width, minimum-scale=1.0, maximum-scale=1.0">
		<link rel="stylesheet" href="/biye/Public/teacher/css/sty.css" media="all" />
		<link rel="stylesheet" href="/biye/Public/teacher/css/style.css" media="all" />
		
	<title>课题申请</title>

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
						<h1>选择课题</h1>
						<h2>教师一览</h2>
					</hgroup>
				</header>
				<div class="content">
					<table id="myTable">
						<thead>
							<tr>
								<td>教研室</td>
								<td>老师工号</td>
								<td>老师姓名</td>
								<td>性别</td>
								<td>系别</td>
								<td>研究方向</td>
								<td>职称</td>
								<td>联系方式</td>
								<td>QQ</td>
								<td>电子邮箱</td>
							</tr>
						</thead>
						
						<?php if(is_array($apply)): $i = 0; $__LIST__ = $apply;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v): $mod = ($i % 2 );++$i;?><form method="get" action="/biye/index.php/Home/Apply/index">
						<tr>
						    <td><?php echo ($v["ERG_name"]); ?></td>
							<td><?php echo ($v["Tnum"]); ?></td>
							<td><a href="/biye/index.php/Home/Apply/topic/Tnum/<?php echo ($v["Tnum"]); ?>"><?php echo ($v["Tname"]); ?></a></td>
							<td><?php echo ($v["sex"]); ?></td>
							<td><?php echo ($v["depart"]); ?></td>
							<td><?php echo ($v["direction"]); ?></td>
							<td><?php echo ($v["Title"]); ?></td>
							<td><?php echo ($v["phone"]); ?></td>
							<td><?php echo ($v["qq"]); ?></td>
							<td><?php echo ($v["email"]); ?></td>
						</tr> 
						</form><?php endforeach; endif; else: echo "" ;endif; ?>
						
						
					</table>
				</div>

	    	</section>
		</section>
	</body>
    
</html>