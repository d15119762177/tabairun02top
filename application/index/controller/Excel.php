<?php

namespace app\index\controller;

use think\Controller;
use think\Loader;
use app\index\controller\Auth;
use PHPExcel;
use PHPExcel_IOFactory;
use PHPExcel_Cell;


class Excel extends Controller
{
   public function index()
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

    public function actionRead($filename,$encode='utf-8'){
    	$objReader = \PHPExcel_IOFactory::createReader('Excel2007'); $objReader->setReadDataOnly(true); $objPHPExcel = $objReader->load($filename); $objWorksheet = $objPHPExcel->getActiveSheet(); $highestRow = $objWorksheet->getHighestRow(); //return $highestRow; 
        $highestColumn = $objWorksheet->getHighestColumn();
        $highestColumnIndex = \PHPExcel_Cell::columnIndexFromString($highestColumn); //var_dump($highestColumnIndex); 
        $excelData = array(); 
        for($row = 1; $row <= $highestRow; $row++) 
        { 
        	for ($col = 0; $col < $highestColumnIndex; $col++) { 
        		$excelData[$row][]=(string)$objWorksheet->getCellByColumnAndRow($col, $row)->getValue(); 
        	} 
        }
         return $excelData;
          }

  }
