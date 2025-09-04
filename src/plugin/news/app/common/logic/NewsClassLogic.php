<?php
namespace plugin\news\app\common\logic;

use think\facade\Db;
use plugin\news\app\common\model\NewsClassModel;
use plugin\news\app\common\model\NewsModel;
use plugin\news\app\common\validate\NewsClassValidate;

/**
 * 文章分类
 *
 * @author zy <741599086@qq.com>
 * @link https://www.superadminx.com/
 * */
class NewsClassLogic
{

    /**
     * 获取所有分类
     * @param bool $filter 是否前端在调用
     * */
    public static function getList(bool $filter = false)
    {
        return NewsClassModel::order('sort desc,id desc')
            ->when($filter, function ($query)
            {
                $query->where('status', 1);
            })
            ->select();
    }

    /**
     * 获取下级列表
     * @param int $id
     * */
    public static function getChildrenList(int $id)
    {
        return NewsClassModel::order('sort desc,id desc')
            ->where('pid', $id)
            ->where('status', 1)
            ->select();
    }

    /**
     * 获取一条数据
     * @param int $id
     */
    public static function findData(int $id)
    {
        return NewsClassModel::find($id);
    }

    /**
     * 添加
     * @param array $params
     */
    public static function create(array $params)
    {
        Db::startTrans();
        try {
            validate(NewsClassValidate::class)->check($params);
            $result = NewsClassModel::create($params);

            // 重新更新我下面所有数据的pid_path相关字段
            self::updatePidPath($result->id);

            Db::commit();
        } catch (\Exception $e) {
            Db::rollback();
            abort($e->getMessage());
        }
    }

    /**
     * 修改文章分类
     * @param array $params
     */
    public static function update(array $params)
    {
        Db::startTrans();
        try {
            validate(NewsClassValidate::class)->check($params);
            // 由于前段form会把字段等于null的干掉，所以这要特别加上
            if (! isset($params['pid']) || ! $params['pid']) {
                $params['pid'] = null;
            }
            NewsClassModel::update($params);

            // 重新更新我下面所有数据的pid_path相关字段
            self::updatePidPath($params['id']);

            Db::commit();
        } catch (\Exception $e) {
            Db::rollback();
            abort($e->getMessage());
        }
    }

    /**
     * 添加修改共用，维护数据的pid_path、pid_path_title两个字段
     * @param int $id
     */
    private static function updatePidPath(int $id)
    {
        $data = NewsClassModel::find($id);

        //更新我自己
        if (! $data['pid']) {
            $data['pid_path']       = ",{$id},";
            $data['pid_path_title'] = $data['title'];
        } else {
            $pidData                = NewsClassModel::find($data['pid']);
            $data['pid_path']       = "{$pidData->pid_path}{$id},";
            $data['pid_path_title'] = "{$pidData->pid_path_title}-{$data->title}";
        }
        $data->save();

        // 更新我的下级
        NewsClassModel::where('pid_path', 'like', "%,{$data->id},%")
            ->orderRaw("CHAR_LENGTH(pid_path) asc")
            ->field('id,title,pid,pid_path,pid_path_title')
            ->select()
            ->each(function ($item)
            {
                if ($item['pid']) {
                    $pidData                = NewsClassModel::field('id,pid,pid_path,pid_path_title')->find($item['pid']);
                    $item['pid_path']       = "{$pidData['pid_path']}{$item['id']},";
                    $item['pid_path_title'] = "{$pidData['pid_path_title']}/{$item['title']}";
                } else {
                    $item['pid_path']       = ",{$item['id']},";
                    $item['pid_path_title'] = $item['title'];
                }
                $item->save();
            });
    }

    /**
     * 状态修改
     * @param array $params
     */
    public static function updateStatus(array $params)
    {
        Db::startTrans();
        try {
            if (! $params['id'] || ! $params['status']) {
                abort('参数错误');
            }
            NewsClassModel::update([
                'id'     => $params['id'],
                'status' => $params['status']
            ]);
            Db::commit();
        } catch (\Exception $e) {
            Db::rollback();
            abort($e->getMessage());
        }
    }

    /**
     * 删除文章分类，同时要删除下级分类及文章
     * @param int $id
     */
    public static function delete(int $id)
    {
        Db::startTrans();
        try {
            // 删除关联的文章
            $ids = NewsClassModel::where('pid_path', 'like', "%,{$id},%")
                ->whereOr('id', $id)
                ->column('id');
            NewsModel::destroy(function ($query) use ($ids)
            {
                $query->where('news_class_id', 'in', $ids);
            });
            // 删除分类
            NewsClassModel::destroy($ids);
            Db::commit();
        } catch (\Exception $e) {
            Db::rollback();
            abort($e->getMessage());
        }
    }

    /**
     * 更改排序
     * @param array $params
     * */
    public static function updateSort(array $params)
    {
        Db::startTrans();
        try {
            foreach ($params as $k => $v) {
                NewsClassModel::update([
                    'id'   => $v['id'],
                    'sort' => $v['sort']
                ]);
            }
            Db::commit();
        } catch (\Exception $e) {
            Db::rollback();
            abort($e->getMessage());
        }
    }
}