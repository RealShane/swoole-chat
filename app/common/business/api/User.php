<?php


namespace app\common\business\api;

use app\common\business\lib\Redis;
use app\common\business\lib\Str;
use app\common\model\api\Friend;
use app\common\model\api\User as UserModel;
use Exception;
use WebSocket\Client;

class User
{

    private $userModel = NULL;
    private $friendModel = NULL;
    private $str = NULL;
    private $redis = NULL;

    public function __construct(){
        $this -> userModel = new UserModel();
        $this -> friendModel = new Friend();
        $this -> str = new Str();
        $this -> redis = new Redis();
    }

    public function addFriend($data){
        $isExist = $this -> userModel -> findByUserNameWithStatus($data['username']);
        if (empty($isExist)){
            throw new Exception("用户名不存在！");
        }
        $socket = $this -> redis -> get(config('redis.socket_pre') . $isExist['id']);
        if (!empty($socket['apply_list'])){
            foreach ($socket['apply_list'] as $key => $value){
                if ($key == $data['user']['id']){
                    throw new Exception("请勿重复申请！");
                }
            }
        }
        if ($this -> friendModel -> isFriend($data['user']['id'], $isExist['id'])){
            throw new Exception("已成为好友！");
        }
        if ($isExist['id'] == $data['user']['id']){
            throw new Exception("不能加自己为好友！");
        }
        $send = [
            'type' => 'addFriend',
            'uid' => $data['user']['id'],
            'username' => $data['user']['username'],
            'target' => $isExist['id'],
            'message' => $data['message'],
        ];
        $client = new Client('wss://apptest.huihuagongxue.top:9502?type=public&token=' . $data['token']);
        $client -> send(json_encode($send));
        $receive = json_decode($client -> receive(), true);
        if ($receive['status'] == config('status.success')){
            $client -> close();
        }
    }

    public function logoff($token){
        $this -> redis -> delete(config('redis.token_pre') . $token);
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