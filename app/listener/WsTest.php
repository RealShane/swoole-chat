<?php
declare (strict_types = 1);

namespace app\listener;

class WsTest
{
    /**
     * 事件监听处理
     *
     * @param $event
     * @return mixed
     */
    public function handle($event) {
        echo json_encode($event);
    }
}
