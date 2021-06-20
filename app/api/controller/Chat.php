<?php


namespace app\api\controller;


use app\BaseController;
use app\common\business\api\Chat as Business;
use app\common\validate\api\Chat as Validate;
use think\App;

class Chat extends BaseController
{

    protected $business = NULL;

    public function __construct(App $app) {
        parent ::__construct($app);
        $this -> business = new Business();
    }

    public function record() {
        $data['fid'] = $this -> request -> param("fid", '', 'htmlspecialchars');
        $data['uid'] = $this -> getUid();
        try {
            validate(Validate::class) -> scene("record") -> check($data);
        }catch (\Exception $exception){
            return $this -> fail($exception -> getMessage());
        }
        $record = $this -> business -> record($data);
        return $this -> success($record);
    }

}