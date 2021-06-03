<?php
/**
 *
 * @description: 人生五十年，与天地长久相较，如梦又似幻
 *
 * @author: Shane
 *
 * @time: 2020/9/23 14:22
 */

use think\facade\Route;

/**
 * 前端页面路由
 */
Route::group('View', function () {
    Route::rule('room', 'api/Index/index', 'GET');
});
/**
 * 无Token
 */
Route::group(function () {
    //论坛
    Route::rule('forumModular', '/api/Forum/modular', 'POST');
    Route::rule('articleList', '/api/Forum/articleList', 'POST');
    Route::rule('article', '/api/Forum/article', 'POST');

    Route::rule('pushSourceExcel', 'api/Source/pushExcel', 'GET');
});


//----------------------------------------------------------------------------------
/*
                          _ooOoo_
                         o8888888o
                         88" . "88
                         (| -_- |)
                         O\  =  /O
                      ____/`---'\____
                    .'  \\|     |//  `.
                   /  \\|||  :  |||//  \
                  /  _||||| -:- |||||-  \
                  |   | \\\  -  /// |   |
                  | \_|  ''\---/''  |   |
                  \  .-\__  `-`  ___/-. /
                ___`. .'  /--.--\  `. . __
             ."" '<  `.___\_<|>_/___.'  >'"".
            | | :  `- \`.;`\ _ /`;.`/ - ` : | |
            \  \ `-.   \_ __\ /__ _/   .-` /  /
       ======`-.____`-.___\_____/___.-`____.-'======
                          `=---='
       ^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^
                    佛祖保佑       永无BUG
       */