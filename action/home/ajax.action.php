<?php

class AjaxAction extends Action{
	
	public function follow(){
		
		$users=$_GET['users'];

		empty($users) && exit();

		$status=follow('followUser',array('action'=>'batch.follow','users'=>$users));

		echo json_encode(array('ret'=>$status));
		
	}
}