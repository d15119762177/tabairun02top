<?php 
namespace  app\admin\controller;

use \think\Request;
use \think\Db;
use think\Controller;
use think\Loader;
use app\index\controller\Auth;
use \think\Cookie;
use PHPExcel;
use PHPExcel_IOFactory;
use PHPExcel_Cell;
vendor("PHPExcel.PHPExcel.PHPExcel");
vendor("PHPExcel.PHPExcel.IOFactory");

class Batch extends \think\Controller
{
	public function index()
	{
		return view();

	}
    //广告组上传
	 public function doexcel()
    {
        $advertiser_id = Cookie::get('advertiser_id');
        Loader::import('PHPExcel.PHPExcel', EXTEND_PATH);
        Loader::import('PHPExcel.PHPExcel.IOFactory.PHPExcel_IOFactory', EXTEND_PATH);
        Loader::import('PHPExcel.PHPExcel.Reader.Excel5', EXTEND_PATH);

        $objPHPExcel = new \PHPExcel();
        $file = request()->file('excel');
        $file_types = explode(".", $_FILES ['excel'] ['name']); // ["name"] => string(25) "excel文件名.xls"
                $file_type = $file_types [count($file_types) - 1];//xls后缀
                $file_name = $file_types [count($file_types) - 2];//xls去后缀的文件名
                /*判别是不是.xls文件，判别是不是excel文件*/
                if (strtolower($file_type) != "xls" && strtolower($file_type) != "xlsx") {
                    echo '不是Excel文件，重新上传';
                    die;
                }
                $file_path = ROOT_PATH . 'public' . DS . 'excel';
                $info = $file->move($file_path);//上传位置

        if ($info) {
            //echo $info->getFilename();
            $exclePath = $info->getSaveName();  //获取文件名
           // dump($exclePath);
            $accept = strrchr($exclePath, '.');
            $objReader = '';
            if ($accept == '.xlsx') {
                $objReader = \PHPExcel_IOFactory::createReader('Excel2007');
            } elseif ($accept == '.xls') {
                $objReader = \PHPExcel_IOFactory::createReader('Excel5');
            }
            $obj_PHPExcel = $objReader->load($file_path . DS . $exclePath, $encode = 'utf-8');  //加载文件内容,编码utf-8
            $worksheet = $obj_PHPExcel->getsheet(0);
            $excel_array = $worksheet->toArray();   //转换为数组格式
            array_shift($excel_array);  //删除第一个数组(标题);
            $imageFilePath = ROOT_PATH . 'public' . DS . 'upload' . DS . 'imgtemp';//图片保存目录
            foreach ($worksheet->getDrawingCollection() as $img) {
                list ($startColumn, $startRow) = \PHPExcel_Cell::coordinateFromString($img->getCoordinates());//获取列与行号
                $imageFileName = time() . mt_rand(100, 999);
                /*表格解析后图片会以资源形式保存在对象中，可以通过getImageResource函数直接获取图片资源然后写入本地文件中*/
                switch ($img->getMimeType()) {
                    case'image/jpg':
                    case'image/jpeg':
                        $imageFileName .= '.jpg';
                        imagejpeg($img->getImageResource(), $imageFilePath . DS . $imageFileName);
                        break;
                    case 'image/gif':
                        $imageFileName .= '.gif';
                        imagegif($img->getImageResource(), $imageFilePath . DS . $imageFileName);
                        break;
                    case 'image/png':
                        $imageFileName .= '.png';
                        imagepng($img->getImageResource(), $imageFilePath . DS . $imageFileName);
                        break;
                }
                $excel_array[$startRow - 2][$startColumn] = $imageFileName; //存到数组里
                
            }
           //dump($excel_array);exit; //打印表格的所有数据
            $datas = [];
            foreach ($excel_array as $k => $v) {
                $type = Db::table('landing_type')->where('type_name','like',"%".$v[2]."%")->find();
              //  dump($type);




                $data[$k]['advertiser_id'] = (int)$advertiser_id;
                $data[$k]['campaign_name'] = $v[0];
               // $data[$k]['landing_type'] = $v[2];
               // $data[$k]['status'] = $v[3];
                $data[$k]['budget_mode'] = $v[3];
                $data[$k]['budget'] = $v[4];
                //预算类型
                if(!$v[2] || $v[2] == '暂停'){
                    $data[$k]['status'] = 'CAMPAIGN_STATUS_DISABLE';
                    $data[$k]['status_name'] = "暂停";
                }else{
                    $data[$k]['status'] = 'CAMPAIGN_STATUS_ENABLE';
                    $data[$k]['status_name'] = "启用";
                }

                //预算类型
                if($v[3] == '日预算'){
                    $data[$k]['budget_mode'] = 'BUDGET_MODE_DAY';
                    $data[$k]['budget_mode_name'] = '日预算';
                    $data[$k]['budget'] = $v[4];

                }else if($v[3] == '总预算'){
                    $data[$k]['budget_mode'] = 'BUDGET_MODE_TOTAL';
                    $data[$k]['budget_mode_name'] = '总预算';
                    $data[$k]['budget'] = $v[4];
                }else{
                    $data[$k]['budget_mode'] = 'BUDGET_MODE_INFINITE';
                    $data[$k]['budget_mode_name'] = '不限';
                    $data[$k]['budget'] = '';
                }

                //推广目的
                if(!$type){
                    $data[$k]['type'] = 'LINK';
                    $data[$k]['type_name'] = '销售线索收集';
                }else{
                    $data[$k]['type'] = $type['type'];
                    $data[$k]['type_name'] = $type['type_name'];
                }

                
                
            }
            $json_data = json_encode($data);
            // $commodity = new CommodityModel();
            // $commodity->saveAll($data);
          //  dump($datas);exit;
           //  unset($info);
           //  unlink($file_path . DS . $exclePath); //删除文件
           // $this->assign('data', $datas);
           // dump($data);
            return $this->fetch('batch/index',['datas'=>$data,'json_data'=>$json_data]);

        } else {
            return $file->getError();
        }
    }

