<?php
namespace WecharAPI\model;
use Think\Model;
class ErgModel extends Model
{
	public function getInfo($ERG_NAME)
	{
		
		$data = $this->join('__TEACHER__ ON __TEACHER__.ERG_group = __ERG__.ERG_group')->field('Tnum,Tname,ERG_name,think_erg.ERG_group')->where('think_erg.ERG_group=%d',$ERG_NAME)->select();
		return $data;
	}
	
	
}
