<?php

function C($key,$value=''){
	if(is_null($value)) setcookie($key,'',time()-3600,'/',COOKIE_DOMAIN);
	elseif(empty($value)) return $_COOKIE[$key];
	else setcookie($key,$value,time()+COOKIE_TIMEOUT,'/',COOKIE_DOMAIN);
}

/**
*	存储或提取会话数据----当value为空时，为提取数据。不为空，则进行保存。
*	@param key string 键
*	@param value 字符串或数字等简单类型
*/
function S($key,$value=''){
	if(is_null($value)) unset($_SESSION[$key]);
	elseif(empty($value)) return $_SESSION[$key];
	else $_SESSION[$key]=$value;
}
/**
*	调用插件	
**/
function P($class,$data=array()){
	$classname=ucfirst($class).'Plugin';
	$file=PLUGIN.$class.'.plugin.php';
	!is_file($file) && exit('文件不存在.请检查路径');
	include_once($file);
	$instance=new $classname;
	return $instance->run($data);
}
