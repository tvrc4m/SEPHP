<?php

class User extends Medium{
	
	public function run($data){

		switch ($data['action']) {

			case 'get.by.uid':return $this->getByUid($data);break;

			case 'get.by.uname':return $this->getByUname($data);break;

			case 'get.by.email':return $this->getByEmail($data);break;

			case 'detail':return $this->detail($data);
		}
	}

	private function getByUid($data){

		$uid=$data['uid'];
		
		empty($uid) && exit('not uid');

		!$uid instanceof MongoId && $uid=new MongoId($uid);

		$m_user=MU('user');
		
		$result=$m_user->getUserByUid($uid);
		
		return $result;
	}
	private function getByUname($data){
		
		$uname=$data['uname'];

		if(empty($uname)) return array();
		
		$m_user=MU('user');
		
		$result=$m_user->getUserByUname($uname);
		
		return $result;
	}
}