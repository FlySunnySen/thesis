<?php
namespace Teacher\model;
use Think\Model;
class DefenseModel extends Model
{
	//获取学生总人数
	public function getCount($year,$status)
	{
		$topic = M('topic');
		$where = array(
		'think_topic.year' => $year ,
		 'think_topic.status' =>1,
		 'think_apply.status'=>1,
		 'denfense_allocation'=>0,
		 'denfense_status'	  =>$status,	 
		 );
		 $studentCount = $topic
						->join('__APPLY__ ON __APPLY__.topic_Cnum = __TOPIC__.Cnum')
						->join('__STUDENT__ ON __STUDENT__.Snum = __APPLY__.student_Snum')
						->join('__TEACHER__ ON __TEACHER__.Tnum = __APPLY__.Tnum')
						->where($where)->count();
		return $studentCount;
	}
	
	//添加答辩组
	public function addTeam($admin,$adminName,$teacher,$ERG_group,$time,$class,$year,$status){
		
		
		$teacherModel = M('teacher');
		$pwd = $teacherModel->where('Tnum = '.$admin)->getField(pwd);
		
		$data1 = array('Tnum' => $admin, 'Tname' => $adminName, 'pwd' => $pwd, 'role' =>'2',);
		$data2 = array('admin' => $admin, 'ERG_group' => $ERG_group,'time'=> $time, 'class' => $class ,'year'=>$year,'status'=>$status);
		
		$adminModel = M('admin');
		//开启事务
		$adminModel->startTrans();
		
		//添加小组组长到管理员表·		
		$find = M('admin')->where('Tnum='.$admin)->find();
		
		if(empty($find)){			
		    $rst1 = $adminModel->add($data1); 	
		}else{
			$rst1 = TRUE;
			
		}
		
		//添加答辩组
		
		$defense = M('defense');
		$rst2    = $defense->add($data2);
		if ($rst2)
		{
			 $id = $rst2; 
		}
		
		//添加教师
		$tea = explode(",",$teacher);
		$teaLenth = count($tea);      
		$Model=M('defenseteacher');
        for($i=0;$i<$teaLenth;$i++){
        	
			$data3 = array(
			       'id' => '',
			       'Tnum' => $tea[$i],
			       'Tname' =>'',
			       'defense_group' => $id,
			);
//			$sql = "INSERT INTO think_defenseteacher VALUES('','$tea[$i]','','$id')";
//			$rst3 = $Model->query($sql);
			$rst3 = $Model->add($data3);			
			if(empty($rst3))
			{
				break;
			}
			
        }
		
		//判断以上sql操作是否成功，如果成功则执行事务，反之回滚事务
		if($rst1 && $rst2 && $rst3){
			
			$adminModel->commit();
			$result = '添加成功';
            
			
			
		}else{
			$adminModel->rollback();
			$result = "失败";
		};		
		return $result;
	}

    //获取答辩组成员信息
    public function getTeaInfo($defense_group)
    {
    	$defenseTeaModel = M('defenseteacher');
		$rst = $defenseTeaModel
		       ->field('think_teacher.Tnum,think_teacher.Tname')
		       ->join('__TEACHER__ ON __TEACHER__.Tnum = __DEFENSETEACHER__.Tnum')
			   ->where('defense_group = '.$defense_group)
			   ->select();
		return $rst;
    }

    public function getStudent($defense_group)
    {
    	$defense_student = M('defensestudent');
		return $defense_student->where('defense_group='.$defense_group)->select();
    }