    public function plan_up()
    {
        return view();
    }
    //计划上传
    public function planexcel()
    {
        Loader::import('PHPExcel.PHPExcel', EXTEND_PATH);
        Loader::import('PHPExcel.PHPExcel.IOFactory.PHPExcel_IOFactory', EXTEND_PATH);
        Loader::import('PHPExcel.PHPExcel.Reader.Excel5', EXTEND_PATH);

        $objPHPExcel = new \PHPExcel();
        $file = request()->file('excel');
        $file_types = explode(".", $_FILES ['excel'] ['name']); // ["name"] => string(25) "excel文件名.xls"
                $file_type = $file_types [count($file_types) - 1];//xls后缀
                $file_name = $file_types [count($file_types) - 2];//xls去后缀的文件名
                /*判别是不是.xls文件，判别是不是excel文件*/
                if (strtolower($file_type) != "xls" && strtolower($file_type) != "xlsx") {
                    echo '不是Excel文件，重新上传';
                    die;
                }
                $file_path = ROOT_PATH . 'public' . DS . 'excel';
                $info = $file->move($file_path);//上传位置

        if ($info) {
            //echo $info->getFilename();
            $exclePath = $info->getSaveName();  //获取文件名
            $accept = strrchr($exclePath, '.');
            $objReader = '';
            if ($accept == '.xlsx') {
                $objReader = \PHPExcel_IOFactory::createReader('Excel2007');
            } elseif ($accept == '.xls') {
                $objReader = \PHPExcel_IOFactory::createReader('Excel5');
            }
            $obj_PHPExcel = $objReader->load($file_path . DS . $exclePath, $encode = 'utf-8');  //加载文件内容,编码utf-8
            $worksheet = $obj_PHPExcel->getsheet(0);
            $excel_array = $worksheet->toArray();   //转换为数组格式
            array_shift($excel_array);  //删除第一个数组(标题);
            $imageFilePath = ROOT_PATH . 'public' . DS . 'upload' . DS . 'imgtemp';//图片保存目录
            foreach ($worksheet->getDrawingCollection() as $img) {
                list ($startColumn, $startRow) = \PHPExcel_Cell::coordinateFromString($img->getCoordinates());//获取列与行号
                $imageFileName = time() . mt_rand(100, 999);
                /*表格解析后图片会以资源形式保存在对象中，可以通过getImageResource函数直接获取图片资源然后写入本地文件中*/
                switch ($img->getMimeType()) {
                    case'image/jpg':
                    case'image/jpeg':
                        $imageFileName .= '.jpg';
                        imagejpeg($img->getImageResource(), $imageFilePath . DS . $imageFileName);
                        break;
                    case 'image/gif':
                        $imageFileName .= '.gif';
                        imagegif($img->getImageResource(), $imageFilePath . DS . $imageFileName);
                        break;
                    case 'image/png':
                        $imageFileName .= '.png';
                        imagepng($img->getImageResource(), $imageFilePath . DS . $imageFileName);
                        break;
                }
                $excel_array[$startRow - 2][$startColumn] = $imageFileName; //存到数组里
                
            }
            dump($excel_array);exit; //打印表格的所有数据
            $data = [];
            foreach ($excel_array as $k => $v) {
               

            }
            // $commodity = new CommodityModel();
            // $commodity->saveAll($data);
             unset($info);
             unlink($file_path . DS . $file_name . $accept); //删除文件

        } else {
            return $file->getError();
        }
    }

