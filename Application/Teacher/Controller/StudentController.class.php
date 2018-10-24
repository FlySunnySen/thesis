<?php
namespace Teacher\Controller;
use Think\Controller;
class StudentController extends CommonController
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
		$studentModel = M('student');
		$count = $studentModel->where('year='.$_SESSION['selected_year'])->count();
				
		$mypage = $this -> mypage($count,5);
		$data = $studentModel->limit($mypage->firstRow,$mypage->listRows)->where('year='.$_SESSION['selected_year'])->select();
		$page = $mypage -> show();
		
		$this->assign('count',$count);
	    $this->assign('page',$page);
		$this->assign('type',$data);	

		$this->display();
		
		
	}

    public function addStudent()
	{
		$this->display();
	}	
	
	public function addStuAction()
	{
		$data  = I('post.');
		$data['pwd'] = md5(md5($_POST['Snum']));	
		$data['year'] = $_SESSION['selected_year'];
		$stuModel = M('student');	
		$rst= $stuModel->add($data);	
		if(!empty($rst)) {
			$this -> ajaxReturn(true);
		}else{
			$this -> ajaxReturn(失败);
		}
	}
	
	public function changePwd()
	{
		 $Snum = $_GET['Snum'];
		 $this->assign('Snum',$Snum);
		 if(IS_POST)
	     {
	     	if(empty(I('post.pwd'))){
	     		$this->error('密码为空');
	     	}
	     	$pwd = md5(md5(I('post.pwd')));
			$Snum=I('post.Snum');			
			$rst = D('student')->changePwd($Snum,$pwd);
			
			if(!empty($rst)){
				$this->success('修改密码成功',U('teacher/student/index'));
				exit;
			}else{
				$this->error('失败了哦',U('teacher/student/index'));
				exit;
			}
									
	     }	
				
		$this->display();
	}
	
    //导入excel文件
    public function assign_student()
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
                            $data['Snum'] = $v["A"];
                            $data['Sname'] = preg_replace("/(\s|\&nbsp\;|　|\xc2\xa0)/","",$v["B"]);
                            $data['pwd'] = md5(md5($v["A"]));
                            $data['sex'] =$v["C"]?$v["C"]:NULL;
                            $data['class'] = $v["D"]?$v["D"]:NULL;
                            $data['phone'] = $v["E"]?$v["E"]:NULL;
                            $data['email'] = $v["F"]?$v["F"]:NULL;
                            $data['qq'] = $v["G"]?$v["G"]:NULL;
                            $data['denfense_status'] = null;
                            $data['denfense_allocation'] = 0;
                            $data['taskbook'] = null;
                            $data['denfense_draft']= null;
                            $data['year'] = $year;
                         
                            //dump($data);exit();
                            $stuModel = M('student');
                            $re = $stuModel->add($data);//导入数据库
                           
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
?>