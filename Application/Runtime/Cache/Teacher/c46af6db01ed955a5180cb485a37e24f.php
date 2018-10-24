<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>


	<head>
		<meta charset="utf-8">
	
		<meta name="viewport" content="width=device-width, minimum-scale=1.0, maximum-scale=1.0">
		<link rel="stylesheet" href="/biye/Public/teacher/css/sty.css" media="all" />
		<link rel="stylesheet" href="/biye/Public/teacher/css/style.css" media="all" />
		
	<title>添加指导评分</title>

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
				
<div class="content">
<meta charset="utf-8" />
<form method="post" id="Ggrade">
	<?php if(is_array($message)): foreach($message as $key=>$v): ?><input type="hidden"
		name="Snum" value="<?php echo ($v["student_Snum"]); ?>" />
	<div>课题名称:<?php echo ($v["Cname"]); ?></div>
	<br />
	<span>学号:<?php echo ($v["student_Snum"]); ?></span>&nbsp;&nbsp;&nbsp;&nbsp;<span>姓名:<?php echo ($v["student_name"]); ?></span>
	<br />
	<br />
	<table
		id="myTable">
		<tr>
			<td colspan="6">
				<h2 style="text-align: center">毕业论文（设计）成绩考核表</h2>
			</td>
		</tr>
		<tr style="background-color: #c0c0c0">
			<td colspan="6">1.指导教师评分 (满分60分)</td>
		</tr>
		<tr style="background-color: #c0c0c0">
			<td>序号</td>
			<td>考核项目</td>
			<td>满分</td>
			<td>得分</td>
			<td>评语</td>			
			<td>保存成绩</td>
		</tr>
		<tr>
			<td>1</td>
			<td>工作态度与记录</td>
			<td>10</td>
			<td><input type="text" name="Ggrade1" class="Ggrade1" size="1"
				value="<?php echo ($score["Ggrade1"]); ?>" /></td>
			<td rowspan="6">
				<textarea name="Gtext" id="Gtext" rows="22"><?php echo ($score["Gtext"]); ?></textarea>
				
			</td>
			
			<td>
				<button onclick="savedScore(event)">保存成功</button>
				<div style="color: red; display: none" class="saved">*保存成功</div>
			</td>
		</tr>
		<tr>
			<td>2</td>
			<td>基本理论、专业知识、基本技能和外语水平</td>
			<td>10</td>
			<td><input type="text" name="Ggrade2" class="Ggrade2" size="1"
				value="<?php echo ($score["Ggrade2"]); ?>" /></td>
		
		</tr>
		<tr>
			<td>3</td>
			<td>完成情况与水平、工作量、及完成质量</td>
			<td>20</td>
			<td><input type="text" name="Ggrade3" class="Ggrade3" size="1"
				value="<?php echo ($score["Ggrade3"]); ?>" /></td>
			
		</tr>
		<tr>
			<td>4</td>
			<td>独立工作能力、分析解决问题和实际工作能力</td>
			<td>15</td>
			<td><input type="text" name="Ggrade4" class="Ggrade4" size="1"
				value="<?php echo ($score["Ggrade4"]); ?>" /></td>
			
		</tr>
		<tr>
			<td>5</td>
			<td>创新能力</td>
			<td>5</td>
			<td><input type="text" name="Ggrade5" class="Ggrade5" size="1"
				value="<?php echo ($score["Ggrade5"]); ?>" /></td>
			
		</tr>
		
	</table><?php endforeach; endif; ?>
</form>
<script src="/biye/Public/public/js/jquery.min.js"></script>
<script>
	//保存分数
	function savedScore(event) {
		event.preventDefault();
		var Ggrade1 = $(".Ggrade1").val();
		var Ggrade2 = $(".Ggrade2").val();
		var Ggrade3 = $(".Ggrade3").val();
		var Ggrade4 = $(".Ggrade4").val();
		var Ggrade5 = $(".Ggrade5").val();
		if (!Ggrade1.match(/^([0-9]|(1[0]))(\.\d{1,6})?$/)
				|| !Ggrade2.match(/^([0-9]|(1[0]))(\.\d{1,6})?$/)
				|| !Ggrade3.match(/^([0-9]|(1[0-9])|(2[0]))(\.\d{1,6})?$/)
				|| !Ggrade4.match(/^([0-9]|(1[0-5]))(\.\d{1,6})?$/)
				|| !Ggrade5.match(/^([0-5])(\.\d{1,6})?$/)) {
			alert("不匹配");
		} else {
			$.ajax({
				type : "post",
				url : "<?php echo U('Score/saveGgrade');?>",
				dataType : "json",
				data : $("#Ggrade").serialize(),
				success : function(data) {
					if (data.status == 1) {
						$(".saved").show().delay(3000).hide(300);
					}
				}
			})
		}
	}
</script>
</div>

	    	</section>
		</section>
	</body>
    
</html>