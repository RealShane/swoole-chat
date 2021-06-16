<?php
/**
 *
 *
 * @description:  大一大万大吉！
 * @author: shenzheng
 * @time: 2020/6/10 上午1:24
 *
 */
namespace service;

use service\business\Chat;

class WS
{

    private $ws = null;
    private $chat = NULL;

    public function __construct(){
//        $this -> chat = new Chat();
        $this -> ws = new Swoole\WebSocket\Server("0.0.0.0", 9502, SWOOLE_PROCESS, SWOOLE_SOCK_TCP | SWOOLE_SSL);
        $this -> ws -> set([
            'task_worker_num' => 4,
            'ssl_cert_file' => '/www/server/panel/vhost/cert/apptest.huihuagongxue.top/fullchain.pem',
            'ssl_key_file' => '/www/server/panel/vhost/cert/apptest.huihuagongxue.top/privkey.pem'
        ]);
        $this -> ws -> on('open', [$this, "onOpen"]);
        $this -> ws -> on('message', [$this, "onMessage"]);
        $this -> ws -> on('close', [$this, "onClose"]);
        $this -> ws -> start();
    }

    public function onOpen($ws, $request){
        echo $request -> get['token'];
        $ws->push($request -> fd, "欢迎客户端： {$request -> fd}\n");
    }

    public function onMessage($ws, $frame){
//        $this -> chat -> handle($ws, $frame);
    }

    public function onClose($ws, $fd){
        echo "客户端：{$fd} 关闭\n";
    }



}
new WS();
echo __DIR__;