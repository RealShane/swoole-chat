<?php
namespace app\api\controller;

use app\BaseController;
use think\facade\View;

class Index extends BaseController
{
    public function index() {
        return View::fetch('room/index');
    }

    public function test(){
        $fp = stream_socket_client("wss://apptest.huihuagongxue.top:9502?token=test-token", $errno, $errstr, 30);
        halt($fp);
    }

}
