<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cook extends Model
{
    protected $guarded = [];

    protected $casts = [
//        'method' => 'array',
        'mob_ctg_ids' => 'array',
    ];

    const SOURCE_MAP = [
        self::SOURCE_MOB => 'mob',
    ];
    const SOURCE_MOB = 1;

    /***********自定义方法**********/

    /**
     * 根据mob menu_id获取菜谱
     * @param $menuId
     * @return Model|null|object|static
     */
    public static function getCookByMenuId($menuId)
    {
        $model = new self();
        return $model->where('menu_id',$menuId)->first();
    }
}
