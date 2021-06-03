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


class WS
{

    private $ws = null;

    public function __construct(){
        $this -> ws = new Swoole\WebSocket\Server("0.0.0.0", 9502);
        $this -> ws -> set([
            'task_worker_num' => 4
        ]);
        $this -> ws -> on('open', [$this, "onOpen"]);
        $this -> ws -> on('message', [$this, "onMessage"]);
        $this -> ws -> on('task', [$this, "onTask"]);
        $this -> ws -> on('finish', [$this, "onFinish"]);
        $this -> ws -> on('close', [$this, "onClose"]);
        $this -> ws -> start();
    }

    public function onOpen($ws, $request){
        var_dump($request->fd, $request->get, $request->server);
        $ws->push($request->fd, "欢迎客户端： {$request -> fd}\n");
    }

    public function onMessage($ws, $frame){
        echo "信息: {$frame -> data}\n";
        foreach ($ws -> connections as $fd){
            if ($fd == $frame -> fd){
                $ws -> task([
                    'fd' => $fd,
                    'message' => "我: {$frame -> data}",
                ]);
                $ws -> push($fd, "我: {$frame -> data}");
            }else{
                $ws -> push($fd, "对方: {$frame -> data}");
            }
        }
    }

    public function onTask($ws, $task_id, $src_worker_id, $data){
        sleep(10);
        return $data;
    }

    public function onFinish($ws, $task_id, $data){
        var_dump("task_id:" . $task_id);
        var_dump($data);
    }

    public function onClose($ws, $fd){
        echo "客户端：{$fd} 关闭\n";
    }



}