<?php
namespace Teacher\Controller;
use Think\Controller;
class TeacherManageController extends CommonController
{
	
	function _initialize() 
	{
	   parent::__initialize();
	   $role = session('role');
	   if($role !=3){
	   	$this->error('权限不够');
	   }
	}
	
	public function index()
	{	
		
		$type= M('teacher');
		$count =  $type -> count();
		$mypage = $this -> mypage($count,8);
		$data = $type ->limit($mypage->firstRow,$mypage->listRows)->join('__ERG__ ON __TEACHER__.ERG_group = __ERG__.ERG_group') -> select();
		$page = $mypage -> show();
		
		$this->assign('count',$count);
	    $this->assign('page',$page);
		$this->assign('type',$data);	

		$this->display();
	}
	public function changePwd()
	{
		 $Tnum = $_GET['Tnum'];
		 $this->assign('Tnum',$Tnum);
		 if(IS_POST)
	     {
	     	$pwd = md5(md5(I('post.pwd')));
			$Tnum=I('post.Tnum');			
			$rst = D('teacher')->changePwd($Tnum,$pwd);
			if(!empty($rst)){
				$this->success('修改密码成功',U('teacher/index/index'));
				exit;
			}else{
				$this->error('失败了哦',U('teacher/index/index'));
				exit;
			}
									
	     }	
				
		$this->display();
	}

    public function addTea()
    {
    	$rst = M('erg')->select();
		$this->assign('erg',$rst);
    	$this->display();
    }
    
	public function addTeaAction()
	{
		$data  = I('post.');
		$data['pwd'] = md5(md5($_POST['Tnum']));	
		$teaModel = M('teacher');	
		$rst= $teaModel->add($data);	
		if(!empty($rst)) {
			$this -> ajaxReturn(true);
		}else{
			$this -> ajaxReturn(失败);
		}
	}
	
	public function information(){

      
		$rst1 = D(teacher)->selectOne($_GET['Tnum']);
		$this->assign('Tinfo',$rst1);	
		$rst2 = M('erg')->select();
		$this->assign('erg',$rst2);	
					
		$this->display();
	}
	
	
	public function saveInformation()
	{
		$data  = I('post.');		
		$rst= D('teacher')->information($data);
		if(!empty($rst)) {
			$this -> ajaxReturn(true);
		}else{
			$this -> ajaxReturn(失败);
		}
	}
	
	
	public function ERG_group()
	{
		$ERG_group = M('erg');
		$data = $ERG_group->select();
		$this->assign('data',$data);
		$this->display();
	}
	
	public function editERG()
	{
		$ERG_group = I('get.ERG_group');
		$rst = M('erg')->where('ERG_group='.$ERG_group)->find();
		$this->assign($rst);
		$this->display();
	}
	
	public function addERG()
	{
		$this->display();
	}	
	
	//添加教研室
	public function addErgAction()
	{
		$data['ERG_name'] = I('post.ERG_name');
		$ERGmodel =  M('erg');
		$MAX = $ERGmodel->max('ERG_group');
		$data['ERG_group'] = $MAX+1;
		$rst =$ERGmodel->add($data);
		if($rst){
			$this->success('添加成功',U('TeacherManage/ERG_group'));
		}else{
			$this->error('添加失败');
		}
	}
	
	//修改教研室数据
	public function saveInfo()
	{
		$ERG_group = I('post.ERG_group');
		$ERG_name  = I("post.ERG_name");
		$data['ERG_name'] = $ERG_name;
		$rst = M('erg')->where('ERG_group='.$ERG_group)->save($data);
		if($rst){
			$this->success('修改成功');
		}else{
			$this->error('修改失败');
		}
	}
	
	//删除教研室
	public function delERG()
	{
		$ERG_group = I('get.ERG_group');
		$rst = M('erg')->where('ERG_group='.$ERG_group)->delete();
		if($rst){
			$this->success('删除成功');
		}else{
			$this->error('不可删除，当前教研室有数据存在');
		}
	}
	
	
	
