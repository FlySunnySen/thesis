<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>


	<head>
		<meta charset="utf-8">
		<title>Retina Dashboard</title>
		<meta name="description" content="" />
		<meta name="keywords" content="" />
		<meta name="robots" content="" />
		<meta name="viewport" content="width=device-width, minimum-scale=1.0, maximum-scale=1.0">
		<link rel="stylesheet" href="/biye/Public/teacher/css/sty.css" media="all" />
		<link rel="stylesheet" href="/biye/Public/teacher/css/style.css" media="all" />
		
	<title>修改密码</title>

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
						<h1>修改密码</h1>
						<h2>学生姓名:<?php echo ($_SESSION['student']['name']); ?></h2>
					</hgroup>
				</header>
				<div class="content">
				<form method="post"  action="/biye/index.php/Home/Student/editpwd">
				
					<table id="myTable">
						
						
						<tr>
						    		<td>原密码</td>
							<td><input type="password" name="oldpwd" id="oldpwd" required="required"></td>
						
						</tr>
						<tr>
								<td>新密码</td>
							<td><input type="password" name="newpwd" id="newpwd" required="required"></td>
							
						</tr>    
						
						
					</table>
					<br />
					
					<input type="submit" value="确认信息" />
					<input type="reset" value="取消修改" />
				</form>
				</div>

	    	</section>
		</section>
	</body>
    
</html>