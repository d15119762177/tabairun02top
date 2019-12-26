<?php 
namespace  app\admin\controller;

use \think\Request;
use \think\Db;
use \think\Cookie;
use \app\common\curl;

class Ajax extends \think\Controller
{
	
  	public function index()
  	{
  		if(request()->isAjax()){
              $name=input('name');
              $name=(string)$name;
              $res = Db::table('ideas_tag')->insert(['name'=>$name]);
             //$res = 1;
              if($res){
              	return json('success');
              }else{
              	return json('error');
              }
              
          }
  	}

    public function ideas_type()
    {
      if(request()->isAjax()){
              $id=input('id');
              $id=(int)$id;
              $name = Db::table('ideas_type')->where('id',$id)->field('ideas_type_name')->find();
             //$res = 1;
              if($name){
                return json($name);
              }else{
                return json('error');
              }
              
          }

    }

    public function last_page()
    {
      if(request()->isAjax()){
              $id=input('num');
              $id=(int)$id;
              $data = Db::table('advertising')->page($id,5)->select();
             //$res = 1;
              if($data){
                return json($data);
              }else{
                return json('error');
              }
              
          }

    }

    public function get_landing_type()
    {
      if(request()->isAjax()){
              $id=input('pid');
              $id=(int)$id;
              $campaign_id = Db::table('plan')->where('pid',$id)->field('campaign_id')->find();
            //  dump($campaign_id);
              $type = Db::table('advertising')->where('campaign_id',$campaign_id['campaign_id'])->field('landing_type')->find();
             // dump($type);
              $type_name = Db::table('landing_type')->where('type',$type['landing_type'])->find();
              
             // dump($type_name);
             //$res = 1;
              if($type_name){
                return json($type_name);
              }else{
                return json('error');
              }
              
          }

    }

    //获取二级行业
    public function get_industry_second()
    {
      if(request()->isAjax()){
              $id=input('id');
              $id=(int)$id;
              $data = Db::table('ideas_industry')->where('first_industry_id',$id)->where('level',2)->select();

               if($data){
                 return json($data);
               }else{
                 return json('error');
               }
              
          }

    }

    //获取三级行业
    public function get_industry_third()
    {
      if(request()->isAjax()){
              $id=input('id');
              $id=(int)$id;
              $data = Db::table('ideas_industry')->where('second_industry_id',$id)->where('level',3)->select();

               if($data){
                 return json($data);
               }else{
                 return json('error');
               }
              
          }
    }

    public function update_status()
    {
      if(request()->isAjax()){
              $data = Request::instance()->param();
             // dump($data);
             // dump($data['campaign_ids']);
              //exit;
              $cid = [];
              foreach ($data['campaign_ids'] as $k => $v) {
                    $cid[$k] = (int)$v;
              }
              //dump($cid);exit;
              $advertiser_id = Cookie::get('advertiser_id');//获取广告主id
              $advertiser_id = (int)$advertiser_id;
                if (empty($advertiser_id)) {
                  $this->error('没有授权','http://ta.bairun2.top');
                }
              $token_data = Db::table('token')->where('advertiser_id',$advertiser_id)->field('access_token')->find();//获取token
              $token = $token_data['access_token'];
              $url = "https://ad.oceanengine.com/open_api/2/campaign/update/status/";
              $curl = new Curl();
              // $datas['advertiser_id'] = (int)$data['advertiser_id'];
              // $datas['opt_status'] = $data['opt_status'];
              // $datas['campaign_ids'] = $cid;
              $datas = [
                'advertiser_id'=>(int)$advertiser_id,
               // 'campaign_ids'=>[1652251802529838],
                'campaign_ids' => json_encode($cid),
                'opt_status'=>$data['opt_status']

              ];
             // dump($datas);//exit;
              $res_data = $curl->post($url,$datas,$token);
              $res_datas = json_decode($res_data);
           // dump($res_datas);

              $data = [
                'message'=> $res_datas->message,
                'code'=> $res_datas->code,
                'data'=> $res_datas->data,
              ] ;
             // dump($data);

               if($data){
                 return $res_data;
               }else{
                 return json_decode('error');
               }
              
          }
    }

    public function update_plan_status()
    {
      if(request()->isAjax()){
              $data = Request::instance()->param();
             // dump($data);
             // dump($data['campaign_ids']);
              //exit;
              $cid = [];
              foreach ($data['pid'] as $k => $v) {
                    $cid[$k] = (int)$v;
              }
              //dump($cid);exit;
              $advertiser_id = Cookie::get('advertiser_id');//获取广告主id
              $advertiser_id = (int)$advertiser_id;
                if (empty($advertiser_id)) {
                  $this->error('没有授权','http://ta.bairun2.top');
                }
              $token_data = Db::table('token')->where('advertiser_id',$advertiser_id)->field('access_token')->find();//获取token
              $token = $token_data['access_token'];
              $url = "https://ad.oceanengine.com/open_api/2/ad/update/status/";
              $curl = new Curl();
              // $datas['advertiser_id'] = (int)$data['advertiser_id'];
              // $datas['opt_status'] = $data['opt_status'];
              // $datas['campaign_ids'] = $cid;
              $datas = [
                'advertiser_id'=>(int)$advertiser_id,
               // 'campaign_ids'=>[1652251802529838],
                'ad_ids' => json_encode($cid),
                'opt_status'=>$data['opt_status']

              ];
              dump($datas);//exit;
              $res_data = $curl->post($url,$datas,$token);
              $res_datas = json_decode($res_data);
           // dump($res_datas);

              $data = [
                'message'=> $res_datas->message,
                'code'=> $res_datas->code,
                'data'=> $res_datas->data,
              ] ;
             // dump($data);

               if($data){
                 return $res_data;
               }else{
                 return json_decode('error');
               }
              
          }
    }

    public function losts_upload()
    {
       $advertiser_id = Cookie::get('advertiser_id');
       if(request()->isAjax()){
          $data = Request::instance()->param(); 
         // $datas = json_decode($data);
          //dump($data);
          $token_data = Db::table('token')->where('advertiser_id',$advertiser_id)->field('access_token')->find();//获取token
          $token = $token_data['access_token'];
          $url = "https://ad.oceanengine.com/open_api/2/campaign/create/";
          $curl = new Curl();
          
          $up_data = [];
          $i = 0;
           foreach($data['data'] as $k=>$v){
              $num = $v['id'];
              $up_data['advertiser_id'] = (int)$advertiser_id;
              $up_data['campaign_name'] = $v['campaign_name'];
              $up_data['budget_mode'] = $v['budget_mode'];
              $up_data['landing_type'] = $v['type'];
              if($v['budget_mode_name']=='不限'){
                $up_data['budget'] = '';
              }else{
                $up_data['budget'] = (int)$v['budget'];
              }
              $res = $curl->post($url,$up_data,$token);
              $res_data = json_decode($res);
              if($res_data->code != 0){
                $error[$i]['id'] = $num;
                $error[$i]['message'] = $res_data->message;
                if($error[$i]['message'] == '广告组不能重复'){
                  $err = '广告组不能重复';
                  return $err;
                }
                $error[$i]['campaign_name'] = $up_data['campaign_name'];
                $i++;
                continue;
              }
              //dump($res_data);exit;
           }
           //dump($error);exit;
          // $error['num'] = count($error);
          return $error;
           
       }
    }

}