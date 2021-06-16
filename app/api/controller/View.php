<?php


namespace app\api\controller;


use app\BaseController;
use think\facade\View as V;

class View extends BaseController
{

    public function chatRoom(){
        return V::fetch('room/index');
    }

}