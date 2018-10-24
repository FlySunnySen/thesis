<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>


	<head>
		<meta charset="utf-8">
	
		<meta name="description" content="" />
		<meta name="keywords" content="" />
		<meta name="robots" content="" />
		<meta name="viewport" content="width=device-width, minimum-scale=1.0, maximum-scale=1.0">
		<link rel="stylesheet" href="/biye/Public/teacher/css/sty.css" media="all" />
		<link rel="stylesheet" href="/biye/Public/teacher/css/style.css" media="all" />
		
	<title>我的信息</title>

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
						<h1>我的信息</h1>
						<h2>学生姓名:<?php echo ($_SESSION['student']['name']); ?></h2>
					</hgroup>
				</header>
				<div class="content">
					<table id="myTable">
					<?php if(is_array($student)): $i = 0; $__LIST__ = $student;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v): $mod = ($i % 2 );++$i;?><tr>
							<td>学号：</td>
							<td><?php echo ($v["Snum"]); ?></td>
						</tr>
						<tr>
							<td>姓名</td>
							<td><?php echo ($v["Sname"]); ?></td>
						</tr>
						<tr>
							<td>性别</td>
							<td><?php echo ($v["sex"]); ?></td>
						</tr>
						<tr>
							<td>专业方向</td>
							<td><?php echo ($v["class"]); ?></td>
						</tr>
						<tr>
							<td>联系方式</td>
							<td><?php echo ($v["phone"]); ?></td>
						</tr>
						<tr>
							<td>电子邮箱</td>
							<td><?php echo ($v["email"]); ?></td>
						</tr>
						<tr>
							<td>QQ</td>
							<td><?php echo ($v["qq"]); ?></td>
						</tr><?php endforeach; endif; else: echo "" ;endif; ?>
						
					</table>
					<br>
					<a href="/biye/index.php/Home/Student/revise/<?php echo ($v["Snum"]); ?>"><button>修改信息</button></a>
					<a href="/biye/index.php/Home/Student/editpwd/<?php echo ($v["Snum"]); ?>"><button>修改密码</button></a>
				</div>

	    	</section>
		</section>
	</body>
    
</html>