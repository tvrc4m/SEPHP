<?php

class Register extends Medium{

	public  function run($data){

		$uname=trim($data['uname']);

		$email=trim($data['email']);

		$pwd1=trim($data['p']);

		$pwd2=trim($data['rep']);

		$bind=$data['bind'];

		$opentype=$data['opentype'];
		
		if(empty($uname)) return json_encode(array('ret'=>-1));

		if(empty($email)) return json_encode(array('ret'=>-2));

		if(empty($pwd1) || $pwd1!==$pwd2) return json_encode(array('ret'=>-3));
		
		$unameStatus=register('uniqueName',array('uname'=>$uname));

		$us=json_decode($unameStatus);

		if($us->ret!==1)

			return json_encode(array('ret'=>-1));

		$emailStatus=register('uniqueEmail',array('email'=>$email));

		$es=json_decode($emailStatus);

		if($es->ret!==1)

			return json_encode(array('ret'=>-2));

		$m_user=MU('User');

		if(!$m_user->addUser(array('uname'=>$uname,'email'=>$email,'password'=>md5($pwd1)))) return -1;

		$userinfo=$m_user->getUserByEmail($email);

		SU($userinfo);

		if($bind)
			//绑定开放平台帐户
			$dd=user('UOpenplatform',array('action'=>'bind','type'=>$opentype));
		
		//创建默认盒子.TODO:类别id应为多少
		
		return json_encode(array('ret'=>1));

	}
}
