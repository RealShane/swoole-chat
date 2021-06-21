<?php
/**
 *
 * @description: 永远爱颍
 *
 * @author: Shane
 *
 * @time: 2021/6/21 10:06
 */

namespace app\api\controller;


use app\BaseController;
use think\facade\View as V;

class View extends BaseController
{

    public function index(){
        return V::fetch('index/index');
    }

    public function login(){
        return V::fetch('index/login');
    }

    public function register(){
        return V::fetch('index/register');
    }

    public function chatRoom(){
        return V::fetch('room/index');
    }

}