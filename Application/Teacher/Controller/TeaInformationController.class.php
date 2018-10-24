<?php
namespace Teacher\Controller;
use Think\Controller;
class TeaInformationController extends  CommonController
{
	
	function _initialize() 
	{
	   parent::__initialize();
	  
	}
	
	
	
	public function index()
	{
		$this->display();
	}
	
	public function changePwd()
	{
		
		 $Tnum = $_SESSION['Tnum'];
		 $this->assign('Tnum',$Tnum);
		 if(IS_POST)
	     {
	     	$pwd = md5(md5(I('post.pwd')));
			$oldpwd_post = md5(md5(I('post.oldpwd')));
					
			$oldPwd = M('teacher')->where('Tnum = '.$Tnum)->getField('pwd');
			
			//验证旧密码
			if($oldPwd != $oldpwd_post){
				$this->error('原密码错误');
				exit;
			}
			//防止修改密码与原密码一样
			if($oldPwd == $pwd){
				$this->error('密码不能和旧密码相同');
			}
			$rst = D('teacher')->changePwd($Tnum,$pwd);
			if(!empty($rst)){
				$this->success('修改密码成功',U('teacher/index/index'));
				exit;
			}else{
				$this->error('失败了哦');
				exit;
			}
									
	     }	
				
		$this->display();
	}
	//修改个人信息
	public function information(){

        
		$rst1 = D(teacher)->selectOne($_SESSION['Tnum']);
		$this->assign('Tinfo',$rst1);					
		$this->display();
	}
	
	public function saveInformation()
	{
		$data  = I('post.');		
		$rst= D('teacher')->information($data);
		if(!empty($rst)) {
			$this -> ajaxReturn(true);
		}else{
			$this -> ajaxReturn(失败);
		}
	}
	
}
?>