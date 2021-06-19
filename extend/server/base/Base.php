<?php


namespace server\base;


use app\common\business\lib\Redis;
use app\common\model\api\User;

class Base
{

    protected $redis = NULL;
    protected $user = NULL;

    public function __construct() {
        $this -> redis = new Redis();
        $this -> user = new User();
    }

    public function handle($token, $type, $ws, $fd){
        $user = $this -> getUser($token);
        if (empty($user)){
            $ws -> close($fd);
        }else{
            $ws -> bind($fd, $user['id']);
            if (strpos($type, 'chat_uid_') !== false){
                $this -> setFd($ws, $user['id'], $fd, $type);
            }
            if ($type == 'index'){
                $this -> setFd($ws, $user['id'], $fd, $type);
                $this -> readDelay($ws, $user['id'], $fd);
            }
        }
    }

    public function readDelay($ws, $uid, $fd){
        $data = $this -> getSocket($uid);
        if (!empty($data['apply_list'])){
            foreach ($data['apply_list'] as $key => $value){
                $user = $this -> user -> findByIdWithStatus($key);
                if (empty($user)){
                    unset($data['apply_list'][$key]);
                    continue;
                }
                $this -> success($ws, $fd, [
                    'type' => 'addFriend',
                    'from' => $key,
                    'username' => $user['username'],
                    'message' => $value
                ]);
            }
        }
        $this -> redis -> set(config('redis.socket_pre') . $uid, $data);
    }

    public function setFd($ws, $uid, $fd, $type){
        $data = $this -> getSocket($uid);
        $this -> success($ws, $fd, $data);
        $data['fd'][$type] = $fd;
        $this -> success($ws, $fd, "<br>");
        foreach ($data['fd'] as $key => $value){
            $info = $ws -> getClientInfo($value);
            if (empty($info['uid']) || $info['uid'] != $uid){
                unset($data['fd'][$key]);
            }
        }
        $this -> success($ws, $fd, $data);
        $this -> redis -> set(config('redis.socket_pre') . $uid, $data);
    }

    public function getSocket($uid){
        return $this -> redis -> get(config('redis.socket_pre') . $uid);
    }

    public function getUser($token){
        return $this -> redis -> get(config('redis.token_pre') . $token);
    }

    public function success($ws, $fd, $data){
        $this -> show($ws, $fd, config('status.success'), config('message.success'), $data);
    }

    public function fail($ws, $fd, $data){
        $this -> show($ws, $fd, config('status.failed'), $data, NULL);
    }

    public function show($ws, $fd, $status, $message, $result){
        $data = [
            'status' => $status,
            'message' => $message,
            'result' => $result
        ];
        $ws -> push($fd, json_encode($data));
    }

}