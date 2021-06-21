<?php
/**
 *
 * @description: 永远爱颍
 *
 * @author: Shane
 *
 * @time: 2021/6/21 10:06
 */

namespace app\common\model\api;


use think\Model;

class Chat extends Model
{

    protected $table = "api_chat";

    public function getRecord($uid, $fid){
        return $this -> field(['uid', 'message', 'create_time']) -> where('uid', $uid) -> where('fid', $fid) -> order(['create_time']) -> select();
    }

}