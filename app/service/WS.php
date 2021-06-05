<?php
/**
 *
 *
 * @description:  大一大万大吉！
 * @author: shenzheng
 * @time: 2020/6/10 上午1:24
 *
 */

//cd /library/WebServer/Documents/swoole_test

class WS
{

    private $ws = null;

    public function __construct(){
        $this -> ws = new Swoole\WebSocket\Server("0.0.0.0", 9000, SWOOLE_PROCESS, SWOOLE_SOCK_TCP | SWOOLE_SSL);
        $this -> ws -> set([
            'task_worker_num' => swoole_cpu_num(),
            'ssl_cert_file' => '/www/server/panel/vhost/cert/apptest.huihuagongxue.top/fullchain.pem',
            'ssl_key_file' => '/www/server/panel/vhost/cert/apptest.huihuagongxue.top/privkey.pem'
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
new WS();