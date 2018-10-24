<?php
namespace Teacher\Model;
use Think\Model;

class ScoreModel extends Model{
	//拼接评分表
	public function getList($tnum,$year){
		//拼接完整表名
		$score = C('DB_PREFIX').'score';
		$apply = C('DB_PREFIX').'apply';
		$student = C('DB_PREFIX').'student';
		$topic   = C('DB_PREFIX').'topic';
		$sql = "select t.Cname,s.Sname,s.Snum,s.denfense_draft,t.Tnum,sc.scorenum,sc.Ggrade1,sc.Ggrade2,sc.Ggrade3,sc.Ggrade4,sc.Ggrade5,sc.Gtext from $score as sc 
		right join $student as s on s.Snum = sc.Studentnum 
		join $apply as a on s.Snum = a.student_Snum 
		join $topic as t on t.Cnum = a.topic_Cnum
		where t.Tnum=$tnum AND a.status = 1 AND t.year = $year";
		return $this->query($sql);
	}
	//添加分数
	public function getMessage($sid){
		$apply = C('DB_PREFIX').'apply';
		$topic = C('DB_PREFIX').'topic';		
		$sql = "select s.student_Snum,s.student_name,t.Cname from $apply as s  
		join $topic as t on s.topic_Cnum = t.Cnum
		where s.student_Snum=$sid";
		return $this->query($sql);
	}
	
	//评阅评分表
	public function getPgradeList($tnum){
		$defense_student = M('defensestudent');
		$field = "think_score.Pgrade1,think_score.Pgrade2,think_score.Ptext,think_student.Snum,think_student.Sname,think_student.taskbook,think_student.denfense_draft,think_topic.Cname,think_teacher.Tname";
		$rst = $defense_student
		       ->field("$field")
		       ->join('__SCORE__ ON __SCORE__.Studentnum = __DEFENSESTUDENT__.Snum')
			   ->join('__STUDENT__ ON __STUDENT__.Snum = __DEFENSESTUDENT__.Snum')
			   ->join('__APPLY__ ON __APPLY__.student_Snum = __DEFENSESTUDENT__.Snum')
			   ->join('__TOPIC__ ON __TOPIC__.Cnum = __APPLY__.topic_Cnum')
			   ->join('__TEACHER__ ON __TOPIC__.Tnum = __TEACHER__.Tnum')
			   ->where('reviewTeacher='.$tnum)
			   ->select();
	   
		return $rst;
		
	}
	//答辩分组表
	public function getRgradeGroup($Tnum){
		$defense_group = M('defenseteacher');
		$rst = $defense_group
		       ->field('think_defenseteacher.defense_group,Tnum,GROUP_CONCAT(DISTINCT Sname) AS STU,class,time')
		       ->join('left join __DEFENSESTUDENT__ ON __DEFENSESTUDENT__.defense_group = __DEFENSETEACHER__.defense_group')
		       ->join('__DEFENSE__ ON __DEFENSE__.defense_group = __DEFENSETEACHER__.defense_group')
		       ->group('think_defenseteacher.id')
			   ->having("Tnum=$Tnum")
			   ->select();
	    return $rst;
		
	}
	
	//获取答辩组的学生
	public function getDefenseStudent($defense_group,$Tnum)
	{
		$defense_student = M('defensestudent');		
		$field = "think_dscore.RgradeC1,think_dscore.Did,think_dscore.RgradeC2,think_dscore.RgradeC3,think_dscore.RgradeC4,think_dscore.RtextC,think_dscore.Tnum,think_defensestudent.Snum,think_defensestudent.Sname,think_topic.Cname,think_teacher.Tname";
		$rst = $defense_student
		       ->field("$field")
		       ->join('left join __SCORE__ ON __SCORE__.Studentnum = __DEFENSESTUDENT__.Snum')
			   ->join('left join __DSCORE__ ON __DSCORE__.scorenum = __SCORE__.scorenum')			  
			   ->join('__APPLY__ ON __APPLY__.student_Snum = __DEFENSESTUDENT__.Snum')
			   ->join('__TOPIC__ ON __TOPIC__.Cnum = __APPLY__.topic_Cnum')
			   ->join('__TEACHER__ ON __TOPIC__.Tnum = __TEACHER__.Tnum')
			   ->where('think_defensestudent.defense_group='.$defense_group." AND think_dscore.Tnum=".$Tnum)
			   ->select();
	   
		return $rst;
	}
	
