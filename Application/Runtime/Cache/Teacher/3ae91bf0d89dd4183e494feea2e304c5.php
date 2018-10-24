<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>


	<head>
		<meta charset="utf-8">
	
		<meta name="viewport" content="width=device-width, minimum-scale=1.0, maximum-scale=1.0">
		<link rel="stylesheet" href="/biye/Public/teacher/css/sty.css" media="all" />
		<link rel="stylesheet" href="/biye/Public/teacher/css/style.css" media="all" />
		
		<title>论文分配</title>
	<style>
		.stu{
			float: left;
			width: 50%;
			margin-top:2% ;
			margin-left:2% ;
			text-align: center;
		}
		.focus{
			font-style: italic;
			color: red;
		}
	</style>

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
								<a href="main.html" target="content"><span class="icon">&#128276;</span>首页</a>
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
				论文分配
			</h1>
			<h2>
				当前组员：
				<?php if(is_array($defense_Tea)): foreach($defense_Tea as $key=>$vo): echo ($vo["Tname"]); ?>,<?php endforeach; endif; ?>
			</h2>
		</hgroup>
	</header>
	<div class="stu">
	<form >
		<table id="myTable">
				<tr>
					<td colspan="6">已分配的学生</td>
				</tr>
				<tr>
					<td>学号</td>
					<td>姓名</td>
					<td>指导老师</td>					
					<td>评阅老师</td>
					<td>组内成员</td>
					<td>操作</td>
				</tr>
				<?php if(is_array($defense_student)): foreach($defense_student as $key=>$vo): ?><tr>
						<td><?php echo ($vo["Snum"]); ?></td>
						<td><?php echo ($vo["Sname"]); ?></td>
						<td class="focus"><?php echo ($vo["EduTeacher"]); ?></td>						
						<td><?php echo ($vo["Tname"]); ?></td>
						<td>
							<select class="<?php echo ($vo["Snum"]); ?>">
							    <?php if(is_array($defense_Tea)): foreach($defense_Tea as $key=>$vo1): ?><option value="<?php echo ($vo1["Tnum"]); ?>"><?php echo ($vo1["Tname"]); ?></option><?php endforeach; endif; ?>
						    </select>
						</td>
						<td><a class="giveTea" id="<?php echo ($vo["Snum"]); ?>" >更改</a></td>
					</tr><?php endforeach; endif; ?>
		</table>
	
	    
	</form>
	</div>	
	
	<div class="stu" style="width: 45%;">
	    <form id="auto" method="post" action="/biye/index.php/Teacher/TeacherDefense/autoAddViewTea">
		<table id="myTable">
				<tr>
					<td colspan="5">未分配的学生</td>
				</tr>
				<tr>
					<td>学号</td>
					<td>姓名</td>
					<td >指导老师</td>
					<td>组内成员</td>
					<td>操作</td>
				</tr>
				<?php if(is_array($defense_student_noreview)): foreach($defense_student_noreview as $key=>$vo): ?><tr>
						<td><?php echo ($vo["Snum"]); ?></td>
						<td><?php echo ($vo["Sname"]); ?></td>
						<td class="focus"><?php echo ($vo["Tname"]); ?></td>
						<td>
							<select class="<?php echo ($vo["Snum"]); ?>">
							    <?php if(is_array($defense_Tea)): foreach($defense_Tea as $key=>$vo1): ?><option value="<?php echo ($vo1["Tnum"]); ?>"><?php echo ($vo1["Tname"]); ?></option><?php endforeach; endif; ?>
						    </select>
						</td>
						<td><a class="giveTea" id="<?php echo ($vo["Snum"]); ?>">手动添加</a></td>
					</tr><?php endforeach; endif; ?>
				
			</table>
			<input name="defense_group" value="<?php echo ($defense_group); ?>" type="hidden"/>
			<!--<button class="blue">自动分配</button>-->
		</form>
	</div>
	<script src="/biye/Public/public/js/jquery.min.js"></script>
	<script>
		$(function(){
			$(".giveTea").bind('click',function(){
				var student = $(this).attr('id');
				var teacher = $("."+student).val();
				$.ajax({
					type:"post",
					url:"/biye/index.php/Teacher/TeacherDefense/addViewTea",
					data:{"Snum":student,"reviewTeacher":teacher},
					async:true,
					success:function(data){
						alert(data);
						location.reload();
					},
				});
			})
		})
	</script>

	    	</section>
		</section>
	</body>
    
</html>