<?php

$host=$_SERVER['HTTP_HOST'];

$ahost=explode('.', $host);

$dir=$ahost[0];

/**路径设置**/

define('CORE',ROOT.'/Core/');

define('VIEW',ROOT,'/View/');

define('MODEL',ROOT.'/Model/');

$actionpath=ROOT.'/Action/';

$dir!=='www'?define('ACTION',$actionpath.ucfirst($dir).'/'):defined('FOLDER')?define('ACTION',$actionpath.FOLDER.'/'):define('ACTION',$actionpath);

define('MEDIUM',ROOT.'/Medium/');

define('PLUGIN',ROOT.'/Plugin/');

define('EXTEND',ROOT.'/Extend/');

define('UNIT',ROOT.'/Unit/');

/***缓存设置***/

define('SMARTY',EXTEND.'smarty/');

define('TEMPLATE_DIR',ROOT.'/View');

define('CACHE_DIR',ROOT.'/cache');

define('COMPILE_DIR',ROOT.'/compile');

define('HTML_CACHE',false);

define('BRAND_CACHE',true);


/***域名地址设置**/

define('DOMAIN','www.taobao.com');

define('HOST','http://www.taobao.com');

define('USERURL','http://www.taobao.com');

/**常用跳转设置**/

define("SUCCESS_LOGIN_REDIREDT",USERURL.'/my/setting');

define("DEFAULT_HEADIMG_PATH",'/Static/default/images/headimg/');

define("DEFAULT_HEADIMG",'120/long.png');

define("DEFAULT_BIG_HEADIMG",'230/long.png');


/**COOKIE设置**/

define('COOKIE_DOMAIN','.taobao.com');

define('COOKIE_TIMEOUT',2592000);	#30天

define('COOKIE_ENCRYPT_KEY','tvrc4m_roam');

/**callback**/

define('OPEN_CALLBACK','http://www.taobao.com/login/callback');

/**图片上传**/

define('UPLOAD_LIMIT_SIZE',3145728);

define('UPLOAD_SAVE_PATH','E:/Doc/roam/imgs/');


/**导航条选中样式名**/
define('BAR_SELECTED','onfocus');

/**分享自定义常数**/

define('ITEM_CLICK_TIMESPAN',86400);	#一小时间隔，阅读数才会相应的加1

/**网站基本命名**/

define('SITE_NAME','');
//口号
define('SITE_SLOGAN','');
//目标
define('SITE_GOAL','');
