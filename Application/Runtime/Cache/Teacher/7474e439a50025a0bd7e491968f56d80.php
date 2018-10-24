<?php if (!defined('THINK_PATH')) exit();?><meta charset="UTF-8">

	<title>选择系统</title>

<?php if(!empty($select)): ?><div class="title">选择系统</div>
<div class="data-edit clear">
<select name="select" id="select">
<?php if(is_array($select)): foreach($select as $key=>$v): ?><option value="<?php echo ($v["year"]); ?>"><?php echo ($v["year"]); ?></option><?php endforeach; endif; ?>
</select>
<button id="yearSelected">进入系统</button>
</div>

<?php else: ?> 
系统未开发，如果你是管理员请<a href="/biye/index.php/Teacher/config/index">点击这里</a><?php endif; ?>
<script src="/biye/Public/teacher/js/jquery.min.js"></script>
<script>
	   $(function(){
	   	   
	   	   $("#yearSelected").bind('click',function(){
	   	   	    	var options=$("#select option:selected").val();
					$.ajax({
							type:"post",
							url:'/biye/index.php/Teacher/Index/getYear',
							dataType:"json",
							data:{options:options},
							success:function(data){
								alert(data);
								window.location.href = "/biye/index.php/Teacher/Index/index";
								
							},
							error:function(){
								alert('失败');
							},
						})
	   	   });
	   	
	   	
	   	
	   })
	
	
</script>