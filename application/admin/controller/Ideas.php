<?php 
namespace  app\admin\controller;

use \think\Request;
use \think\Db;
use \app\common\curl;
use \think\Cookie;

class Ideas extends \think\Controller
{
	public function index()
	{
		$advertiser_id = Cookie::get('advertiser_id');//获取广告主id
		if (empty($advertiser_id)) {
			$this->error('没有授权','http://ta.bairun2.top');
		}
		//获取页码
		$page_data = Request::instance()->param();
		if(empty($page_data)){
			$this->getideas();
		}
		if(!empty($page_data['page'])){
			//上一页
			if($page_data['page'] == 'last'){
				$page_data['page_num'] = $page_data['page_num'] - 1;

			//下一页
			}else if($page_data['page'] == 'next'){
				$page_data['page_num'] = $page_data['page_num'] + 1;
			}
			//判断是否在第一页情况下点击上一页
			if($page_data['page_num'] == '0' && empty($page_data['page_num'])){
				$page_data['page_num'] = 1;
			}
		}else{
			//当页码数据为空
			$page_data['page_num'] = 1;
		}
		//判断是否有输入页码数，有则按输入的页码处理
		if(!empty($page_data['input_page'])){
				$page_data['page_num'] = $page_data['input_page'];
			}
		//判断输入的页码是否大于总页数，大于则等于最大页码数
		$sum_data = Db::table('ideas')->where('advertiser_id',$advertiser_id)->count();
		$page_sum = ceil($sum_data / 15);
		if($page_data['page_num'] > $page_sum){
			$page_data['page_num'] = $page_sum;
			}
		//是否有传入页码数
		if($page_data){
			$datas = Db::table('ideas')->where('advertiser_id',$advertiser_id)->where('advertiser_id',$advertiser_id)->order('id desc')->page($page_data['page_num'],15)->select();
		}else{
			//默认第一页输出的数据
			$datas = Db::table('ideas')->where('advertiser_id',$advertiser_id)->order('id desc')->page(1,15)->select();
		}

		//处理页码数为最后一页时再点击下一页的情况
		// if(empty($datas)){
		// 	$page_data['page_num'] = $page_data['page_num'] - 1;
		// 	$datas = Db::table('ideas')->page($page_data['page_num'],5)->select();
		// }

		//统计总数据
		$count = count($datas);
		//查询计划
		foreach ($datas as $k => $v) {
			$plan = Db::table('plan')->where('pid',$v['ad_id'])->field('name')->find();
			$status = Db::table('ideas_status')->where('status',$v['status'])->find();
			//dump($plan);exit;
			$v['status'] = $status['title'];
			$v['plan_name'] = $plan['name'];
			$datas[$k] = $v;
		}
		//$plan_data = Db::table('plan')->field(['id','name'])->select();
		//$datas['plan_data'] = $plan_data;
		//dump($datas);exit;
			
			    $this->assign('page', $page_data['page_num']);
				$this->assign('sum', $sum_data);
				$this->assign('count', $count);
         return $this->fetch('index',['datas'=>$datas]);
	}

	public function add()
	{
		//$error = $this->get_industry();
		//dump($error);exit;
		$advertiser_id = Cookie::get('advertiser_id');//获取广告主id
		if (empty($advertiser_id)) {
			$this->error('没有授权','http://ta.bairun2.top');
		}
		$industry_data = Db::table('ideas_industry')->where('level',1)->select();
		//查询计划表
		$data = Db::table('plan')->where('advertiser_id',$advertiser_id)->field(['pid','name'])->select();
		//查询创意标签
		$tag_data = Db::table('ideas_tag')->select();
		//查询创意分类
		$ideas_type = Db::table('ideas_type')->select();
		//dump($data);exit;
         return $this->fetch('add',[
         	'data'=>$data,
         	'tag_data'=>$tag_data,
         	'ideas_type'=>$ideas_type,
         	'industry_data'=>$industry_data
         ]);
	}

