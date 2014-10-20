<?php
/*
 * 模块类
 */
abstract class Model{
    
	protected $_db=null;
	
	protected $_cache=null;

	protected static $instance=null;
	
	protected static $_instances=array();

	protected function __construct(){
		//$this->_cache=MemoryCache::Instance();	
	}
	/**
	*	单例模式
	*/
	public static function Instance(){
		$c=get_called_class();
		if(isset(self::$_instances[$c])) return self::$_instances[$c];
		self::$instance=new $c();
		self::$instance->init();
		self::$_instances[$c]=$instance;
		return self::$instance;
	}
	/**
	*	Model子类
	*/
	public static function getStorges(){
		return array('MysqlModel'=>'mysql','MongoModel'=>'mongo','SphinxModel'=>'sphinx','RedisModel'=>'redis');
	}

	/**
	* Model静态方法调用
	* @param dir Model目录下的目录
	* @param args[0]->文件名(不带type.php),args[1]->要调用的方法,args[2]->调用方法的参数
	* @return 原方法返回值
	*/

	public static function __callStatic($dir,$args){

		$storges=self::getStorges();

		$storge=$storges[get_called_class()];

		$classname=ucfirst($args[0]).ucfirst($storge);

		$file=MODEL.$storge.'/'.$dir.'/'.$args[0].'.'.$storge.'.php';
		// echo $file;exit();
		if(!is_file($file)) exit('model file not found');
		
		include_once($file);

		return call_user_func_array(array($classname::Instance(),$args[1]),$args[2]);
	}
	
	abstract protected function init();
	
	/**
	*	设置缓存
	*/
	public function setcache($k,$v,$expiration=3600){
		$this->_cache->set($k,$v,$expiratio);
	}
	
	/**
	*	读取缓存
	*/
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

	public function extradata($id,$field,$data,$count,$tongji,$otherSetDate=array()){

		$ret=$this->get(array('findOne'=>array('_id'=>$id),'fields'=>array("{$field}"=>1)));
		
		$total=count($ret[$field]);

		$setData=array_merge(array('$push'=>array("{$field}"=>$data),'$inc'=>array("{$tongji}"=>1)),$otherSetDate);

		$addparams=array('update'=>array('_id'=>$id),'_set'=>$setData,'_options'=>array('upsert'=>1));	
		
		if($total<$count){

			return $this->query($addparams);	#直接添加

		}else{

			$setData=array_merge(array('$pop'=>array("{$field}"=>-1)),$otherSetDate);#删除头部的数据

			$params=array('update'=>array('_id'=>$id),'_set'=>$setData);

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

class SphinxModel extends Model{

	protected $index='';

	protected static $queries=array();

	protected function init(){

		$this->_db=new Coreseek();

	}
	public static function run(){
		return Coreseek::Instance()->run();
		// return $this->_db->run();
	}
	/**
	*	单条搜索---立即执行返回数据
	*	@param data array|string 查询词
	*	@param params array 属性设置数组
	*	@param split string 查询词分割符
	*	@return array 返回数组
	*/
	public function find($data,$params,$split=' '){
		$this->_db->init();
		$this->_setParams($params);
		$keyword=$this->_setKeyword($data);
		return $this->_db->Query($keyword);
	}

	/**
	*	返回一条数据信息---立即执行返回数据----单一数组
	*	@param data array|string 查询词
	*	@param params array 属性设置数组
	*	@param split string 查询词分割符
	*	@return array 返回数组
	*/
	public function get($data,$param,$split=' '){
		$result=$this->find($data,$param,$split);
		if(isset($result['value']) && !empty($result['value']))
			return $result['value'][0];
		return array();
	}
	/**
	*	添加到批量查询数组中
	*	@param sign 此查询语句结果标识
	*	@param data 查询关键词或数组
	*	@param params array 过滤数组
	*	@param split 
	*	@return null
	*/
	public function add($sign,$data,$params,$split=' '){
		Coreseek::Instance()->add($sign,$data,$params,$split);
	}

	public function summary($keywords,$index='*'){

		return $this->_db->BuildKeywords($keywords,$index);
	}
	/**
	*	设置属性
	*	@params array 跟类字段一一对应
	*/
	private function _setParams($params){
		!isset($params['_index']) && $params['_index']=$this->index;
		$this->_db->setParmas($params);
	}
	/*
	*	设置查询词
	*	@param data array 查询
	*	@return string 查询词
	*	@return string 查询词
	*/
	private function _setKeyword($data){
		$keyword='';
		if(is_array($data))
			foreach($data as $k=>$v) !empty($v) && $keyword.=empty($kv)?' '.$v.' ':' '.$k.' '.$v.' ';
		else if(is_string($data)) $keyword=$data;
		return $keyword;
	}
	/**
	*	设置过虑值或范围
	*/
	private function _setFilters($filters){
		foreach($filters as $k=>$v)
			!empty($v) && $this->_filters[]['type']=$k=='values'?SPH_FILTER_VALUES:($k=='range'?SPH_FILTER_RANGE:SPH_FILTER_FLOATRANGE);
	}
}

class RedisModel extends Model{

	protected function init(){
		$this->_db=DBRedis::Instance();
	}

	/**
	*	调用redis内置方法
	*	@param method string redis内置方法
	*	@param args array 方法对应的参数
	*/
	public function __call($method,$args){
		if(method_exists($this->_db->getRedis(),$method)) 
			return call_user_func_array(array($this->_db->getRedis(),$method),$args);
		else
			exit('no this '.$method);
	}
}