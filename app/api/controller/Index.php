<?php
namespace app\api\controller;

use app\BaseController;
use think\facade\View;

class Index extends BaseController
{
    public function index() {
        echo json_encode("sss");exit();
        return View::fetch('room/index');
    }

}
