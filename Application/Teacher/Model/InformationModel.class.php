<?php
namespace Teacher\model;
use Think\Model;
class InformationModel extends Model
{
	
	protected $_validate =array(
	      array('infotitle','require','标题不能为空'),	    	      
	     
	
	);
	
	public function getList()
	{
		$data = $this->order('infotime desc')->select();
		return $data;
	}
	
	public function addNew($data)
	{
		$data['infonum']  = date("Ymd").mt_rand(10,99);	
		$data['infotime'] = date("Y-m-d H-i-s");		
		$data['Tnum']  = $_SESSION['Tnum'];
		if($this->create($data)){
		$rst = $this->add($data);
		}else{
			$this->getError();
		}
		return $rst;
	}
	
	public function getOne($id)
	{
		$where = array('infonum' => $id,);
		$rst = $this->where($where)->find();
		return $rst;
	}
	
	public function delectNews($num)
	{
		$where = array(infonum => $num,);
		$rst = $this->where($where)->delete();
		return $rst;
	}
	
	public function saveNews($data,$infonum)
	{
		$rst = $this->where('infonum='.$infonum)->save($data);
	
		return $rst;
	}
}
