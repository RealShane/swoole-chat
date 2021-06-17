<?php


namespace app\api\controller;


use app\BaseController;
use WebSocket\Client;

class Chat extends BaseController
{

    public function test() {
        $client = new Client('wss://apptest.huihuagongxue.top:9502?token=' . $this -> getToken());
        $client -> send("是的");
        var_dump($client -> receive());
        $client -> close();
    }

}