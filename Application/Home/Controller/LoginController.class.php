<?php
namespace Home\Controller;
use Think\Controller;
//学生端登录控制器
class LoginController extends Controller {
	//后台登录页
	public function index(){
		if (IS_POST){
			
			
			$student_num=$_POST['student_num'];
			$student_pwd=md5(md5($_POST['student_pwd']));
			$where = array(
					'Snum' => $student_num,
					'pwd' => $student_pwd,
			);
			
			$student = M('student');
			$r = $student -> where($where) -> find();
			
			
			if(!empty($r)){
				$user = array(
						'num' => $r['Snum'],
						'name' => $r['Sname'],
						'year' => $r['year'],
										);
			
				// session('admin',$admin_user);//把用户信息存到session
				$_SESSION['student']=$user;
				$this->success('登录成功，请稍等', U('Index/index'));
			}else{
				$this->error('登录失败，用户名或密码错误');
			}
			return;
		}
		$this->display();
	}
	
	//退出系统
	public function logout(){
		session('[destroy]');
		$this->success('退出成功',U('Login/index'));
	}
}