    //添加组员
    public function addIteam($defense_group,$numOrName)
	{
	   $deTeaModel = M('defenseteacher');
	   $deStuModel = M('defensestudent');
	   $scoreModel  = M('score');	
	   $dscoreModel = M('dscore');
	    if(is_numeric($numOrName)){
	   	   $info = $numOrName;
	   }else{
	   	   $teacher = M('teacher');
	   	   $info = $teacher->where("Tname='".$numOrName."'")->getField('Tnum');
	   }	
	  
	   //获取该答辩组的学生
	   $deStudent = $deStuModel->where('defense_group='.$defense_group)->getField('Snum',true); 
	   $DidArray   = array();
	   foreach($deStudent as $value){
	   	   
	   	   $DidItem = $scoreModel				   	   
				   	   ->where('Studentnum ='.$value)
					   ->getField('scorenum');
		    $DidArray[] = $DidItem;
	   } 
     
	   $deTeaModel->startTrans();
	   
	   //添加数据到答辩教师表
	   $data = array(
	           'defense_group' => $defense_group,
	           'Tnum'          => $info,           
	   );
	   $denTeaRst   = $deTeaModel->add($data);	
	 
	   if(!empty($DidArray)){
	   	
		     //添加数据到答辩评分表
			   $dscoreModel = M('dscore');
			   foreach($DidArray as $value)
			   {
			   	   $data = array(
				       'Tnum' => $info,
				       'scorenum' => $value,
				       
				   );
				   $is_exist = $dscoreModel->where($data)->find();
				   
				   if(empty($is_exist)){
					   	$dscoreRst = $dscoreModel->add($data);
					   if(!$dscoreRst){
					   	  break;
					   }
				   }else{
				   	  $dscoreRst=TRUE;
				   }
				   
			   }
		
	   }else{
	   	    $dscoreRst=TRUE;
	   }
	 
	  
	   if($denTeaRst && $dscoreRst){
	   	    $deTeaModel->commit();
		    return '添加成功';
	   }else{
	   	  $deTeaModel->rollback();
		  return  '添加失败';
	   }
	 
	}

	//删除组员
	public function deleteItem($defense_group,$Tnum)
	{
		$deTeaModel = M('defenseteacher');
		$deTeaModel->startTrans();
		$deStuModel = M('defensestudent');
		$data1 = array(
		      'defense_group' => $defense_group,
		      'Tnum'          => $Tnum,
		);
		$data2 = array(
		      'defense_group' => $defense_group,
		      'reviewTeacher' => $Tnum,
		);
		//如果论文评阅状态是未评阅状态，则修改为未分配
		$is_exist = $deStuModel->where($data2)->where("review_status != 2")->select();
		if($is_exist){
			$rst1 = $deStuModel->where($data2)->where("review_status != 2")->save(array('reviewTeacher'=>NULL,'review_status'=>0));
		}else{
			$rst1 = TRUE;
		}
	    //删除答辩组教师信息
		$rst2 = $deTeaModel->where($data1)->delete();		
		if($rst1 && $rst2){
			$this->commit();
			$result = TRUE;
		}else{
			$this->rollback();
			$result = FALSE;
		}
		return $result;
	}
	
	
	public function getList($defense_group,$year)
	{

	    $defensestudent = M('defensestudent');
		$rst = $defensestudent->field('think_defense.defense_group,think_defense.year,think_defense.ERG_group,GROUP_CONCAT(DISTINCT think_teacher.Tname) AS TEA,GROUP_CONCAT(DISTINCT Sname) AS STU,think_admin.Tname AS admin,think_admin.Tnum AS adminnum ,class,time')
		->where($year)
		->group('think_defense.defense_group')
		->join('right join __DEFENSE__  ON  __DEFENSESTUDENT__.defense_group = __DEFENSE__.defense_group')
		->join('__DEFENSETEACHER__ ON __DEFENSETEACHER__.defense_group = __DEFENSE__.defense_group')
		->join('__ADMIN__ ON __ADMIN__.Tnum = __DEFENSE__.admin') 
		->join('__TEACHER__ ON __DEFENSETEACHER__.Tnum = __TEACHER__.Tnum')
		->having($defense_group)
		
		->select();
		return $rst;
	}
	 
	//改写该学生的答辩分配状态 
	public function changeStatus($student_Snum,$status)
	{
		    $student   = M('student');
			$data['denfense_allocation'] = $status;				
			$rst = $student->where('Snum='.$student_Snum)->save($data);				
			return $rst;
	}
	
