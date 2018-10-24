<?php
namespace Teacher\Controller;
use Think\Controller;
class InformationController extends CommonController
{
	function _initialize() 
	{
		
	   parent::__initialize();
	  
	}
	
	
	public function index()
	{
		
			$type= M('information');
			$count =  $type -> count();
			$mypage = $this -> mypage($count,6);
			$data = $type ->limit($mypage->firstRow,$mypage->listRows) -> select();
			$page = $mypage -> show();
			
			$this->assign('count',$count);
		    $this->assign('page',$page);
			$this->assign('type',$data);	
			
			$this->display();
		
	}
	
	
	
	
	public function add()
	{
		if(IS_POST){
			$data = $_POST;
			$rst  = D('information')->addNew($data);
			if(!empty($rst)){
//				$this->success('发布公告成功',U('teacher/information/index'));
                $this->ajaxReturn('发布公告成功');
			}else{
				$this->ajaxReturn('发布公告失败');
			}
		}
		$this->display();
		
	}
	
	public function show()
	{
	    $id  = I('get.infonum');
		$rst = D('information')->getOne($id);
		$this->assign('news',$rst);
		$this->display();	
	}
	
	public function delectNews()
	{
		$num = I('get.infonum');
		$rst = D('information')->delectNews($num);
		if(!empty($rst)){
			$this->success('删除成功',U('teacher/information/index'));
		}else{
			$this->success('删除失败',U('teacher/information/index'));
		}
	}
	
	public function saveNews()
	{
		$data['infocontent'] = $_POST['infocontent'];
		$data['infotitle'] = $_POST['infotitle'];
		$infonum = $_POST['infonum'];
		$rst  = D('information')->saveNews($data,$infonum);
			if(!empty($rst)){
                $this->ajaxReturn('更新公告成功');
			}else{
				$this->ajaxReturn('修改公告失败');
			}
		
	} 
	
	public function editInformationShow()
	{
		$infoNum = I('get.infonum');
		$info = M('information');
		$rst  = $info->where('infonum='.$infoNum)->find();			
		$this->assign($rst);
		$this->display();
	}

}
