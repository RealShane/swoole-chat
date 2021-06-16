<?php


namespace app\common\model\api;


use think\Model;

class User extends Model
{

    protected $table = "api_user";

    public function findByUserName($username){
        return $this -> where('username', $username) -> find();
    }

}