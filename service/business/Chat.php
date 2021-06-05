<?php
/**
 *
 * @description: 永远爱颍
 *
 * @author: Shane
 *
 * @time: 2021/6/6 0:51
 */


class Chat
{

    public function handle($uid, $target, $message){
        echo json_encode($uid);
    }

}