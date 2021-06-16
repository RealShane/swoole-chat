<?php
namespace app\api\controller;

use app\BaseController;
use think\facade\View;
use WebSocket\Client;

class Index extends BaseController
{
    public function index() {
        return View::fetch('room/index');
    }

    public function test(){
        $client = new Client('wss://apptest.huihuagongxue.top:9502?token=test-token');
        $client->send("ssss");
        var_dump($client->receive());
    }

}
