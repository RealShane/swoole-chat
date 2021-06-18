<?php


namespace server\base;


use app\common\business\lib\Redis;

class Base
{

    protected $redis = NULL;

    public function __construct() {
        $this -> redis = new Redis();
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
            $this -> success($ws, $fd, $this -> getSocket($user['id']));
        }
    }

    public function setFd($ws, $uid, $fd, $type){
        $data = $this -> getSocket($uid);
        $data['fd'][$type] = $fd;
        foreach ($data['fd'] as $key => $value){
            $info = $ws -> getClientInfo($value);
            if (empty($info['uid']) || $info['uid'] != $uid){
                unset($data['fd'][$key]);
            }
        }
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