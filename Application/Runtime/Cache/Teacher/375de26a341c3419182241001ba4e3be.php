<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<title>上传文件</title>
	</head>
	<body>
		<form method="post" enctype="multipart/form-data">
			    <input type="hidden" name="Snum" value="<?php echo ($Snum); ?>" />
				<input type="file" name="file" />
				<input type="submit" value="提交" />
		</form>
	</body>
</html>