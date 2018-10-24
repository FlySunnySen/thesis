<?php
namespace Home\Controller;
use Teacher\Model\InformationModel;

class IndexController extends CommonController {
	//学生首页
	  public function index(){
       $newModel = new \Teacher\Model\InformationModel();
       $new = $newModel->getList();
	   $this->assign('new',$new);  
       $this->display();
	  
    }
}