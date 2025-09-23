<?php
namespace plugin\news\app\common\logic;

use plugin\news\app\common\model\NewsCollectModel;
use plugin\news\app\common\validate\NewsCollectValidate;

/**
 * 收藏文章 逻辑层
 *
 * @author zy <741599086@qq.com>
 * @link https://www.superadminx.com/
 * */
class NewsCollectLogic
{

    /**
     * 列表
     * @param array $params get参数
     * @param bool $page 是否需要翻页，不翻页则返回模型
     * */
    public static function getList(array $params = [], bool $page = true)
    {
        // 排序
        $orderBy = "id desc";
        if (isset($params['orderBy']) && $params['orderBy']) {
            $orderBy = "{$params['orderBy']},{$orderBy}";
        }

        $list = NewsCollectModel::withSearch(['user_id', 'news_id'], $params, true)
            ->with([
                'News' => function ($query)
                {
                    $query->field('id,title,img,description,create_time');
                }
            ])
            ->order($orderBy);

        return $page ? $list->paginate($params['pageSize'] ?? 20) : $list;
    }

    /**
     * 收藏/取消收藏
     * @param int $userId
     * @param int $newsId
     */
    public static function change(int $userId, int $newsId)
    {
        // 判断是否有收藏
        $id = NewsCollectModel::where([
            ['user_id', '=', $userId],
            ['news_id', '=', $newsId]
        ])->value('id');
        if ($id) {
            NewsCollectModel::destroy($id);
            return false;
        }

        NewsCollectModel::create([
            'user_id' => $userId,
            'news_id' => $newsId
        ]);
        return true;
    }

    /**
     * 删除
     * @param int $id 要删除的id
     * @param int $userId 用户id
     */
    public static function delete(int $id, int $userId)
    {
        NewsCollectModel::where([
            ['id', '=', $id],
            ['user_id', '=', $userId]
        ])->delete();
    }

    /**
     * 清除所有收藏
     * @param int $userId 用户id
     */
    public static function clear(int $userId)
    {
        NewsCollectModel::where('user_id', $userId)
            ->delete();
    }

    /**
     * 获取收藏的总数
     * @param int $userId 用户id
     * @return int
     */
    public static function getCount(int $userId) : int
    {
        return NewsCollectModel::where('user_id', $userId)
            ->count();
    }

    /**
     * 判断用户是否收藏了此文章
     * @param int $newsId 文章id
     * @param int $userId 用户id
     * @return bool
     */
    public static function isCollect(int $newsId, ?int $userId = null) : bool
    {
        if (! $userId) {
            return false;
        }
        return NewsCollectModel::where([
            ['user_id', '=', $userId],
            ['news_id', '=', $newsId]
        ])
            ->value('id') ? true : false;
    }

}