<?php
namespace Teacher\Controller;
use Think\Controller;
class IndexController extends CommonController {
    public function index(){
       
       parent::__initialize();	
	   $newModel = new \Teacher\Model\InformationModel();
       $new = $newModel->getList();
	   $this->assign('new',$new);  
       $this->display();
	  
    }
	
	//session存储选中系统年份
	public function getYear(){
		$year=I("post.options");		
		//判断该年份是否开发
		$config = M('config')->where("year = $year AND status=1")->find();							
		if($config){
		  $_SESSION['selected_year']=$year;
		  $this->ajaxReturn('选择年份成功');
		}else{
		  $this->ajaxReturn('失败');
		}
	}
	
	//选择系统
	public function select_year(){
		$select=M('config')->order("year desc")->where('status=1')->select();
		$this->assign('select',$select);
		$this->display();
	}
	
}