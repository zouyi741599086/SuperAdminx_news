<?php
namespace plugin\news\app\api\controller;

use support\Request;
use support\Response;
use app\utils\Jwt;
use plugin\news\app\common\logic\NewsLogic;

/**
 * 新闻
 *
 * @author zy <741599086@qq.com>
 * @link https://www.superadminx.com/
 * */
class News
{
    // 此控制器是否需要登录
    protected $onLogin = false;
    // 不需要登录的方法
    protected $noNeedLogin = [];

    
}
