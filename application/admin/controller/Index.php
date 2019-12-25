<?php 
namespace  app\admin\controller;

use \app\common\getadv;
use \think\Request;
use \think\Db;
use \think\Cookie;
//use \app\index\controller\index;
use \app\common\curl;

class Index extends \think\Controller
{
	public function index()
	{
		$advertiser_id = Cookie::get('advertiser_id');//获取广告主id
		if (empty($advertiser_id)) {
			$this->error('没有授权','http://ta.bairun2.top');
		}
		//$advertiser_id = Cookie::get('advertiser_id');
		//获取页码
		$page_data = Request::instance()->param();
		if(empty($page_data) && $advertiser_id){
			$data = new Getadv();
			$data->getAdvertising();//获取最新广告组数据
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

		if(!empty($page_data['input_page'])){
				$page_data['page_num'] = $page_data['input_page'];
			}
		$sum_data = Db::table('advertising')->where('advertiser_id',$advertiser_id)->count();
		$page_sum = ceil($sum_data / 15);
		if($page_data['page_num'] > $page_sum){
			$page_data['page_num'] = $page_sum;
					
			}

		if($page_data){
			$data = Db::table('advertising')->where('advertiser_id',$advertiser_id)->order('campaign_modify_time desc')->page($page_data['page_num'],15)->select();
		}else{
			$data = Db::table('advertising')->where('advertiser_id',$advertiser_id)->order('campaign_modify_time desc')->page(1,15)->select();
		}
		// if(empty($data)){
		// 	$page_data['page_num'] = $page_data['page_num'] - 1;
		// 	$data = Db::table('advertising')->page($page_data['page_num'],5)->select();
		// }
		//dump(count($data));exit;

		$count = count($data);
		//dump($sum_data);exit;
		foreach ($data as $k => $v) {
			$name = Db::table('landing_type')->where('id',$v['landing_type'])->field('type_name')->find();
			$v['landing_type'] = $name['type_name']; 
			$data[$k] = $v;
		}
		//dump($data);
				$this->assign('data', $data);
				$this->assign('page', $page_data['page_num']);
				$this->assign('sum', $sum_data);
				$this->assign('count', $count);
         return $this->fetch('index');
	}

	public function add()
	{
		$data = Db::table('landing_type')->select();
		// foreach ($data as $k => $v) {
		// 	$name = Db::table('landing_type')->where('id',$v['landing_type'])->field('type_name')->find();
		// 	$data[$k] = $v;
		// 	$data[$k]['name'] = $name['type_name'];
		// }
		$advertiser_id = Cookie::get('advertiser_id');
		if (empty($advertiser_id)) {
			$this->error('没有授权','http://ta.bairun2.top');
		}
         return $this->fetch('add',['data'=>$data,'advertiser_id'=>$advertiser_id]);
	}

	public function doadd()
	{
		$advertiser_id = Cookie::get('advertiser_id');//获取广告主id
		if (empty($advertiser_id)) {
			$this->error('没有授权','http://ta.bairun2.top');
		}
		$data = Request::instance()->param();
		//dump($data);//exit;
		$datas['budget_mode'] = 'BUDGET_MODE_DAY';
		//$datas['operation'] = 'enable';
		//$datas['modify_time'] = time();
		//$datas['created_time'] = date('Y-m-d H:i:s',time());
		//$datas['updated_time'] = date('Y-m-d H:i:s',time());
		$datas['campaign_name'] = $data['name'];
		$datas['advertiser_id'] = $advertiser_id;
		$datas['landing_type'] = $data['landing_type'];
		
		$datas['budget'] = (int)$data['budget'];
		if (empty($data['budget'])) {
			$datas['budget'] = '';
			$datas['budget'] = (int)$datas['budget'];
			$datas['budget_mode'] = 'BUDGET_MODE_INFINITE';
		}

		//$datas['campagn_name'] = $this->unicode_encode($datas['campagn_name']);
		$landing_type_data = Db::table('landing_type')->find($datas['landing_type']);
		$datas['landing_type'] = $landing_type_data['type'];
		//$datas = json($datas);
		//dump($datas);//exit;
		$token_data = Db::table('token')->where('advertiser_id',$advertiser_id)->field('access_token')->find();//获取token
		$token = $token_data['access_token'];
		$url = "https://ad.oceanengine.com/open_api/2/campaign/create/";
		$curl = new Curl();
		$res = $curl->post($url,$datas,$token);
		$res_data = json_decode($res);
		$datas['campaign_id'] = $res_data->data->campaign_id;
		$datas['campaign_id'] = (string)$datas['campaign_id'];
		//dump($res);exit;
		$res = Db::table('advertising')->insert($datas);
		if ($res && !empty($data['next'])) {
			$this->success('添加成功','plan/add');
		}else if($res){
			$this->success('添加成功');
		}else{
			$this->error('添加失败');
		}
		// if (!empty($data['next'])) {
		// 	return $this->fetch('plan/add');
		// }
		// if (!empty($data['goon'])) {
		// 	dump($data);
		// 	return $this->fetch('plan/add');
		// }
		//dump($data);
	}

	public function edit()
	{
		$id = Request::instance()->param('id');
		$data = Db::table('advertising')->where('id',$id)->find();
		//dump($data);exit;
		return $this->fetch('index/edit',['data'=>$data]);
	}

	public function update()
	{
		$data = Request::instance()->param();
		//$datas['budget_mode'] = 'BUDGET_MODE_DAY';
		//$datas['operation'] = 'enable';
		// $datas['modify_time'] = time();
		// $datas['created_time'] = date('Y-m-d H:i:s',time());
		
		//$datas['updated_time'] = date('Y-m-d H:i:s',time());
		$datas['advertiser_id'] = (int)$data['advertiser_id'];
		$datas['budget_mode'] = $data['budget_mode'];
		$datas['campaign_name'] = $data['campaign_name'];
		$datas['campaign_id'] = (int)$data['campaign_id'];
		$datas['budget'] = $data['budget'];
		$datas['modify_time'] = $data['modify_time'];
		if (empty($data['budget'])) {
			$datas['budget'] = '';
		}
		$datas['budget'] = $data['budget'];

		 //dump($datas);//exit;


		 $url = "https://ad.oceanengine.com/open_api/2/campaign/update/";
		 $token_data = Db::table('token')->where('advertiser_id',$datas['advertiser_id'])->field('access_token')->find();//获取token
		 $token = $token_data['access_token'];
		 $curl = new Curl();
		 $res = $curl->post($url,$datas,$token);
		// dump($res);exit;
		 $res_sql = Db::table('advertising')->where('id',$data['id'])->update($datas);
		if ($res && $res_sql) {
			$this->success('修改成功','index');
		}else{
			$this->error('修改失败');
		}

	}
	public function del()
	{
		$id = Request::instance()->param('id');
		$res = Db::table('advertising')->where('id',$id)->delete();
		if ($res) {
			$this->success('删除成功');
		}else{
			$this->error('删除失败');
		}
		//dump($id);
	}

	public function exit()
	{
		Cookie::set('advertiser_id','');//消除Cookie
		$this->redirect('http://ta.bairun2.top');//重定向

	}
}

 ?>