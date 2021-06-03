<?php
/**
 *
 * @description: 人生五十年，与天地长久相较，如梦又似幻
 *
 * @author: Shane
 *
 * @time: 2020/9/23 15:30
 */


namespace app\common\business\lib;


class Str
{

    //生成token
    public function createToken($str){
        $tokenSalt = md5(uniqid(md5(microtime(true)), true));
        return sha1($tokenSalt . $str);
    }

    //生成盐
    public function salt($bit) {
        // 盐字符集
        $chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
        $str = '';
        for($i = 0; $i < $bit; $i++) {
            $str .= substr($chars, mt_rand(0, strlen($chars) - 1), 1);
        }
        return $str;
    }

    //文件大小转换字节
    public function convertToBytes($size){
        $number = substr($size,0,-2);
        switch(strtoupper(substr($size,-2))){
            case "KB":
                return $number * 1024;
            case "MB":
                return $number * pow(1024,2);
            case "GB":
                return $number * pow(1024,3);
            case "TB":
                return $number * pow(1024,4);
            case "PB":
                return $number * pow(1024,5);
            default:
                return $size;
        }
    }

    public function convertSex($sex){
        switch ((int)$sex){
            case 0 : return '女';
            case 1 : return '男';
            case -1 : return '保密';
        }
    }

    public function convertIs($is){
        return $is == 1 ? '是' : '否';
    }

}