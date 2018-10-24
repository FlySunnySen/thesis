<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>


	<head>
		<meta charset="utf-8">
	
		<meta name="viewport" content="width=device-width, minimum-scale=1.0, maximum-scale=1.0">
		<link rel="stylesheet" href="/biye/Public/teacher/css/sty.css" media="all" />
		<link rel="stylesheet" href="/biye/Public/teacher/css/style.css" media="all" />
		
	<title>答辩分汇总</title>

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
			<h1>答辩分汇总</h1>
			<h2>
				当前组员：
				<?php if(is_array($defense_Tea)): foreach($defense_Tea as $key=>$vo): echo ($vo["Tname"]); ?>,<?php endforeach; endif; ?>
			</h2>
		</hgroup>
</header>

<div class="content">
	
	<button class="button blue addGgrade">汇总分数</button>
	<input class="defense_group" type="hidden" value="<?php echo ($defense_group); ?>" />
	<br/><br/>
	<div>
		<table id="myTable">
		<thead>
			<tr>
				<td align="center" colspan="10">已评分</td>
			</tr>
			<tr class="text-center"
				style="font-weight: 800; color: #2A6496; background-color: #C0C0C0;">
				<td>汇总分数</td>
				<td>指导老师</td>
				<td>课题名</td>
				<td>学号</td>
				<td>学生名</td>
				<td>项8</td>
				<td>项9</td>
				<td>项10</td>
				<td>项11</td>
				<td>评语</td>
			</tr>
			</thead>
			<?php if(is_array($Rscore)): foreach($Rscore as $key=>$v): ?><tr class="text-center">
				<td><input type="checkbox" value="<?php echo ($v["student_Snum"]); ?>" name="sid" class="check"/></td>
				<td><?php echo ($v["Tname"]); ?></td>
				<td><?php echo ($v["Cname"]); ?></td>
				<td><?php echo ($v["student_Snum"]); ?></td>
				<td><?php echo ($v["student_name"]); ?></td>
				<td class="Rgrade1_<?php echo ($v["Sid"]); ?>"><?php echo ($v["Rgrade1"]); ?></td>
				<td class="Rgrade2_<?php echo ($v["Sid"]); ?>"><?php echo ($v["Rgrade2"]); ?></td>
				<td class="Rgrade3_<?php echo ($v["Sid"]); ?>"><?php echo ($v["Rgrade3"]); ?></td>
				<td class="Rgrade4_<?php echo ($v["Sid"]); ?>"><?php echo ($v["Rgrade4"]); ?></td>
				<td><?php echo ($v["Rtext"]); ?></td>
			<tr>
			 	<td colspan="100%"> 
							<table cellspacing="0" cellpadding="4" rules="rows"
								style="background-color: #ffffff; border-color: #336666; border-width: 3px; border-style: Double; height: 100%; width: 55%; border-collapse: collapse;">
								<thead>
								<tr 
									style=" background-color: #336666; font-weight: bold;">
									<th scope="col" style="width: 80px;">答辩教师</th>
									<th scope="col">项8</th>
									<th scope="col">项9</th>
									<th scope="col">项10</th>
									<th scope="col">项11</th>
									<th scope="col">评语</th>
								</tr>
								</thead>
								<?php if(is_array($v["Rscoreinfo"])): foreach($v["Rscoreinfo"] as $key=>$w): if(($w["Sid"]) == $v["Sid"]): ?><tr>
										<td><?php echo ($w["Tname"]); ?></td>
										<td><?php echo ($w["RgradeC1"]); ?></td>
										<td><?php echo ($w["RgradeC2"]); ?></td>
										<td><?php echo ($w["RgradeC3"]); ?></td>
										<td><?php echo ($w["RgradeC4"]); ?></td>
										<td><?php echo ($w["RtextC"]); ?></td>
									</tr><?php endif; endforeach; endif; ?>
							</table>
				</td> 
			</tr>

			</tr><?php endforeach; endif; ?>
		</table>
	</div>
</div>
<script src="/biye/Public/public/js/jquery.min.js"></script>
<script>
$(function(){
	$('.table-responsive').find('input[type=checkbox]').bind('click',function(){
		$('.table-responsive').find('input[type=checkbox]').not(this).prop("checked",false);
	})
});
//选中课题的操作
function checkedOnlyStatus(sid,defense_group){
	$.ajax({
		type:"post",
		url:"<?php echo U('teacherDefense/plusScore');?>",
		dataType:"json",
		data:{sid:sid,defense_group:defense_group},
		success:function(data){
			alert(data);
			location.reload();
		}
		})
}
//添加分数提交
$(".addGgrade").click(function(){
	if($(".check").is(':checked')){
		var defense_group = $(".defense_group").val();
		var sid=$(".check:checked").val();
		checkedOnlyStatus(sid,defense_group);
	}else{
		alert("没有选中课题");
	}
});
</script>

	    	</section>
		</section>
	</body>
    
</html>