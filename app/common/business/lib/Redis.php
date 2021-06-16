<?php


namespace app\common\business\lib;


use think\facade\Cache;

class Redis
{

    private $store = NULL;

    public function __construct($store = 'redis'){
        $this -> setStore($store);
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

    public function setStore($store){
        $this -> store = $store;
        return $this;
    }

}