<?php
/****	中间件类	***/

abstract class Medium{
	
	protected $_sign;

	public function __construct(){

	}

	abstract public function run($data);
	
}