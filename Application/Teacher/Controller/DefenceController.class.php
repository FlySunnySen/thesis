<?php
namespace Teacher\Controller;
use Think\Controller;
use Org\Util;

class DefenceController extends CommonController
{
	
	function _initialize() 
	{
	   parent::__initialize();
	   $role = session('role');
	   if($role !=3){
	   	$this->error('权限不够');
	   }
	}
	
	public function index()
	{
		$year        = $_SESSION['selected_year'];	
	    $status      = $_GET['status'];
		$yearInfo="think_defense.year=$year AND think_defense.status=$status";		
		$defenseinfo = D('defense')->getList('',$yearInfo,$status);
		//获取还没分配的学生
		$count       = D('defense')->getCount($year,$status);
		$this->assign('status',$status);
		$this->assign('count',$count);
		$this->assign('defenseinfo',$defenseinfo);		
		$this->display();
	}
	
	public function add()
	{

        $status = $_GET['status'];
		$EGR = M('erg');		
		$rst = $EGR->select();
		$this->assign('status',$status);
		$this->assign('ERG',$rst);
        $this->display();
	}
	//接受ajax请求，根据教研室，获取对应教研室的教师
	public function returnInfo()
	{
		$ERG = $_POST['ERG_group'];	
		$rst = D('erg')->getInfo($ERG);
		return $this->ajaxReturn($rst);
		$this->assign('teacherInfo',$rst);
	}
	//接受ajax请求，新增分组
	public function addTeam()
	{
		$admin = I('post.adminNum');
		$teacher = I('post.teacher');
		$adminName = I('post.adminName');
		$ERG_group = I('post.ERG_group');
		$class     = I('post.class');
		$time      = I('post.time');
		$status    = I('post.status');	
		$year      = $_SESSION['selected_year'];	
		$rst = D('defense')->addTeam($admin,$adminName,$teacher,$ERG_group,$time,$class,$year,$status);
		$this->ajaxReturn($rst);
	}
	//分配学生
	public function showAddStudent()
	{
					
		$DATA = $_GET;
		$year = $_GET['year'];
		$status = $_GET['status'];
		$ERG_group = $_GET['ERG_group']; 
		$defense_group = $_GET['defense_group'];	
		$rst2 = D('defense')->getStudent($defense_group);
		
		//找出该答辩组的教师
		$teacher = M('defenseteacher');
		$teacherRst = $teacher
		              ->field('think_teacher.Tname')
                      ->where('defense_group='.$defense_group)
                      ->join('__TEACHER__ ON __DEFENSETEACHER__.Tnum = __TEACHER__.Tnum')
	                  ->select();
		//遍历结果集，生成数组并转换为字符串	
		foreach($teacherRst as $key=>$value){
			$teacherTnum[]=$value['Tname'];
		}
		$teacherTnameString = implode(',', $teacherTnum);
		$this->assign('status',$status);
		$this->assign('defense_teacher',$teacherTnameString);		
		$this->assign('defense_student',$rst2);
		$this->assign($DATA);
		$this->display();
		
	}
    
	//显示符合加入答辩组条件的学生
	public function ajaxShow()
	{
		$N =$_GET['N'];
		$year = $_GET['year'];
		$ERG_group = $_GET['ERG_group'];
		$status    = $_GET['status'];
		$defense_group = $_GET['defense_group'];
		$method        = "student";
		$studentlist  = "studentlist";
		self::ajaxShowStuden($N,$year,$defense_group,$ERG_group,$method,$studentlist,$status);
		
	}
    //显示不符合加入答辩组条件的学生
	public function ajaxShowStudentNo()
	{
		$N =$_GET['N'];
		$year = $_GET['year'];
		$ERG_group = $_GET['ERG_group']; 
		$status    = $_GET['status'];
		$defense_group = $_GET['defense_group'];
		$method        = "student_no";
		$studentlist   = "studentlist_no";
		self::ajaxShowStuden($N,$year,$defense_group,$ERG_group,$method,$studentlist,$status);
		
	}