    public function ideas_up()
    {
        return view();
    }

    //创意上传
    public function ideasexcel()
    {
        Loader::import('PHPExcel.PHPExcel', EXTEND_PATH);
        Loader::import('PHPExcel.PHPExcel.IOFactory.PHPExcel_IOFactory', EXTEND_PATH);
        Loader::import('PHPExcel.PHPExcel.Reader.Excel5', EXTEND_PATH);

        $objPHPExcel = new \PHPExcel();
        $file = request()->file('excel');
        $file_types = explode(".", $_FILES ['excel'] ['name']); // ["name"] => string(25) "excel文件名.xls"
                $file_type = $file_types [count($file_types) - 1];//xls后缀
                $file_name = $file_types [count($file_types) - 2];//xls去后缀的文件名
                /*判别是不是.xls文件，判别是不是excel文件*/
                if (strtolower($file_type) != "xls" && strtolower($file_type) != "xlsx") {
                    echo '不是Excel文件，重新上传';
                    die;
                }
                $file_path = ROOT_PATH . 'public' . DS . 'excel';
                $info = $file->move($file_path);//上传位置

        if ($info) {
            //echo $info->getFilename();
            $exclePath = $info->getSaveName();  //获取文件名
            $accept = strrchr($exclePath, '.');
            $objReader = '';
            if ($accept == '.xlsx') {
                $objReader = \PHPExcel_IOFactory::createReader('Excel2007');
            } elseif ($accept == '.xls') {
                $objReader = \PHPExcel_IOFactory::createReader('Excel5');
            }
            $obj_PHPExcel = $objReader->load($file_path . DS . $exclePath, $encode = 'utf-8');  //加载文件内容,编码utf-8
            $worksheet = $obj_PHPExcel->getsheet(0);
            $excel_array = $worksheet->toArray();   //转换为数组格式
            array_shift($excel_array);  //删除第一个数组(标题);
            $imageFilePath = ROOT_PATH . 'public' . DS . 'upload' . DS . 'imgtemp';//图片保存目录
            foreach ($worksheet->getDrawingCollection() as $img) {
                list ($startColumn, $startRow) = \PHPExcel_Cell::coordinateFromString($img->getCoordinates());//获取列与行号
                $imageFileName = time() . mt_rand(100, 999);
                /*表格解析后图片会以资源形式保存在对象中，可以通过getImageResource函数直接获取图片资源然后写入本地文件中*/
                switch ($img->getMimeType()) {
                    case'image/jpg':
                    case'image/jpeg':
                        $imageFileName .= '.jpg';
                        imagejpeg($img->getImageResource(), $imageFilePath . DS . $imageFileName);
                        break;
                    case 'image/gif':
                        $imageFileName .= '.gif';
                        imagegif($img->getImageResource(), $imageFilePath . DS . $imageFileName);
                        break;
                    case 'image/png':
                        $imageFileName .= '.png';
                        imagepng($img->getImageResource(), $imageFilePath . DS . $imageFileName);
                        break;
                }
                $excel_array[$startRow - 2][$startColumn] = $imageFileName; //存到数组里
                
            }
            dump($excel_array);exit; //打印表格的所有数据
            $length = count($excel_array);
            $data = [];
            // foreach ($excel_array as $k => $v) {
            //     $data[]
            // }
            

            // $commodity = new CommodityModel();
            // $commodity->saveAll($data);
             unset($info);
             unlink($file_path . DS . $file_name . $accept); //删除文件

        } else {
            return $file->getError();
        }
    }



}