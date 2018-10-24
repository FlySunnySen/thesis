<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>


	<head>
		<meta charset="utf-8">
	
		<meta name="viewport" content="width=device-width, minimum-scale=1.0, maximum-scale=1.0">
		<link rel="stylesheet" href="/biye/Public/teacher/css/sty.css" media="all" />
		<link rel="stylesheet" href="/biye/Public/teacher/css/style.css" media="all" />
		
	<title>指导评分</title>

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
				
<input type="hidden" name="sid" value="1" id="sid"/>
<header>
	<hgroup>
		<h1>指导评分</h1>
	</hgroup>
</header>

<div class="container">
	<br />
<a href="javascript:void(0);" data-url="<?php echo U('Score/addGgrade');?>" class="addGgrade" ><button class="button blue">指导教师评分</button></a>
<button class="deleted">删除评分</button>

	
		<table id="myTable" class="table-responsive">
			<tr>
				<td>选择</td>
				<td>课题名</td>
				<td>学生</td>
				<td>答辩稿</td>
				<td>项1</td>
				<td>项2</td>
				<td>项3</td>
				<td>项4</td>
				<td>项5</td>
				<td>评语</td>
				<td>答辩状态</td>
			</tr>
			<?php if(is_array($score)): foreach($score as $key=>$v): ?><tr class="text-center">
				<td><input type="checkbox" value="<?php echo ($v["Snum"]); ?>" name="Snum" class="check"/></td>
				<td><?php echo ($v["Cname"]); ?></td>
				<td><?php echo ($v["Sname"]); ?></td>
				<td>答辩稿</td>
				<td><?php echo ($v["Ggrade1"]); ?></td>
				<td><?php echo ($v["Ggrade2"]); ?></td>
				<td><?php echo ($v["Ggrade3"]); ?></td>
				<td><?php echo ($v["Ggrade4"]); ?></td>
				<td><?php echo ($v["Ggrade5"]); ?></td>
				<td><?php echo ($v["Gtext"]); ?></td>
				<td><?php echo ($v["defense_status"]); ?></td>
			</tr><?php endforeach; endif; ?>
		</table>
	</div>
</div>
<script src="/biye/Public/public/js/jquery.min.js"></script>
<script>
	$(function(){
		    var _this;
			$('.table-responsive').find('input[type=checkbox]').bind('click',function(){
				$('.table-responsive').find('input[type=checkbox]').not(this).prop("checked",false);
		        var _this=$(this).prop("value");
		        checkedOnlyStatus(_this); 
			})
		
		//选中课题的操作
			function checkedOnlyStatus(sid){
				$.ajax({
					type:"post",
					url:"<?php echo U('Score/showGgrade');?>",
					dataType:"json",
					data:{Snum:sid}
					})
			}
		
		//添加分数提交
		$(".addGgrade").click(function(){
			if($(".check").is(':checked')){
				
				window.location.href=$(this).attr('data-url');
			}else{
				alert("没有选中课题");
			}
			
		});
		
		function delComfirm(sid){
		var msg = "您真的确定要删除吗？";
		if (confirm(msg)==true){
			$.ajax({
				type:"post",
				url:"<?php echo U('Score/deletedGgrade');?>",
				dataType:"json",
				data:{sid:sid},
				success:function(data){
					alert(data);
					location.reload();
				}
			})
		}else{
			return false;
		}
	}
	
	//删除分数
	$(".deleted").click(function(){
		if($(".check").is(':checked')){
			var sid = $(".check:checked").val();
			delComfirm(sid);
		}else{
			alert("没有选中课题");
		}
	});


		
	});
</script>

	    	</section>
		</section>
	</body>
    
</html>