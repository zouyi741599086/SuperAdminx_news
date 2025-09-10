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
    // 不需要加密的方法
    protected $noNeedEncrypt = [];

    /**
     * 获取所有分类
     * @method get
     * @param Request $request 
     * @return Response
     */
    public function getList(Request $request) : Response
    {
        $list = NewsClassLogic::getList(true);
        return success($list);
    }

    /**
     * 获取分类详情
     * @method get
     * @param Request $request 
     * @return Response
     */
    public function findData(Request $request) : Response
    {
        $data = NewsClassLogic::findData($request->get('id'));
        return success($data);
    }

    /**
     * 获取下级分类
     * @method get
     * @param Request $request 
     * @return Response
     */
    public function getChildrenList(Request $request) : Response
    {
        $data = NewsClassLogic::getChildrenList($request->get('id'));
        return success($data);
    }
}
