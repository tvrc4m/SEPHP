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

	public function ajax(){
		M::common('login',array('name'=>'teric.wei'));
	}
	
}