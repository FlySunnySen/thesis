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
				
<br/><br/><br/><br/>

<form method="post" id="Rgrade">
	<?php if(is_array($info)): foreach($info as $key=>$v): ?><div>课题名称: <strong> <?php echo ($v["Cname"]); ?></strong></div>
			<br />
			<span>学号:<?php echo ($v["student_Snum"]); ?></span>&nbsp;&nbsp;&nbsp;&nbsp;<span>姓名:<?php echo ($v["student_name"]); ?></span>
			<br />
			<br /><?php endforeach; endif; ?>
	<input type="hidden" value="<?php echo ($Rgrade["0"]["Did"]); ?>" name="Did" />
	<input type="hidden" value="<?php echo ($Rgrade["0"]["Studentnum"]); ?>" name="Studentnum" />
	<table id="myTable">
		<tr>
			<td colspan="7">
				<h2 style="text-align: center">毕业论文（设计）成绩考核表</h2>
			</td>
		</tr>
		
		<tr style="background-color: #c0c0c0">
			<td colspan="7">3.答辩组教师评分 (满分20分)</td>
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
			<td>8</td>
			<td>完成任务情况与水平</td>
			<td>5</td>
			<td><input type="text" name="RgradeC1" class="RgradeC1" size="1" value="<?php echo ($Rgrade["0"]["RgradeC1"]); ?>"/>			
			</td>
			<td rowspan="5"><textarea name="RtextC" id="Rtext" rows="15"><?php echo ($Rgrade["0"]["RtextC"]); ?></textarea></td>
			<td rowspan="4"><input type="submit" value="保存" onclick="savedScore(event)" /></td>
		</tr>
		<tr>
			<td>9</td>
			<td>论文、设计任务书、图纸与实物的质量</td>
			<td>5</td>
			<td><input type="text" name="RgradeC2" class="RgradeC2" value="<?php echo ($Rgrade["0"]["RgradeC2"]); ?>" size="1" /></td>
		</tr>
		<tr>
			<td>10</td>
			<td>答辩时讲述的系统性和语言表达能力</td>
			<td>5</td>
			<td><input type="text" name="RgradeC3" class="RgradeC3" value="<?php echo ($Rgrade["0"]["RgradeC3"]); ?>" size="1" /></td>
		</tr>
		<tr>
			<td>11</td>
			<td>回答问题的正确性</td>
			<td>5</td>
			<td><input type="text" name="RgradeC4" class="RgradeC4" value="<?php echo ($Rgrade["0"]["RgradeC4"]); ?>" size="1" /></td>
		</tr>
	
	</table>
</form>

<script src="/biye/Public/public/js/jquery.min.js"></script>
<script>
	//保存分数
	function savedScore(event) {
		event.preventDefault();
		var RgradeC1 = $(".RgradeC1").val();
		var RgradeC2 = $(".RgradeC2").val();
		var RgradeC3 = $(".RgradeC3").val();
		var RgradeC4 = $(".RgradeC4").val();
		if (!RgradeC1.match(/^([0-5]|(1[0-2]))(\.\d{1,6})?$/) || !RgradeC2.match(/^([0-5])(\.\d{1,6})?$/) || !RgradeC3.match(/^([0-5])(\.\d{1,6})?$/) || !RgradeC4.match(/^([0-5])(\.\d{1,6})?$/)) {
			alert("不匹配");
		} else {
			$.ajax({
				type : "post",
				url : "<?php echo U('Score/saveRgrade');?>",
				dataType : "json",
				data : $("#Rgrade").serialize(),
				success : function(data) {
					
						alert(data);
						location.reload();
					
				}
			})
		}
	}
</script>

	    	</section>
		</section>
	</body>
    
</html>