	//答辩评分表
	public function getRgradeList($snum,$tnum){
		//拼接完整表名
		$score = C('DB_PREFIX').'score';
		$topic = C('DB_PREFIX').'topic';
		$student = C('DB_PREFIX').'student';
		$teacher = C('DB_PREFIX').'teacher';
		$dscore = C('DB_PREFIX').'dscore';
		$sql = "select * from $student as s join $score as sc
		on s.Snum = sc.Snum join $dscore as ds 
		on sc.Sid = ds.Sid join $topic as t
		on s.Cnum = t.Cnum join $teacher as te
		on t.Tnum = te.Tnum 
		where s.Snum in ($snum) and ds.RgradeTnum=$tnum and s.defense_allocation=1 order by te.Tname desc";
		return $this->query($sql);
	}
	
	//获取学生的答辩成绩
	public function getRgrade($Snum,$Tnum){
		//拼接完整表名
		$score = C('DB_PREFIX').'score';
		$dscore = C('DB_PREFIX').'dscore';
		$sql = "select * from $score as s left join $dscore as ds on 
		s.scorenum = ds.scorenum where (s.Studentnum=$Snum AND (ds.Tnum=$Tnum OR ds.Tnum is null))";
		return $this->query($sql);
	}
	
	public function getDefenseRgrade($tnum){
		$student = C('DB_PREFIX').'student';
		$defense = C('DB_PREFIX').'defense';
		$score = C('DB_PREFIX').'score';
		$dscore = C('DB_PREFIX').'dscore';
		$teacher = C('DB_PREFIX').'teacher';
		$sql = "select * from $student as s join $score as sc
		on s.Snum = sc.Snum join $topic as t
		on s.Cnum = t.Cnum join $teacher as te
		on t.Tnum = te.Tnum join $dscore as ds 
		on sc.Sid = ds.Sid where te.Tnum=$tnum";
		return $this->query($sql);
	}
	
	
	
	//答辩分汇总
	public function allRscore($defense_group)
	{
		$defense_student = M('defensestudent');
		$student = $defense_student->where("defense_group = $defense_group")->getField('Snum',true);
		$score = M('score');
		$Dscore = M('dscore');
		$allScore = array();
		foreach($student as $key=>$value)
		{
		    $Rscore = $score
		              ->field('Tname,student_Snum,student_name,Cname,scorenum,Rgrade1,Rgrade2,Rgrade3,Rgrade4,Rtext')
		              ->join('__APPLY__ ON __APPLY__.student_Snum = __SCORE__.Studentnum')
					  ->join('__TEACHER__ ON __TEACHER__.Tnum = __APPLY__.Tnum')
					  ->join('__TOPIC__ ON __TOPIC__.Cnum = __APPLY__.topic_Cnum')
		              ->where("Studentnum = $value")->select();			
			$RscoreItem = $Dscore
			              ->join('__TEACHER__ ON __TEACHER__.Tnum = __DSCORE__.Tnum')
			              ->where("scorenum = ".$Rscore['0']['scorenum']." AND RgradeC1 IS NOT NULL AND RgradeC2 IS NOT NULL AND RgradeC3 IS NOT NULL AND RgradeC4 IS NOT NULL")->select();							
			foreach($Rscore as $key1=>$value1)
			{
				$allScore[] = $value1;
				$allScore[$key]['Rscoreinfo']=$RscoreItem;
			}

		}			
		return $allScore;
	}
}