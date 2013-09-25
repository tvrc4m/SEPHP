<?php
/*
*数据库抽象类---定义数据库基本功能
*数据库基类应该实现为单例模式
*/
abstract class DB{
	
	public static $_instance=null;
	
	private $_link=null;
	
	protected $prefix='kt_';
	
	/*
	*私有构造函数---不允许NEW对象
	*/
	private function __construct(){
		
	}
	/**
	*	单例模式
	*/
	public static function Instance(){
		if(self::$_instance==null){
			$c=get_called_class();
			self::$_instance=new $c();
			self::$_instance->connect();
		}
		return self::$_instance;
	}
	
	abstract protected function connect($connectstring=null);
	
	
	public function __destruct(){
		self::$_instance=null;
		$this->_link=null;
	}
}

class DBMysql extends DB{
	
	CONST HOST='localhost';
	CONST USER='fastty';
	CONST PWD='';
	CONST DB='fastty';
	CONST CHARSET='UTF8';
	
	protected $_select='*';
	protected $_table;
	protected $_where;	
	protected $_order;
	protected $_group;
	protected $_having;
	protected $_join;
	
	protected $_limit;
	protected $_insert;
	protected $_value;
	protected $_update;
	protected $_set;
	
	protected $_delete;
	
	protected $sqlType=array('select','update','delete','insert');
	
	/*
	*连接
	*/
	protected  function connect($connectstring=null){
		$this->_link=mysql_pconnect(self::HOST,self::USER,self::PWD);
		if(!mysql_ping($this->_link)){
			mysql_close($this->_link);
			$this->_link=mysql_pconnect(self::HOST,self::USER,self::PWD);
		}
		mysql_select_db(self::DB,$this->_link);
		mysql_set_charset(self::CHARSET,$this->_link);
	}
	/*
	*	重新初始化选项
	*/
	protected function init(){
		$this->_select='*';
		$this->_table='';
		$this->_where='';
		$this->_order='';
		$this->_group='';
		$this->_join='';
		$this->_update='';
		$this->_set='';
		$this->_delete='';
		$this->_insert='';
		$this->_limit='';
		$this->_value='';
		$this->_having='';
	}
	/**
	* 	查询
	*/
	public function find($params){
		$result=$this->_query($params);
		$rows=array();
		while($row=mysql_fetch_assoc($result)){
			$rows[]=$row;
		}
		mysql_free_result($result);
		return $rows;
	}
	/*
	*	获取单行
	*/
	public function get($params){
		$result=$this->_query($params);
		$row=mysql_fetch_assoc($result);
		mysql_free_result($result);
		return $row;
	}
	/*
	*	获取总的个数
	*/
	public function count($params){
		$result=$this->_query($params);
		$row=mysql_fetch_array($result,MYSQL_NUM);
		mysql_free_result($result);
		return $row[0];
	}
	/**
	*	更新|插入|删除
	*/
	public function query($params){
		$num=$this->_query($params);
		return $num;
	}
	/**
	*	构造查询
	*/
	private function _query($params){
		$sql=$this->_sql($params);
		if(!$this->_link){
			$this->connect();
		}
		$query=mysql_query($sql,$this->_link);
		#echo $sql.'<br />';
		if(!$query){
            #echo $sql.'<br />';
			#print_r(mysql_error($this->_link));
			exit('数据执行有错');
		}
		return $query;
	}
	/**
	*	初始化选项
	*/
	private function _set($params){
		$this->init();
		foreach($params as $key=>$value){
			if(!property_exists($this,$key))
				exit('不存在此属性，可能有待添加');
			$this->$key=$value;
		}
	}
	/*
	*	构造SQL语句
	*/
	private function _sql($params){
		$this->_set($params);
		$sql='';
		if($this->_insert){
			$sql='INSERT INTO '.$this->_table.$this->_value;
		}else if($this->_update){
			$sql='UPDATE '.$this->_table.' SET '.$this->_set;
		}else if($this->_delete){
			$sql='DELETE FROM '.$this->_table;
		}else{
			$sql='SELECT '.$this->_select.' FROM '.$this->_table;
		}
		if(!empty($this->_where))
			$sql.=' WHERE '.$this->_where;
		if(!empty($this->_order))
			$sql.=' ORDER BY '.$this->_order;
		if(!empty($this->_group))
			$sql.=' GROUP BY '.$this->_group;
		if(!empty($this->_limit)){
			$sql.=' LIMIT '.$this->_limit;
		}
		return $sql;
	}
}

