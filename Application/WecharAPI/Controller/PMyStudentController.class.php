<?php
namespace WecharAPI\Controller;
use Think\Controller;

class PMyStudentController extends Controller {

	//学生列表
	public function index(){
		$tnum = $_POST['num'];
		$data['list'] = D('student')->getStudentList($tnum);
		$this->assign($data);
		echo json_encode($data);
	}
	//教师核对信息推荐一辩
	public function change(){
		$Snum=I('post.Snum',0);
		//$Snum=$_POST('Snum');
		//echo $Snum;exit;
		$score = M('score');
		$is_grade = $score->where("Studentnum = $Snum")->find();
		if(!$is_grade){
			$this->ajaxReturn(array('status'=>2,'info'=>'请先指导评分'));
		} 		
		$status=M('student')->where("Snum=$Snum")->save(array('denfense_status'=>1));
		if($status){
			$this->ajaxReturn(array('status'=>1,'info'=>'success'));
			//echo "success";exit;
			
		}else{
			$this->ajaxReturn(array('status'=>0,'info'=>'添加失败'));
		}
	}
}