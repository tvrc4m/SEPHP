<?php

/**
*视图层
*/
class View{
	
	public static $_instance=null;
	
	protected $view=null;

	protected $title;

	protected $keyword;

	protected $description;
	
	public function __construct(){
		$this->init();
		$this->init_REQUEST();
	}
	
	/**
	*	单例模式
	*/
	public static function Instance(){
		if(self::$_instance==null){
			$c=get_called_class();
			self::$_instance=new $c;
			self::$_instance->init();
		}
		return self::$_instance;
	}
	/**
	*	初始化smarty类
	*/
	private function init(){
		include_once(SMARTY.'/Smarty.class.php');
		$this->view=new Smarty;
		$this->view->setTemplateDir(TEMPLATE_DIR);
		$this->view->setCacheDir(CACHE_DIR);
		$this->view->setCompileDir(COMPILE_DIR);
		$this->view->caching=HTML_CACHE;
		//检测登录cookie
		P('CheckLogin');
	}

	private function init_REQUEST(){

		P('SecurityFilter');

		$page=$_GET['page'];

		(empty($page) || $page<1) && $_GET['page']=1;

		$page>100 && $_GET['page']=100;
		
	}


	private function stripslashes_array(&$array) {
		while(list($key,$var) = each($array)) {
			if ($key != 'argc' && $key != 'argv' && (strtoupper($key) != $key || ''.intval($key) == "$key")) {
				is_string($var) && $array[$key] = stripslashes($var);
				is_array($var) && $array[$key] = stripslashes_array($var);
			}
		}
		return $array;
	}
	/**
	**	向页面赋值
	*/
	public function assign($array){
		foreach($array as $k=>$v){
			$this->view->assign($k,$v);
		}
	}

	/**
	*	显示页面
	*/
	public function display($tpl,$cache_id=null,$compile_id=null,$suffix='.tpl'){
		
		$this->assign(array('pageTitle'=>$this->title,'pageKeyword'=>$this->keyword,'pageDescription'=>$this->description));

		$this->view->display($tpl.$suffix,$cache_id,$compile_id);
	}

	public function fetch($tpl,$cache_id=null,$compile_id=null,$suffix='.tpl'){
		
		return $this->view->fetch($tpl.$suffix,$cache_id,$compile_id);
	}
}