class DBMongo extends DB{
	
	CONST HOST='mongodb://localhost:27017';

	//CONST HOST='mongodb://fred:foobar@localhost';
	//CONST HOST='mongodb://fred:foobar@localhost/baz';	#Connect and login to the "baz" database as user "fred" with password "foobar":
	
	protected $_db='fastty';
	
	protected $_mongo;
	
	protected $_mongodb;
	
	
	protected $_talbe;		#集合
	
	protected $_set;		#更新值
	
	protected $_options=array();
	
	/**
	*	连接
	*/
	protected function connect($connectstring=self::HOST){
		$this->_mongo=new Mongo($connectstring);
		$this->_mongodb=$this->_mongo->selectDB($this->_db);
	}
	/*
	*	选择库和集合
	*/
	public function selectCollection($db,$collection){
		$this->_collection=$this->_mongo->selectCollection($db,$collection);
	}
	
	/**
	*	查询多条数据记录
	*/
	public function find($params=array()){
		return $this->_setParams($params);
		//return $this->_forCursor();
	}
	/**
	*	获取单个值
	*/
	public function get($params){
		return $this->_setParamsDirectReturn($params);
	}
	
	public function count($params){
		return $this->_setParams($params);
	}
	/**
	*	更新数据 | 插入数据 |  批量插入 |  删除数据
	*/
	public function query($params){
		return $this->_setParamsDirectReturn($params);
	}
	
	/**
	*	设置参数
	*/
	private function _setParams($params){
		$this->init();
		!isset($params['_table']) && exit('没有选定指定的集合！');
		$collection=$this->_mongodb->selectCollection($params['_table']);
		unset($params['_talbe']);
		isset($params['_options']) && $this->_options=array_merge($this->_options,$params['_options']);
		unset($parmas['_options']);
		$cursor=$collection->find($params['find'],$this->_options);
		
		foreach($params as $k=>$v){
			if(method_exists($cursor,$k)){
				if($k=='count'){
					return $cursor->count($params['count']);
				}
				/*else if($k=='fields'){   # 为0是排除，为1是包含
					$fields=array();
					foreach(explode(',',$v) as $field){
						$fields[$field]=true;
					}
					$cursor=$cursor->fields($fields);
				}*/
				else
					$cursor=$cursor->$k($v);
			}
		}
		unset($params);
		$result=array();
		while($doc=$cursor->getNext()){
			$result[]=$doc;
		}
		$cursor=null;
		$collection=null;
		return $result;
	}
	/**
	*	设置那些在集合类中直接返回值的
	*/
	private function _setParamsDirectReturn($params){
		$this->init();
		!isset($params['_table']) && exit('没有选定指定的集合！');
		$collection=$this->_mongodb->selectCollection($params['_table']);#new MongoCollection($this->_mongodb,$params['_talbe']);
		unset($params['_talbe']);
		isset($params['_options']) && $this->_options=array_merge($this->_options,$params['_options']);
		unset($parmas['_options']);
		//asort($params);
		foreach($params as $k=>$v){
			if(method_exists($collection,$k)){
				if($k=='findOne'){
					$fields=isset($params['fields'])?$params['fields']:array();
					$data=$collection->findOne($v,$fields);
				}
				else if($k!='update'){
					$data=$collection->$k($v,$this->_options);
				}
				else
					$data=$collection->$k($v,$params['_set'],$this->_options);
				
				unset($params);
				return $data;
			}
		}
	}
	
	private function init(){
		$this->_talbe='';
		$this->_set=array();
		$this->_options=array();
	}

}
