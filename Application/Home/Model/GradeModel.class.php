<?php
namespace Home\Model;
use Think\Model;
class GradeModel extends Model {
    protected $insertFields = 'scorenum,Gtext,Ggrade,Ptext,Pgrade,RtextC,RgradeC,scoreSumGrade,scoreC_scoreCnum';
    protected $updateFields = 'scorenum,Gtext,Ggrade,Ptext,Pgrade,RtextC,RgradeC,scoreSumGrade,scoreC_scoreCnum';
    protected $_validate = array(
		array('scorenum','require','课题名不能为空'),
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
	public function getList($field,$table,$where){
		//准备查询条件
		if($where['scorenum']<=0){
			unset($where['scorenum']);
		}
		//查询数据
		//取得数据
		$data['list'] = $this->table($table)->field($field)->where($where)->select();
		return $data;
	}
	
	
}