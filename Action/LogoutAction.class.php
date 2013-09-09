<?php

class LogoutAction extends Action{
	
	public function index(){
		
		unset($_SESSION);

		$_SESSION=array();

		session_destroy();

		C('uid',null);
		
		go(HOST);

	}
}