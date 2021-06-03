<?php
/**
 *
 *
 * @description:  オラ!オラ!オラ!オラ!
 * @author: Shane
 * @time: 2020/6/19 17:30
 *
 */
return[

    //激活Token
    "active_pre" => "active_account_pre_",
    //登陆Token
    "token_pre" => "access_token_pre_",
    //登陆Token持续时间(一天)
    "token_expire" => 24 * 3600,
    //登录验证码
    "code_pre" => "login_pre_",
    //登录验证码过期时间
    "code_expire" => 120,
    //文件数据过期时间 15min
    'file_expire' => 3600 / 4

];