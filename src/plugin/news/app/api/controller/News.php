<?php
namespace plugin\news\app\api\controller;

use support\Request;
use support\Response;
use plugin\news\app\common\logic\NewsLogic;
use plugin\news\app\common\logic\NewsCollectLogic;

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
    // 不需要加密的方法
    protected $noNeedEncrypt = [];

    /**
     * 获取列表
     * @method get
     * @param Request $request 
     * @return Response
     */
    public function getList(Request $request) : Response
    {
        $list = NewsLogic::getList($request->get(), [], true)
            ->each(function ($item, $key)
            {
                $item->img = $item->img ? file_url($item->img) : [];
            });
        return success($list);
    }

    /**
     * 获取文章
     * @method get
     * @param Request $request 
     * @param int $id
     * @return Response
     */
    public function findData(Request $request, int $id) : Response
    {
        $data = NewsLogic::findData($id);
        if (! $data || $data->status == 2) {
            return error('数据不存在');
        }
        //替换连接
        $data->img     = file_url($data->img);
        $data->content = file_url($data->content);

        // 判断用户是否收藏了此文章
        $data->is_collect = NewsCollectLogic::isCollect($data->id, $request->user->id ?? null);
        return success($data);
    }

    /**
     * 增加浏览量
     * @method get
     * @param Request $request 
     * @param int $id
     * @return Response
     */
    public function incPv(Request $request, int $id) : Response
    {
        NewsLogic::incPv($id);
        return success();
    }

}
