<?php
namespace Home\Controller;
//课题控制器
class TopicController extends CommonController {
	//课题列表
	public function index() {
		//获得课题列表
		
		$year = $_SESSION['student']['year'];
		$sql="select t.Cnum,t.Cname,t.Ctype,t.Csource,t.status,teach.Tname,teach.Tnum,	s.student_Snum,s.student_name from think_topic as t 
			 join think_teacher as teach on t.Tnum=teach.Tnum 
			left	join think_apply as s on s.topic_Cnum=t.Cnum  where year=$year order by t.status asc,t.Tnum";
		$data['topic']=D('topic')->query($sql);
		$this->assign($data);
		$this->display();
	}
	
	public function topicxx(){
		$Cnum = I('get.Cnum',0,'int');
		/* $data['Cxx']=D('topic')->getList(
				't.Cnum,t.Cname,t.Ctype,t.Csource,t.Ctext,s.Sname',
				array('topic'=>'t','student'=>'s'),
				array('t.Cnum='.$Cnum,'s.stu_Cnum=t.Cnum'),'Cnum asc'
				); */
		$sql="select t.Cnum,t.Cname,t.Ctype,t.Csource,t.Ctext,s.Sname from think_topic as t
				join think_student as s on s.stu_Cnum=t.Cnum where t.Cnum=".$Cnum;
		$data['Cxx']=D('topic')->query($sql);
		$this->assign($data);
		$this->display();
	}
	
}