<?php


namespace app\common\exception;


use think\exception\Handle;
use think\exception\HttpException;
use think\exception\ValidateException;
use think\Response;
use Throwable;


class Http extends Handle
{

    private $msg = NULL;
    private $status = NULL;

    public function render($request, Throwable $e): Response{
        $this -> msg = $e -> getMessage();
        $this -> status = config('status.failed');

        if ($this -> msg == config('status.goto')){
            $this -> msg = "检测到IP变化！";
            $this -> status = config('status.goto');
        }
        return json([
            'status' => $this -> status,
            'message' => $this -> msg,
            'result' => NULL
        ]);
    }

}