	public function doadd()
	{
		//获取请求数据
		$data = Request::instance()->param();
		//dump($data);
		$file = request()->file('file');
		 if(isset($_FILES['file']) && $_FILES['file']['error']==0)
        {
            $file_name = $_FILES['file']['name'];
            $size = getimagesize($_FILES['file']['tmp_name']);
            $type = $_FILES['file']['type'];
            $original = $_FILES['file']['tmp_name'];
            $file_md5 = md5_file($original);
        }

    	// 移动到框架应用根目录/public/uploads/ 目录下

    	$info = $file->rule('md5')->move(ROOT_PATH . 'public' . DS . 'uploads');//验证上传文件类型,并存放到指定目录
    	//var_dump($info);exit;
    	dump($info->getFilename());//exit;
    	dump($info);
    	$f = $info->getSaveName();
    	dump($f);
    	$file_name = $info->getFilename();
       // $post_data = new CURLFile(realpath($file_name));
    // $post_data = [
    //     'file' => new CURLFile(realpath($file_name)),
    // 		];
    	$img_url = 'http://ta.bairun2.top/uploads/'.$f;
    	//dump($img_url);exit;
    //	$file_data = explode('.',$file_name);
    	//$video_md5 = $file_data[0];
$file_data = [
    		'name'=>'a.mp4',
    		'type'=>'video/mp4',
    		'file'=>$img_url
    	];
    		
    	$this->up_video_data($file_data,$file_md5);
    	exit;

    	$this->video_file($video_md5,$file);exit;
    	$img_url = 'http://ta.bairun2.top/uploads/'.$file_name;
    	exit;
    	$this->upimage($img_url);
		$datas['advertiser_id'] = $data['advertiser_id'];
		$datas['ad_id'] = $data['ad_id'];
		$datas['inventory_type'] = $data['inventory_type'];
		$datas['third_industry_id'] = $data['third_industry_id'];
		$datas['creative_material_mode'] = $data['creative_material_mode'];
		$datas['title'] = $data['title'];
		$datas['source'] = $data['source'];
		$datas['status'] = 'enable';

		$tag_id = $data['ad_keywords'];
		$datas['ad_keywords'] = implode(',',$tag_id);

		dump($datas);exit;

		$res = Db::table('ideas')->insert($datas);

		if ($res && !empty($data['goon'])) {
			$this->success('添加成功','ideas/add');
		}else if($res){
			$this->success('添加成功','ideas/index');
		}else{
			$this->error('添加失败');
		}
	}

	public function edit()
	{
		$id = Request::instance()->param('id');
		$data = Db::table('ideas')->where('id',$id)->find();

		$this->fetch('ideas/edit',['data'=>$data]);
	}

	public function update()
	{
		$data = Request::instance()->param();

		dump($data);
	}

	public function del()
	{
		$id = Request::instance()->param('id');
		$res = Db::table('ideas')->where('id',$id)->delete();
		if($res){
			$this->success('删除成功');
		}else{
			$this->error('删除失败');
		}
	}

