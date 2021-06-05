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
use Swoole\WebSocket\Frame;

use think\Container;

class WS
{

    protected $websocket = null;
    protected $server = null;

    public function __construct(Server $server, Websocket $websocket, Container $container)
    {
        $this->websocket = $websocket;//依赖注入的方式
        $this->server = $server;
    }

    public function onConnect(Request $request){}

    // 监听客户连接
    public function onOpen(Request $request)
    {
        $fd = $this->websocket->getSender();// 获取连接标识
        $this->server->push($fd , 'something');// 发送给客户端
    }

    // 监听客户端发送消息
    public function onMessage(Server $server, Frame $frame)
    {
        $fd = $frame->fd; // 为当前连接唯一值
        $msg = json_decode($frame->data , true) ;// 获取cli上传的消息,json格式
        $this->server->push($fd , $msg);// 发送给客户端
    }

    public function onPoint(Frame $frame, $data){
        $fd = $frame->fd;
        $this->server->push($fd , json_encode($data));
    }

    //onClose触发的事件
    public function onClose()
    {
        // 一般做一些资源释放的动作
    }
}