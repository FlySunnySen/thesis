<?php
namespace WecharAPI\Controller;
use Think\Controller;

class PScoreController extends Controller{
	
	//教师评分
	public function Ggrade(){
		$tnum=$_POST['num'];
		$year=$_POST['year'];
		$data['score']=D('score')->getList($tnum,$year);
		$this->assign($data);
		echo json_encode($data);
	}
	//选中学生课题
	public function showGgrade(){
		//获取选中复选框
		$check=I('post.Snum');
		session('selected_sid',$check);
	}
	//指导教师评分
	public function addGgrade(){
		//列出学生信息
		$sid=$_SESSION['selected_sid'];
		$data['message']=D('score')->getMessage($sid);
		$data['score']=M('score')->field('Ggrade1,Ggrade2,Ggrade3,Ggrade4,Ggrade5,Pgrade1,Pgrade2,Ptext,Rgrade1,
				Rgrade2,Rgrade3,Rgrade4,Rtext')->where("Studentnum=$sid")->find();
		$this->assign($data);
		echo json_encode($data);
	}
	//保存分数
	public function saveGgrade(){
		
		$score=M('score');
		$Ggrade1=I('post.Ggrade1');
		$Ggrade2=I('post.Ggrade2');
		$Ggrade3=I('post.Ggrade3');
		$Ggrade4=I('post.Ggrade4');
		$Ggrade5=I('post.Ggrade5');
		$Gtext =I('post.Gtext');
		$Snum=I('post.Snum');
		//首先判断有无成绩单存在
		$checkScore=$score->where('Studentnum='.$Snum)->find();
		//如果不存在，创建成绩单
		if(empty($checkScore)){
			$data['Studentnum']=$Snum;
			$rst = $score->add($data);		
		}
		$savedScore=$score->where('Studentnum='.$Snum)->save(array('Ggrade1'=>$Ggrade1,'Ggrade2'=>$Ggrade2,
				'Ggrade3'=>$Ggrade3,'Ggrade4'=>$Ggrade4,'Ggrade5'=>$Ggrade5,'Gtext'=>$Gtext,
		));
		
		if($savedScore){
			$this->ajaxReturn(array('status'=>1,'info'=>'添加成功'));
		}else{
			$this->ajaxReturn(array('status'=>0,'info'=>'添加失败'));
		}
	}
	
	
	//删除指导分数
	public function deletedGgrade(){
		$sid=I("post.Snum",0,"int");
		$score=M("score")->where("Studentnum=$sid")->save(array('Ggrade1'=>NULL,'Ggrade2'=>NULL,'Ggrade3'=>NULL,'Ggrade4'=>NULL,'Ggrade5'=>NULL));
		if($score){
			$this->ajaxReturn("成功");
		}else{
			$this->ajaxReturn("失败");
		}
	}
	//评阅评分
	public function Pgrade(){
		$tnum=$_POST['num'];
		
		$data=D('score')->getPgradeList($tnum);
		
		$this->assign('score',$data);
		echo json_encode($data);
	}
	
	//修改评阅评分
	public function addPgrade(){
		//列出学生信息
		$Snum=I("get.Snum",0,"int");
		$data['message']=D('score')->getMessage($Snum);
		$data['score']=M('score')->field('Pgrade1,Pgrade2,Ptext')->where("Studentnum=$Snum")->find();	
		$this->assign($data);
		$this->display();
	}
	//保存论文评阅分数
	public function savePgrade(){
		$Snum=I("post.Snum",0,"int");
		$score=M('score');
		$Pgrade1=I('post.Pgrade1');
		$Pgrade2=I('post.Pgrade2');
		$Ptext=I('post.Ptext');
		$Pteacher = $_POST['Tname'];
		$savedScore=$score->where("Studentnum=$Snum")->save(array('Pgrade1'=>$Pgrade1,'Pgrade2'=>$Pgrade2,'Ptext'=>$Ptext,'Pteacher'=>$Pteacher));
		
		
		if($savedScore){
			$deTeaModel = M('defensestudent');
			$data['review_status'] = 2;
			$is_check = $deTeaModel->where("Snum=$Snum AND review_status=2")->find();
			if(!$is_check){
				$deTeaModel->where("Snum=$Snum")->save($data);
			}
			$this->ajaxReturn('成功');
		}else{
			$this->ajaxReturn('失败');
		}
	}
	//删除论文评阅分数
	public function deletePgrade(){
		
		$Snum=I("post.Snum",0,"int");
		$deTeaModel = M('defensestudent');
		$deTeaModel->startTrans();
		$shanchu=M('score')->where("Studentnum=$Snum")->save(array('Pgrade1'=>NULL,'Pgrade2'=>NULL,'Ptext'=>NULL,'Pteacher'=>NULL));
		$data['review_status'] = 1;
		$is_change = $deTeaModel->where("Snum=$Snum AND review_status = 1")->find();
		
		if(empty($is_change)){
			$change_status = $deTeaModel->where("Snum=$Snum")->save(array('review_status'=>1));
		}else{
			$change_status = TRUE;
		}
	
		if($shanchu && $change_status){
			$deTeaModel->commit();
			echo '成功';
		}else{
			$deTeaModel->rollback();
			echo '失败';
		}
		
	}
	//答辩评分
	public function Rgrade(){
		$Tnum = $_POST['num'];
		$rst  = D('score')->getRgradeGroup($Tnum);
		$this->assign('data',$rst);
		echo json_encode($rst);
		exit;
	}
	
	//进入答辩组
	public function RgradeShowStudent()
	{
		$defense_group =$_POST['defense_group']; 	
		$Tnum = $_POST['num'];
		$rst['rst'] = D('score')->getDefenseStudent($defense_group,$Tnum);
		$rst['rst1'] = D('defense')->getTeaInfo($defense_group);
		$this->assign('TeaInfo',$rst['rst1']);
		$this->assign('data',$rst['rst']);
		echo json_encode($rst);
		
	}
	
	//添加答辩评分
	public function addRgrade(){
		$Snum = I('get.Snum');
		$Tnum = $_SESSION['Tnum'];
		
		//获取学生信息		
	    $info=D('score')->getMessage($Snum);
		$Rgrade = D('score')->getRgrade($Snum,$Tnum);
		$this->assign('info',$info);
		$this->assign('Rgrade',$Rgrade);
		$this->display();
	}
	
	
	//保存答辩评阅分数
	public function saveRgrade(){
		$Tnum = $_POST['Tnum'];
		$Did=I("post.Did",0,"int");	
		$Studentnum =I("post.Studentnum",0,"int");	
		$dscore=M('dscore');
		if(empty($Did)){
			$score = M('score');
			$scorenum = $score->where('Studentnum='.$Studentnum)->getField('scorenum');
			$Did = $dscore ->add(array('Tnum'=>$Tnum,'scorenum'=>$scorenum,));
		}		
		$RgradeC1=I('post.RgradeC1');
		$RgradeC2=I('post.RgradeC2');
		$RgradeC3=I('post.RgradeC3');
		$RgradeC4=I('post.RgradeC4');
		$RtextC=I('post.RtextC');
		$savedScore=$dscore->where("Did=$Did AND Tnum=$Tnum")->save(array('RgradeC1'=>$RgradeC1,'RgradeC2'=>$RgradeC2,'RgradeC3'=>$RgradeC3,
				'RgradeC4'=>$RgradeC4,'RtextC'=>$RtextC));
		if($savedScore){
			$this->ajaxReturn('成功');
		}else{
			$this->ajaxReturn('失败');
		}
	}
	
	
	
	
}