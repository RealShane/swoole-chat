<?php


namespace app\common\model\api;


use think\Model;

class Friend extends Model
{

    protected $table = "api_friend";

    public function isFriend($uid, $fid){
        $u = $this -> where('uid', $uid) -> where('fid', $fid) -> where('status', 1) -> find();
        $f = $this -> where('uid', $fid) -> where('fid', $uid) -> where('status', 1) -> find();
        return !empty($u) && !empty($f);
    }

}