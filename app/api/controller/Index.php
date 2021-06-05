<?php
namespace app\api\controller;

use app\BaseController;
use think\facade\View;

class Index extends BaseController
{
    public function index() {
        return View::fetch('room/index');
    }
    public function message() {
        event('swoole.websocket.Point', [
            'api' => true,
            'uid' => $this->request->param('uid'),
            'to' => $this->request->param('to'),
            'content' => $this->request->param('content')
        ]);
    }

}
