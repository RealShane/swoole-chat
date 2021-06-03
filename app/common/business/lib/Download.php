<?php


namespace app\common\business\lib;


use think\Exception;

class Download
{

    public function push($file_path, $file_name){
        header("Content-type:text/html;charset=utf-8");
        if(!file_exists($file_path)) {
            throw new Exception("下载文件不存在！");
        }
        $file = fopen($file_path, "r");
        $file_size = filesize($file_path);
        Header("Content-type: application/octet-stream");
        Header("Accept-Ranges: bytes");
        Header("Accept-Length:" . $file_size);
        Header("Content-Disposition: attachment; filename=" . $file_name);
        $buffer = 1024;$file_count = 0;
        while(!feof($file) && $file_count < $file_size) {
            $file_con = fread($file, $buffer);
            $file_count += $buffer;
            echo $file_con;
        }
        fclose($file);
    }

}