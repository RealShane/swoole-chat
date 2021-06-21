<?php
/**
 *
 * @description: 永远爱颍
 *
 * @author: Shane
 *
 * @time: 2021/6/21 10:06
 */

use think\facade\Route;
use app\api\middleware\IsLogin;

Route::group('View/Chat', function (){
    Route::rule('room', '/api/View/chatRoom', 'GET');
});

Route::group('Chat', function (){
    Route::rule('record', '/api/Chat/record', 'POST');
}) -> middleware(IsLogin::class);