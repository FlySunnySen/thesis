<?php
namespace WecharAPI\model;
use Think\Model;
class TeacherModel extends Model
{
	protected $_validate =array(
	      array('Tname','require','姓名不能为空'),	    	      
	      array('phone','number','电话必须是数字'),
	      array('qq','number','QQ必须是数字'),
	      array('email','email','邮箱格式有误'),
	
	);
	
	public function selectOne($num)
	{
		
	   	$where =array('Tnum' => $num,);
		$rst = $this->where($where)->find();
		return $rst;
	} 
	
	public function getList()
	{
	    $data = $this->join('__ERG__ ON __TEACHER__.ERG_group = __ERG__.ERG_group')->order('ERG_name')->select();
		return $data;	
	}
	public function changePwd($Tnum,$pwd)
	{
		$adminModel = M('admin');
		$is_exist = $adminModel->where('Tnum='.$Tnum)->find();		
		$save = array('Tnum'=>$Tnum,'pwd' => $pwd,);
		if($is_exist){
			$rst1 = $adminModel->save($save);
		}else{
			$rst1 = TRUE;
		}
		$rst2 = $this->save($save);
		if($rst1 && $rst2){
			$rst = TRUE;
		}
		return $rst;
	}
	//修改个人信息
	public function information($data)
	{
		if(!$this->create($data,2)){
		    exit($this->getError());
		}else{
			$rst= $this->save($data);
			return $rst;
		}
	}
	
	
	
}
