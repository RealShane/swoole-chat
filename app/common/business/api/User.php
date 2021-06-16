<?php


namespace app\common\business\api;

use app\common\business\lib\Redis;
use app\common\business\lib\Str;
use app\common\model\api\User as UserModel;
use Exception;

class User
{

    private $userModel = NULL;
    private $str = NULL;
    private $redis = NULL;

    public function __construct(){
        $this -> userModel = new UserModel();
        $this -> str = new Str();
        $this -> redis = new Redis();
    }

    public function login($data){
        $isExist = $this -> userModel -> findByUserNameWithStatus($data['username']);
        if (empty($isExist)){
            throw new Exception("用户名不存在！");
        }
        $password = md5($isExist['password_salt'] . $data['password'] . $isExist['password_salt']);
        if ($password != $isExist['password']){
            throw new Exception("密码填写错误！");
        }
        $this -> redis -> delete(config('redis.token_pre') . $isExist['last_login_token']);
        $token = $this -> str -> createToken($isExist['username']);
        $this -> userModel -> updateLoginInfo([
            'username' => $isExist['username'],
            'last_login_token' => $token
        ]);
        $this -> redis -> set(config('redis.token_pre') . $token, [
            'id' => $isExist['id'],
            'username' => $isExist['username']
        ]);
        return $token;
    }

    public function register($data){
        $isExist = $this -> userModel -> findByUserName($data['username']);
        if (!empty($isExist)){
            throw new Exception("用户名已被注册！");
        }
        $data['password_salt'] = $this -> str -> salt(5);
        $data['password'] = md5($data['password_salt'] . $data['password'] . $data['password_salt']);
        $this -> userModel -> save($data);
    }

}