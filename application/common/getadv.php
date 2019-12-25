<?php 
namespace  app\common;

use \think\Request;
use \think\Db;
use \think\Cookie;
use \app\common\curl;

class Getadv extends \think\Controller
{
	public function getAdvertising()
    {
    	$advertiser_id = Cookie::get('advertiser_id');
    	$token = Db::table('token')->where('advertiser_id',$advertiser_id)->field('access_token')->find();
    	$url = "https://ad.oceanengine.com/open_api/2/campaign/get?advertiser_id=".$advertiser_id."&page=1&page_size=50";
    	$curl = new Curl();
    	$datas = $curl->get($url,$token['access_token']);
    //	print_r('<pre>');
    	$data = json_decode($datas);
        //dump($data);exit;
     	$list = $data->data->list;
     	//dump($list);
     	$push_data=[];
     	foreach ($list as $k => $v) {
     		$v->campaign_id = (string)$v->campaign_id;
     		//dump($v->campaign_id);
			$push_data['budget_mode'] = $v->budget_mode;
			$push_data['status'] =  $v->status;
			$push_data['campaign_create_time'] =$v->campaign_create_time;
			$push_data['campaign_modify_time'] =$v->campaign_modify_time;
			$push_data['created_time'] = date('Y-m-d H:i:s',time());
			$push_data['updated_time'] = date('Y-m-d H:i:s',time());
			$push_data['advertiser_id'] = $v->advertiser_id;
			$push_data['landing_type'] = $v->landing_type;
			$push_data['campaign_name'] = $v->name;
			$push_data['campaign_id'] = $v->campaign_id;
			$push_data['budget'] = $v->budget;
			$push_data['modify_time'] = $v->modify_time;
			//dump($push_data);
            $hasdata = Db::table('advertising')->where('campaign_id',$push_data['campaign_id'])->find();
            if($hasdata){
                $res = Db::table('advertising')->where('campaign_id',$push_data['campaign_id'])->update($push_data);
            }else{
                $res = Db::table('advertising')->insert($push_data);
            }
				if(!$res){
					$this->error('获取数据失败');
				}
     		}
    }
}