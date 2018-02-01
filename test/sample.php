<?php
/**
 * @doc 示例
 * @author chenyansheng
 * @date 2018年2月1日
 */
 
require '../lib/SimpleRedis.class.php';

//redis配置
$config = array(
	'host' => '127.0.0.1',
	'port' => 6379,
	'timeout' => 5,
	'db_id' => 0,
	'auth' => null
);
$redis = SimpleRedis::getInstance($config);

$redis_ping = $redis->ping();
var_dump($redis_ping);
