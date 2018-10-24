<?php
namespace Home\Controller;
//我的课题控制器
class MyTopicController extends CommonController {
	//我的课题
	public function index() {
	$studentnum= $_SESSION['student'];
	/* $data['topic'] = D('student')->getList(
			//待查询字段
			't.Ctext,t.Cname,t.Ctype,t.Csource,teach.Tname,teach.Tnum',
			array('topic'=>'t','teacher'=>'teach'),
			array('t.Tnum=teach.Tnum','t.student_studentnum='.$studentnum['num'])
	); */
	//视图
	$sql1="select t.Ctext,t.Cname,t.Ctype,t.Csource,teach.Tname,teach.Tnum from think_topic as t 
				join think_teacher as teach on t.Tnum=teach.Tnum 
				join think_apply as s on s.topic_Cnum=t.Cnum where s.student_Snum=".$studentnum['num']." AND s.status = 1";
	$sql2="select t.Ctext,t.Cname,t.Ctype,t.Csource,teach.Tname,teach.Tnum from think_topic as t 
				join think_teacher as teach on t.Tnum=teach.Tnum 
				join think_apply as s on s.topic_Cnum=t.Cnum where s.student_Snum=".$studentnum['num']." AND s.status = 0";
	$data1['topic'] = D('student')->query($sql1);
	$data2 = D('student')->query($sql2);
	$_SESSION['tname']=$data['topic'][0]['Tname'];
	$_SESSION['tnum']=$data['topic'][0]['Tnum'];
	$this->assign($data1);
	$this->assign('data2',$data2);	
	$this->display();
	}
	
	public function teacher(){
		$tnum= $_SESSION['tnum'];
		$sql = "select Tnum,Tname,sex,depart,direction,phone,email,qq,title,Ttext,startdate from think_teacher 
				where Tnum=".$tnum;
		$data['teacher'] = D('teacher')->query($sql);
		$this->assign($data);
		$this->display();
	}
}
