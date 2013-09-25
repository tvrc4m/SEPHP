<?php
/*
 * 控制层
 */
class Action extends View{

	public function __construct(){

		parent::__construct();
		
		$this->_init();
		
	}

	protected function _init(){
		
	}
	
}

class UAction extends View{

	public function __construct(){

		parent::__construct();
		
		$this->_init();
		
	}

	public function _init(){
		
		$UID=S('UID');
		
		if(empty($UID)){

			$furl=urlencode('http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']);

			empty($furl)?go(HOST.'/login.html'):go(HOST."/login.html?furl={$furl}");

		}

		$requesturl=$_SERVER['REQUEST_URI'];

		if($requesturl=='/' || !$requesturl){

			//header("Location:".USERURL);
			
		}

	}
}
