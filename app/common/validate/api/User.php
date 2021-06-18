<?php


namespace app\common\validate\api;


use think\Validate;

class User extends Validate
{

    protected $rule = [
        'username|用户名' => ['require', 'max' => 20, 'min' => 2],
        'password|密码' => ['require', 'max' => 20, 'min' => 4],
        'message|留言' => ['max' => 20],
    ];

    protected $scene = [
        'addFriend' => ['username', 'message'],
        'login_register' => ['username', 'password']
    ];

}