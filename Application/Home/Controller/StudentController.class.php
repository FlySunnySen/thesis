<?php
namespace Home\Controller;
//学生信息控制器
class StudentController extends CommonController {
	//学生信息列表
	public function index() {
		//获得请求参数
		$studentnum= $_SESSION['student'];
		//获得学生信息
		$data['student'] = D('student')->getData($studentnum['num']);
		//视图
		$this->assign($data);
		$this->display();
	}
	
	public function revise() {
		
		//获得请求参数
		$studentnum= $_SESSION['student'];
		//处理表单
		if (IS_POST){
			$revise=$_POST;
			$this->reviseAction($studentnum['num'],$revise);
			return;
		}
		$data['student'] = D('student')->getData($studentnum['num']);
		//视图
		$this->assign($data);
		$this->display();
	}
	
	private function reviseAction($sid,$revise){
		//修改基本信息
		$db = M("student");
		$rst = $db->save($revise);
		if($rst===false){
			$this->error("修改学生信息失败",U('Student/index'));
		}
		//跳转
		$this->success('修改成功',U('Student/index'));
		$_SESSION['student']['name']=$revise['Sname'];
	}
	
	public function editpwd(){
		$studentnum= $_SESSION['student'];
	    if (IS_POST){
	    	$revise=$_POST;
			$this->editpwdAction($studentnum['num'],$revise);
			return;
		}
		$this->display();
	}
	
	private function editpwdAction($num,$revise){
		$db=M("student");
		
		$sql="select pwd from think_student where Snum=".$num;
		$res=$db->query($sql);
		$pwd = md5(md5($revise['newpwd']));
		$oldpwd_post = md5(md5(I('post.oldpwd')));
		if($res[0][pwd] != $oldpwd_post){
			$this->error("旧密码错误");
		}
		if ($res[0][pwd]== $pwd){
			$this->error("不可以与旧密码一样");			
		}
		$sql="UPDATE think_student SET pwd='".$pwd."' WHERE Snum=".$num;
		$result=$db->execute($sql);
			
		if ($result==1){
				$this->success('修改密码成功',U('Student/index'));
			}else{
				$this->error("修改密码失败",U('Student/index'));
			}
	}
}