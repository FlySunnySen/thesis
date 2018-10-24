<?php
namespace Teacher\Controller;
use Think\Controller;
//教师添加课题
class TopicController extends CommonController {
	
	
	function _initialize() 
	{
	   parent::__initialize();
	}
	
	
	//选择系统
	public function select(){
		$select=M('config')->order("year desc")->select();
		$this->assign('select',$select);
		$this->display();
	}
	//session存储选中系统年份
	public function getYear(){
		$year=I("post.options");
		session('selected_year',$year);
	}
	
	//显示教师课题列表
	public function my_theme() {
		//获得请求参数
		$tnum=$_SESSION['Tnum'];
		$year=$_SESSION['selected_year'];
		//获得课题列表
		$data['topic'] = D('topic')->getTopicList($tnum,$year);
		$this->assign($data);
		$this->display();
	}
	//显示所有课题
	public function all() {
		$year = $_SESSION['selected_year'];
		$data['all_topic']=D('topic')->getAllTopicList($year);
		$data['count']=M('topic')->count('Cnum');
		$this->assign($data);
		$this->display();
	}
	
	//添加课题-显示页面
	public function add() {
		//获得请求参数
		$tnum=I('post.Tnum');
		
		//处理表单
		if (IS_POST) {
			
			$this->addAction($tnum);
			return;
		}
	
		$this->display();
	}
	
	//添加课题
	private function addAction($tnum){
		//添加课题
		$gid = $this->create('topic','add');
		
		if($gid===false){
			
			$this->error("添加课题失败");
			
		}
		$this->success('保存成功',U('my_theme',"tnum=$tnum"));
	}
	//修改课题-显示页面
	public function revise() {
		//获得请求参数
		$gid = I('get.gid',0,'int');
		//处理表单
		if (IS_POST){
			$this->reviseAction($gid);
			return;
		}
		//获取课题信息
		$data['goods'] = D('goods')->where("gid=$gid")->find();
		//获取课题属性数据
		$cid = $data['goods']['cid'];
		$data['attr'] = D('goodsAttr')->getData($cid,$gid);
		//视图
		$this->assign($data);
		$this->display();
	}
	
	//删除课题
	
	public function delTopic()
	{
		$Cnum = I('get.Cnum');
		$topicModel = M('topic');
		$topicModel->startTrans();
		$rst1 = $topicModel->where("Cnum = $Cnum AND status = 0")->delete();
		$is_exist = M('apply')->where("topic_Cnum = $Cnum")->find();
		if($is_exist){
			$rst2 = M('apply')->where("topic_Cnum = $Cnum")->delete();
		}else{
			$rst2 = TRUE;
		}
		if($rst1 && $rst2){
			$topicModel->commit();
			$this->success('删除成功');
		}else{
			$topicModel->rollback();
			$this->error('不可删除，已有学生选择');
		}
	}
	
	//为课题分配学生
	public function giveStu()
	{
		$Cnum = I('get.Cnum');
		$Tnum = I('get.Tnum');
		$this->assign('Tnum',$Tnum);
		$this->assign('Cnum',$Cnum);
		$this->display();
		
	}
	
	public function giveStuAction()
	{
		$Cnum = I('post.Cnum');
		$Snum = I('post.Snum');
		$Tnum = I('post.Tnum');
		$rst  = D('topic')->giveStu($Cnum,$Snum,$Tnum);
		$this->success("$rst",U('Topic/my_theme'));
	}
	
	//显示成绩单
	public function grade()
	{
		$snum=I('get.Snum');
        $score  = M('score');
		$allscore = $score
		            ->where('Studentnum='.$snum)
		            ->join('__STUDENT__ ON __STUDENT__.Snum = __SCORE__.Studentnum')
		            ->find();	
		$this->assign($allscore);
		$this->display();
	}
	
