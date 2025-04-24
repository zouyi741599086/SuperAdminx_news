<?php
namespace plugin\news\app\api\controller;

use support\Request;
use support\Response;
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

    /**
     * 获取列表
     * @method get
     * @param Request $request 
     * @return Response
     */
    public function getList(Request $request) : Response
    {
        $list = NewsLogic::getList([], [], true);
        $list->each(function ($item, $key)
        {
            if ($item['img']) {
                $item['img'] = file_url($item['img']);
            } else {
                $item['img'] = [];
            }
        });
        return success($list);
    }

    /**
     * 获取文章
     * @method get
     * @param Request $request 
     * @return Response
     */
    public function findData(Request $request) : Response
    {
        $data = NewsLogic::findData(request()->get('id'));
        if (!$data || $data['status'] == 2) {
            return error('数据不存在');
        }
        //替换连接
        $data['img']     = file_url($data['img']);
        $data['content'] = file_url($data['content']);
        return success($data);
    }

    /**
     * 增加浏览量
     * @method get
     * @param Request $request 
     * @return Response
     */
    public function incPv(Request $request) : Response
    {
        NewsLogic::incPv($request->get('id'));
        return success();
    }

}
