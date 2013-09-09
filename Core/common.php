<?php

/**
**	实例化Mongo模型类---实例保存在全局静态数组中
*	@param name string 模型名 
*	@return 实例
**/
function M($name,$fold){
	static $_model=array();
	$name=ucfirst($name);
	if(in_array($name,array_keys($_model))) return $_model[$name];
	$className=$name.'Mongo';
	$file=MODEL.'Mongo/'.$fold.'/'.$className.'.class.php';
	!is_file($file) && exit('不存在此model，请检查模块路径');
	include_once($file);
	$instance=$className::Instance();
	$_model[$name]=&$instance;
	return $instance;
}
function MU($name){
	return M($name,'User');
}
/**
**	实例化MySQL模型类---实例保存在全局静态数组中
*	@param name string 模型名 
*	@return 实例
**/
function D($name){
	static $_model=array();
	$name=ucfirst($name);
	if(in_array($name,array_keys($_model))) return $_model[$name];
	$className=$name.'Mysql';
	$file=MODEL.'Mysql/'.$className.'.class.php';
	!is_file($file) && exit('不存在此model，请检查模块路径');
	include_once($file);
	$instance=$className::Instance();
	$_model[$name]=&$instance;
	return $instance;	
}
/**
**	实例化控制器类---实例保存在全局静态数组中
*	@param name string 控制器名 
*	@return 实例
**/
function A($name){
	static $_action = array();
    $name=ucfist($name);
	if(in_array($name,array_keys($_action))) return $_action[$name];
	$actionName=$name.'Action';
	$file=ACTION.$actionName.'.class.php';
	!is_file($file) && exit('不存在此action，请检查控制器路径');
	$instance=new $actionName;
	$_action[$name]=&$instance;
	return $instance;
}

/*
*	存储或提取缓存数据----当data为空时，为提取数据。不为空，则进行保存。
*	@param key string 键
*	@param data 任意类型
*	@param expiration int 缓存时间
*/
function MC($key,$data='',$expiration=3600){
	$cache=MemoryCache::Instance();
	print_r($cache);
	if(!empty($data)){
		$cache->set($key,$data,$expiration);
	}else{
		return $cache->get($key);
	}
}
function C($key,$value=''){
	if(is_null($value)) setcookie($key,'',time()-3600,'/',COOKIE_DOMAIN);
	elseif(empty($value)) return $_COOKIE[$key];
	else setcookie($key,$value,time()+COOKIE_TIMEOUT,'/',COOKIE_DOMAIN);
}

/*
*	存储或提取会话数据----当value为空时，为提取数据。不为空，则进行保存。
*	@param key string 键
*	@param value 字符串或数字等简单类型
*/
function S($key,$value=''){
	if(is_null($value)) unset($_SESSION[$key]);
	elseif(empty($value)) return $_SESSION[$key];
	else $_SESSION[$key]=$value;
}

function SU($userinfo){
	if(empty($userinfo)) return 0;
	$uid=$userinfo['_id'];
	S('USERINFO',$userinfo);
	S('UID',$uid);
	S('UNAME',$userinfo['uname']);
	S('HEADIMG',$userinfo['headimg']);
	C('uid',encrypt($uid->__toString()));
	return 1;
}

function P($class,$data=array()){
	$classname=$class.'Plugin';
	$file=PLUGIN.$class.'.plugin.php';
	!is_file($file) && exit('文件不存在.请检查路径');
	include_once($file);
	$instance=new $classname;
	return $instance->run($data);
}
/**I=>invoke调用**/
function IM($class,$fold,$data=array()){
	$file=MEDIUM.'Mongo/'.$fold.'/'.$class.'.php';
	//echo $file;
	!is_file($file) && exit('文件不存在.请检查路径');
	include_once($file);
	$instance=new $class;
	return $instance->run($data);
}
function login($class,$data=array()){
	return IM($class,'Login',$data);
}
function register($class,$data=array()){
	return IM($class,'Register',$data);
}
function user($class,$data=array()){
	return IM($class,'User',$data);
}