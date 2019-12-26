<?php 
namespace app\common;

	/**
	 * 
	 */
class curlGet extends \think\Controller
 {
		
    public function get($url,$token)
    {
 
     $header = array(
       'Accept: application/json',
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

    public function post($url, $data,$token) 
    {

    	$header = array(
         'Accept: application/json',
     	 'Access-Token: '.$token,
    	 );

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
   		 curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
         //忽略header头信息
         curl_setopt($ch, CURLOPT_ENCODING, "");
         //设置头文件的信息作为数据流输出
   		 curl_setopt($ch, CURLOPT_HEADER, 0);
         //curl_setopt($ch, CURLOPT_HEADER, 0);
         curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
         //设置超时时间
         curl_setopt($ch, CURLOPT_TIMEOUT, 10);

         //发送请求
         $output = curl_exec($ch);

         //关闭curl
         curl_close($ch);

         //返回数据
         return $output;
       
    }
}

 ?>