	//修改课题-处理表单
	private function reviseAction($gid){
		$cid = I('get.cid',0,'int');
		//修改课题基本信息
		$rst = $this->create('goods','save',2,array("gid=$gid"));
		if($rst===false){
			$this->error("修改课题失败");
		}
		//修改课题属性
		$data = I('post.attr');
		if($data){
			$rst = D('goodsAttr')->saveData($data,$gid);
			if($rst===false){
				$this->error('修改属性失败',U('Goods/revise',"gid=$gid&cid=$cid"));
			}
		}
		//保存上传文件
		if(!empty($_FILES['thumb']['name'])){
			$rst = D('goods')->uploadThumb($gid);
			if($rst!==true){
				$this->error($rst,U('Goods/revise',"gid=$gid&cid=$cid"));
			}
		}
		//跳转
		$this->success('修改成功',U('Goods/index',"cid=$cid"));
	}
	//快捷修改操作
	public function change(){
		//获得请求参数
		$gid = I('get.gid',0,'int');
		$action = I('get.');
		//准备待操作字段
		$allow_action=array('status','is_best');
		$field = array();
		foreach($allow_action as $v){
			if(isset($action[$v])){
				$field = array($v => $action[$v]);
				//反转字段值
				$field[$v] = $field[$v]=='yes' ? 'no' : 'yes';
				break;
			}
		}
		if(empty($field)){
			$this->error('请求参数有误');
		}
		//操作数据
		$rst = M('goods')->where("gid=$gid")->save($field);
		if($rst===false){
			$this->error('操作失败');
		}
		//跳转
		$cid = I('get.cid',0,'int');
		$this->redirect('Goods/index',"cid=$cid");
	}
	//删除课题
	public function del() {
		//获得请求参数
		$gid = I('get.gid',0,'int');
		//操作数据
		$rst = M('goods')->where("gid=$gid")->save(array('recycle'=>'yes'));
		if($rst===false){
			$this->error('删除失败');
		}
		//跳转
		$cid = I('get.cid',0,'int');
		$this->success('删除成功', U('Goods/index',"cid=$cid"));
	}
	//审批课题
	public function trial()
	{
		$year = $_SESSION['selected_year'];
		$Tnum = $_SESSION['Tnum'];
		$rst = D('topic')->getApply($Tnum,$year);
	    $this->assign('apply',$rst);
		$this->display();
	}
	//审核操作
	public function trialAction()
	{
		$status = I('get.status');
		$apply_num = I('get.apply_num');
		$topicNum    = I('get.Cnum');
		$Snum = I('get.Snum');
		$rst = D('topic')->trialAction($status,$apply_num,$Snum,$topicNum);
		if($rst){
			$this->success('操作成功');
		}else{
			$this->error('操作失败');
		}
	}
	public function delectTrial()
	{
		$apply_num = I('get.apply_num');
		$apply = M('apply');
		$rst = $apply->delete($apply_num);
		if($rst){
			$this->success('操作成功');
		}else{
			$this->error('操作失败');
		}
	}
	//上传文件
	public function upload_denfense_draft()
	{
		$year = $_SESSION['selected_year'];
		$Snum = $_GET['Snum'];
		$Sname = M('student')->where('Snum='.$Snum)->getfield('Sname');				
		$excel_file_name = $Snum.$Sname;				
		if(IS_POST){
			$studentNum = I('post.Snum');
			$path = "./Public/$year/denfense_draft/";
			if(!is_dir($path)){
				self::mkdirs_2($path);
			}
			$upload = new \Think\Upload();// 实例化上传类  
			$upload->maxSize = 314572800;// 设置附件上传大小  
			$upload->exts = array('doc','docx');// 设置附件上传类型  
			$upload->rootPath = "./Public/$year/denfense_draft/"; // 设置附件上传根目录  
			$upload->replace = TRUE;
			$upload->autoSub = false;
			$upload->saveName ="$excel_file_name";
			// 上传文件  
			$info = $upload->upload();  					
			$denfense_draftPath = $path.$info['file']['savepath'].$info['file']['savename'];
			$student = M('student');
			$rst = $student->where('Snum='.$studentNum)->save(array('denfense_draft'=>$denfense_draftPath,));		
			if(!$info && !$rst) {// 上传错误提示错误信息  
			$this->error('失败');  
			}else{// 上传成功  
			$this->success('上传成功！',U('Topic/my_theme'));  
			}  
			
			
		}
		$this->assign('Snum',$Snum);
		$this->display('upload_file');
	}
	
	public function upload_taskbook()
	{
		$year = $_SESSION['selected_year'];		
		$Snum = $_GET['Snum'];
		$Sname = M('student')->where('Snum='.$Snum)->getfield('Sname');				
		$excel_file_name = $Snum.$Sname;	
		if(IS_POST){
			$studentNum = I('post.Snum');
			$path = "./Public/$year/taskbook/";
			if(!is_dir($path)){
				self::mkdirs_2($path);
			}
			$upload = new \Think\Upload();// 实例化上传类  
			$upload->maxSize = 314572800;// 设置附件上传大小  
			$upload->exts = array('doc','docx');// 设置附件上传类型  
			$upload->rootPath = "./Public/$year/taskbook/"; // 设置附件上传根目录  	
			$upload->replace = TRUE;
			$upload->autoSub = false;		
			$upload->saveName ="$excel_file_name";
			
			// 上传文件  
			$info = $upload->upload();  			
			$taskbook_draftPath = $path.$info['file']['savepath'].$info['file']['savename'];
			
			$student = M('student');
			$rst = $student->where('Snum='.$studentNum)->save(array('taskbook'=>$taskbook_draftPath,));		
			if(!$info && !$rst) {// 上传错误提示错误信息  
			$this->error('失败');  
			}else{// 上传成功  
			$this->success('上传成功！',U('Topic/my_theme'));  
			}  
			
			
		}
		$this->assign('Snum',$Snum);
		$this->display('upload_file');
	}
	
	public function mkdirs_2($path)
	{
		if(!is_dir($path)){
		self::mkdirs_2(dirname($path));
		if(!mkdir($path, 0777)){
		return false;
		}
		}
		return true;
	}
}