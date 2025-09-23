<?php
namespace plugin\news\app\api\controller;

use support\Request;
use support\Response;
use plugin\news\app\common\logic\NewsCollectLogic;

/**
 * 收藏文章 控制器
 *
 * @author zy <741599086@qq.com>
 * @link https://www.superadminx.com/
 * */
class NewsCollect
{

    // 此控制器是否需要登录
    protected $onLogin = true;
    // 不需要登录的方法
    protected $noNeedLogin = [];
    // 不需要加密的方法
    protected $noNeedEncrypt = [];


    /**
     * 列表
     * @method get
     * @param Request $request 
     * @return Response
     */
    public function getList(Request $request) : Response
    {
        $params = [
            'user_id' => $request->user->id
        ];
        $list   = NewsCollectLogic::getList($params)
            ->each(function ($item)
            {
                $item->News->img = file_url($item->News->img);
            });
        return success($list);
    }

    /**
     * 收藏/取消收藏
     * @method post
     * @param Request $request 
     * @return Response
     */
    public function change(Request $request) : Response
    {
        $result = NewsCollectLogic::change($request->user->id, $request->post('news_id'));
        return success($result, $result ? '收藏成功' : '取消收藏');
    }

    /**
     * 删除收藏
     * @method post
     * @param Request $request 
     * @return Response
     */
    public function delete(Request $request) : Response
    {
        $data = NewsCollectLogic::delete($request->post('id'), $request->user->id);
        return success($data);
    }

    /**
     * 清除所有收藏
     * @method get
     * @param Request $request 
     * @return Response
     */
    public function clear(Request $request) : Response
    {
        $data = NewsCollectLogic::clear($request->user->id);
        return success($data);
    }

    /**
     * 获取收藏的总数
     * @method get
     * @param Request $request 
     * @return Response
     */
    public function getCount(Request $request) : Response
    {
        $data = NewsCollectLogic::getCount($request->user->id);
        return success($data);
    }

}