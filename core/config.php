<?php

/**路径设置**/

define('CORE',ROOT.'/core/');

define('VIEW',ROOT,'/view/');

define('MODEL',ROOT.'/model/');

define('ACTION',ROOT.'/action/');

define('MEDIUM',ROOT.'/medium/');

define('PLUGIN',ROOT.'/plugin/');

define('EXTEND',ROOT.'/extend/');

define('UNIT',ROOT.'/unit/');

/***缓存设置***/

define('SMARTY',EXTEND.'smarty/');

define('TEMPLATE_DIR',ROOT.'/view');

//define('CACHE_DIR',ROOT.'/cache');

define('CACHE_DIR','/var/log/cache');

define('COMPILE_DIR','/var/log/compile');

define('HTML_CACHE',false);

define('BRAND_CACHE',true);

define('CU_CACHE',true);
/***域名地址设置**/

define('DOMAIN','www.fastty.com');

define('HOST','http://www.fastty.com');

define('USERURL','http://www.fastty.com');

/**常用跳转设置**/

define("SUCCESS_LOGIN_REDIREDT",USERURL.'/my/setting');

define("DEFAULT_HEADIMG_PATH",'/Static/default/images/headimg/');

define("DEFAULT_HEADIMG",'120/long.png');

define("DEFAULT_BIG_HEADIMG",'230/long.png');


/**COOKIE设置**/

define('COOKIE_DOMAIN','.fastty.com');

define('COOKIE_TIMEOUT',2592000);	#30天

define('COOKIE_ENCRYPT_KEY','tvrc4m_roam');

/**callback**/

define('OPEN_CALLBACK','http://www.fastty.com/login/callback');

/**图片上传**/

define('UPLOAD_LIMIT_SIZE',3145728);

define('UPLOAD_SAVE_PATH','E:/Doc/roam/imgs/');

/**Sphinx-Coreseek设置**/
define('SE_HOST','127.0.0.1');
define('SE_PORT',9312);

/**导航条选中样式名**/
define('BAR_SELECTED','onfocus');

/**分享自定义常数**/

define('ITEM_CLICK_TIMESPAN',86400);	#一小时间隔，阅读数才会相应的加1

/**网站基本命名**/

define('SITE_NAME','快推网络');
//口号
define('SITE_SLOGAN','');
//目标
define('SITE_GOAL','做最具影响力的返利比价购物平台');

// assert
assert_options(ASSERT_ACTIVE,1);
assert_options(ASSERT_WARNING,1); // 为每个失败的断言产生一个 PHP 警告（warning）
assert_options(ASSERT_QUIET_EVAL,0); // 在断言表达式求值时禁用 error_reporting
assert_options(ASSERT_BAIL,0); // 在断言失败时中止执行
// assert_options(ASSERT_CALLBACK,nil); //断言失败时调用回调函数
