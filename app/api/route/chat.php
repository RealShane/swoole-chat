<?php

use think\facade\Route;
use app\api\middleware\IsLogin;

Route::group('View/Chat', function (){
    Route::rule('room', '/api/View/chatRoom', 'GET');
});

Route::group('Chat', function (){
    Route::rule('test', '/api/Chat/test', 'POST');
}) -> middleware(IsLogin::class);