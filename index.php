<?php
//设置编码
header('Content-type:text/html;charset=utf-8');

error_reporting(E_ALL & ~E_NOTICE);

date_default_timezone_set('Asia/Shanghai');

define("ROOT",dirname(__FILE__));

$folder=$_REQUEST['f'];

!empty($folder) && define('FOLDER',ucfirst($folder));

include_once(ROOT.'/Core/config.php');

ini_set('session.cookie_domain',COOKIE_DOMAIN);

#session_save_path(ROOT.'/session');

session_start();

include_once(CORE.'function.php');
include_once(CORE.'common.php');
include_once(CORE.'DB.class.php');
include_once(CORE.'SE.class.php');
include_once(CORE.'Cache.class.php');
include_once(CORE.'Model.class.php');
include_once(CORE.'View.class.php');
include_once(CORE.'Action.class.php');
include_once(CORE.'Medium.class.php');
include_once(CORE.'Plugin.class.php');
include_once(CORE.'Unit.class.php');

!isset($_REQUEST['app']) && $_REQUEST['app']='index';

$app=$_REQUEST['app'];

$method=isset($_REQUEST['act'])?$_REQUEST['act']:'index';

$appName=ucfirst($app).'Action';

$appFile=ACTION.$appName.'.class.php';

!file_exists($appFile) && exit('指定文件不存在');

include_once($appFile);

$appInstance=new $appName;

!method_exists($appInstance,$method) && exit;

try{
	
	$appInstance->$method();

}
catch(Exception $e){

	exit;
	
}
