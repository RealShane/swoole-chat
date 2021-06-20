<?php


namespace app\common\validate\api;


use think\Validate;

class Chat extends Validate
{

    protected $rule = [
        'fid' => ['require', 'number']
    ];

    protected $scene = [
        'record' => ['fid']
    ];

}