<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>


	<head>
		<meta charset="utf-8">
	
		<meta name="viewport" content="width=device-width, minimum-scale=1.0, maximum-scale=1.0">
		<link rel="stylesheet" href="/biye/Public/teacher/css/sty.css" media="all" />
		<link rel="stylesheet" href="/biye/Public/teacher/css/style.css" media="all" />
		
	<title>教师信息管理</title>

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
	    		<h1>
	    			教师信息管理
	    		</h1>
	    		<h2>
	    			教师总数：<?php echo ($count); ?>
	    		</h2>
	    	</hgroup>
	    </header>
	    
		<div class="content">
			<a href="/biye/index.php/Teacher/TeacherManage/addTea"><button>添加教师</button></a>
			<form style="display:none" action="/biye/index.php/Teacher/TeacherManage/assign_teacher" method="post" enctype="multipart/form-data">
				　　<input type="file" name="file" value="">
				</form>
			<a href="javascript:;" class="import"><button>批量导入</button></a>
			<table id="myTable">
				<thead>
					<tr>
						<td>教师名称</td>
						<td>工号</td>
						<td>系别</td>
						<td>手机号码</td>
						<td>QQ号码</td>
						<td>邮箱</td>
						<td>教研室</td>
						<td>操作</td>
					</tr>
				</thead>
					<tbody>
						
							
							
						
						<?php if(is_array($type)): foreach($type as $key=>$vo): ?><tr>
								<td style="padding-left: 50px;"><?php echo ($vo["Tname"]); ?></td>
								<td><?php echo ($vo["Tnum"]); ?></td>
								<td><?php echo ($vo["depart"]); ?></td>
								<td><?php echo ($vo["phone"]); ?></td>
								<td><?php echo ($vo["qq"]); ?></td>
								<td><?php echo ($vo["email"]); ?></td>
								<td><?php echo ($vo["ERG_name"]); ?></td>
								<td><a href="/biye/index.php/Teacher/TeacherManage/information/Tnum/<?php echo ($vo["Tnum"]); ?>" >修改</a> <a href="/biye/index.php/Teacher/TeacherManage/changePwd/Tnum/<?php echo ($vo["Tnum"]); ?>" style="margin-left: 15px;">修改密码</a>
								
								</td>
								
							</tr><?php endforeach; endif; ?>
						
					</tbody>
				</table>
				
			
				
				<div class="page">
					<!--<form action="" method="get">
					共<span>1</span>页
						<a href="#">首页</a>
						<a href="#">上一页</a>
						<a href="#">下一页</a>
						第<span style="color:red;font-weight:600">1</span>页
						共<span style="color:red;font-weight:600">1</span>页
						<input type="text" class="page-input">
						<button type="submit" class="green">跳转</button>-->
						 <?php echo ($page); ?>
					</form>
				</div>
		</div>
		
 
		<script src="/biye/Public/public/js/jquery.min.js"></script>
		<!--  记得载入jquery文件 -->
				
		<script>
		$('.import').click(function(){
		　　$(this).prev('form').find('[name="file"]').trigger('click');
		});
		
		// 当表单文件有变化时执行提交动作
		
		$('[name="file"]').change(function(){
		　　if($(this).val()){
		　　　　$('.import').addClass('disabled' );
		　　　　$(this).parent().submit();
		　　}
		});
		</script>
		

	    	</section>
		</section>
	</body>
    
</html>