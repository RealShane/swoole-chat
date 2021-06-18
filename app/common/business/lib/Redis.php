<?php


namespace app\common\business\lib;


use think\facade\Cache;
use think\cache\driver\Redis as R;

class Redis
{

    private $store = NULL;
    private $redis = NULL;

    public function __construct($store = 'redis'){
        $this -> setStore($store);
        echo json_decode(config('cache.stores' . $this -> store));exit();
        $this -> redis = new R(config('cache.stores' . $this -> store));
    }

    public function set($key, $value, $ttl = NULL){
        return Cache::store($this -> store) -> set($key, $value, $ttl);
    }

    public function get($key){
        return Cache::store($this -> store) -> get($key);
    }

    public function delete($key){
        return Cache::store($this -> store) -> delete($key);
    }

    public function rset($key, $value, $ttl = NULL){
        return $this -> redis -> set($key, $value, $ttl);
    }

    public function multi(){
        return $this -> redis -> multi();
    }

    public function exec(){
        return $this -> redis -> exec();
    }

    public function discard(){
        return $this -> redis -> discard();
    }

    public function setStore($store){
        $this -> store = $store;
        return $this;
    }

}