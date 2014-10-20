<?php
/**		本地登录	**/

//目前只支持用户名登录

class Login extends Medium{

	public  function run($data){
		SQL::user('user','login',array('user','user'));
	}
}