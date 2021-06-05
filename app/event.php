<?php
// 事件定义文件
return [
    'bind'      => [
    ],

    'listen'    => [
        'AppInit'  => [],
        'HttpRun'  => [],
        'HttpEnd'  => [],
        'LogLevel' => [],
        'LogWrite' => [],
        'swoole.websocket.Connect' => [
            app\listener\WsConnect::class
        ],
        //监听关闭
        'swoole.websocket.Close' => [
            \app\listener\WsClose::class
        ],
        //监听 Test 场景
        'swoole.websocket.Test' => [
            \app\listener\WsTest::class
        ],
    ],

    'subscribe' => [
    ],
];
