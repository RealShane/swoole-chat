<?php
/**
 *
 * @description: 永远爱颍
 *
 * @author: Shane
 *
 * @time: 2021/6/6 0:51
 */

namespace service\business;

class Chat
{

    public function handle($ws, $frame){
        foreach ($ws -> connections as $fd){
            if ($fd == $frame -> fd){
                $ws -> task([
                    'fd' => $fd,
                    'message' => "我: {$frame -> data}",
                ]);
                $ws -> push($fd, "我: {$frame -> data}");
            }else{
                $ws -> push($fd, "对方: {$frame -> data}");
            }
        }
    }

}