<?php
namespace vote\home\controller;
use vote\home\controller\Base;

/**
 * @desc   期刊前台页面
 * @author ming123jew
 *
 */
class Index extends Base{

    public function __construct($request){
        parent::__construct($request);

    }


    /**
     * @desc   首页
     * @return multitype:string multitype:
     */
    public function Index(){
        return ['code'=>0,'msg'=>'yes'];
    }
}