	public function getideas()
	{
		$advertiser_id = Cookie::get('advertiser_id');//获取广告主id
		if (empty($advertiser_id)) {
			$this->error('没有授权','http://ta.bairun2.top');
		}
		$curl = new Curl();//实例化curl
		$url = "https://ad.oceanengine.com/open_api/2/creative/get?advertiser_id=".$advertiser_id."&page=1&page_size=50";//设置url
		$token_data =  Db::table('token')->where('advertiser_id',$advertiser_id)->field('access_token')->find();//获取access_token值
		$token = $token_data['access_token'];
		//dump($token);
		$datas = $curl->get($url,$token);//发送get请求
		
		$data = json_decode($datas);//处理返回的数据
		$list = $data->data->list;
		dump($list);exit;
		$ideas_datas = [];

		foreach ($list as $k => $v) { //遍历数据，写入数据库
			$ideas_datas['creative_id'] = $v->creative_id;
			$ideas_datas['ad_id'] = $v->ad_id;
			$ideas_datas['status'] = $v->status;
			$ideas_datas['title'] = $v->title;
			$ideas_datas['advertiser_id'] = $v->advertiser_id;
			$ideas_datas['opt_status'] = $v->opt_status;
			$ideas_datas['image_ids'] = $v->image_ids;
			$ideas_datas['video_id'] = $v->video_id;
				if($v->image_ids){
					foreach($v->image_ids as $k=>$v){
						$img_data['image_ids'] = $v;
						$img_data['creative_id'] = $ideas_datas['creative_id'];
						$img_data['advertiser_id'] = $ideas_datas['advertiser_id'];
						$img_data['created_time'] = date('Y-m-d H:i:s',time());
						$has_img_data = Db::table('ideas_pics')->where('image_ids',$img_data['image_ids'])->find();
						if($has_img_data){
							$img_res = Db::table('ideas_pics')->where('image_ids',$img_data['image_ids'])->update($img_data);
						}else{
							$img_res = Db::table('ideas_pics')->insert($img_data);
						}
						if(!$img_res){
							continue;
						}
					}
				}
				if($v->image_ids){
				foreach($v->image_ids as $k=>$v){
					$img_data['image_ids'] = $v;
					$img_data['creative_id'] = $ideas_datas['creative_id'];
					$img_data['advertiser_id'] = $ideas_datas['advertiser_id'];
					$img_data['created_time'] = date('Y-m-d H:i:s',time());
					$has_img_data = Db::table('ideas_pics')->where('image_ids',$img_data['image_ids'])->find();
					if($has_img_data){
						$img_res = Db::table('ideas_pics')->where('image_ids',$img_data['image_ids'])->update($img_data);
					}else{
						$img_res = Db::table('ideas_pics')->insert($img_data);
					}
					if(!$img_res){
						continue;
					}
				}
			}

			

			$hsaideas = Db::table('ideas')->where('creative_id',$ideas_datas['creative_id'])->find();
			if($hsaideas){
				$res = Db::table('ideas')->where('creative_id',$ideas_datas['creative_id'])->update($ideas_datas);
			}else{
				$res = Db::table('ideas')->insert($ideas_datas);
			}
			// if($res){
			// 	return $this->success('获取数据成功');
			// }
			

			// if($ideas_datas['video_id']){ //素材是否为图片
			// 	//dump($ideas_datas['image_ids']);
			// 	dump($ideas_datas['video_id']);//exit;
			// 	$this->getimage($advertiser_id  ,$token);
			// 	// foreach ($ideas_datas['image_ids'] as $k => $v) {
			// 	// 	$key = $k;
			// 	// 	$id[$key] = $v;
			// 	// 	 //获取素材图片信息
			// 	// }

				
			// }//dump($ideas_datas);
		}
		



	}

	public function get_industry()
	{
		$advertiser_id = Cookie::get('advertiser_id');
		$token_data =  Db::table('token')->where('advertiser_id',$advertiser_id)->field('access_token')->find();//获取access_token值
		$token = $token_data['access_token'];
		$curl = new Curl();//实例化curl
		$url = "https://ad.oceanengine.com/open_api/2/tools/industry/get/";
		$data = $curl->get($url,$token);
		$data = json_decode($data);
		$list = $data->data->list;
		//dump($list);
		$datas = [];
		$error = [];
		foreach ($list as $k => $v) {
			$datas['level'] = $v->level;
			$datas['industry_id'] = $v->industry_id;
			$datas['industry_name'] = $v->industry_name;
			$datas['first_industry_id'] = $v->first_industry_id;
			$datas['first_industry_name'] = $v->first_industry_name;
			$datas['second_industry_id'] = $v->second_industry_id;
			$datas['second_industry_name'] = $v->second_industry_name;
			$datas['third_industry_id'] = $v->third_industry_id;
			$datas['third_industry_name'] = $v->third_industry_name;
			//dump($datas);//exit;
			$has_data = Db::table('ideas_industry')->where('industry_id',$datas['industry_id'])->find();
			//dump($has_data);
			if($has_data){
				//$res = Db::table('ideas_industry')->where('industry_id',$datas['industry_id'])->update($datas);
			}else{
				$res = Db::table('ideas_industry')->insert($datas);
			}
			// if($res){
			// 	$i = 0;
			// 	$error[$i] = array_push($error, $datas['industry_id']);
			// 	$i++;
			// 	continue;
			// }
		}
		//return $error;

	}



