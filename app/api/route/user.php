<?php
use think\facade\Route;
use app\api\middleware\IsLogin;

Route::group('View/User', function (){
    Route::rule('register', '/api/View/register', 'GET');
    Route::rule('login', '/api/View/login', 'GET');
    Route::rule('index', '/api/View/index', 'GET');
});

Route::group('User', function (){
    Route::rule('register', '/api/User/register', 'POST');
    Route::rule('login', '/api/User/login', 'POST');
});

Route::group('User', function (){
    Route::rule('logoff', '/api/User/logoff', 'POST');
    Route::rule('isLogin', '/api/User/isLogin', 'POST');
}) -> middleware(IsLogin::class);