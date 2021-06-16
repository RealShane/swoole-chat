<?php


namespace app\api\controller;

use app\common\business\api\User as Business;
use app\common\validate\api\User as Validate;
use app\BaseController;
use think\App;

class User extends BaseController
{

    protected $business = NULL;

    public function __construct(App $app) {
        parent ::__construct($app);
        $this -> business = new Business();
    }

    public function login(){
        $data['username'] = $this -> request -> param("username", '', 'htmlspecialchars');
        $data['password'] = $this -> request -> param("password", '', 'htmlspecialchars');
        try {
            validate(Validate::class) -> scene("login_register") -> check($data);
        }catch (\Exception $exception){
            return $this -> fail($exception -> getMessage());
        }
        $errCode = $this -> business -> login($data);
        return $this -> success($errCode);
    }

    public function register(){
        $data['username'] = $this -> request -> param("username", '', 'htmlspecialchars');
        $data['password'] = $this -> request -> param("password", '', 'htmlspecialchars');
        try {
            validate(Validate::class) -> scene("login_register") -> check($data);
        }catch (\Exception $exception){
            return $this -> fail($exception -> getMessage());
        }
        $this -> business -> register($data);
        return $this -> success("注册成功！");
    }

}