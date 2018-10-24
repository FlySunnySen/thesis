<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>


	<head>
		<meta charset="utf-8">
	
		<meta name="viewport" content="width=device-width, minimum-scale=1.0, maximum-scale=1.0">
		<link rel="stylesheet" href="/biye/Public/teacher/css/sty.css" media="all" />
		<link rel="stylesheet" href="/biye/Public/teacher/css/style.css" media="all" />
		
	<style>
		.field-wrap input,select{
		width:200px;
		margin-left: 20px;
	}
	.field-wrap span{
		width: 100px;
		font-weight: bold;
		font-size: 15px;
		display: inline-block;
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
								<a href="/biye/index.php/Teacher/Score/Ggrade" ><span class="icon">&#9776;</span>指导评分</a>
							</li>
							
							<li>
								<a href="/biye/index.php/Teacher/Score/Pgrade" ><span class="icon">&#128202;</span>论文评阅</a>
							</li>
							
							<li>
								<a href="/biye/index.php/Teacher/Score/Rgrade"><span class="icon">&#9881;</span>答辩评分</a>
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
			<h1>添加学生</h1>
		</hgroup>
	</header>
	<div class="content">
		
			
		<form id="information">
			
				<div class="field-wrap">
					<span>学生姓名:</span>
					<input  type="text"  name="Sname" placeholder="请输入姓名"/>
				</div>
				<div class="field-wrap">
					<span>学号:</span>
					<input type="text"  name="Snum" placeholder="请输入学号"/>
				</div>
				
				<div class="field-wrap">
					<span>方向:</span>
					<input type="text"  name="class" placeholder="请输入专业方向"/>
				</div>
				
				<div class="field-wrap">
					<span>手机号码:</span>	
					<input type="text" name="phone"  placeholder="请输入手机号码"/>
				</div>
				<div class="field-wrap">
					<span>QQ号码:</span>
					<input type="text"  name="qq" placeholder="请输入QQ号码"/>
				</div>
				<div class="field-wrap">
					<span>邮箱:</span>
					<input type="text"  name="email" placeholder="请输入邮箱"/>
				</div>
							
				
				<button style="font-weight: bold;" id="save"  class="green">添加</button>
				<button style="font-weight: bold;"  class="">取消</button>
			
		</form>
		<script src="/biye/Public/teacher/js/jquery.min.js"></script>		
		<script type="text/javascript">
		$(function() {
			$('#save').bind('click',function() {				
				var data = $('#information').serialize();			
				
				$.ajax({
						    async : false,
						    cache : false,
						    data  : data,					    
						    type : 'POST',
						    url : '/biye/index.php/Teacher/Student/addStuAction',
						    error : function() {
						        alert('添加失败 ');
						    },
						    success : function(data) {
						    	if(data==true){
						    		alert('添加成功');	
						    		window.location.href="/biye/index.php/Teacher/Student/index";
						       }else{
						       	    alert(data);
						       }
						    }
						});
				return false;
			})
		})
		</script>
	</div>

	    	</section>
		</section>
	</body>
    
</html>