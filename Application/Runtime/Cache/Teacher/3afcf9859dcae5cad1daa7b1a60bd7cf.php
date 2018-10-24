<?php if (!defined('THINK_PATH')) exit();?><table id="myTable">
				<tr>
					<td colspan="4" style="color: red;">其他教研室的学生</td>
				</tr>
				<tr>
					<td>学号</td>
					<td>指导老师</td>
					<td>姓名</td>
					<td>操作</td>
				</tr>
				<?php if(is_array($list)): foreach($list as $key=>$vo): ?><tr>
						<td><?php echo ($vo["student_Snum"]); ?></td>
						<td><?php echo ($vo["Tname"]); ?></td>
						<td><?php echo ($vo["student_name"]); ?></td>
						<td><a href="/biye/index.php/Teacher/Defence/addStudent/Snum/<?php echo ($vo["student_Snum"]); ?>/Sname/<?php echo ($vo["student_name"]); ?>/defense_group/<?php echo ($defense_group); ?>">手动添加</a></td>
					</tr><?php endforeach; endif; ?>
				
			</table>
			<div style="margin-top: 15px;margin-bottom: 20px;"><?php echo ($page); ?></div>