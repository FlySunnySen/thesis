<?php
namespace Teacher\Controller;
use Think\Controller;
class TeacherDefenseController extends CommonController
{
	function _initialize() 
	{
	   parent::__initialize();
	}
	
	
	public function index()
	{
		$admin = $_SESSION['Tnum'];
		$where = "adminnum=".$admin;
		$rst = D('defense')->getList($where);
		$this->assign('defenseinfo',$rst);
		$this->display();
	}
	
	
	public function showAddViewTeacher()
	{
		$defense_group = I('get.defense_group');
		$year          = I('get.year');
		$ERG_group     = I('get.ERG_group');	
		//获取已经分配的学生	
		$rst1 = D('teacherManage')->getStudent($defense_group);	
		//获取未分配的学生
		$review = "(review_status = 0 OR review_status IS NULL) AND defense_group = $defense_group";
		$rst2 = D('teacherManage')->getNoAllotStudent($review);	
		//获取该答辩组的成员
		$rst3 = D('teacherManage')->getDefenseTea($defense_group);
		$this->assign('defense_group',$defense_group);	
		$this->assign('defense_student' , $rst1);
		$this->assign('defense_student_noreview' , $rst2);
		$this->assign('defense_Tea' , $rst3);
		$this->display();
	}
	
	public function autoAddViewTea()
	{
		$defense_group  = I('post.defense_group');
		$rst = D('teacherManage')->autoAddViewTea($defense_group);
		if($rst){
			$this->success("分配成功");
		}else{
			$this->error("分配失败");
		}
	}
	
	public function addViewTea()
	{
		$teacher = I('post.reviewTeacher');
		$student = I('post.Snum');
		$rst = D('teacherManage')->AddViewTea($student,$teacher);
		
		
		$this->ajaxReturn($rst);
		
	}
	
	public function RscoreSum()
	{
		$defense_group = I('get.defense_group');
		
		$rst = D('score')->allRscore($defense_group);
		//获取该答辩组的成员
		$rst3 = D('teacherManage')->getDefenseTea($defense_group);
		$this->assign('Rscore',$rst);
		$this->assign('defense_group',$defense_group);
		$this->assign('defense_Tea' , $rst3);
		$this->display();
	}
	
	//汇总分数
	public function plusScore(){
		$sid=I("post.sid",0,"int");
		$defense_group = I("post.defense_group",0,"int");
		$defenseTeaModel = M('defenseteacher');
		$defenseTeaModel->startTrans();
        $score = M('score');
		$dscore = M('dscore');
		//获取教师人数
		$tea = $defenseTeaModel->where('defense_group ='.$defense_group)->getfield('Tnum',true);
		$teaString = implode(',', $tea);		
	    $count = count($tea);
		
		
		$scoreNum = $score->where('Studentnum='.$sid)->getField('scorenum');
		
		//检查所有老师是否评分
		$map['Tnum'] = array('in',$teaString);
		$map['scorenum'] = array('EQ',$scoreNum);
	    $is_over = $dscore->where("RgradeC1 IS NOT NULL AND RgradeC2 IS NOT NULL AND RgradeC3 IS NOT NULL AND RgradeC4 IS NOT NULL")->where($map)->count();
		
		if($is_over != $count){
			$this->ajaxReturn('还有教师未评分');
			exit;
		}
		
		$DscoreArray = $dscore->field("cast(AVG(RgradeC1) as decimal(5,1)) AS Rgrade1,cast(AVG(RgradeC2) as decimal(5,1)) AS Rgrade2,cast(AVG(RgradeC3) as decimal(5,1)) AS Rgrade3,cast(AVG(RgradeC4) as decimal(5,1)) AS Rgrade4,GROUP_CONCAT(RtextC SEPARATOR ' ') AS Rtext")->group('scorenum')->having("scorenum = $scoreNum")->select();
		foreach($DscoreArray as $key=>$value){
			$scoreSum = $score->where('Studentnum='.$sid)->save($value);
		}
		
		$gradeSum = $dscore->field("AVG(RgradeC1)+AVG(RgradeC2)+AVG(RgradeC3)+AVG(RgradeC4) AS sum")->where("scorenum = $scoreNum")->find();
		
		//如果答辩成绩小于12分则进入二辩
		if($gradeSum['sum'] < 12){
			$data['denfense_status'] = 2;
			$data['denfense_allocation'] = 0;	
		}else{
			$data['denfense_status'] = 0;	
		}
		$changeStatus = M('student')->where("Snum = $sid")->save($data);
				
		if($scoreSum && $changeStatus){
			$defenseTeaModel->commit();
			$this->ajaxReturn('汇总成功');
		}else{
			$defenseTeaModel->rollback();
			$this->ajaxReturn("汇总失败");
		}
	}
}
