<?php
namespace Teacher\Controller;
use  Think\Controller;
class ConfigController extends Controller
{
     public function index()
     {
     	if (!session('?Tnum')){
 	       
 	    	$this->error('请登录',U('teacher/Login/index'));
 	        exit;
 	    }
		//分配模板变量	   
	    $role = session('role');
		$this->assign('role',$role);	
	    if($role !=3){
	   	$this->error('权限不够');
	    }
		$this->display();
     }	
	 //开放系统
	 public function openSystem()
	 {
	 	if(IS_POST)
		{
			$year   = $_POST['myYear'];
			$arr =array('year' =>$year , 'status' => '1',);
			$config = M('config');
			$rst = $config -> add($arr);
			//如果系统处于维护，执行save操作
			if(empty($rst)){
				$rst = $config -> save($arr);
			}
			if(!empty($rst)){
				$this->success('开放系统成功',U('teacher/config/index'));
			}else{
				$this->error('开放系统失败');
			}
		}
	 }
	 //关闭系统
	 public function closeSystem()
	 {
	 	$year   = $_POST['myYear'];
			$arr =array('year' =>$year , 'status' => '0',);
			$config = M('config');
			$rst = $config -> save($arr);
			if(!empty($rst)){
				$this->success('关闭系统成功',U('teacher/config/index'));
			}else{
				$this->error('关闭系统失败');
			}
	 }
	 
	public function addFileToZip($path,$zip){
		    $handler=opendir($path); //打开当前文件夹由$path指定。
		    while(($filename=readdir($handler))!==false){
		        if($filename != "." && $filename != ".."){//文件夹文件名字为'.'和‘..’，不要对他们进行操作
		            if(is_dir($path."/".$filename)){// 如果读取的某个对象是文件夹，则递归
		                self::addFileToZip($path."/".$filename, $zip);
		            }else{ //将文件加入zip对象
		                $zip->addFile($path."/".$filename);
		            }
		        }
		    }
		    @closedir($path);
			}
	 public function exportData()
	 {
	 	  $year   = $_POST['myYear'];
		  $zipname = "./Public/$year.zip";
	 	  $zip = new \ZipArchive;
		  $path = "./Public/$year/";
		  $res = $zip->open($zipname, \ZipArchive::CREATE);  
			if ($res === TRUE) {  
			   if(is_dir($path)){  //给出文件夹，打包文件夹
			       
			        self::addFileToZip($path, $zip);
				   
			    }else if(is_array($path)){  //以数组形式给出文件路径
			        foreach($path as $file){
			            $zip->addFile($file);
			        }
					
			    }else{      //只给出一个文件
			        $zip->addFile($path);
					
				}
			}  
								   
			    $zip->close(); //关闭处理的zip文件
			    header("Content-Type: application/zip");  
				header("Content-Transfer-Encoding: Binary");  
				  
				header("Content-Length: " . filesize($zipname));  
				header("Content-Disposition: attachment; filename=\"" . basename($zipname) . "\"");  
				  
				readfile($zipname);  
                
                exit;  
			 
			
	 }		
	 
	 //修改超级管理员密码
	 public function changePwd()
	 {
	 	if (!session('?Tnum')){
 	       
 	    	$this->error('请登录',U('teacher/Login/index'));
 	        exit;
 	    }
		//分配模板变量	   
	    $role = session('role');
		$this->assign('role',$role);	
	    if($role !=3){
	   	$this->error('权限不够');
	    }
		
		 $Tnum = $_SESSION['Tnum'];
		 $this->assign('Tnum',$Tnum);
		
		 if(IS_POST)
	     {
	     	$oldpwd_post = md5(md5(I('post.oldpwd')));
	     	$pwd = md5(md5(I('post.pwd')));
			$Tnum=I('post.Tnum');			
			
			$oldPwd = M('admin')->where('Tnum = '.$Tnum)->getField('pwd');	
			
			//验证旧密码
			if($oldPwd != $oldpwd_post){
				$this->error('原密码错误');
				exit;
			}
			//防止修改密码与原密码一样
			if($oldPwd == $pwd){
				$this->error('密码不能和旧密码相同');
				exit;
			}
			$data = array(
			       'Tnum' =>$Tnum,
			       'pwd'  =>$pwd,
			);
		    $rst = M('admin')->where('Tnum ='.$Tnum)->save($data);
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
	 
	 
}
