<?php
namespace Home\Model;
use Think\Model;
class TopicModel extends Model {
    protected $insertFields = 'Cnum,Cname,Ctype,Csource,Ctext,status,year,Tnum';
    protected $updateFields = 'Cnum,Cname,Ctype,Csource,Ctext,status,year,Tnum';
    protected $_validate = array(
		array('Cname','require','课题名不能为空'),
		array('Ctype','require','课题类型不能为空'),
		array('Csource','require','课题来源不能为空'),
	);
	protected function _before_insert(&$data,$options){
	    $data['description'] = I('post.description','',''); //防止被HTML转义
	}
	protected function _before_update(&$data,$options){
	    $data['description'] = I('post.description','',''); //防止被HTML转义
	}
    
	/**
	 * 获得课题列表
	 * @param array $field 查询字段
	 * @param array $where 查询条件
	 * @return array 数据
	 */
	public function getList($field,$table,$where,$order){
		//准备查询条件
		if($where['Cnum']<=0){
			unset($where['Cnum']);
		}
		//查询数据
		//取得数据
		$data['list'] = $this->table($table)->field($field)->where($where)->order($order)->select();
		return $data;
	}
}