	 //导入excel文件
    public function assign_teacher()
    {
    	$year = $_SESSION['selected_year'];
        $data = I('post.') ? I('post.') : I('get.');
        if(IS_File){
            if (!empty ( $_FILES)) {
                // 上传文件
                $year = $_SESSION['selected_year'];
                $path = "./Public/$year/";
				if(!is_dir($path)){
					self::mkdirs_2($path);
				}
                
                
                
                $upload = new \Think\Upload();                      // 实例化上传类
                $upload->maxSize = 10485760;                 // 设置附件上传大小
                $upload->exts = array('xls', 'xlsx');       // 设置附件上传类型
                $upload->rootPath = "./Public/$year/";             // 设置附件上传根目录
                $upload->autoSub = false;                         // 将自动生成以photo后面加时间的形式文件夹，关闭
                $info = $upload->upload();                                   // 上传文件
                $exts = $info['file']['ext'];                                 // 获取文件后缀
                $filename = $upload->rootPath . $info['file']['savename'];        // 生成文件路径名
                if (!$info) {                                                     // 上传错误提示错误信息
                    $this->error($upload->getError());
                } else {                                                           // 上传成功
                    import("Org.Util.PHPExcel");                        // 导入PHPExcel类库，因为PHPExcel没有用命名空间，只能inport导入
                    $PHPExcel = new \PHPExcel();                                 // 创建PHPExcel对象，注意，不能少了\
                    if ($exts == 'xls') {                                        // 如果excel文件后缀名为.xls，导入这个类
                        import("Org.Util.PHPExcel.Reader.Excel5");
                        $PHPReader = new \PHPExcel_Reader_Excel5();
                    } else if ($exts == 'xlsx') {
                            import("Org.Util.PHPExcel.Reader.Excel2007");
                            $PHPReader = new \PHPExcel_Reader_Excel2007();
                        }
                    $PHPExcel = $PHPReader->load($filename);    // 载入文件
                    $currentSheet = $PHPExcel->getSheet(0);        // 获取表中的第一个工作表，如果要获取第二个，把0改为1，依次类推
                    $allColumn = $currentSheet->getHighestColumn();   // 获取总列数
                    $allRow = $currentSheet->getHighestRow();              // 获取总行数
                    for ($currentRow = 0; $currentRow <= $allRow; $currentRow++) {// 循环获取表中的数据，$currentRow表示当前行，从哪行开始读取数据，索引值从0开始
                        for ($currentColumn = 'A'; $currentColumn <= $allColumn; $currentColumn++) {// 从哪列开始，A表示第一列
                            $address = $currentColumn . $currentRow;             // 数据坐标
                            $ExlData[$currentRow][$currentColumn] = $currentSheet->getCell($address)->getValue();// 读取到的数据，保存到数组$ExlData中
                        }
                    }
                    unset($ExlData[0]);//清楚数组0的空值,这一组没有数据
                    unset($ExlData[1]);//excel表头，第一行
                    ini_set('max_execution_time', '500');//设置导入最大时长。
                    $arr = array_values($ExlData);//重新排序数组键名
                    foreach($arr as $k=>$v){
                        if($v["A"] != null){//不导入空值
                          
                            import("Vendor.excel.PHPExcel.Shared.Date");
                            $shared = new \PHPExcel_Shared_Date();            
                            $data['Tnum'] = $v["A"];
                            $data['Tname'] = preg_replace("/(\s|\&nbsp\;|　|\xc2\xa0)/","",$v["B"]);
                            $data['pwd'] = md5(md5($v["A"]));
                            $data['depart'] =$v["C"]?$v["C"]:NULL;						
                            $data['direction'] = $v["D"]?$v["D"]:NULL;
                            $data['phone'] = $v["E"]?$v["E"]:NULL;
                            $data['startdate'] = $v["F"]?$v["F"]:NULL;
                            $data['email'] = $v["G"]?$v["G"]:NULL;
                            $data['qq'] = $v["H"]?$v["H"]:NULL;
                            $data['Ttext'] = $v["I"]?$v["I"]:NULL;
                            $data['title'] = $v["J"]?$v["J"]:NULL;
                            $data['ERG_group']= $v["K"];
                            
                         
                            //dump($data);exit();
                            $teacher = M('teacher');
                            $re = $teacher->add($data);//导入数据库
                            
                            if($re){
                                unset($data);
                            }else{
                            	
                                die("<script>alert('导入出错，请重试！');history.back(-1);</script>");
                            }
                        }
                    }
                    if($re){
                    	$this->success('导入成功');
						exit;
                    }
                }
            }
        }
			
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
