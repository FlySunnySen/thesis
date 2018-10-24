<?php
namespace WecharAPI\Controller;
use Think\Controller;
class PTeacherManageController extends Controller
{
	
	
	
	public function indexphone()
	{	
		
		$type= M('teacher');
//		$count =  $type -> count();
//		$mypage = $this -> mypage($count,8);
//		$data = $type ->limit($mypage->firstRow,$mypage->listRows)->join('__ERG__ ON __TEACHER__.ERG_group = __ERG__.ERG_group') -> select();
//		$page = $mypage -> show();
//		
//		$this->assign('count',$count);
//	    $this->assign('page',$page);
//		$this->assign('type',$data);	
//
//		$this->display();
		
			$count =  $type -> count();			
			$data = $type ->select();
			
			echo json_encode($data)	;	
	
		exit;
	}
	
	public function changePwd()
	{
		 $Tnum = $_POST['Tnum'];
		 $this->assign('Tnum',$Tnum);
		 if(IS_POST)
	     {
	     	$pwd = md5(md5(I('post.pwd')));
			$Tnum=I('post.Tnum');			
			$rst = D('teacher')->changePwd($Tnum,$pwd);
			if(!empty($rst)){
				echo '成功';
				exit;
			}else{
				echo '失败了哦';
				exit;
			}
									
	     }	
				
		$this->display();
	}

    public function addTea()
    {
    	$rst = M('erg')->select();
		$this->assign('erg',$rst);
    	$this->display();
    }
	
	
    public function PaddTeaAction()
	{
		$data['Tnum'] = $_POST['Tnum'];
		$data['Tname'] = $_POST['Tname'];
		$data['direction'] = $_POST['direction'];
		$data['phone'] = $_POST['phone'];
		$data['qq'] = $_POST['qq'];
		$data['email'] = $_POST['email'];
		$data['ERG_group'] = $_POST['ERG_group'];
		$data['Ttext'] = $_POST['Ttext'];
		$data['pwd'] = md5(md5($_POST['Tnum']));	
		$teaModel = M('teacher');	
		$rst= $teaModel->add($data);	
		if(!empty($rst)) {
			 echo "true";exit;
		}else{
			 echo "false";exit;
		}
	}
	
	public function addTeaAction()
	{
		$data  = I('post.');
		$data['pwd'] = md5(md5($_POST['Tnum']));	
		$teaModel = M('teacher');	
		$rst= $teaModel->add($data);	
		if(!empty($rst)) {
			$this -> ajaxReturn(true);
		}else{
			$this -> ajaxReturn(失败);
		}
	}
	
	public function information(){

      
		$rst1 = D(teacher)->selectOne($_GET['Tnum']);
		$this->assign('Tinfo',$rst1);	
		$rst2 = M('erg')->select();
		$this->assign('erg',$rst2);
		if(IS_POST){
            $data  = I('post.');		
			$rst= D('teacher')->information($data);
			if($rst){
				$this->success('修改成功',U('teacher/index/index'));
			}else{
				$this->error('失败了',U('teacher/index/index'));
			}
		}
					
		$this->display();
	}
	
	public function ERG_groupphone()
	{
		$ERG_group = M('erg');
		$data = $ERG_group->select();
		echo json_encode($data)	;	
	
		exit;
	}
	
	public function editERG()
	{
		$ERG_group = I('get.ERG_group');
		$rst = M('erg')->where('ERG_group='.$ERG_group)->find();
		$this->assign($rst);
		$this->display();
	}
	
	public function addERG()
	{
		$this->display();
	}	
	
	//添加教研室
	public function addErgAction()
	{
		$data['ERG_name'] = I('post.ERG_name');
		$ERGmodel =  M('erg');
		$MAX = $ERGmodel->max('ERG_group');
		$data['ERG_group'] = $MAX+1;
		$rst =$ERGmodel->add($data);
		if($rst){
			$this->success('添加成功',U('TeacherManage/ERG_group'));
		}else{
			$this->error('添加失败');
		}
	}
	
	//修改教研室数据
	public function saveInfo()
	{
		$ERG_group = I('post.ERG_group');
		$ERG_name  = I("post.ERG_name");
		$data['ERG_name'] = $ERG_name;
		$rst = M('erg')->where('ERG_group='.$ERG_group)->save($data);
		if($rst){
			$this->success('修改成功');
		}else{
			$this->error('修改失败');
		}
	}
	
	//删除教研室
	public function delERG()
	{
		$ERG_group = I('get.ERG_group');
		$rst = M('erg')->where('ERG_group='.$ERG_group)->delete();
		if($rst){
			$this->success('删除成功');
		}else{
			$this->error('不可删除，当前教研室有数据存在');
		}
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
