<?php
namespace WecharAPI\Controller;
use Think\Controller;
//教师添加课题
class PTopicController extends Controller {
	
	//显示教师课题列表  我的课题
	public function my_theme() {
		//获得请求参数
		$tnum=$_POST['num'];
		$year=$_POST['year'];
		//获得课题列表
		$data['topic'] = D('topic')->getTopicList($tnum,$year);
		$this->assign($data);
		echo json_encode($data);
	}
	//显示所有课题
	public function all() {
		$year  = $_POST['year'];
		$data['all_topic']=D('topic')->getAllTopicList($year);
		$data['count']=M('topic')->count('Cnum');
		echo json_encode($data);
	}
	
	//显示指定课题
public function show()
	{
		
	    $id  = $_POST['infonum'];
		$rst = D('information')->getOne($id);
		//$this->assign('news',$rst);
	//$rst=M('information')->where("infonum=$id")->select();
	echo json_encode($rst);
			
	}
	
	//添加课题-显示页面
	public function add(){
		//获得请求参数
		
		$data['Tnum']=$_POST['num'];
		$data['Cname']=$_POST['Cname4'];
		$data['Ctext']=$_POST['Ctext4'];
		$data['Csource']=$_POST['Csource'];
		$data['Ctype']=$_POST['Ctype'];
		$data['year']=$_POST['year'];
		$rst=M('teacher')->field('ERG_group')->where("Tnum=".$_POST['num'])->find() ;
	    $data['ERG_group']=array_values($rst)[0];

		$success=M('topic')->add($data);
		if($success){
		echo "success";exit;
		}
		exit;
	}
	
   //添加课题
	private function addAction($tnum){
		//添加课题
		$gid = $this->create('topic','add');
		if($gid===false){
			
			echo "添加课题失败";
			exit;
			
		}
		echo '保存成功';
		exit;
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
	
	public function delTopic()
	{
		$Cnum = $_POST['Cnum'];
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
			echo 'del';//删除成功
		}else{
			$topicModel->rollback();
			echo 'nodel';//不可删除，已有学生选择
		}
	}
	//审批课题
	public function trial()
	{
		$year = $_POST['year'];
		$Tnum = $_POST['num'];
		$rst = D('topic')->getApply($Tnum,$year);
	    $this->assign('apply',$rst);
		echo json_encode($rst);
	}
	//审核操作
	public function trialAction()
	{
		$status = $_POST['status'];
		$apply_num =$_POST['apply_num']; 
		$topicNum    =$_POST['Cnum']; 
		$Snum =$_POST['Snum']; 
		$rst = D('topic')->trialAction($status,$apply_num,$Snum,$topicNum);
		if($rst){
			exit;  //'操作成功';
		}else{
			exit;  //'操作失败';
		}
	}
	public function delectTrial()
	{
		$apply_num = $_POST['apply_num'];
		$apply = M('apply');
		$rst = $apply->delete($apply_num);
		if($rst){
			exit;  //'操作成功';
		}else{
			exit;  //'操作失败';
		}
	}
	//上传文件
	public function upload_denfense_draft()
	{
		$year = $_SESSION['selected_year'];
		$Snum  = I('get.Snum');
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
			$upload->savePath = ''; // 设置附件上传（子）目录  
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
		$Snum  = I('get.Snum');
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
			$upload->savePath = ''; // 设置附件上传（子）目录  
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