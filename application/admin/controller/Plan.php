<?php 
namespace  app\admin\controller;

use \think\Request;
use \think\Db;
use \think\Cookie;
use \app\common\curl;

class Plan extends \think\Controller
{
	public function index()
	{

		$advertiser_id = Cookie::get('advertiser_id');
		//获取页码
		$page_data = Request::instance()->param();
		if(empty($page_data)){
			   $this->getplan();
			//dump($data);exit;
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
		$sum_data = Db::table('plan')->where('advertiser_id',$advertiser_id)->count();
		$page_sum = ceil($sum_data / 15);
		if($page_data['page_num'] > $page_sum){
			$page_data['page_num'] = $page_sum;
			}
		//是否有传入页码数		
		if($page_data){
			$data = Db::table('plan')->where('advertiser_id',$advertiser_id)->order('ad_modify_time desc')->page($page_data['page_num'],15)->select();
		}else{
			//默认第一页输出的数据
			$data = Db::table('plan')->where('advertiser_id',$advertiser_id)->order('ad_modify_time desc')->page(1,15)->select();
		}
		// if(empty($data)){
		// 	$page_data['page_num'] = $page_data['page_num'] - 1;
		// 	$data = Db::table('plan')->page($page_data['page_num'],5)->select();
		// }
		//统计总数据
		$count = count($data);
		foreach ($data as $k => $v) {
			$advertising = Db::table('advertising')->where('campaign_id',$v['campaign_id'])->field('campaign_name')->find();
			$plan_status = Db::table('plan_status')->where('status',$v['status'])->find();
			$v['advertising_name'] = $advertising['campaign_name'];
			$v['status'] = $plan_status['title'];
			$data[$k] = $v;
		}
		//dump($data);exit;
		//$data = Db::table('plan')->select();
				$this->assign('page', $page_data['page_num']);
				$this->assign('sum', $sum_data);
				$this->assign('count', $count);
         return $this->fetch('index',['data'=>$data]);
	}

	public function add()
	{
		$advertiser_id = Cookie::get('advertiser_id');
		if (empty($advertiser_id)) {
			$this->error('没有授权','http://ta.bairun2.top');
		}
		$data = Db::table('advertising')->where('advertiser_id',$advertiser_id)->field(['campaign_id','campaign_name'])->select();
		
		$active_convert_data = Db::table('active_convert')->select();
		// foreach ($data as $k => $v) {
		// 	$name = Db::table('landing_type')->where('id',$v['landing_type'])->field('type_name')->find();
		// 	$data[$k] = $v;
		// 	$data[$k]['name'] = $name['type_name'];
		// }
		//dump($data);exit;
		
         return $this->fetch('add',['data'=>$data,'advertiser_id'=>$advertiser_id,'active_convert_data'=>$active_convert_data]);
	}

	public function doadd()
	{
		$data = Request::instance()->param();
		$datas['campaign_id'] = $data['campaign_id'];
		$datas['advertiser_id'] =(int)$data['advertiser_id'];
		$datas['name'] =$data['name'];
		$datas['budget'] =(int)$data['budget'];
		$datas['start_time'] =$data['start_time'];
		$datas['end_time'] =$data['end_time'];
		$datas['pricing'] =$data['pricing'];
		//$datas['bid'] =$data['bid'];
		$datas['cpa_bid'] =$data['cpa_bid'];
		$datas['budget_mode'] =$data['budget_mode'];
		if($datas['pricing']=='PRICING_CPV'){
			$datas['bid'] =$data['bid'];//判断预算类型
		}
		$datas['delivery_range'] =$data['delivery_range'];
		$datas['status'] ='enable';
		//$datas['created_time'] = date('Y-m-d H:i:s',time());
		//$datas['updated_time'] = date('Y-m-d H:i:s',time());
		$datas['external_url'] =$data['external_url'];
		$datas['convert_id'] =$data['convert_id'];
		$datas['schedule_type'] =$data['schedule_type'];
		$datas['flow_control_mode'] =$data['flow_control_mode'];

		//dump($datas['start_time']);
		$start = strtotime($datas['start_time']);
		$end = strtotime($datas['end_time']);

		$datas['start_time'] = date("Y-m-d H:i",$start);//转化接口规定的时间类型
		$datas['end_time'] = date("Y-m-d H:i",$end);
		//exit;
		$token_data =  Db::table('token')->where('advertiser_id',$datas['advertiser_id'])->field('access_token')->find();
		$token = $token_data['access_token'];

		$create_plan_res = $this->createplan($datas,$token);//调用接口发送数据，创建计划
		if($create_plan_res != 'success'){//获取返回错误信息
			$this->error($create_plan_res);//返回错误信息
		}
		$datas['created_time'] = date('Y-m-d H:i:s',time());
		$datas['updated_time'] = date('Y-m-d H:i:s',time());
		$res = Db::table('plan')->insert($datas);//插入数据库
		if ($res && !empty($data['next'])) {
			$this->success('添加成功','ideas/add');
		}else if($res){
			$this->success('添加成功');
		}else{
			$this->error('添加失败');
		}


		// if (!empty($data['next'])) {
		// 	return $this->fetch('ideas/add');
		// }
		// if (!empty($data['goon'])) {
		// 	dump($data);
		// 	return $this->fetch('add');
		// }
		//dump($data);
	}

	public function edit()
	{
		//广告组id，名称
		$dis_data = Db::table('advertising')->field(['campaign_id','campaign_name'])->select();
		
		//
		$advertiser_id = Cookie::get('advertiser_id');
		if (empty($advertiser_id)) {
			$this->error('没有授权','http://ta.bairun2.top');
		}
		$pid = Request::instance()->param('pid');
		
		//dump($campaign_id);exit;
		$data = Db::table('plan')->where('pid',$pid)->find();
		$start =  strtotime($data['start_time']);
		$end =  strtotime($data['end_time']);
		$data['start_time'] = date("Y-m-d H:i:s",$start);
		$data['end_time'] = date("Y-m-d H:i:s",$end);


		$convert_id_type = Db::table('active_convert')->where('id',$data['convert_id'])->find();
		$active_convert_data = Db::table('active_convert')->select();
		//dump($data);exit;
		return $this->fetch('edit',['data'=>$data,'dis_data'=>$dis_data,'advertiser_id'=>$advertiser_id,'active_convert_data'=>$active_convert_data]);
	}

	public function update()
	{
		$data = Request::instance()->param();
		//dump($data);exit;
		$datas['advertiser_id'] = $data['advertiser_id'];
		$datas['ad_id'] = (int)$data['ad_id'];
		$datas['name'] =$data['name'];
		$datas['budget'] =$data['budget'];
		$datas['start_time'] =$data['start_time'];
		$datas['end_time'] =$data['end_time'];
		//$datas['pricing'] =$data['pricing'];
		//$datas['bid'] = (int)$data['bid'];
		$datas['cpa_bid'] = (int)$data['cpa_bid'];
		$datas['budget_type'] =$data['budget_type'];
		$datas['flow_control_mode'] =$data['flow_control_mode'];
		$datas['modify_time'] =$data['modify_time'];
		
		//$datas['delivery_range'] =$data['delivery_range'];
		if($data['pricing']=='PRICING_CPV'){
			$datas['bid'] = (int)$data['bid'];//判断预算类型
		}

		//$datas['updated_time'] = date('Y-m-d H:i:s',time());
		$start = strtotime($datas['start_time']);
		$end = strtotime($datas['end_time']);
		$datas['start_time'] = date("Y-m-d H:i",$start);//转化接口规定的时间类型
		$datas['end_time'] = date("Y-m-d H:i",$end);
		//dump($datas);exit;
		$token_data =  Db::table('token')->where('advertiser_id',$datas['advertiser_id'])->field('access_token')->find();
		$token = $token_data['access_token'];
		$update_plan_res = $this->updateplan($datas,$token);
		if($update_plan_res != 'success'){//获取返回错误信息
			$this->error($update_plan_res);//返回错误信息
		}else{
			$this->success('修改成功','plan/index');
		}
		//dump($datas);exit;
		//$datas['pid'] = (int)$data['ad_id'];
		// $res = Db::table('plan')->where('id',$data['id'])->update($datas);
		// if ($res) {
		// 	$this->success('修改成功','plan/index');
		// }else{
		// 	$this->error('修改失败');
		// }
	}

	public function del()
	{
		$id = Request::instance()->param('id');
		$res = Db::table('plan')->where('id',$id)->delete();
		if ($res) {
			$this->success('删除成功');
		}else{
			$this->error('删除失败');
		}
		//dump($id);
	}

	//获取广告计划数据
	public function getplan()
	{
		$advertiser_id = Cookie::get('advertiser_id');
		//dump($advertiser_id);
		if (empty($advertiser_id)) {
			$this->error('没有授权','http://ta.bairun2.top');
		}
		$curl = new Curl();
		$url = "https://ad.oceanengine.com/open_api/2/ad/get?advertiser_id=".$advertiser_id."&page=1&page_size=100";
		$token_data =  Db::table('token')->where('advertiser_id',$advertiser_id)->field('access_token')->find();
		$token = $token_data['access_token'];
		//dump($token);
		$datas = $curl->get($url,$token);
		
		$data = json_decode($datas);
		$list = $data->data->list;
		$plan_datas = [];
		//dump($list);exit;
		if(empty($list)){
			$res = Db::table('plan')->where('advertiser_id',$advertiser_id)->delete();
			//dump($res);exit;
		}else{
		foreach ($list as $k => $v) {
			$plan_datas['pid'] = $v->id;
			$plan_datas['name'] = $v->name;
			$plan_datas['campaign_id'] = $v->campaign_id;
			$plan_datas['advertiser_id'] = $v->advertiser_id;
			$plan_datas['delivery_range'] = $v->delivery_range;
			$plan_datas['status'] = $v->status;
			$plan_datas['budget'] = $v->budget;
			$plan_datas['budget_mode'] = $v->budget_mode;
			$plan_datas['external_url'] = $v->external_url;
			$plan_datas['ad_create_time'] = $v->ad_create_time;
			$plan_datas['ad_modify_time'] = $v->ad_modify_time;
			$plan_datas['modify_time'] = $v->modify_time;
			$plan_datas['bid'] = $v->bid;
			$plan_datas['pricing'] = $v->pricing;
			$plan_datas['start_time'] = $v->start_time;
			$plan_datas['end_time'] = $v->end_time;
			$plan_datas['opt_status'] = $v->opt_status;
			$plan_datas['external_url'] = $v->external_url;
			$plan_datas['audit_reject_reason'] = $v->audit_reject_reason;
			$plan_datas['cpa_bid'] = $v->cpa_bid;
			$plan_datas['convert_id'] = $v->convert_id;
			$plan_datas['flow_control_mode'] = $v->flow_control_mode;
			// $plan_datas['pid'] = $v->id;
			// $plan_datas['pid'] = $v->id;

			$hasplan = Db::table('plan')->where('pid',$plan_datas['pid'])->find();
			if($hasplan){
				$res = Db::table('plan')->where('pid',$plan_datas['pid'])->update($plan_datas);
			}else{
				$res = Db::table('plan')->insert($plan_datas);
			}
			//dump($res);
			// if(!$res){
			// 	$this->error('数据错误，请重试');
			// }

		}
	}
		//dump($plan_datas);

	}

	// 获取转化id方法
	public function get_convert_id($external_url)
	{
		$advertiser_id = Cookie::get('advertiser_id');
		if (empty($advertiser_id)) {
			$this->error('没有授权','http://ta.bairun2.top');
		}
		//$external_url = 'http://fy009.aaaafirst.com/';
	//	dump($advertiser_id);
		$url = "https://ad.oceanengine.com/open_api/2/tools/ad_convert/select?advertiser_id=".$advertiser_id."&external_url=".$external_url;
		//$external_url = 
		$curl = new Curl();
		$token_data =  Db::table('token')->where('advertiser_id',$advertiser_id)->field('access_token')->find();
		$token = $token_data['access_token'];
		$datas = $curl->get($url,$token);
		
		$data = json_decode($datas);
		if($data->code != 0){
			$this->error('数据为空或数据出错');
		}
	//	dump($data);
		$list = $data->data->active_convert_list;
	//	dump($list);
		$convert_data = [];
		foreach ($list as $k => $v) {
			$convert_data['convert_id'] = $v->id;
			$convert_data['name'] = $v->name;

			$has_data = Db::table('active_convert')->where('convert_id',$v->id)->find();
			if($has_data){
				Db::table('active_convert')->where('convert_id',$v->id)->update($convert_data);
			}else{
				Db::table('active_convert')->insert($convert_data);
			}
		}
		//return $list->id

	}

	//ajax获取转化id
	public function ajax_convert_id()
    {
      if(request()->isAjax()){
              $external_url=input('geturl');
             // dump($external_url);
              $this->get_convert_id($external_url);
              $data = Db::table('active_convert')->select();
             //$res = 1;
              //dump($data);exit;
              if($data){
                return json($data);
              }else{
                return 'error';
              }
              
          }
    }

    //创建计划方法
    public function createplan($datas,$token)
    {
    	$url = "https://ad.oceanengine.com/open_api/2/ad/create/";
    	
    	$curl = new Curl();
    	$datas = $curl->post($url,$datas,$token);
    	$data = json_decode($datas);
    	//dump($data);
    	if($data->code == 0){
    		return 'success';
    	}else{
    		return $data->message;
    	}
    	


    }

    public function updateplan($datas,$token)
    {
    	$url = "https://ad.oceanengine.com/open_api/2/ad/update/";
    	$curl = new Curl();
    	$datas = $curl->post($url,$datas,$token);
    	$data = json_decode($datas);
    	//dump($data);
    	if($data->code == 0){
    		return 'success';
    	}else{
    		return $data->message;
    	}
    }



}

 ?>