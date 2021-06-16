<?php


namespace app\common\business\api;

use app\common\business\lib\Str;
use app\common\model\api\User as UserModel;
use Exception;

class User
{

    private $userModel = NULL;
    private $str = NULL;

    public function __construct(){
        $this -> userModel = new UserModel();
        $this -> str = new Str();
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