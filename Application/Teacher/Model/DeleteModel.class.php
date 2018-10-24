<?php
namespace Teacher\Model;
use Think\Model;

class DeleModel extends Model{
	//删除
	public function del() {
		$tnum=$this->userInfo['tnum'];
		//删除课题
		$this->where("Cnum=$cnum")->delete();
		if($rst===false){
			$this->error('删除课题失败');
		}
		//跳转
		$cid = I('get.cid',0,'int');
		$this->success('删除成功', U('index',"cid=$cid"));
	}
}