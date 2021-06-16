<?php
use think\facade\Route;
use app\api\middleware\IsLogin;

Route::group('User', function (){
    Route::rule('register', '/api/User/register', 'POST');
    Route::rule('login', '/api/User/login', 'POST');
});

Route::group('User', function (){
    Route::rule('logoff', '/api/User/logoff', 'POST');
    Route::rule('isLogin', '/api/User/isLogin', 'POST');
}) -> middleware(IsLogin::class);