<?php


namespace server\base;
require __DIR__ . '/../../../public/index.php';

use app\common\business\lib\Redis;
use Swoole\WebSocket\Server;
use server\business\Chat;

class WS
{

    private $ws = NULL;
    private $chat = NULL;
    private $redis = NULL;

    public function __construct() {
        $this -> chat = new Chat();
        $this -> redis = new Redis();
        $this -> ws = new Server("0.0.0.0", 9502);
        $this -> ws -> set([
            'task_worker_num' => 4,
            'ssl_cert_file' => '/www/server/panel/vhost/cert/apptest.huihuagongxue.top/fullchain.pem',
            'ssl_key_file' => '/www/server/panel/vhost/cert/apptest.huihuagongxue.top/privkey.pem',
        ]);
        $this -> ws -> on('open', [$this, "onOpen"]);
        $this -> ws -> on('message', [$this, "onMessage"]);
        $this -> ws -> on('task', [$this, "onTask"]);
        $this -> ws -> on('finish', [$this, "onFinish"]);
        $this -> ws -> on('close', [$this, "onClose"]);
        $this -> ws -> start();
    }

    public function onOpen($ws, $request) {
        echo $request -> get['token'];
        $ws -> push($request -> fd, "欢迎客户端： {$request -> fd}\n");
    }

    public function onMessage($ws, $frame) {
        $this -> chat -> handle($ws, $frame);
        $this -> redis -> set("chenggong", "yes");
    }

    public function onTask($ws, $task_id, $src_worker_id, $data) {
        return $data;
    }

    public function onFinish($ws, $task_id, $data) {
    }

    public function onClose($ws, $fd) {
        echo "客户端：{$fd} 关闭\n";
    }

}new WS();