    public function ajaxShowStuden($N,$year,$defense_group,$ERG_group,$method,$studentlist,$status)
	{		
		
	
		//获取符合条件的学生
		$topic = M('topic');
		$where = array(
		'think_topic.year' => $year ,		 
		 'think_topic.status' =>1,
		 'think_apply.status'=>1,
		 'denfense_allocation'=>0,	
		 'denfense_status'	  =>$status,		 
		 );
		 $map['think_topic.ERG_group']  = array("$N",$ERG_group);
		 
		$count = $topic ->field('think_apply.Tnum,think_teacher.Tname,student_Snum,student_name')	
		->join('__APPLY__ ON __APPLY__.topic_Cnum = __TOPIC__.Cnum')
		->join('__STUDENT__ ON __STUDENT__.Snum = __APPLY__.student_Snum')
		->join('__TEACHER__ ON __TEACHER__.Tnum = __APPLY__.Tnum')
		->where($where)->where($map)->count();
		
		 //实例化分页类，传入三个参数，分别是数据总数、每页显示的数据条数、要调用的jQuery ajax方法名
		$p=new \Org\Util\AjaxPage($count,5,"$method");
		
		$page=$p->show();
		
		$studentRst = $topic ->field('think_apply.Tnum,think_teacher.Tname,student_Snum,student_name')	
		->join('__APPLY__ ON __APPLY__.topic_Cnum = __TOPIC__.Cnum')
		->join('__STUDENT__ ON __STUDENT__.Snum = __APPLY__.student_Snum')
		->join('__TEACHER__ ON __TEACHER__.Tnum = __APPLY__.Tnum')
		->where($where)->where($map)->limit($p->firstRow.','.$p->listRows)->select();
		$this->assign('defense_group',$defense_group);
		$this->assign('list',$studentRst);
        $this->assign('page',$page);		
        //ajax返回信息，就是要替换的模板
        $res["content"] = $this->fetch("Defence/$studentlist");
	
        $this->ajaxReturn($res);
	}
    //自动添加学生
	public function autoAddStudent()
	{
		if(IS_POST)
		{
			$num = $_POST['studentNum'];
			$defense_group = $_POST['defense_group'];
			$status = $_POST['status'];
			$year = $_POST['year'];
			$ERG_group = $_POST['ERG_group'];
			$rst = D('defense')->autoAddStudent($defense_group,$num,$year,$ERG_group,$status);
			if($rst){
				$this->success("成功添加".$rst."人");
			}else{
				$this->error('没有符合条件的学生');
			}
		}	
	}
	//手动添加学生
	public function addStudent()
	{
		$data = $_GET;
		$defense_group = $_GET['defense_group'];
		$Snum = $_GET['Snum'];
		$rst = D('defense')->addStudent($data,$Snum,$defense_group);
		if($rst){
			$this->success('添加成功');
		}else{
			$this->error('添加失败');
		}
	}
	
	//按学号或姓名添加学生
	public function findAddStudent()
	{
		$num_name = I('post.num_name');
		$year     = I('post.year');
		$defense_group = I('post.defense_group');
		$status = I('post.status');
		$rst = D('defense')->findAddStudent($num_name,$defense_group,$year,$status);
		if($rst){
			$this->success("$rst");
		}else{
			$this->error('添加失败');
		}
	}
	
	//删除答辩组的学生
	public function deleteStudent()
	{
		$Snum = $_GET['Snum'];
		$rst = D('defense')->deleteStudent($Snum);
		
		if($rst){
			$this->success('删除成功');
		}else{
			$this->error('删除失败');
		}
        
	}
	
	//删除整个答辩组
	public function delectTeam()
	{
		$defense_group = I('get.defense_group');
		$rst = D('defense')->delectTeam($defense_group);
	
		if($rst){
			$this->success('删除成功');
		}else{
			$this->error('删除失败');
		}
	}
	//修改答辩组信息
	public function editTeam()
	{
		$defense_group = I('defense_group');
		$defense  = M('defense');
		//获取答辩时间和教室
		$rst = $defense->where('defense_group='.$defense_group)->find();
		//获取当前组员
		$rst2= D('defense')->getTeaInfo($defense_group);
		$date = substr($rst['time'], 0,10);
		$time = substr($rst['time'], 10);
		$this->assign('teaInfo',$rst2);
		$this->assign('date',$date);
		$this->assign('time',$time);
		$this->assign('class',$rst['class']);
		$this->assign('defense_group',$rst['defense_group']);
		$this->display();
	}
	
	//添加组员
	public function addItem()
	{
		$defense_group = I('post.defense_group');
		$numOrName     = I('post.numOrName');
		$rst = D('defense')->addIteam($defense_group,$numOrName);
		$this->ajaxReturn($rst);
	}
	
	//删除组员
	public function deleteItem()
	{
		$defense_group = I('get.defense_group');
		$Tnum          = I('get.Tnum');
		$rst = D('defense')->deleteItem($defense_group,$Tnum);
		if($rst){
			$this->success('删除成功');
		}else{
			$this->error('删除失败');
		}
	}
	
	//保存答辩时间和教室
	public function saveTeam()
	{
		$data = $_POST;
		$defense_group = $_POST['defense_group'];
		$defense = M('defense');
		$rst    = $defense->where('defense_group='.$defense_group)->save($data);
		if($rst){
			$this->ajaxReturn("更新成功");
		}else{
			$this->ajaxReturn('修改失败');
		}
	}
}
