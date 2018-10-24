<?php
namespace WecharAPI\Controller;
use Think\Controller;
class PInformationController extends Controller
{
	
	
	public function indexphone()
	{
	
			$type= M('information');
			$count =  $type -> count();			
			$data = $type -> select();
			
			echo json_encode($data)	;	
	
		exit;
}
	
	
	
	
	public function addphone()
	{
		
			$data['infotitle'] = $_POST['infotitle'];
			$data['infocontent'] = $_POST['infocontent'];
			$num=$_POST['num'];
			$rst  = D('information')->addNewp($data,$num);
			if(!empty($rst)){
//				$this->success('发布公告成功',U('teacher/information/index'));
                echo "true";exit;
			}else{
				echo "false";exit;
			}
		
		
	}
	
	public function show()
	{
	    $id  = I('get.infonum');
		$rst = D('information')->getOne($id);
		$this->assign('news',$rst);
		$this->display();	
	}
	
	public function PdelectNews()
	{
		$num = $_POST['infonum'];
		$rst = D('information')->delectNews($num);
		if(!empty($rst)){
			echo "true";exit;
		}else{
			echo "false";exit;
		}
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
		$data = $_POST;
		$infonum = $_POST['infonum'];
		$rst  = D('information')->saveNews($data,$infonum);
			if(!empty($rst)){
                $this->ajaxReturn('更新公告成功');
			}else{
				$this->ajaxReturn('修改公告失败');
			}
		
	} 
	public function PsaveNews()
	{
		$data['infotitle'] = $_POST['infotitle'];
		$data['infocontent'] = $_POST['infocontent'];
		$infonum = $_POST['infonum'];
		$rst  = D('information')->saveNews($data,$infonum);
			if(!empty($rst)){
                echo "true";exit;
			}else{
				echo "true";exit;
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
