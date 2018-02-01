<?php
/**
 * @doc SimpleRedis
 * @author chenyansheng
 * @date 2018年02月01日
 */
class SimpleRedis {
    private $redis;
    
    // 当前权限认证码
    private $auth;
    
    /**
     * 实例化的对象,单例模式.
     */
    private static $_instance = null;
    
    // 连接属性数组
    private $attr = array(
        // 连接超时时间，redis配置文件中默认为30秒
        'timeout' => 30,
        // 选择的数据库为0号库
        'db_id' => 0
    );
    
    private $host;
    private $port;
    
    private function __construct($config) {
        if( ! extension_loaded('redis')) {
            throw new Exception("php env not supported redis");
        }
        if( ! is_array($config)) {
            throw new Exception("{$config} config not exist");
        }
        
        $this->attr = array_merge($this->attr, $config);
        $this ->redis = new Redis();
        $this ->port = $config['port'] ? $config['port'] : 6379;
        $this ->host = $config['host'];
        $this ->redis ->connect($this ->host, $this ->port, $this ->attr['timeout']);
        
        if($config['auth']) {
            $this ->auth($config['auth']);
            $this ->auth = $config['auth'];
        }
    }
    
    /**
     * 获取实例化对象.
     * @param array $config              
     * @return \iphp\db\Redis
     */
    public static function getInstance($config) {
        if(! (static::$_instance instanceof self)) {
            
            static::$_instance = new self($config);
            static::$_instance ->dbId = $config['db_id'];
            
            // 如果不是0号库，选择一下数据库。
            if($config['db_id'] != 0) {
                static::$_instance-> select($config['db_id']);
            }
        }
        return static::$_instance;
    }
    
    /**
     * 禁止clone
    */
    private function __clone(){}
    
    /**
     * 执行原生的redis操作
     * 
     * @return \Redis
     */
    public function getRedis() {
        return $this ->redis;
    }
    
    /**
     * redis ping
     * @return string +PONG
     */
    public function ping() {
        return $this->redis->ping();
    }
    
    /**
     * 从左边入队一个元素
     * 即从列表表头写入
     * @param string $name
     * @param unknown $element
     * @return 写入的是第几个元素
     */
    public function lPush($name, $element) {
        return $this->redis->rPush($name, $element);
    }
    
    /**
     * 从右边出队一个元素
     * 即从列表表尾删除
     * @param string $name
     * @return 删除的元素
     */
    public function rPop($name) {
        return $this->redis->lPop($name);
    }
    
    /**
     * 修剪列表
     * start 和 stop 都是由0开始计数的， 这里的 0 是列表里的第一个元素（表头），1 是第二个元素，以此类推
     * start 和 end 也可以用负数来表示与表尾的偏移量，比如 -1 表示列表里的最后一个元素， -2 表示倒数第二个，等等
     * @param string $name
     * @param int $start
     * @param int $stop
     * @return boolean
     */
    public function lTrim($name, $start, $stop) {
        return $this->redis->ltrim($name, $start, $stop);
    }
    
    /**
     * 查看列表内容
     * @param string $name
     * @param int $start
     * @param int $stop
     * @return array
     */
    public function lRange($name, $start, $stop) {
        return $this->redis->lrange($name, $start, $stop);
    }
    
    /**
     * 查看列表长度
     * @param string $name
     * @return int
     */
    public function lLen($name) {
        return $this->redis->lLen($name);
    }
    
}
    