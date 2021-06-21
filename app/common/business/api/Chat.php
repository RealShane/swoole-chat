<?php
/**
 *
 * @description: 永远爱颍
 *
 * @author: Shane
 *
 * @time: 2021/6/21 10:06
 */

namespace app\common\business\api;

use app\common\model\api\Chat as ChatModel;

class Chat
{

    private $chatModel = NULL;

    public function __construct() {
        $this -> chatModel = new ChatModel();
    }

    public function record($data){
        $myRecord = $this -> chatModel -> getRecord($data['uid'], $data['fid']) -> toArray();
        $friendRecord = $this -> chatModel -> getRecord($data['fid'], $data['uid']) -> toArray();
        $all = array_merge($myRecord, $friendRecord);
        $key = array_column($all, 'create_time');
        array_multisort($key, SORT_ASC, $all);
        return $all;
    }

}