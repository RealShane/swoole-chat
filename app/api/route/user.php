<?php
use think\facade\Route;

Route::group('User', function (){
    Route::rule('register', '/api/User/register', 'POST');
});