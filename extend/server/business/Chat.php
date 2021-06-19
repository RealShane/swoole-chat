<?php


namespace server\business;


use server\base\Base;

class Chat extends Base
{

    public function switchboard($ws, $frame){
        $data = json_decode($frame -> data, true);
        switch ($data['type']){
            case 'addFriend' :
                $this -> addFriend($ws, $frame -> fd, $data);
                break;
        }
    }

    private function addFriend($ws, $fd, $data){
        $socket = $this -> getSocket($data['target']);
        $socket['apply_list'][$data['uid']] = $data['message'];
        if (!empty($socket['fd']['index'])){
            $this -> success($ws, $socket['fd']['index'], [
                'type' => 'addFriend',
                'from' => $data['uid'],
                'username' => $data['username'],
                'message' => $data['message']
            ]);
        }
        $this -> redis -> set(config('redis.socket_pre') . $data['target'], $socket);
        $this -> success($ws, $fd, NULL);
    }

}