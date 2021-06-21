<?php
/**
 *
 * @description: 永远爱颍
 *
 * @author: Shane
 *
 * @time: 2021/6/21 10:06
 */

namespace app\common\validate\api;


use think\Validate;

class User extends Validate
{

    protected $rule = [
        'username|用户名' => ['require', 'max' => 20, 'min' => 2],
        'password|密码' => ['require', 'max' => 20, 'min' => 4],
        'message|留言' => ['max' => 20],
        'decision' => ['require', 'between:0,1'],
        'target' => ['require', 'number']
    ];

    protected $scene = [
        'handleFriend' => ['decision', 'target'],
        'addFriend' => ['username', 'message'],
        'login_register' => ['username', 'password']
    ];

}