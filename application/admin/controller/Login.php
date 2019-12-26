<?php 
namespace  app\admin\controller;

use \think\Validate;

class Login extends \think\Controller
{
	public function login()
	{
		
         return $this->fetch('login',['abc'=>'thinkphp']);
	}

	public function dologin()
	{
		
         return 'aaa';
	}
}

 ?>