	public function findStudent($defense_group,$year,$ERG_group,$N,$status)
	{
		
		//找出该答辩组的教师
		$teacher = M('defenseteacher');
		$teacherRst = $teacher->field('Tnum')->where('defense_group='.$defense_group)->select();
		//遍历结果集，生成数组并转换为字符串	
		foreach($teacherRst as $key=>$value){
			$teacherTnum[]=$value['Tnum'];
		}
		$teacherTnumString = implode(',', $teacherTnum);
		
		//获取符合条件的学生
		$topic = M('topic');
		$where = array(
		'think_topic.year' => $year ,
		 'think_topic.ERG_group' => $ERG_group, 
		 'think_topic.status' =>1,
		 'think_apply.status'=>1,
		 'denfense_allocation'=>0,
		 'denfense_status'	  =>$status,	 
		 );
		 $map['think_apply.Tnum']  = array("$N",$teacherTnumString);
		$studentRst = $topic ->field('think_apply.Tnum,think_teacher.Tname,student_Snum,student_name')	
		->join('__APPLY__ ON __APPLY__.topic_Cnum = __TOPIC__.Cnum')
		->join('__STUDENT__ ON __STUDENT__.Snum = __APPLY__.student_Snum')
		->join('__TEACHER__ ON __TEACHER__.Tnum = __APPLY__.Tnum')
		->where($where)->where($map)->select();
		echo $topic->getLastSql();exi;
		return $studentRst;
	}
	
	//自动添加学生
	public function autoAddStudent($defense_group,$num,$year,$ERG_group,$status)
	{
		$N ="NOT IN";
		$studentRst =self::findStudent($defense_group,$year,$ERG_group,$N,$status);
		//将获取到的数据添加到数据库
		$think_defensestudent = M('defensestudent');
		
		$think_defensestudent->startTrans();  //开启事务
		
		$i = 0; //建立标志变量		
		foreach($studentRst as $key=>$value){						
			if($i == $num){				
				break;
			}
			$data = array(
			     'Snum' => $value['student_Snum'],
			     'Sname'=> $value['student_name'],
			     'reviewTeacher' => '',
			     'defense_group' =>$defense_group,
			);
			//添加到答辩学生表
            $rst1 = $think_defensestudent->add($data);
			//改写该学生的答辩分配状态
            $rst2 = self::changeStatus($value['student_Snum'],1);	
			$rst3 = self::addData($value['student_Snum'],$defense_group);		   
			if(empty($rst1) && empty($rst2) && empty($rst3)){
				$think_defensestudent->rollback();
				break;
			}
			
			$i++;
			
			
		}		
		if($rst1 && $rst2){			
		    $think_defensestudent->commit();
		    return $i;
		}
		
		
		
						
	}
	
	//按照学号添加学生
	public function findAddStudent($num_name,$defense_group,$year)
	{
		$studentModel = M('student');
		$where = array(
		 'think_topic.year' => $year ,		 
		 'think_topic.status' =>1,
		 'think_apply.status'=>1,
		 'denfense_allocation'=>0,	
		 'denfense_status'	  =>1,		 
		 );
		 if(is_numeric($num_name)){
		 	$info = 'student_Snum';
			
		 }else{
		 	$info = 'student_name';
		 }
		$defense_student_num  = $studentModel
		            ->field('student_Snum,student_name')
		            ->join('__APPLY__ ON __APPLY__.student_Snum = __STUDENT__.Snum')
					->join('__TOPIC__ ON __TOPIC__.Cnum = __APPLY__.topic_Cnum')
					->where($where)
					->where("$info = '".$num_name."'")
					->count();
	  
		if($defense_student_num > 1){
			return '存在同名学生，请用学号添加';
		}
		if($defense_student_num == 0){
			return '该学生不存在或不满足条件';
		}
		$defense_student  = $studentModel
		            ->field('student_Snum,student_name')
		            ->join('__APPLY__ ON __APPLY__.student_Snum = __STUDENT__.Snum')
					->join('__TOPIC__ ON __TOPIC__.Cnum = __APPLY__.topic_Cnum')
					->where($where)
					->where("$info = '".$num_name."'")
					->find();
	   
	    if($defense_student){
	    	$defenseStudent = M('defensestudent');
			$defenseStudent->startTrans();
			$data = array(
			        'Snum'=>$defense_student['student_Snum'],
			        'Sname'=>$defense_student['student_name'],
			        'defense_group'=>$defense_group,
			);
			
			$rst1 = $defenseStudent->add($data);								
			$rst2 = self::changeStatus($defense_student['student_Snum'],1);			
			$rst3 = self::addData($defense_student['student_Snum'],$defense_group);	
			if($rst1 && $rst2 && $rst3){
				$defenseStudent->commit();
				return '添加成功';
			}else{
				$defenseStudent->rollback();
				return '添加失败';
			}
	    }else{
	    	return '添加失败';
	    }
	}
			

			
	
