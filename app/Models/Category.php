<?php

namespace App\Models;

use Encore\Admin\Traits\AdminBuilder;
use Encore\Admin\Traits\ModelTree;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use AdminBuilder, ModelTree, ColumnTree;

    protected $guarded = [];

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        $this->setParentColumn('parent_id');
        $this->setOrderColumn('sort');
        $this->setTitleColumn('title');
    }

    /***********自定义方法**********/

    /**
     * 根据分类名获取分类
     * @param $name
     * @return Model|null|object|static
     */
    public static function getCategoryByMobName($name)
    {
        $model = new self();
        return $model->where('title',$name)->first();
    }

    /**
     * 根据mob分类id获取分类
     * @param $mobCtgId
     * @return Model|null|object|static
     */
    public static function getCategoryByMobCtgId($mobCtgId)
    {
        $model = new self();
        return $model->where('mob_ctg_id',$mobCtgId)->first();
    }

    /**
     * 根据mob分类ids获取category_ids
     * @param array $mobCtgIds
     * @return array
     */
    public static function getCategoryIdsByMobCtgIds(array $mobCtgIds)
    {
        $model = new self();
        $categories = $model->whereIn('mob_ctg_id',$mobCtgIds)->get();
        return $categories->pluck('id')->toArray();
    }
}
