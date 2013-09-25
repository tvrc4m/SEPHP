<?php

class CheckLoginPlugin extends Plugin{
	
	public function run($data){

		$uid=S('UID');
		
		if(!empty($uid)) return 1;

		$uid=C('uid');

		if(!empty($uid)){
			
			$uid=decrypt($uid);

			$userinfo=user('User',array('action'=>'get.by.uid','uid'=>$uid));

			if(empty($userinfo)) C('uid',null);

			else return SU($userinfo);

			return 0;
		}

		return 0;
	}
}