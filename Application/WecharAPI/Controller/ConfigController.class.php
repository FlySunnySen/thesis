<?php
namespace WecharAPI\Controller;
use  Think\Controller;
class ConfigController extends Controller
{
    
	 //开放系统
	 public function openSystem()
	 {
	 	if(IS_POST)
		{
			$year   = $_POST['myYear'];
			$arr =array('year' =>$year , 'status' => '1',);
			$config = M('config');
			$rst = $config -> add($arr);
			//如果系统处于维护，执行save操作
			if(empty($rst)){
				$rst = $config -> save($arr);
			}
			if(!empty($rst)){
				$this->ajaxReturn(TRUE);
			}else{
				$this->ajaxReturn(FALSE);
			}
		}
	 }
	 //关闭系统
	 public function closeSystem()
	 {
	 	$year   = $_POST['myYear'];
			$arr =array('year' =>$year , 'status' => '0',);
			$config = M('config');
			$rst = $config -> save($arr);
			if(!empty($rst)){
				$this->ajaxReturn(TRUE);
			}else{
				$this->ajaxReturn(FALSE);
			}
	 }
	 	 	
	
	//添加教研室
	public function addErgAction()
	{
		$data['0'] = I('post.ERG_name');
		$ERGmodel =  M('erg');
		$MAX = $ERGmodel->max('ERG_group');
		$data['ERG_group'] = $MAX+1;
		$rst =$ERGmodel->add($data);
		if($rst){
			$this->ajaxReturn(TRUE);
		}else{
			$this->ajaxReturn(FALSE);
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
			$this->ajaxReturn(TRUE);
		}else{
			$this->ajaxReturn(FALSE);
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
	
	
	 
	public function addFileToZip($path,$zip){
		    $handler=opendir($path); //打开当前文件夹由$path指定。
		    while(($filename=readdir($handler))!==false){
		        if($filename != "." && $filename != ".."){//文件夹文件名字为'.'和‘..’，不要对他们进行操作
		            if(is_dir($path."/".$filename)){// 如果读取的某个对象是文件夹，则递归
		                self::addFileToZip($path."/".$filename, $zip);
		            }else{ //将文件加入zip对象
		                $zip->addFile($path."/".$filename);
		            }
		        }
		    }
		    @closedir($path);
			}
	 public function exportData()
	 {
	 	  $year   = $_POST['myYear'];
		  $zipname = "./Public/$year.zip";
	 	  $zip = new \ZipArchive;
		  $path = "./Public/$year/";
		  $res = $zip->open($zipname, \ZipArchive::CREATE);  
			if ($res === TRUE) {  
			   if(is_dir($path)){  //给出文件夹，打包文件夹
			       
			        self::addFileToZip($path, $zip);
				   
			    }else if(is_array($path)){  //以数组形式给出文件路径
			        foreach($path as $file){
			            $zip->addFile($file);
			        }
					
			    }else{      //只给出一个文件
			        $zip->addFile($path);
					
				}
			}  
								   
			    $zip->close(); //关闭处理的zip文件
			    header("Content-Type: application/zip");  
				header("Content-Transfer-Encoding: Binary");  
				  
				header("Content-Length: " . filesize($zipname));  
				header("Content-Disposition: attachment; filename=\"" . basename($zipname) . "\"");  
				  
				readfile($zipname);  
                
                exit;  
			 
			
	 }		
	 
}
