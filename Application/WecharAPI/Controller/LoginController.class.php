<?php
namespace WecharAPI\Controller;
use Think\Controller;
class LoginController extends Controller{
	public function index(){
		
		$this->display();
		
	}
	
	
public function checkLogin()
    {
	    if (IS_POST){	    	 
		    	 //检查用户名和密码    	
		    	 $userName = I('post.userName');
				
		    	 $pwd = md5(md5( I('post.password')));
		    	 $where = array(
		    	       'Tnum' => $userName,
		    	       'pwd'  => $pwd,
		    	 );
		    	 //初始化数据库
		    	 $teacher = M('teacher');
				 $admin   = M('admin');            
		    	 $rst  = $admin->where($where)->find();
				 $ERG  = $teacher->where('Tnum='.$userName)->getField('ERG_group');
				 if(empty($rst)){
				 	 $rst2 = $teacher->where($where)->find();
				 }
				
		    	 //判断是否存在该用户
		    	 if (!empty($rst) || !empty($rst2)){
		    	 //判断身份是否为管理员，并分配权限	
		    	        $user = array(
			    	 	        'Tnum' => $rst['Tnum'],
								'Tname' => $rst['Tname'],
								'role'	=> $rst['role'],
								'ERG_group' => $ERG,					
								       
			    	 	);
		    	        $user2 = array(
			    	 	        'Tnum' => $rst2['Tnum'],
								'Tname' => $rst2['Tname'],
								'role'  => '1',	
								'ERG_group' => $rst2['ERG_group'],				
								       
			    	 	);
						
			    	if($rst['role']==2){  
			    	 											
			    	    $_SESSION=$user;
						
						
					}else if($rst['role']==3){											
			    	 	
			    	      $_SESSION=$user;
						
					}else{
						
						  $_SESSION=$user2;
					}
					
		    	    $this->success('登录成功',U('teacher/index/select_year'));
		    	 }else {
		    	 
		    	 	$this->error('登陆失败，用户名或密码错误');
					
		    	 }
		    	  
	       }
    	
    }

	//检查用户名和密码是否正确//小程序
	public function checkLoginphone()
    {
	    if (IS_POST){
	    		$userName =$_POST['userName'];
		    	$pwd =md5(md5($_POST['password']));		    				 		    				    		
		    	 $where = array(
		    	       'Tnum' => $userName,
		    	       'pwd'  => $pwd,
		    	 );
		    	 //初始化数据库
		    	 $teacher = M('teacher');
				 $admin   = M('admin');            
		    	 $rst  = $admin->where($where)->find();
				 $ERG  = $teacher->where('Tnum='.$userName)->getField('ERG_group');
				 $rst2 = $teacher->where($where)->find();
		    	 //判断是否存在该用户
		    	 if (!empty($rst) || !empty($rst2)){
		    	 //判断身份是否为管理员，并分配权限	
		    	        $user = array(
			    	 	        'Tnum' => $rst['Tnum'],
								'Tname' => $rst['Tname'],
								'role'	=> $rst['role'],
								'ERG_group' => $ERG,					
								       
			    	 	);
		    	        $user2 = array(
			    	 	        'Tnum' => $rst2['Tnum'],
								'Tname' => $rst2['Tname'],
								'role'  => '1',	
								'ERG_group' => $rst2['ERG_group'],				
								       
			    	 	);
						
			    	if($rst['role']==2){  
			    	 											
			    	    $_SESSION=$user;
						
						
					}else if($rst['role']==3){											
			    	 	
			    	      $_SESSION=$user;
						
					}else{
						
						  $_SESSION=$user2;
						  $data=array('user'=>1,'info'=>"登录成功",'name'=>$rst2['Tname']);
						  echo json_encode($data);					
					exit;
					}
					
					$data=array('user'=>$rst['role'],'info'=>"登录成功",'name'=>$rst['Tname']);
					echo json_encode($data);					
					exit;
		    	    
		    	 }	
		    	 else {
						echo "登陆失败，用户名或密码错误";
						exit;
					
		    	 }
		    	 	    	 
	       }
		    	
    	
    }
    
	
	public function captcha(){
		$verify = new \Think\Verify();
		return $verify->entry();
	}
	
	//检查验证码
	private function checkVerify($code, $id = '') {
		$verify = new \Think\Verify();
		$rst = $verify->check($code, $id);
		if($rst!==true){
			$this->error('验证码输入有误');
		}
	}
    //退出登录
    public function logout(){
		session('[destroy]');
		$this->success('退出成功',U('Login/index'));
	}
}
