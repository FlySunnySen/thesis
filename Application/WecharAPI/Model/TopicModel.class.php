<?php
namespace WecharAPI\Model;
use Think\Model;
class TopicModel extends Model {
	protected $insertFields = 'Cnum,Cname,Ctype,Csource,Ctext,Tnum,year,ERG_group,status';
	protected $updateFields = 'Cnum,Cname,Ctype,Csource,Ctext,Tnum,year,ERG_group,status';
	protected $_validate = array(
// 			array('Cnum','require','课题号不能为空',1,'',1),
			array('Cname','require','课题名不能为空',1,'',3),
			array('Ctype','require','课题类别不能为空',1,'',3),
			array('Csource','require','课题来源不能为空',1,'',3),
			array('Ctext','require','课题描述不能为空',1,'',3),
			array('Tnum','require','教师工号不能为空',1,'',3),
			array('year','require','系统年份不能为空',1,'',3),
			array('ERG_group','require','教研室不能为空',1,'',3),
			array('status','require','状态不能为空',1,'',3)
// 			array('student_studentnum','require','学生姓名不能为空',1,'',3),
			//......实际项目需要更多的验证规则，读者可以自行实现。
// 			array('price','/^[\d]+$/','商品价格只能是数字',1,'',3),
// 			array('stock','/^[\d]+$/','商品库存只能是数字',1,'',3),
	);
	/**
	 * 获得课题列表
	 * @param array $field 查询字段
	 * @param array $where 查询条件
	 * @param array $order 排序条件
	 * @return array 数据
	 */
	public function getList($field,$where,$order){
		//准备查询条件
		if($where['cid']<=0){
			unset($where['cid']);
		}
		//查询数据
		$count = $this->where($where)->count();
		$Page = new \Think\Page($count,5);
		$limit = $Page->firstRow.','.$Page->listRows;
		//取得数据
		$data['page'] = $Page->show();
		$data['list'] = $this->field($field)->where($where)->order($order)->limit($limit)->select();
		return $data;
	}
	
	//教师课题关联表
	public function getTopicList($tnum,$year){
		//拼接完整表名
		$teacher = C('DB_PREFIX').'teacher';
		$student = C('DB_PREFIX').'student';
		$apply   = C('DB_PREFIX').'apply';
		$topic =  C('DB_PREFIX').'topic';
		$sql = "select tc.Tnum,tc.Tname,t.Cnum,t.Cname,t.Ctype,t.Csource,s.Snum,s.Sname,s.taskbook,s.denfense_draft from $student as s right join $apply as a on s.Snum = a.student_Snum right join $topic as t on t.Cnum = a.topic_Cnum  join $teacher as tc on tc.Tnum = t.Tnum where t.year =$year and tc.Tnum = $tnum";
		return $this->query($sql);
	}
	
	//全部课题关联表
	public function getAllTopicList($year){
		//拼接完整表名
		$teacher = C('DB_PREFIX').'teacher';
		$student = C('DB_PREFIX').'student';
		$apply   = C('DB_PREFIX').'apply';
		$topic =  C('DB_PREFIX').'topic';
		$sql = "select tc.Tnum,tc.Tname,t.Cnum,t.Cname,t.Ctype,t.Csource,s.Snum,s.Sname,s.taskbook,s.denfense_draft from $student as s right join $apply as a on s.Snum = a.student_Snum right join $topic as t on t.Cnum = a.topic_Cnum  join $teacher as tc on tc.Tnum = t.Tnum where t.year =$year";
		return $this->query($sql);
	}
	
	//分配学生
	public function giveStu($Cnum,$Snum,$Tnum)
	{
		$stuModel = M('student');
		$applyModel = M('apply');
		$topicModel = M('topic');
		$is_status = $topicModel->where("Cnum = $Cnum AND status=1")->find();
		if($is_status){
			return "课题已分配";
		}
		$is_exist1 = $stuModel->where("Snum = $Snum")->find();
		if($is_exist1){
			$is_exist2 = $applyModel->where("student_Snum = $Snum AND status = 1")->find();
			if($is_exist2){
				return "该学生已选课题";
			}
		}else{
			return "学生不存在";
		}
        $studentName = $stuModel->where("Snum = $Snum")->getField('Sname');
		$applyModel->startTrans();
		$data =array(
		      "topic_Cnum" => $Cnum,
		      "student_Snum" => $Snum,
		      "student_name" => $studentName,
		      "status"       => 1,
		      "Tnum"         =>$Tnum,
		);
		
		$rst1 = $applyModel->add($data);
		$is_select = $applyModel->where("student_Snum = $Snum AND status!=1")->find();
		if($is_select){
			$rst2 = $applyModel->where("student_Snum = $Snum AND status!=1")->delete();
		}else{
			$rst2 = TRUE;
		}
		$rst3 = $topicModel->where("Cnum = $Cnum")->save(array("status"=>1));
	
		if($rst1 && $rst2 && $rst3){
			$topicModel->commit();
			return "添加成功";
		}else{
			$topicModel->rollback();
			return "添加失败";
		}
		
		
		
	}
	
	//获取课题申请记录
	public function getApply($Tnum,$year)
	{
		$apply = M('apply');
		$rst = $apply
		        ->field('apply_num,student_Snum,Cnum,student_name,reason,Cname,Ctype,Csource,year,think_apply.status')
				->join('__TOPIC__ ON __TOPIC__.Cnum = __APPLY__.topic_Cnum')
				->where("year = $year AND think_topic.Tnum = $Tnum")
				->select();	  
		return $rst;
	}	
		
	public function trialAction($status,$apply_num,$Snum,$topicNum)	
	{
		$apply = M('apply');		
		$data['status'] = $status;
		$rst1  = $apply->where('apply_num='.$apply_num)->save($data);
		
		$topic = M('topic');
		$rst2  = $topic->where('Cnum='.$topicNum)->save($data);
		$score = M('score');
		$rst3  = $score->where('Studentnum='.$Snum)->find();
		$rst4  = $apply->where("student_Snum = $Snum AND status = 0")->delete();
		if(empty($rst3)){
			$data = array('Studentnum'=>$Snum,);
			$rst3=$score->add($data);
		}
		if($rst1 && $rst2 && $rst3 && $rst4){
			return TRUE;
		}else{
			return FALSE;
		}
	}
}