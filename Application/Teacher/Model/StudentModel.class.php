<?php
namespace Teacher\Model;
use Think\Model;

class StudentModel extends Model {
	public function getStudentList($tnum){
		//拼接完整表名
		$student = C('DB_PREFIX').'student';
		$apply =  C('DB_PREFIX').'apply';
		//执行SQL查询
		$sql = "select * from $student as a
		left join $apply as b
		on a.Snum=b.student_Snum where Tnum=$tnum and status = 1 order by denfense_status";
		$data = $this->query($sql);
		return $data;
	}
	
	public function changePwd($Snum,$pwd)
	{
		$save = array('Snum'=>$Snum,'pwd' => $pwd,);
		$rst = $this->save($save);
		return $rst;
	}
	
}