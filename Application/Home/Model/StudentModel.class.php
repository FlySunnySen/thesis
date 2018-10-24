<?php
namespace Home\Model;
use Think\Model;
class StudentModel extends Model {
    protected $insertFields = 'studentnum,Sname,pwd,sex,major,phone,email,qq,teacher_Tnum,score_scorenum';
    protected $updateFields = 'studentnum,Sname,pwd,sex,major,phone,email,qq,teacher_Tnum,score_scorenum';
    protected $_validate = array(
		array('studentnum','require','学号不能为空'),
		array('Sname','require','姓名不能为空'),
		array('pwd','require','密码不能为空'),
	);
	protected function _before_insert(&$data,$options){
	    $data['description'] = I('post.description','',''); //防止被HTML转义
	}
	protected function _before_update(&$data,$options){
	    $data['description'] = I('post.description','',''); //防止被HTML转义
	}
    

	
	public function getData($num){
		//拼接完整表名
		$stu =  'think_student';
		//执行SQL查询
		$sql = "select Snum,Sname,pwd,sex,class,phone,email,qq from $stu where Snum=$num";
		$data = $this->query($sql);
		return $data;
	}
}