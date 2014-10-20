<?php
/*
 * 控制层
 */
class Action extends View{

	public function __construct(){

		parent::__construct();
		
		$this->initialize();
	}

	protected function initialize(){
		$this->view->registerPlugin('block','lrtip','smarty_block_lrtip',false);
		$this->view->registerPlugin('block','top','smarty_block_top',false);
		$this->view->registerPlugin('block','toplr','smarty_block_toplr',false);
	}
}

function smarty_block_lrtip($param, $content, &$smarty) {
	return $content;
}

function smarty_block_top($param, $content, &$smarty) {
	return $content;
}

function smarty_block_toplr($param, $content, &$smarty) {
	return $content;
}