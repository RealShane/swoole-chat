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

class Chat extends Validate
{

    protected $rule = [
        'fid' => ['require', 'number']
    ];

    protected $scene = [
        'record' => ['fid']
    ];

}