<?php
namespace Home\Controller;
//课题控制器
class GradeController extends CommonController {
	//课题列表
	public function index() {
		
        $snum=$_SESSION['student']['num'];
        $score  = M('score');
		$allscore = $score
		            ->where('Studentnum='.$snum)
		            ->join('__STUDENT__ ON __STUDENT__.Snum = __SCORE__.Studentnum')
		            ->find();	
		$this->assign($allscore);
		$this->display();
	}
	
}