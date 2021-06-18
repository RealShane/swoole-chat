<?php


namespace server\base;
require __DIR__ . '/../../../public/index.php';

use Swoole\WebSocket\Server;
use server\business\Chat;

class WS extends Base
{

    private $ws = NULL;
    private $chat = NULL;

    public function __construct() {
        parent ::__construct();
        $this -> chat = new Chat();
        $this -> ws = new Server("0.0.0.0", 9502, SWOOLE_PROCESS, SWOOLE_SOCK_TCP | SWOOLE_SSL);
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
        $this -> handle($request -> get['token'], $request -> get['type'], $ws, $request -> fd);
    }

    public function onMessage($ws, $frame) {
        $this -> chat -> handle($ws, $frame);
    }

    public function onTask($ws, $task_id, $src_worker_id, $data) {
        return $data;
    }

    public function onFinish($ws, $task_id, $data) {
    }

    public function onClose($ws, $fd) {

    }

}new WS();