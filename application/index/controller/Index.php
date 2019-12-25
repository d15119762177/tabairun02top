<?php
namespace app\index\controller;
use \think\Request;
use \app\common\HttpClient\HttpClient;
use \app\common\HttpClient\HttpClient2;
use \think\Db;
use \think\Cookie;
class Index extends \think\Controller
{
    public function index()
    {
        $data = array();
        $data['app_id'] = '1651141812090893';
        $data['state'] = '访问成功';
        //$data['scope'] =
        $data['redirect_uri'] = 'http://tt.bairun2.top/index.php/index/api';

    	
         return $this->fetch('index',['data'=>$data]);
    }

    public function test()
    {
    	return view();
    }

    public function api()
    {
    	//echo PHP_INT_SIZE();
    	$data = Request::instance()->param(); //获取code值
    	
        $code = (string)$data['auth_code'];
        $url='https://ad.oceanengine.com/open_api/oauth2/access_token/';
     //  $url='http://ta.bairun2.top/index.php/index/index/test1/';
        $id = 1651141812090893;
        $id = (int)$id;
        $secret = "c8d72604f15fe2c17aa8b83c34a91c001c1c0462";
        //$id = $id & 0xffffffff;
        $post_data = array(
            "app_id" => 1651141812090893,
            "secret" => "b85604308566e4d4ff10eacb8723910a684ff1ea",
            "grant_type" => "auth_code",
            "auth_code" => $code
        );
         //$headers = ['Content-Type: application/json'];
         $data = $this->curlPost($url,$post_data); //获取token
         $data=json_decode($data,true);
         $data['data']['advertiser_id'] = (string)$data['data']['advertiser_id'];
         //dump($data['data']['advertiser_id']);
         $token_data['access_token'] = $data['data']['access_token']; 
         $token_data['refresh_token'] = $data['data']['refresh_token']; 
         $token_data['expires_in'] = $data['data']['expires_in']; 
         $token_data['refresh_token_expires_in'] = $data['data']['refresh_token_expires_in']; 
         $token_data['advertiser_id'] = $data['data']['advertiser_id']; 
         $token_data['advertiser_name'] = $data['data']['advertiser_name']; 
         $token_data['created_date'] = date('Y-m-d H:i:s',time());
         $token_data['updated_date'] = date('Y-m-d H:i:s',time());
         $hastoken = Db::table('token')->where('advertiser_id',$token_data['advertiser_id'])->find();
         $token_data['advertiser_id'] = (int)$token_data['advertiser_id'];
         Cookie::set('advertiser_id',$token_data['advertiser_id']);
         //dump(Cookie::get('advertiser_id'));exit;
        // dump($hastoken);
         if(empty($hastoken)){
         	$res = Db::table('token')->insert($token_data);
         	if($res){
         		$this->getAdvertising();
         	}else{
         		$this->error('出现未知错误');
         	}
         	$this->success('授权成功，正在跳转...', 'admin/index/index');
         }else{
         	$token_data['created_date'] = $hastoken['created_date'];
         	$res = Db::table('token')->where('advertiser_id',$token_data['advertiser_id'])->update($token_data);
         	if($res){
         		$this->getAdvertising();
         	}else{
         		$this->error('出现未知错误');
         	}
         	$this->success('授权成功，正在跳转...', 'admin/index/index');
         }

        // dump($res);
        // $res = Db::table('token')->insert($token_data);
        // dump($res);
         exit;

    }

