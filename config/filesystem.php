<?php

use think\facade\Env;

return [
    // 默认磁盘
    'default' => Env::get('filesystem.driver', 'local'),
    // 磁盘列表
    'disks'   => [
        'local'  => [
            'type' => 'local',
            'root' => app()->getRuntimePath() . 'storage',
        ],
        'public' => [
            'type'       => 'local',
            'root'       => app()->getRootPath() . 'public/uploads',
            'url'        => '/uploads',
            'visibility' => 'public',
        ],
        // 更多的磁盘配置信息
        'synthesize_poor' => [
            'type'       => 'local',
            'root'       => app()->getRootPath() . 'public/uploads/synthesize/poor',
            'url'        => '/uploads',
            'visibility' => 'public',
        ],
        'dormitory' => [
            // 磁盘类型
            'type'       => 'local',
            // 磁盘路径
            'root'       => app()->getRootPath() . 'public/uploads/dormitory',
            // 磁盘路径对应的外部URL路径
            'url'        => '/uploads',
            // 可见性
            'visibility' => 'public',
        ],
    ],
];
