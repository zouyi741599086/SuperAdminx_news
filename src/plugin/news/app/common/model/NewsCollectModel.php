<?php
namespace plugin\news\app\common\model;

use app\common\model\BaseModel;
use plugin\user\app\common\model\UserModel;
use plugin\news\app\common\model\NewsModel;

/**
 * 收藏文章 模型
 *
 * @author zy <741599086@qq.com>
 * @link https://www.superadminx.com/
 * */
class NewsCollectModel extends BaseModel
{

    // 表名
    protected $name = 'news_collect';

    // 自动时间戳
    protected $autoWriteTimestamp = false;

    // 字段类型转换
    protected $type = [
    ];

    // 包含附件的字段，''代表直接等于附件路劲，'array'代表数组中包含附件路劲，'editor'代表富文本中包含附件路劲
    protected $file = [
    ];


    // 用户 搜索器
    public function searchUserIdAttr($query, $value, $data)
    {
        $query->where('user_id', '=', $value);
    }

    // 文章 搜索器
    public function searchNewsIdAttr($query, $value, $data)
    {
        $query->where('news_id', '=', $value);
    }


    // 用户 关联模型
    public function User()
    {
        return $this->belongsTo(UserModel::class);
    }

    // 文章 关联模型
    public function News()
    {
        return $this->belongsTo(NewsModel::class);
    }

}