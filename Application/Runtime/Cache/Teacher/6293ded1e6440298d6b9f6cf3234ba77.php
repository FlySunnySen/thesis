<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>


	<head>
		<meta charset="utf-8">
	
		<meta name="viewport" content="width=device-width, minimum-scale=1.0, maximum-scale=1.0">
		<link rel="stylesheet" href="/biye/Public/teacher/css/sty.css" media="all" />
		<link rel="stylesheet" href="/biye/Public/teacher/css/style.css" media="all" />
		
	<title>添加评阅评分</title>

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
				
<br/><br/><br/><br/>
<form method="post" id="Pgrade">
<br/><br/>
	<?php if(is_array($message)): foreach($message as $key=>$v): ?><input type="hidden"
		name="Snum" value="<?php echo ($v["student_Snum"]); ?>" />
	<div>课题名称:<?php echo ($v["Cname"]); ?></div>
	<br />
	<span>学号:<?php echo ($v["student_Snum"]); ?></span>&nbsp;&nbsp;&nbsp;&nbsp;<span>姓名:<?php echo ($v["student_name"]); ?></span>
	<br />
	<br />
	<table id="myTable">
		<tr>
			<td colspan="6">
				<h2 style="text-align: center">毕业论文（设计）成绩考核表</h2>
			</td>
		</tr>
		
		<tr style="background-color: #c0c0c0">
			<td colspan="3">2.评阅教师评分 (满分20分)</td>
			<td colspan="4"><span style="color: #FF0000"><strong>评阅人:<?php echo ($v["Pteacher"]); ?></strong></span></td>
		</tr>
		<tr style="background-color: #c0c0c0">
			<td>序号</td>
			<td>考核项目</td>
			<td>满分</td>
			<td>得分</td>
			<td>评语</td>		
		
			<td></td>
		</tr>
		<tr>
			<td>6</td>
			<td>质量(正确性、条理性、创造性和实用性)</td>
			<td>12</td>
			<td><input type="text" name="Pgrade1" class="Pgrade1" size="1"
				value="<?php echo ($score["Pgrade1"]); ?>" /></td>
			<td rowspan="2"><textarea name="Ptext" id="Ptext" rows="6"><?php echo ($score["Ptext"]); ?></textarea></td>
		
			<td rowspan="2">
				<button onclick="savedScore(event)">保存成功</button>
				
			</td>
		</tr>
		<tr>
			<td>7</td>
			<td>成果的技术水平(理论、分析、计算、实践和实物性能)</td>
			<td>8</td>
			<td><input type="text" name="Pgrade2" class="Pgrade2" size="1"
				value="<?php echo ($score["Pgrade2"]); ?>" /></td>
		</tr>
		
	</table>
</form><?php endforeach; endif; ?>
<script src="/biye/Public/public/js/jquery.min.js"></script>
<script>
	//保存分数
	function savedScore(event) {
		event.preventDefault();
		var Pgrade1 = $(".Pgrade1").val();
		var Pgrade2 = $(".Pgrade2").val();
		if (!Pgrade1.match(/^([0-9]|(1[0-2]))(\.\d{1,6})?$/) || !Pgrade2.match(/^([0-8])(\.\d{1,6})?$/)) {
			alert("不匹配");
		} else {
			$.ajax({
				type : "post",
				url : "<?php echo U('Score/savePgrade');?>",
				dataType : "json",
				data : $("#Pgrade").serialize(),
				success : function(data) {
					alert(data);
				}
			})
		}
	}
</script>

	    	</section>
		</section>
	</body>
    
</html>