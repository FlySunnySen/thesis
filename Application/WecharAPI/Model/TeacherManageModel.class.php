<?php
namespace WecharAPI\model;
use  Think\Model;
class TeacherManageModel extends Model
{
	//获取已经分配的学生
	public function getStudent($defense_group,$review)
	{
		$defense = M('defense');
		$rst     = $defense
		           ->field('think_defensestudent.Snum,think_defensestudent.Sname,
		                    think_defensestudent.reviewTeacher,think_teacher.Tname')
		           ->join('__DEFENSESTUDENT__ ON __DEFENSESTUDENT__.defense_group = __DEFENSE__.defense_group')
		           ->join('__TEACHER__ ON __TEACHER__.Tnum = __DEFENSESTUDENT__.reviewTeacher')
				   ->where('think_defense.defense_group ='.$defense_group)
				   ->where($review)
				   ->select();	   
		$field = 'Tname';
	    foreach($rst as $key=>$value)
	    {
	    	$rst[$key]['EduTeacher'] = self::findEduTeacher($rst[$key]['Snum'],$field);
	    }
	    return $rst;        
	}
	
	//找出学生的指导老师
	public function findEduTeacher($studentnum,$field)
	{
		$apply = M('apply');
		$rst = $apply ->field($field)
		                ->join('__TOPIC__ ON __TOPIC__.Cnum = __APPLY__.topic_Cnum')
						->join('__TEACHER__ ON __TEACHER__.Tnum = __TOPIC__.Tnum')
						->where('student_Snum='.$studentnum)
						->select();
		foreach($rst as $key=>$value)
		{
			$Tname = $value['Tname'];
		}
	    return $Tname;
	}
	
	//获取未分配的学生
	public function getNoAllotStudent($review)
	{
		$defenseStudent = M('defensestudent');
		$rst            = $defenseStudent->field('think_defensestudent.Snum,think_defensestudent.Sname,think_teacher.Tnum,Tname')
		                                 ->join('__APPLY__ ON __DEFENSESTUDENT__.Snum = __APPLY__.student_Snum')
		                                 ->join('__TEACHER__ ON __TEACHER__.Tnum = __APPLY__.Tnum')																			 
										 ->where($review)
										 ->select();
	   
	    return $rst;
	}
	
	//获取该答辩组成员
	public function getDefenseTea($defense_group)
	{
		$defenseTea = M('defenseteacher');
		$rst        = $defenseTea->where('defense_group='.$defense_group)
		              ->join('__TEACHER__ ON __TEACHER__.Tnum = __DEFENSETEACHER__.Tnum')
					  
		              ->select();
		return $rst;
	}
	//手动分配
	public function AddViewTea($student,$teacher)
	{
		$defense_student = M('defensestudent');
		$defense_student->startTrans();
		$data['reviewTeacher']  = $teacher;
		$rst   =  $defense_student ->where('Snum ='.$student)->save($data);
		
		if($rst){
			
			$data1['review_status'] = 1;
			$is_check = $defense_student->where("Snum=$student AND review_status=1")->find();					
			if(empty($is_check)){
				$rst1=$defense_student->where('Snum='.$student)->save($data1);				
			}else{
				$rst1=TRUE;
			}
            if($rst1){
            	$defense_student->commit();
            	$result="分配成功";
            }else{
            	$defense_student->rollback();
				$result="分配失败";
            }
			
		}else{
			$result="分配失败";
		}
		return $result;
	}
	//自动分配
	public function autoAddViewTea($defense_group)
	{
		$teacherSum = M('defenseteacher')->where('defense_group ='.$defense_group)->count();
		$studentSum = M('defensestudent')->where('defense_group ='.$defense_group)->count(); 
		$review = array("reviewTeacher" =>0, "defense_group"=>$defense_group,);
		$student    = self::getNoAllotStudent($review);		
		$teacher = self::getDefenseTea($defense_group);
		$rst        = self::numberAvg($studentSum,$teacherSum); //分配各教师评阅人数
		//将有指导老师在的学生放在数组前面
		
		foreach($student as $key=>$value)
		{		
			
			foreach($teacher as $key1=>$value1)
			{			  	
			  $search  = array_search($value['Tnum'], $value1);	
			  if($search){
			  	$count = array_unshift($student,$value);
				$del   = array_splice($student,$key+1,1);
			  	break;
			  }	
			}								
					
		}
       
		//进行论文评阅分配
	       
		$defense_student = M('defensestudent');	
		$defense_student->startTrans();
		foreach($teacher as $key=>$value)
		{
			$i = 0;				
			$num = $rst[$key];			
			foreach($student as $key1=>$value1)
	        {
	        	if($num == $i){		        		
	        		break;
	        	}						        			
				if($value1['Tnum'] != $value['Tnum']){
			    	$data['reviewTeacher'] = $value['Tnum'];
					$rst1 = $defense_student->where('Snum='.$value1['Snum'])->save($data);
					$del = array_splice($student,$key1,1);
					$i++;
					if(empty($rst1)){
						$defense_student->rollback();
						break;
					}
					
				}					        			        										
			  						
			}
			
		}
		
		if($rst1){
			$defense_student->commit();
			return TRUE;
		}else{
			return FALSE;
		}
			
		
		
	}
	
	
	//评阅学生人数分配
	public function numberAvg($number, $avgNumber)  
	    {  
	        if($number == 0) {  
	            $array = array_fill(0, $avgNumber, 0);  
	        } else {  
	            $avg     = floor($number / $avgNumber);  
	            $ceilSum = $avg * $avgNumber;  
	            $array   = array();  
	            for($i = 0; $i < $avgNumber; $i++) {  
	                if($i < $number - $ceilSum) {  
	                    array_push($array, $avg + 1);  
	                } else {  
	                    array_push($array, $avg);  
	                }  
	            }  
	        }  
	        return $array;  
	    }  

  
}
