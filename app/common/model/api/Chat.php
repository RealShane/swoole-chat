<?php


namespace app\common\model\api;


use think\Model;

class Chat extends Model
{

    protected $table = "api_chat";

    public function getRecord($uid, $fid){
        return $this -> field(['uid', 'message', 'create_time']) -> where('uid', $uid) -> where('fid', $fid) -> order(['create_time']) -> select();
    }

}