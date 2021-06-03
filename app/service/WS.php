<?php
/**
 *
 * @description: 永远爱颍
 *
 * @author: Shane
 *
 * @time: 2021/6/4 1:08
 */


namespace app\service;

use app\Request;
use Swoole\Server;
use think\swoole\Websocket;
use app\common\business\lib\Redis;

class WS
{

    protected $websocket = null;
    protected $server = null;
    protected $redis = null;

    public function __construct(Server $server, Websocket $websocket) {
        $this -> websocket = $websocket;//依赖注入的方式
        $this -> server = $server;
        $this -> redis = new Redis;
    }

    //onOpen触发的事件,传入的是一个request对象
    public function onConnect(Request $request) {
        //通过websocket的上下文取得fd:$this->websocket->getSender()
        $fd = $this -> websocket -> getSender();
        $this -> websocket -> push("欢迎客户端： {$fd}\n");
    }

    //onClose触发的事件
    public function onClose() {
        echo "客户端关闭\n";
    }

}