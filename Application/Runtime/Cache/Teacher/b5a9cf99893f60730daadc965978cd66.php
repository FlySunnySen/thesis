<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>


	<head>
		<meta charset="utf-8">
	
		<meta name="viewport" content="width=device-width, minimum-scale=1.0, maximum-scale=1.0">
		<link rel="stylesheet" href="/biye/Public/teacher/css/sty.css" media="all" />
		<link rel="stylesheet" href="/biye/Public/teacher/css/style.css" media="all" />
		
	<style type="text/css">
		input,select,p,button{
			margin-left: 15px;
			margin-top: 15px;
			font-size: 15px;
		}
		#member{
			margin-left: 45px;
			margin-top: 15px;
			font-size: 15px;
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
		<h1>修改分组</h1>
	</header>
	   
	    	<input id="defense_group" type="hidden" value="<?php echo ($defense_group); ?>" />
	        <p>当前答辩组编号:<?php echo ($defense_group); ?></p>
	        
		        <p>当前组员</p>
		    <div>
		        <input style="width:40%;display: inline-block;" type="text" id="numOrName" placeholder="请输入工号或姓名"/>
		        <button id="addItem">添加组员</button>
	        </div>
	        <table id="myTable">
	        	<tr>
	        		<td>工号</td>
	        		<td>姓名</td>
	        		<td>操作</td>
	        	</tr>
	        	<?php if(is_array($teaInfo)): foreach($teaInfo as $key=>$vo): ?><tr>
		        		<td><?php echo ($vo["Tnum"]); ?></td>
		        		<td><?php echo ($vo["Tname"]); ?></td>
		        		<td><a href="/biye/index.php/Teacher/Defence/deleteItem/defense_group/<?php echo ($defense_group); ?>/Tnum/<?php echo ($vo["Tnum"]); ?>">删除</a></td>
	        		</tr><?php endforeach; endif; ?>
	        </table>
            <p>请选择时间</p>
			<input type="date" id="date" value="<?php echo ($date); ?>" style="width:20%"/><input type="time" id="time" value="<?php echo ($time); ?>" style="width:20%"/>
			<br />
			<p>请选择教室</p>
			<input type="text" id="Dclass" value="<?php echo ($class); ?>" style="width:20%"/><br />
	         <button id="sub">跟新信息</button>
	         
	<script src="/biye/Public/public/js/jquery.min.js"></script>
	<script>
		$(function(){
			//添加组员
			$('#addItem').bind('click',function(){
				var defense_group = $('#defense_group').val();
				var numOrName        = $('#numOrName').val();	
				if(!numOrName){
					alert('请输入工号或姓名！')
				}else{
					$.ajax({
						type:"post",
						url:"/biye/index.php/Teacher/Defence/addItem",
						async:true,
						data:{'defense_group':defense_group,'numOrName':numOrName},
						success:function(data){
							alert(data);
							location.reload();
						},
					});
				}
			});
			
			//更新答辩时间和教室
			$('#sub').bind('click',function(){
			var defense_group = $('#defense_group').val();
			var Dclass        = $('#Dclass').val();
			var time          = $('#date').val();
			time              = time.concat(" ");
			time             += $('#time').val();
			$.ajax({
				type:"post",
				url:"/biye/index.php/Teacher/Defence/saveTeam",
				async:true,
				data:{'defense_group':defense_group,'class':Dclass,'time':time},
				success:function(data){
					alert(data);
					window.location.href='/biye/index.php/Teacher/Defence/index';
				},
			});
		});
			
		})
	</script>

	    	</section>
		</section>
	</body>
    
</html>