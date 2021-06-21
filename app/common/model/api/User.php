<?php
/**
 *
 * @description: 永远爱颍
 *
 * @author: Shane
 *
 * @time: 2021/6/21 10:06
 */

namespace app\common\model\api;


use think\Model;

class User extends Model
{

    protected $table = "api_user";

    public function updateLoginInfo($data){
        $result = $this -> findByUserNameWithStatus($data['username']);
        return $result -> allowField(['last_login_token']) -> save($data);
    }

    public function findByIdWithStatus($id){
        return $this -> where('id', $id) -> where('status', 1) -> find();
    }

    public function findByUserName($username){
        return $this -> where('username', $username) -> find();
    }

    public function findByUserNameWithStatus($username){
        return $this -> where('username', $username) -> where('status', 1) -> find();
    }

}