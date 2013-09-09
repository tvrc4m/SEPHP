<?php

class LoginAction extends Action{
	
	public function index(){
		
		P('CheckLogin') && go(USERURL);
		
		$furl=empty($_GET['furl'])?$_SERVER['HTTP_REFERER']:$_GET['furl'];

		$this->assign(array('furl'=>urlencode($furl)));

		$this->title="欢迎登录!GOOD分享者";

		$this->display('Login/index');
	}

	public function needlogin(){

		$this->display('Login/needlogin');

	}

	/**
	**	用户进行登录，如果已登录，则直接跳转回个人中心页
	*/

	public function local(){

		$callback=$_REQUEST['jsonpcallback'];

		echo $callback.'('.login('loginLocal').')';;

	}
	
}