<?php
namespace plugin\news\app\api\controller;

use support\Request;
use support\Response;
use plugin\news\app\common\logic\NewsClassLogic;

/**
 * 配置
 *
 * @author zy <741599086@qq.com>
 * @link https://www.superadminx.com/
 * */
class NewsClass
{
    //此控制器是否需要登录
    protected $onLogin = false;
    //不需要登录的方法
    protected $noNeedLogin = [];

    
}
