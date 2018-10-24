<?php
namespace Teacher\Controller;
use Think\Controller;
class CommonController extends Controller{
	public function __initialize()
	{
       
 	   $this->checkUser();       //检查登陆	
 	   $this->checkSelected();  //检查是否选择了年份
 	  
	  
 	}
 	
		
	
 	//检查登陆	
 	public function checkUser()
 	{
 	     if (!session('?Tnum')){
 	       
 	    	$this->error('请登录',U('teacher/Login/index'));
 	        exit;
 	    }
		//分配模板变量	   
	   	$role=$_SESSION['role'];	   
		$this->assign('role',$role);	  
 	}
	
	
	//检查是否选择了年份
	public function checkSelected()
	{
		$config = M('config');
		$count  = $config->where('status=1')->count();
		$role   = $_SESSION['role'];
		if (!session('?selected_year')){
 	        if($count == 0 && $role ==3){
 	        	$this->error('请先开发系统',U('teacher/config/index'));
				
 	        }else{
				$this->error('请选择年份',U('teacher/index/select_year'));
	 	         exit;
			}	
 	    }
	}
	
	public function mypage($count,$pagenumber)
	{
	    	$Page = new \Think\Page($count,$pagenumber);//实例化分页类记录数和每页显示的记录数
	    	
	    	// 修改分页样式
	    	$Page->setConfig('header', '共%TOTAL_ROW%条数据，当前第%NOW_PAGE%/%TOTAL_PAGE%页');
	    	$Page->setConfig('prev', '上一页');
	    	$Page->setConfig('first', '首页');
	    	$Page->setConfig('last',   '尾页');
	    	$Page->setConfig('next', '下一页');
	    	$Page->setConfig('theme','%HEADER% %FIRST% %UP_PAGE%  %LINK_PAGE%  %DOWN_PAGE% %END%');
	
	    	// 返回分页对象
	    	return $Page;
	}
	
	
	/**
	 * 公共数据创建方法
	 * @param string $tablename 表名
	 * @param string $func 操作方法
	 * @param int $type 验证时机（1=添加 2=修改）
	 * @param string/array $where 查询条件
	 * @return mixed 操作结果
	 */
	protected function create($tablename,$func,$type=1,$where=array())
	{
		$Model = D($tablename);
		if(!$Model->create(I('post.'),$type)){
			$this->error($Model->getError());
			
		}
		if(empty($where)){
			return $Model->$func();
			
		}
		
		return $Model->where($where)->$func();
	}

	
	
	
	
	
	
	
}
