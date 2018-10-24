<?php
namespace Teacher\Controller;
use Think\Controller;

class ScoreController extends CommonController{
	
	function _initialize()
	{
		parent::__initialize();
	}
	
	//教师评分
	public function Ggrade(){
		$tnum=$_SESSION['Tnum'];
		$year=$_SESSION['selected_year'];
		$data['score']=D('score')->getList($tnum,$year);
		$this->assign($data);
		$this->display();
	}
	//选中学生课题
	public function showGgrade(){
		//获取选中复选框
		$check=I('post.Snum');
		session('selected_sid',$check);
	}
	//指导教师评分
	public function addGgrade(){
		//列出学生信息
		$sid=$_SESSION['selected_sid'];
		$data['message']=D('score')->getMessage($sid);
		$data['score']=M('score')->field('Ggrade1,Ggrade2,Ggrade3,Ggrade4,Ggrade5,Pgrade1,Pgrade2,Ptext,Rgrade1,
				Rgrade2,Rgrade3,Rgrade4,Rtext')->where("Studentnum=$sid")->find();
		$this->assign($data);
		$this->display();
	}
	//保存分数
	public function saveGgrade(){
		
		$score=M('score');
		$Ggrade1=I('post.Ggrade1');
		$Ggrade2=I('post.Ggrade2');
		$Ggrade3=I('post.Ggrade3');
		$Ggrade4=I('post.Ggrade4');
		$Ggrade5=I('post.Ggrade5');
		$Gtext =I('post.Gtext');
		$Snum=I('post.Snum');
		//首先判断有无成绩单存在
		$checkScore=$score->where('Studentnum='.$Snum)->find();
		//如果不存在，创建成绩单
		if(empty($checkScore)){
			$data['Studentnum']=$Snum;
			$rst = $score->add($data);		
		}
		$savedScore=$score->where('Studentnum='.$Snum)->save(array('Ggrade1'=>$Ggrade1,'Ggrade2'=>$Ggrade2,
				'Ggrade3'=>$Ggrade3,'Ggrade4'=>$Ggrade4,'Ggrade5'=>$Ggrade5,'Gtext'=>$Gtext,
		));
		
		if($savedScore){
			$this->ajaxReturn(array('status'=>1,'info'=>'添加成功'));
		}else{
			$this->ajaxReturn(array('status'=>0,'info'=>'添加失败'));
		}
	}
	
	
	//删除指导分数
	public function deletedGgrade(){
		$sid=I("post.sid",0,"int");
		$score=M("score")->where("Studentnum=$sid")->save(array('Ggrade1'=>NULL,'Ggrade2'=>NULL,'Ggrade3'=>NULL,'Ggrade4'=>NULL,'Ggrade5'=>NULL));
		if($score){
			$this->ajaxReturn("成功");
		}else{
			$this->ajaxReturn("失败");
		}
	}
	//评阅评分
	public function Pgrade(){
		$tnum=$_SESSION['Tnum'];
		
		$data=D('score')->getPgradeList($tnum);
		
		$this->assign('score',$data);
		$this->display();
	}
	
	//修改评阅评分
	public function addPgrade(){
		//列出学生信息
		$Snum=I("get.Snum",0,"int");
		$data['message']=D('score')->getMessage($Snum);
		$data['score']=M('score')->field('Pgrade1,Pgrade2,Ptext')->where("Studentnum=$Snum")->find();	
		$this->assign($data);
		$this->display();
	}
	//保存论文评阅分数
	public function savePgrade(){
		$Snum=I("post.Snum",0,"int");
		$score=M('score');
		$Pgrade1=I('post.Pgrade1');
		$Pgrade2=I('post.Pgrade2');
		$Ptext=I('post.Ptext');
		$Pteacher = $_SESSION['Tname'];
		$savedScore=$score->where("Studentnum=$Snum")->save(array('Pgrade1'=>$Pgrade1,'Pgrade2'=>$Pgrade2,'Ptext'=>$Ptext,'Pteacher'=>$Pteacher));
		
		
		if($savedScore){
			$deTeaModel = M('defensestudent');
			$data['review_status'] = 2;
			$is_check = $deTeaModel->where("Snum=$Snum AND review_status=2")->find();
			if(!$is_check){
				$deTeaModel->where("Snum=$Snum")->save($data);
			}
			$this->ajaxReturn('添加成功');
		}else{
			$this->ajaxReturn('修改失败');
		}
	}
	//删除论文评阅分数
	public function deletePgrade(){
		
		$Snum=I("get.Snum",0,"int");
		$deTeaModel = M('defensestudent');
		$deTeaModel->startTrans();
		$shanchu=M('score')->where("Studentnum=$Snum")->save(array('Pgrade1'=>NULL,'Pgrade2'=>NULL,'Ptext'=>NULL,'Pteacher'=>NULL));
		$data['review_status'] = 1;
		$is_change = $deTeaModel->where("Snum=$Snum AND review_status = 1")->find();
		
		if(empty($is_change)){
			$change_status = $deTeaModel->where("Snum=$Snum")->save(array('review_status'=>1));
		}else{
			$change_status = TRUE;
		}
	
		if($shanchu && $change_status){
			$deTeaModel->commit();
			$this->success('删除成功',U('Pgrade'));
		}else{
			$deTeaModel->rollback();
			$this->error('删除失败',U('Pgrade'));
		}
		
	}
	//答辩评分
	public function Rgrade(){
		$Tnum = $_SESSION['Tnum'];
		$rst  = D('score')->getRgradeGroup($Tnum);
		$this->assign('data',$rst);
		$this->display();
	}
	
	//进入答辩组
	public function RgradeShowStudent()
	{
		$defense_group = I('get.defense_group');
		
		$Tnum          = $_SESSION['Tnum'];
		$rst = D('score')->getDefenseStudent($defense_group,$Tnum);
		$rst1 = D('defense')->getTeaInfo($defense_group);
		$this->assign('TeaInfo',$rst1);
		$this->assign('data',$rst);
		$this->display();
	}
	
	//添加答辩评分
	public function addRgrade(){
		$Snum = I('get.Snum');
		$Tnum = $_SESSION['Tnum'];
		
		//获取学生信息		
	    $info=D('score')->getMessage($Snum);
		$Rgrade = D('score')->getRgrade($Snum,$Tnum);
		$this->assign('info',$info);
		$this->assign('Rgrade',$Rgrade);
		$this->display();
	}
	
	
	//保存答辩评阅分数
	public function saveRgrade(){
		$Tnum = $_SESSION['Tnum'];
		$Did=I("post.Did",0,"int");	
		$Studentnum =I("post.Studentnum",0,"int");	
		$dscore=M('dscore');
		if(empty($Did)){
			$score = M('score');
			$scorenum = $score->where('Studentnum='.$Studentnum)->getField('scorenum');
			$Did = $dscore ->add(array('Tnum'=>$Tnum,'scorenum'=>$scorenum,));
		}		
		$RgradeC1=I('post.RgradeC1');
		$RgradeC2=I('post.RgradeC2');
		$RgradeC3=I('post.RgradeC3');
		$RgradeC4=I('post.RgradeC4');
		$RtextC=I('post.RtextC');
		$savedScore=$dscore->where("Did=$Did AND Tnum=$Tnum")->save(array('RgradeC1'=>$RgradeC1,'RgradeC2'=>$RgradeC2,'RgradeC3'=>$RgradeC3,
				'RgradeC4'=>$RgradeC4,'RtextC'=>$RtextC));
		if($savedScore){
			$this->ajaxReturn('添加成功');
		}else{
			$this->ajaxReturn('添加失败');
		}
	}
    
	function start()
	{
		ob_start();
		echo '<html xmlns:o="urn:schemas-microsoft-com:office:office"
		xmlns:w="urn:schemas-microsoft-com:office:word"
		xmlns="http://www.w3.org/TR/REC-html40">';
	}
	function save($path)
	{
	  
		echo "</html>";
		$data = ob_get_contents();
		ob_end_clean();	  
	    $this->wirtefile ($path,$data);
	}
	  
	function wirtefile ($fn,$data)
	{
		$fp=fopen($fn,"wb");
		fwrite($fp,$data);
		fclose($fp);
	}
	
    //导出成绩单
    public function importGrage()
	{
		
		$Tnum = $_SESSION['Tnum'];
		$applyModel = M('apply');
		$studentArray = $applyModel->where('Tnum ='.$Tnum)->getField('student_Snum',true);		
		$scoreModel = M('score');
		ob_start(); //打开缓冲区  
		
		echo '  
		<html xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:w="urn:schemas-microsoft-com:office:word" xmlns="http://www.w3.org/TR/REC-html40">  
		<head> 
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>  
		<xml><w:WordDocument><w:View>Print</w:View></xml>   
		<style>			
			table td {			
			border-left: 1px solid #804040;			
			border-top: 1px solid #804040;			
			padding: 10px;			
			font-size: 14px;			
			}
		</style>
		</head>';  
	
		foreach($studentArray as $key=>$value){
			$grade = $scoreModel		         
			         ->join('__STUDENT__ ON __STUDENT__.Snum = __SCORE__.Studentnum')
					 ->join('__APPLY__ ON __APPLY__.student_Snum = __STUDENT__.Snum')
					 ->join('__TOPIC__ ON __TOPIC__.Cnum = __APPLY__.topic_Cnum')
			         ->where('Studentnum='.$value)					 
			         ->find();
			$Ggrade = $grade['Ggrade1']+$grade['Ggrade2']+$grade['Ggrade3']+$grade['Ggrade4']+$grade['Ggrade5'];
			$Pgrade = $grade['Pgrade1'] + $grade['Pgrade2'];
			$Rgrade = $grade['Rgrade1'] +$grade['Rgrade2']+$grade['Rgrade3']+$grade['Rgrade4'];
			$sum = $Ggrade+$Pgrade+$Rgrade;			
			$sum =  floor($sum/10);
			switch($sum){
				case  9: 
				        $evaluate="优";
						break;
				case  8 :
					    $evaluate="良";
					    break;
				case  7 :
					    $evaluate="中"; 
					    break;
				case  6 :
                         $evaluate="及格";
				default : 
				         $evaluate="不及格";
			}
	        		echo '		
		<div>
			<h3 style="text-align: center">广州大学华软软件学院</h3>  
            <h3 style="text-align: center">本科毕业论文(设计)成绩单</h3>  
			<table  style="border-right: 1px solid #804040;border-bottom: 1px solid #804040;border-collapse:collapse;" >
				<tr>
					<td style="width: 12%;text-align: center;">姓 名</td>
					
       					<td style="width: 12%;">';
       	 echo $grade['Sname'];
       	echo '
					</td>
					<td style="width: 10%;text-align: center;">学 号</td>
					<td style="width: 14%;">';
	    echo $grade['Snum'];
	    echo '	
					</td>
					<td style="width: 22%;text-align: center;">专业 (方向)</td>
					<td style="width: 20%;">
					';
		echo $grade['class'];
		
		echo '
		</td>
				</tr>
				<tr>
					<td style="width: 10%;text-align: center;">题 目</td>
					<td colspan="5">';
		
		echo $grade['Cname'];				
				
		echo '
					</td>
				</tr>
				
				<tr>
					<td style="width: 10%;">指导教师评语(占论文成绩的60%)</td>
					<td colspan="5">
						    <p style="text-indent:2em">';
		echo $grade['Gtext'];		
		echo '
						    </p>
							<p style="margin-top: 90%;">成绩:';
		echo $Ggrade;
		echo '
							
						    </p>
							<p style="margin-top: 100%;text-align: right;">签名: &nbsp;&nbsp;&nbsp;年 &nbsp;&nbsp;  月 &nbsp;&nbsp;  日</p>
						
					</td>
				</tr>
				<tr>
					<td style="width: 10%;">评阅教师评语(占论文成绩的60%)</td>
					<td colspan="5">
						 <p style="text-indent:2em">';
		echo $grade['Ptext'];
		echo '
						 </p>
						<p style="margin-top: 90%;">成绩:';
		echo $Pgrade;
		echo '
						</p>
						<p style="margin-top: 95%;text-align: right;">签名: &nbsp;&nbsp;&nbsp;年 &nbsp;&nbsp;  月 &nbsp;&nbsp;  日</p>
						
					</td>
				</tr>
				<tr>
					<td style="width: 10%;">答辩组评语(占论文成绩的60%)</td>
					<td colspan="5">
						 <p style="text-indent:2em">';
		echo $grade['Rtext'];
		echo '
						 </p>
						<p style="margin-top: 90%;">成绩:';
	    echo $Rgrade;
	    echo '
						</p>
						<p style="margin-top: 95%;text-align: right;">答辩组成员: &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;年 &nbsp;&nbsp;  月 &nbsp;&nbsp;  日</p>
						
					</td>
				</tr>
				
				<tr>
					<td style="width:10%;">总成绩</td>
					<td colspan="5">
						<p style="font-size: 30px;margin-left: 15px;">';
		echo $evaluate;
		echo '</p>
						<p style="margin-top: 90%;text-align: right;">系主任签名: &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;  系(章) &nbsp;&nbsp;</p>
						<p style="margin-top: 95%;text-align: right;">年 &nbsp;&nbsp;  月 &nbsp;&nbsp;  日</p>
						
					</td>
				</tr>
			</table>
		</div>
	
	
		'; 
		
		}
		
	
		
		header("Cache-Control: public");  
		Header("Content-type: application/octet-stream");  
		Header("Accept-Ranges: bytes");  
		if (strpos($_SERVER["HTTP_USER_AGENT"],'MSIE')) {  
		header('Content-Disposition: attachment; filename=test.doc');  
		}else if (strpos($_SERVER["HTTP_USER_AGENT"],'Firefox')) {  
		Header('Content-Disposition: attachment; filename=test.doc');  
		} else {  
		header('Content-Disposition: attachment; filename=test.doc');  
		}  
		header("Pragma:no-cache");  
		header("Expires:0");  
		ob_end_flush();//输出全部内容到浏览器  
	}
	
	
	
	
}