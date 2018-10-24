<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>


	<head>
		<meta charset="utf-8">
	
		<meta name="viewport" content="width=device-width, minimum-scale=1.0, maximum-scale=1.0">
		<link rel="stylesheet" href="/biye/Public/teacher/css/sty.css" media="all" />
		<link rel="stylesheet" href="/biye/Public/teacher/css/style.css" media="all" />
		
	<style>
		.stu{
			float: left;
			width: 45%;			
			margin-top:2% ;
			margin-left:2% ;
			text-align: center;
		}
		input{
			width:70%;
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
			<h1>分配学生</h1>
			<h2>当前组员为：<?php echo ($defense_teacher); ?></h2>
		</hgroup>
	</header>
	<div class="stu">
		   
		    <form id="auto" method="post" action="/biye/index.php/Teacher/Defence/autoAddStudent">
			    <input name="studentNum" placeholder="请输入学生人数（只能将学生分配到没有指导老师的组别）" />
			    <input id="defense_group" name="defense_group" value="<?php echo ($defense_group); ?>" type="hidden" />
				<input id="year" name="year" value="<?php echo ($year); ?>" type="hidden" />
				<input id="status" name="status" value="<?php echo ($status); ?>" type="hidden" />
				<input id="ERG_group" name="ERG_group" value="<?php echo ($ERG_group); ?>" type="hidden" />
				<button class="blue">自动添加</button>
			</form>
			
				<table id="myTable" >
					<tr>
						<td colspan="4">已添加的学生</td>
					</tr>
					<tr>
						<td>学号</td>
						
						<td>姓名</td>
						<td>操作</td>
					</tr>
					<?php if(is_array($defense_student)): foreach($defense_student as $key=>$vo): ?><tr>
							<td><?php echo ($vo["Snum"]); ?></td>
							
							<td><?php echo ($vo["Sname"]); ?></td>
							<td><a href="/biye/index.php/Teacher/Defence/deleteStudent/Snum/<?php echo ($vo["Snum"]); ?>">删除</a></td>
						</tr><?php endforeach; endif; ?>
				</table>
				
				
			
	</div>	
	
	<div class="stu">
		 <form id="findAddStudent" action="/biye/index.php/Teacher/Defence/findAddStudent" method="post">
		 	    <input id="year" name="year" value="<?php echo ($year); ?>" type="hidden" />
		 	    <input id="defense_group" name="defense_group" value="<?php echo ($defense_group); ?>" type="hidden" />
		 	    <input id="status" name="status" value="<?php echo ($status); ?>" type="hidden" />
			    <input name="num_name" placeholder="按学号添加"/>
			    <button>添加</button>
		 </form>
		<div id="student"></div>
	
		<div id="student_no"></div>
	</div>
	
	
	<script src="/biye/Public/public/js/jquery.min.js"></script>
	
	<script type="text/javascript">
			$(function(){
			var init_id = 1;			
			student(init_id);	//初始化页面 init_id==1
			student_no(init_id);
			
			});
			function student(id){
				var id   = id;
				var year = $("#year").val();
				var ERG_group = $("#ERG_group").val();
				var defense_group = $("#defense_group").val();
				var N             = "IN";
				var status        =<?php echo ($status); ?>;
				//把数据传递到要替换的控制器方法中
				$.ajax({
				url:"/biye/index.php/Teacher/Defence/ajaxShow",
				type:"GET",
				async:false,
				dataType:"JSON",
				data:{'p':id,'year':year,'ERG_group':ERG_group,'defense_group':defense_group,'N':N,'status':status},
				success:function(data){
			    
			  
				$("#student").replaceWith("<div  id='student' >"
             +data.content+
             "</div>");
				},
				error:function(data){
//				 console.log("4:ajax not run~");

				}
				});
			}
			function student_no(id){
				var id   = id;
				var year = $("#year").val();
				var ERG_group = $("#ERG_group").val();
				var defense_group = $("#defense_group").val();
				var N             = "NOT IN";
					var status        =<?php echo ($status); ?>;
				//把数据传递到要替换的控制器方法中
				$.ajax({
				url:"/biye/index.php/Teacher/Defence/ajaxShowStudentNo",
				type:"GET",
				async:false,
				dataType:"JSON",
				data:{'p':id,'year':year,'ERG_group':ERG_group,'defense_group':defense_group,'N':N,'status':status},
				success:function(data){
			
				
				$("#student_no").replaceWith("<div  id='student_no' >"
             +data.content+
             "</div>");
				},
				error:function(data){
//				 console.log("4:ajax not run~");

				}
				});
			}
	</script>
	
	
		

	    	</section>
		</section>
	</body>
    
</html>