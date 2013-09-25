<?php
/*
 * 缓存抽象类
 *  应该被实例为单例模式
 */
abstract class Cache{
    
	protected $_cache=null;
	
	protected static $_instance=null;
	
	private function __construct(){
		
	}
	public static function Instance(){
		if(self::$_instance===null){
			$c=get_called_class();
			self::$_instance=new $c;
			self::$_instance->connect();
		}
		return self::$_instance;
	}
	
	abstract protected function connect($host,$port);
	/*
	//获取某一KEY缓存数据
	abstract public function get();
	
	//设置某一KEY缓存
	abstract public function set();
	
	//删除某一KEY缓存
	abstract public function delete();
	
	//清除全部
	abstract public function remove();
	*/
	public function __destruct(){
		self::$_instance=null;
		$this->_cache=null;
	}
	
}
/*
 * 内存缓存类
 */
class MemoryCache extends Cache{
    
	CONST HOST='127.0.0.1';
	
	CONST PORT='11211';
	
	/*
	*初始化实例
	*/
	protected function connect($host='',$port=''){
		$this->_cache=new Memcache;
		if(empty($host) || empty($port)){
			$this->_cache->pconnect(self::HOST,self::PORT);
		}else{
			$this->_cache->pconnect($host,$port);
		}
	}
	/*
	*取值
	*/
	public function get($key){
		$value=$this->_cache->get($key);
		return unserialize($value);
	}
	/*
	* 设置值
	*/
	public function set($key,$value,$expiration=3600){
		$value=serialize($value);
		$this->_cache->set($key,$value,0,$expiration);
	}
	/*
	*删除缓存
	*/
	public function delete($key,$ttl=false){
		return $ttl === false ?
            $this->handler->delete($key) :
            $this->handler->delete($key, $ttl);
	}
	/*
	*清除全部缓存
	*/
	public function remove(){
		$this->_cache->flush();
	}
}
/*
 * 文件缓存类
 */
class FileCache extends Cache{
    
	protected $FILE_PATH='';
	
	 /**
     * 缓存存储前缀
     */
    protected $prefix='~@';
	
	private $dir_permission=0007777;
	
	private $file_permission=0000666;
	
	/*
	* 初始化并创建目录
	*/
	public function __construct($file_path=''){
		if(!empty($file_path)){
			$this->FILE_PATH=$file_path;
		}
		if(!is_dir($this->FILE_PATH)){
			if (!mkdir($this->FILE_PATH))
                return false;
             chmod($this->FILE_PATH, $this->dir_permission);
		}
	}
	
	public function connect($host='',$port=''){
	
	}
	/*
	*取值
	*/
	public function get($key){
		
	}
	/*
	* 设置值
	*/
	public function set($key,$value,$expiration=3600){
		
	}
	/*
	*删除缓存
	*/
	public function delete($file){
		
	}
	/*
	*清除全部缓存
	*/
	public function remove(){
		
	}
}