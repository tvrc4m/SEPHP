<?php

/**
	user表：默认头像的格式为.jpg
	{'_id':mongoid,'uname':string,'email':string,'password':string,'headimg':string,'sign':string,'bind':array,'status':int,'score':int,'amount':int,'rtime':int,'rip':string,'ltime':int,'lip':string,'boxnum':int,'sharenum':int,'transmitnum':1,'follownum':int,'fansnum':int}
**/

class UserMongo extends MongoModel{

	protected $table="user";

	public function addUser($data){

		$data=array_merge(array('headimg'=>'.jpg','status'=>-1,'score'=>100,'amount'=>0,'rtime'=>time(),'rip'=>getip(),'boxnum'=>0,'sharenum'=>0,'transmitnum'=>0,'follownum'=>0,'fansnum'=>0),$data);

		$params=array('insert'=>$data,'_options'=>array('safe'=>true,'fsync'=>true));#同步插入，等待响应返回。		

		return $this->query($params);

	}
	
	public function getUserByUid($uid){

		$params=array('findOne'=>array('_id'=>$uid),'fields'=>array('password'=>0));
		
		return $this->get($params);

	}

	public function getUserByUname($uname){

		$params=array('findOne'=>array('uname'=>$uname),'fields'=>array());

		return $this->get($params);

	}

	public function getUserByEmail($email){

		$params=array('findOne'=>array('email'=>$email),'fields'=>array('uname'=>1,'headimg'=>1,'sign'=>1,'email'=>1));

		return $this->get($params);

	}

	public function updateUserInfo($uid,$data,$options=array()){

		$params=array('update'=>array('_id'=>$uid),'_set'=>array('$set'=>$data),'_options'=>$options);

		return $this->query($params);
	}

	public function IncUserinfo($uid,$data,$options=array()){

		$params=array('update'=>array('_id'=>$uid),'_set'=>array('$inc'=>$data),'_options'=>$options);

		return $this->query($params);
	}

	public function updateByParams($uid,$data,$options=array()){

		$params=array('update'=>array('_id'=>$uid),'_set'=>$data,'_options'=>$options);
		
		return $this->query($params);
	}

	public function getUsers($where,$sort=array()){

		$params=array('find'=>$where,'sort'=>$sort);

		return $this->find($params);
	}

	public function getLimitUsers($where,$fields=array(),$sort=array(),$page=1,$limit=10){

		$params=array('find'=>$where,'fields'=>$fields,'sort'=>$sort,'skip'=>($page-1)*$limit,'limit'=>$limit);
		print_r($params);
		return $this->find($params);
	}
}