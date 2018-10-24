<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>


	<head>
		<meta charset="utf-8">
	
		<meta name="description" content="" />
		<meta name="keywords" content="" />
		<meta name="robots" content="" />
		<meta name="viewport" content="width=device-width, minimum-scale=1.0, maximum-scale=1.0">
		<link rel="stylesheet" href="/biye/Public/teacher/css/sty.css" media="all" />
		<link rel="stylesheet" href="/biye/Public/teacher/css/style.css" media="all" />
		
	<title>我的课题</title>

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
						<h1>我的课题信息</h1>
						<h2>学生姓名:<?php echo ($_SESSION['student']['name']); ?></h2>
					</hgroup>
					<aside>
						<a href="/biye/index.php/Home/MyTopic/teacher/<?php echo (session('tnum')); ?>">导师姓名：<?php echo (session('tname')); ?></a>
					</aside>
				</header>
				<div class="content">
				    
				<?php if($topic != null): ?><table id="myTable">
						<?php if(is_array($topic)): $i = 0; $__LIST__ = $topic;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v): $mod = ($i % 2 );++$i;?><tr>
								<td>课题名</td>
								<td><?php echo ($v["Cname"]); ?></td>
							</tr>
							<tr>
								<td>课题类别</td>
								<td><?php echo ($v["Ctype"]); ?></td>
							</tr>
							<tr>
								<td>课题来源</td>
								<td><?php echo ($v["Csource"]); ?></td>
							</tr>
							<tr>
								<td>课题简介</td>
								<td><textarea style="height: 100px;" disabled="disabled"><?php echo ($v["Ctext"]); ?></textarea></td>
							</tr><?php endforeach; endif; else: echo "" ;endif; ?>
					 </table>
				
				<?php else: ?>
				   
				   <table id="myTable">
				    	<tr>
				    		<td>课题名称</td>
				    		<td>课题类型</td>
				    		<td>课题来源</td>
				    		<td>课题简介</td>
				    		<td>教师</td>
				    		<td>状态</td>
				    	</tr>
				    	<?php if(is_array($data2)): foreach($data2 as $key=>$vo): ?><tr>
				    			<td><?php echo ($vo["Cname"]); ?></td>
				    			<td><?php echo ($vo["Ctype"]); ?></td>
				    			<td><?php echo ($vo["Csource"]); ?></td>
				    			<td><?php echo ($vo["Ctext"]); ?></td>
				    			<td><?php echo ($vo["Tname"]); ?></td>
				    			<td style="color: red;">审核中</td>				    			
				    		</tr><?php endforeach; endif; ?>
				    </table><?php endif; ?>
			
					 
				</div>

	    	</section>
		</section>
	</body>
    
</html>