    //添加答辩评分表数据
	public function addData($studentNum,$defense_group)
	{
		
			$score = M('score');
			//获取成绩单编号
			$Did   = $score->where('Studentnum='.$studentNum)->getField('scorenum');
			//获取该答辩组的教师
			$defense_teacher = M('defenseteacher');
			$Dscore = M('dscore');
			$teacher = $defense_teacher->where('defense_group='.$defense_group)->getField('Tnum',true);
			foreach($teacher as $key1=>$value1){
				$data   = array('scorenum' =>$Did,'Tnum'=>$value1);
				$rst3   = $Dscore->add($data);
			}
            return $rst3;
	}
	 //删除答辩评分表数据
	public function deleteData($studentNum)
	{
		
			$score = M('score');
			//获取成绩单编号
			$Did   = $score->where('Studentnum='.$studentNum)->getField('scorenum');	
			
			$Dscore = M('dscore');
			$rst    = $Dscore->where('scorenum ='.$Did)->delete();
			
            return $rst;
	}
	
    //手动添加学生
    public function addStudent($data,$Snum,$defense_group)
	{
		$defenseStudent = M('defensestudent');
		$defenseStudent->startTrans();
		$rst1 = $defenseStudent->add($data);
		$rst2 = self::changeStatus($Snum,1);
		$rst3 = self::addData($Snum,$defense_group);
		if($rst1 && $rst2 && $rst3){
			$defenseStudent->commit();
			return TRUE;
		}else{
			$defenseStudent->rollback();
			return FALSE;
		}
	    
	}

    //删除学生
    public function deleteStudent($Snum)
	{
		$defenseStudent = M('defensestudent');
		$defenseStudent->startTrans(); //开启事务
		$rst1 = $defenseStudent->delete($Snum);				
		$rst2 = self::changeStatus($Snum,0);
		$rst3 = self::deleteData($Snum);
		
	    if($rst1 && $rst2 && $rst3){
	    	$defenseStudent->commit();
			return TRUE;
	    }else{
	    	$defenseStudent->rollback();
			return FALSE;
	    }
	}
	
	//删除整个答辩组
	public function delectTeam($defense_group)
	{
		$defense = M('defense');
		$defense->startTrans();
		//先删除学生
		$student = M('defensestudent');
		$studentRst = $student->where('defense_group='.$defense_group)->getField('Snum',true);
		if($studentRst){
				foreach($studentRst as $key=>$value){						
					$rst1 = $student->delete($value);				
					$rst2 = self::changeStatus($value,0);
					if($rst1 && $rst2){
						$rst = TRUE;
					}else{
						$rst = FALSE;
						break;
					}
			    }	
		}else{
			$rst = TRUE;
		}
		
		//再删除教师
		$teacher = M('defenseteacher');
		$teacherRst = $teacher ->where('defense_group='.$defense_group)->delete();
		//接着删除组长管理员身份
		$defenseAdmin = $defense->where('defense_group='.$defense_group)->getField('admin'); //找出该组的管理员
		$defenseAdminNum = $defense -> where('admin='.$defenseAdmin)->count();
		//如果该管理员拥有两个以上的答辩组则不进行删除
		if($defenseAdminNum == 1){
			$admin  = M('admin');
			$where  = array('Tnum' => $defenseAdmin,'role'=>2,);
			$adminRst = $admin ->where($where)->delete();
		}else{
			$adminRst = TRUE;
		}
		
		//最后删除答辩组
		$defenseRst = $defense ->delete($defense_group);
		
		if($rst && $teacherRst && $defenseRst && $adminRst){
			$defense->commit();
			return  TRUE;
		}else{
			
			$defense->rollback();
			return FALSE;
		}
	}
	
	

}
