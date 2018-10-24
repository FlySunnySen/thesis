<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="">
<head>
	<meta charset="utf-8">
	<title>登录</title>
	<meta name="description" content="" />
	<meta name="keywords" content="" />
	<meta name="robots" content="" />
	<meta name="viewport" content="width=device-width, minimum-scale=1.0, maximum-scale=1.0">
	<link rel="stylesheet" href="/biye/Public/student/css/style.css" media="all" />
	<!--[if IE]><link rel="stylesheet" href="css/ie.css" media="all" /><![endif]-->
</head>
<body class="login">
	<section>
		<h1>毕业论文管理系统</h1>
		<h1 style="color: red;">学生端</h1>
		<form method="post">
			<input type="text" value="" name="student_num" placeholder="学号"/>
			<input type="password" value="" placeholder="密码" name="student_pwd"/>
		
			<button class="blue">登录</button>
		</form>
		<p><a href="/biye/index.php/teacher/Login/index.html">>>>前往教师端<<<</a></p>
	</section>
<script src="/biye/Public/public/js/jquery.min.js"></script>
<script type="text/javascript">
// Page load delay by Curtis Henson - http://curtishenson.com/articles/quick-tip-delay-page-loading-with-jquery/
$(function(){
	$('.login button').click(function(e){ 
		// Get the url of the link 
		var toLoad = $(this).attr('href');  
 
		// Do some stuff 
		$(this).addClass("loading"); 
 
			// Stop doing stuff  
			// Wait 700ms before loading the url 
			setTimeout(function(){window.location = toLoad}, 10000);	  
 
		// Don't let the link do its natural thing 
		e.preventDefault
	});
	
	$('input').each(function() {

       var default_value = this.value;

       $(this).focus(function(){
               if(this.value == default_value) {
                       this.value = '';
               }
       });

       $(this).blur(function(){
               if(this.value == '') {
                       this.value = default_value;
               }
       });

});
});
</script>
</body>
</html>