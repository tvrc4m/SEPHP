<?php
/*
 * 模块块
 */
abstract class Model{
    
	protected $_db=null;
	
	protected $_cache=null;

	protected static $instance=null;
	
	protected static $_instances=array();

	
	protected function __construct(){
		//$this->_cache=MemoryCache::Instance();	
	}
	
	public static function Instance(){
		$c=get_called_class();
		if(isset(self::$_instances[$c])) return self::$_instances[$c];
		self::$instance=new $c();
		self::$instance->init();
		self::$_instances[$c]=$instance;
		return self::$instance;
	}
	
	abstract protected function init();
	
	
	public function setcache($k,$v,$expiration=3600){
		$this->_cache->set($k,$v,$expiratio);
	}
	
	public function getcache($k){
		return $this->_cache->get($k);
	}
	
}
/**
*	MYSQL模块类
*/
class MysqlModel extends Model{

	protected $prefix='kt_';
	
	protected $table='';
	
	protected function init(){
		$this->_db=DBMysql::Instance();
	}

	public function find($params){
		$this->_setTable($params);
		return $this->_db->find($params);
	}
	
	public function query($params){
		$this->_setTable($params);
		return $this->_db->query($params);
	}
	
	public function get($params){
		$this->_setTable($params);
		return $this->_db->get($params);
	}
	
	public function count($params){
		$this->_setTable($params);
		return $this->_db->count($params);
	}
	/**
	*	设置table名
	*/
	protected function _setTable(&$params){
		if($this->table && !isset($params['_table'])){
			$params['_table']=$this->prefix.$this->table;
		}else{
			$params['_table']=$this->prefix.$params['_table'];
		}
	}
	
}
/**
*	MONGO模块类
*/
class MongoModel extends Model{
	
	protected $table='';
	
	protected function init(){
		$this->_db=DBMongo::Instance();
	}
	
	public function find($params){
		$this->_setTable($params);
		return $this->_db->find($params);
	}
	
	public function get($params){
		$this->_setTable($params);
		return $this->_db->get($params);
	}
	
	public function query($params){
		$this->_setTable($params);
		return $this->_db->query($params);
	}

	public function count($params){
		$this->_setTable($params);
		return $this->_db->count($params);
	}

	public function removeNull($where,$field){

		$params=array('update'=>$where,'_set'=>array('$pullAll'=>array($field=>array(null))));
		
		return $this->query($params);
	}

	public function extradata($id,$field,$data,$count,$tongji){

		$ret=$this->get(array('findOne'=>array('_id'=>$id),'fields'=>array("{$field}"=>1)));
		
		$total=count($ret[$field]);

		$addparams=array('update'=>array('_id'=>$id),'_set'=>array('$push'=>array("{$field}"=>$data),'$inc'=>array("{$tongji}"=>1)),'_options'=>array('upsert'=>1));	
		
		if($total<$count){

			return $this->query($addparams);	#直接添加

		}else{

			$params=array('update'=>array('_id'=>$id),'_set'=>array('$pop'=>array("{$field}"=>-1)));	#删除头部的数据

			$this->query($params);

			return $this->query($addparams);
		}
	}
	/**
	*	设置table名
	*/
	protected function _setTable(&$params){	
		if($this->table && !isset($params['_table'])){
			$params['_table']=$this->table;
		}
	}
	
}