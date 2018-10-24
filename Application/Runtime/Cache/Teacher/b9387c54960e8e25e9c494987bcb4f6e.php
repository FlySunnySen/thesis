<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>


	<head>
		<meta charset="utf-8">
	
		<meta name="viewport" content="width=device-width, minimum-scale=1.0, maximum-scale=1.0">
		<link rel="stylesheet" href="/biye/Public/teacher/css/sty.css" media="all" />
		<link rel="stylesheet" href="/biye/Public/teacher/css/style.css" media="all" />
		
	<style type="text/css">
		input,select,p{
			
			margin-left: 15px;
			margin-top: 15px;
			font-size: 15px;
		}
		input{
			width: 3%;
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
		<h1>新增分组</h1>
	</header>
	
	<section>
		<form>
		<p>请选择教研室：</p>
		    <select id="ERG" name="ERG_group">
		    	<option>   </option>
		        <?php if(is_array($ERG)): foreach($ERG as $key=>$vo): ?><option value="<?php echo ($vo["ERG_group"]); ?>"><?php echo ($vo["ERG_name"]); ?></option><?php endforeach; endif; ?>
			</select>
			
		<p>请选择组长：</p>
		
			<select id="admin">
				
				
			</select>
			<p>请选择组员：</p>
			<div id="member">
				
			</div>
			<p>请选择时间</p>
			<input type="date" id="date" style="width:20%"/><input type="time" id="time" style="width:20%"/>
			<br />
			<p>请选择教室</p>
			<input type="text" id="Dclass" style="width:20%"/><br />
			<button id="sub">确认分组</button>
		</form>
	</section>
	
	<script src="/biye/Public/teacher/js/jquery.min.js"></script>
	<!-- 以下为ajax功能 根据选择的教研室显示对应教师 -->	
	<script type="text/javascript">		
		$(function(){
			$("#ERG").bind("change",function(){
				var ERG_name = document.getElementById('ERG').value;
				$.ajax({
					type : "POST",
					url  : '/biye/index.php/Teacher/Defence/returnInfo' ,
					data : {"ERG_group":ERG_name},
					dataType : "json",
					success:function(data){
						$("#admin").empty();
						$("#member").empty();
						for (var i = data.length - 1; i >= 0; i--) {
						   $("#admin").prepend('<option value="' + data[i].Tnum + '">' + data[i].Tname + '</option>');
						   $("#member").prepend(data[i].Tname + '<input type="checkbox" name="Tnum" value="'+ data[i].Tnum + '"/>');
						};
						
					},
				});
		    })
			
			
			
		})	
	</script>

     <!-- 提交分组 -->
     <script type="text/javascript">
     	$(function(){
     		$("#sub").bind('click',function(){
     			var adminNum = $("#admin option:selected").val();
     			var adminName = $("#admin option:selected").text();
     			var ERG_group = $("#ERG option:selected").val();
     			var time      = $("#date").val();
     			var status    = <?php echo ($status); ?>;
     			time          = time.concat(" ");
     			time     += $("#time").val();
     			var Dclass    = $("#Dclass").val();
     			var teacherArray = [];
     			obj = $('input:checkbox:checked').each(
     				function(){
     					teacherArray.push($(this).val());
     				}
     			);
     			teacherArray.push(adminNum);
     			var teacher = teacherArray.join(",");
     			$.ajax({
     				type:"post",
     				url:"/biye/index.php/Teacher/Defence/addTeam",
     				async:true,
     	            data:{"adminNum":adminNum,"adminName":adminName,"teacher":teacher,"ERG_group":ERG_group,"time":time,"class":Dclass,"status":status},
     				success:function(data){
     					 alert(data);
     					 window.location.href='/biye/index.php/Teacher/Defence/index';
     				},
     				error:function(data){
     					alert(data);
     				},
     			});
     			return false;
     		})
     	})
     </script>

	    	</section>
		</section>
	</body>
    
</html>