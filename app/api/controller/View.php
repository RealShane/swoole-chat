<?php


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

}