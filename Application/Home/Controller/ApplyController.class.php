<?php
namespace Home\Controller;
//课题控制器
class ApplyController extends CommonController {
	//课题列表
	public function index() {
		/* $data['apply']=D('teacher')
		->field('Tnum,Tname,sex,depart,direction,phone,email,qq,Title,Ttext,startdate')
		->order('staffroom asc')
		->select(); */
		
		$sql="select t.Tnum,t.Tname,t.depart,t.direction,t.phone,t.email,t.qq,t.title,t.Ttext,t.startdate,erg.ERG_name
				from think_teacher as t join think_erg as erg on t.ERG_group=erg.ERG_group order by ERG_name";
		$data['apply']=D('teacher')->query($sql);
		$this->assign($data);
		$this->display();
	}
	
	public function topic(){
		$Tnum = I('get.Tnum');
		$studentnum=$_SESSION['student'];
		
		if (IS_POST){
			$res=$_POST;
			$this->applyAction($studentnum['num'],$studentnum['name'],$res['Cnum'],$res['Tnum'],$res['reason']);
			return;
		}
		
		
		$data['topicx']=D('topic')
		->field('Tnum,Cnum,Cname,Ctype,Ctext')
		->where(array('status="0"','Tnum='.$Tnum))
		->select();
		$this->assign($data);
		$this->display();
		
		
	}
	
	private function applyAction($Snum,$Sname,$Cnum,$Tnum,$reason){
		
		$count = D('apply')->where('student_Snum='.$Snum)->count();
		if($count >= 3){
			$this->error('你已选够了三个课题',U('topic/index'));
		}	
		$apply=array('topic_Cnum'=>$Cnum,'student_Snum'=>$Snum,'student_name'=>$Sname,'Tnum'=>$Tnum,'reason'=>$reason,'status'=>0);	
		$err=D('apply')->where(array('topic_Cnum'=>$Cnum,'student_Snum'=>$Snum,'Tnum'=>$Tnum))->find();
		$err1=D('apply')->where(array('student_Snum'=>$Snum,'Tnum'=>$Tnum,'status'=>1))->find();
	
		if ($err || $err1){
			$this->error('已申请',U('topic/index'));
		}else{
			$re=D('apply')->add($apply);
			
		}
		
		
		if ($re!=false){
			$this->success('申请成功',U('MyTopic/index'));
		}else {
			$this->error('申请失败',U('topic/index'));
		}
		/*  */
	}
}