    public function doapi()
    {
        //$num=input('m');                                     //获取前台提交的手机号
        //$url='https://test-ad.toutiao.com/open_api/2/campaign/create/';
        $url='http://ta.bairun2.top/index.php/index/index/test1/';
       // $url='http://tt.bairun2.top/index.php/index/index/test1?advertiser_id=1050773298624051&page=1&page_size=10';       //查询主机链接
        $post_data = [
            "advertiser_id" => "1050773298624051",
            "campaign_name" => "测试一组",
            "budget_mode" => "BUDGET_MODE_INFINITE",
            "landing_type" => "APP"
            //'Access-Token'=>'c1c7db3128fdf44d1bd25845b7b63fc37856f364',
            //'Content-Type' => 'application/json'
        ];
        $headers = ['Access-Token: c1c7db3128fdf44d1bd25845b7b63fc37856f364','Content-Type: application/json'];
        //$headers[] = 'Access-Token: c1c7db3128fdf44d1bd25845b7b63fc37856f364';
        //array_push($headers, "Authorization:APPCODE " . $appcode);//请求头
        $method='GET';                                               //请求方式
        $curl=curl_init();                                          //初始化一个curl句柄,用于获取其它网站内容
      //  curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "post"); //请求方式
        curl_setopt($curl, CURLOPT_URL, $url);   //请求url
        curl_setopt($curl, CURLOPT_POST, 1);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $post_data);
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers); //请求头
        curl_setopt($curl, CURLOPT_HEADER, true); 
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
       
        // if (1 == strpos("$".$url, "https://"))
        // {
        //     curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);//禁止curl验证对等证书
        //     curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);//不检查证书
        // }
        $res=curl_exec($curl);//执行查询句柄
        curl_close($curl);    //关闭查询连接
        $resu=json_decode($res,true);//将json数据解码为php数组
        //echo 'aa';
        dump($res);exit;
        // if($resu['showapi_res_body']['ret_code']==-1){          //返回错误码，查询失败
        //     return $this->error('没有查询结果，请重新输入','Index/index');
        // }else{
        //     $this->assign('num',$num);           //将查询手机号写入模板
        //     $this->assign('res',$resu);          //将查询结果php数组写入模板
        //     return $this->fetch('index');
        // }
    }


    public function test1()
    {
        $data = Request::instance()->header();
        
           // $data = $_POST;
        //echo $data;exit;
        return json($data);
        return $data;
           dump($data);exit;
        if (Request::instance()->isPost()){
            $data = Request::instance()->param();
            $data['1'] = 1;
            file_put_contents('common/1.txt', $data);
            return json($data);
            }else{
                return 'false';
            }
       // dump($data);
        // if(!empty($data)){
        //     return json($data);
        // }else{
      //  return json($data);
        // }
        
       // 
       
    }


    public function test2()
    {
        $url      ="http://tt.bairun2.top/index.php/index/index/test1/";
        $push = array(
                    'title'     => 'aaaaaaaa',
                    'content'   => 'bbbb',
                    'id'        => '11111111',
            );
        $header[] = "Content-type: application/x-www-form-urlencoded";
        $response= $this->http($url,$push,'POST',$header);
        dump($response);
    }

   

    public function curlPost($url, $data) 
    {

         //初使化init方法
         $ch = curl_init();

         //指定URL
         curl_setopt($ch, CURLOPT_URL, $url);

         //设定请求后返回结果
         curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

         //声明使用POST方式来进行发送
         curl_setopt($ch, CURLOPT_POST, 1);

         //发送什么数据呢
         curl_setopt($ch, CURLOPT_POSTFIELDS, $data);


         //忽略证书
         curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
         curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);

         //忽略header头信息
         //curl_setopt($ch, CURLOPT_HEADER, 0);
        // curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
         //设置超时时间
         curl_setopt($ch, CURLOPT_TIMEOUT, 10);

         //发送请求
         $output = curl_exec($ch);

         //关闭curl
         curl_close($ch);

         //返回数据
         return $output;
       
    }

    public function h2()
    {
        //  $push = array(
        //             'title'     => 'aaaaaaaa',
        //             'content'   => 'bbbb',
        //             'id'        => '11111111',
        //     );
        // httpClient2::init($http2, array( 'debugging' => true , 'userAgent' => 'MSIE 15.0' ));
        // // $http2 = new HttpClient2();
        // $http2->post('http://ta.bairun2.top/index.php/index/index/test1', 'name=123');
        // dump($http2->buffer);
        $data = array(
          'test'=>'bar',
          'baz'=>'boom',
          'site'=>'www.nimip.com',
          'name'=>'nimip.com');
        $data = http_build_query($data);
        //$postdata = http_build_query($data);
        $options = array(
          'http' => array(
            'method' => 'POST',
            'header' => 'Content-type:application/x-www-form-urlencoded',
            'content' => $data,
            'timeout' => 60 // 超时时间（单位:s）
          )
        );
        $url = "http://ta.bairun2.top/index.php/index/index/test1";
        $context = stream_context_create($options);
        $result = file_get_contents($url, false, $context);
        echo $result;

    }

    public function curlGet11($url,$headers)
    {
    	         //初使化init方法
         $ch = curl_init();
         $method='GET';  
         //指定URL
         curl_setopt($ch, CURLOPT_URL, $url);

         //设定请求后返回结果
         curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

         //声明使用POST方式来进行发送
        // curl_setopt($ch, CURLOPT_POST, 1);

         //发送什么数据呢
         //curl_setopt($ch, CURLOPT_POSTFIELDS, $data);

         curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);
         //忽略证书
         curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
         curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);

         //忽略header头信息
         curl_setopt($ch, CURLOPT_HEADER, 0);
         curl_setopt($ch, CURLOPT_HTTPHEADER,$headers);
         curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
   		 curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
         //curl_setopt($ch, CURLOPT_HEADER, 0);
        // curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
         //设置超时时间
         curl_setopt($ch, CURLOPT_TIMEOUT, 10);
        // curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);

         //发送请求
         $output = curl_exec($ch);

         //关闭curl
         curl_close($ch);

         //返回数据
         return $output;
    }

    public function getAdvertising()
    {
    	$advertiser_id = Cookie::get('advertiser_id');
       // dump($advertiser_id);exit;
    	$token = Db::table('token')->where('advertiser_id',$advertiser_id)->field('access_token')->find();
    	$url = "https://ad.oceanengine.com/open_api/2/campaign/get?advertiser_id=".$advertiser_id."&page=1&page_size=50";

    	$datas = $this->curlget1($url,$token['access_token']);
    	//print_r('<pre>');
    	$data = json_decode($datas);
       // dump($data);exit;
        if($data->message != 'OK' ){
            $this->error('http://ta.bairun2.top','获取数据出错');
        }
     	$list = $data->data->list;
     	//dump($list);exit;
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
			//$push_data['budget'] = $v->budget;
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

    public function curlget1($url,$token)
    {
 
     $header = array(
      // 'Accept: application/json',
       'Access-Token: '.$token,
     );
    $curl = curl_init();
    //设置抓取的url
    curl_setopt($curl, CURLOPT_URL, $url);
    //设置头文件的信息作为数据流输出
    curl_setopt($curl, CURLOPT_HEADER, 0);
    // 超时设置,以秒为单位
    curl_setopt($curl, CURLOPT_TIMEOUT, 1);
 
    // 超时设置，以毫秒为单位
    // curl_setopt($curl, CURLOPT_TIMEOUT_MS, 500);
 	curl_setopt($curl, CURLOPT_ENCODING, "");
    // 设置请求头
    curl_setopt($curl, CURLOPT_HTTPHEADER, $header);
    //设置获取的信息以文件流的形式返回，而不是直接输出。
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
    curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
    //curl_setopt($curl, CURLOPT_HTTPHEADER, array('Accept-Encoding: gzip, deflate'));
    //执行命令
    $data = curl_exec($curl);
 
    // 显示错误信息
    if (curl_error($curl)) {
        print "Error: " . curl_error($curl);
    } else {
        // 打印返回的内容
        curl_close($curl);
        return  $data;
        
     }
    }

    // public function get_advertising_data()
    // {
        
    // }

	// public function http1()
	// {
	// 	$token = Db::table('token')->where('advertiser_id','1630771692455939')->field('access_token')->find();
	// 	$token = $token['access_token'];
	// 	$header = array(
 //       'Accept: application/json',
 //       'Access-Token: '.$token,
 //     );
	// 	$data = array(
	// 		'advertiser_id'=> 1630771692455939,
	// 		'page'=>1,

	// 	);

	// 	$url = "https://ad.oceanengine.com/open_api/2/campaign/get/";
	// 	$url = "http://ta.bairun2.top/index.php/index/index/test1/";
	// 	$http = new HttpClient();
	// 	$http->setHeader($header);
	// 	$http->setBody($data);
	// 	$http->setUrl($url);
	// 	$datas = $http->post();
	// 	//$http2->post()
	// 	var_dump($datas);


	// }

		
	// public function dotest()
	// {
	// 	$url = "https://ad.oceanengine.com/open_api/2/campaign/get?advertiser_id=1630771692455939&page=1";
	// 	$token = Db::table('token')->where('advertiser_id','1630771692455939')->field('access_token')->find();
	// 	$token = $token['access_token'];
	// 	$headers = array(
 //       'Accept: application/json',
 //       'Access-Token: '.$token,
 //     );
	// 	$datas = $this->curlGet($url,$headers);
	// 	dump($datas);
	// }


}
