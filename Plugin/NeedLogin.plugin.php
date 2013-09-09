<?php

class NeedLoginPlugin extends Plugin{
	
	public function run($data){

		$status=P('CheckLogin');

		//$furl='http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_RUI'];
		
		if(!$status) go(HOST.'/login.html');

		return 1;
	}
}