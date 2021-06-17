<?php


namespace server\business;


class Chat
{

    public function handle($ws, $frame){
        foreach ($ws -> connections as $fd) {
            if ($fd == $frame -> fd) {
                $ws -> task([
                    'fd' => $fd,
                    'message' => "我: {$frame -> data}",
                ]);
                $ws -> push($fd, "我: {$frame -> data}");
            } else {
                $ws -> push($fd, "对方: {$frame -> data}");
            }
        }
    }

}