	public function upimage($img_url)
	{
		$advertiser_id = Cookie::get('advertiser_id');
		$token_data =  Db::table('token')->where('advertiser_id',$advertiser_id)->field('access_token')->find();
		$token = $token_data['access_token'];
		$curl = new Curl();
		//dump($id);exit;
		 
		$url = "https://ad.oceanengine.com/open_api/2/file/image/ad/";
		//dump($url);//exit;
		// foreach ($id as $k => $v) {
		// 		$url .= "&image_ids[".$k."]=".$v;
		// 		}
		$data['upload_type'] = 'UPLOAD_BY_URL';
		$data['advertiser_id'] = (int)$advertiser_id;
		$data['image_url'] = $img_url;
		$datas = $curl->post($url,$data,$token);
		//dump($datas);
		$datas = json_decode($datas);
		if($datas->message != 'OK' || $datas->message != 'ok'){
			$this->error('上传文件失败');
		}
		$list = $datas->data;
		$img_data['img_id'] = $list->id;
		$img_data['url'] = $list->url;
		$img_data['format'] = $list->format;
		$img_data['signature'] = $list->signature;
		$img_data['size'] = $list->size;
		$img_data['width'] = $list->width;
		$img_data['height'] = $list->height;

		$res = Db::table('ideas_img')->insert($img_data);
		if(!$res){
			$this->error('数据库出错,请重试');
		}
	}

	public function video_file($video_md5, $file)
	{
		$advertiser_id = Cookie::get('advertiser_id');
		$token_data =  Db::table('token')->where('advertiser_id',$advertiser_id)->field('access_token')->find();
		$token = $token_data['access_token'];
		$curl = new Curl();
		//dump($id);exit;
		 
		$url = "https://ad.oceanengine.com/open_api/2/file/video/ad/";
		//dump($url);//exit;
		// foreach ($id as $k => $v) {
		// 		$url .= "&image_ids[".$k."]=".$v;
		// 		}
		$data['video_signature'] = $video_md5;
		$data['advertiser_id'] = (int)$advertiser_id;
		$data['video_file'] = $file;
		$datas = $curl->post($url,$data,$token);
		//dump($datas);
		$datas = json_decode($datas);
		dump($datas);exit;
		if($datas->message != 'OK' || $datas->message != 'ok'){
			$this->error('上传文件失败');
		}
		$list = $datas->data;
		$img_data['img_id'] = $list->id;
		$img_data['url'] = $list->url;
		$img_data['format'] = $list->format;
		$img_data['signature'] = $list->signature;
		$img_data['size'] = $list->size;
		$img_data['width'] = $list->width;
		$img_data['height'] = $list->height;

		$res = Db::table('ideas_img')->insert($img_data);
		if(!$res){
			$this->error('数据库出错,请重试');
		}
	}

	public function up_video_data($file,$video_signature)
	{

		$advertiser_id = Cookie::get('advertiser_id');
		$token_data =  Db::table('token')->where('advertiser_id',$advertiser_id)->field('access_token')->find();
		$token = $token_data['access_token'];
		$url = 'https://ad.oceanengine.com/open_api/2/file/video/ad/';
		$curl = new Curl();
		$datas=[
			'advertiser_id'=>(int)$advertiser_id,
			'video_signature'=>$video_signature,
			'video_file'=>$file
		];
		$data = $curl->file($url,$datas,$token);
		$res = json_decode($data);
		dump($res);

		


	}

	public function gain_img()
	{
		$advertiser_id = Cookie::get('advertiser_id');
		$token_data =  Db::table('token')->where('advertiser_id',$advertiser_id)->field('access_token')->find();
		$token = $token_data['access_token'];
		$curl = new Curl();
		// $img = Db::table('ideas_pics')->where('creative_id','1647623897202700')->field('image_ids')->find();
		// $img_id = $img['image_ids'];
		// $image_ids = Db::table('ideas_img')->where('id',1)->field('img_id')->find();
		// $img_id = $image_ids['img_id'];
		//$url = 'https://ad.oceanengine.com/open_api/2/file/image/ad/get/?advertiser_id='.$advertiser_id.'&image_ids[]=7f3b824ccb3841bd7f8de6c1e50da958';
		//dump($img);
		$url = 'https://ad.oceanengine.com/open_api/2/file/image/get/?advertiser_id='.$advertiser_id;
		$data = $curl->get($url,$token);
		$datas = json_decode($data);
		dump($advertiser_id);
		dump($datas);

	}

	
}

 ?>